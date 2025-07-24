<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\InvoiceMgmt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class  UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        

        if (Auth::user()->user_type == "2") {
            $users = User::latest()->where("building_id", Auth::user()->building_id)->whereIn("user_type", ["0", "3"]);
        } else {
            $users = User::latest()->whereIn('user_type', ['0', '2', '3']);
        }

        $buildings = Building::latest()->get();
        if ($request->ajax()) {
            $search = $request->search;
            $status = $request->status;
            if ($status) {
                $users = $users->where('status', $status);
            }
            $itemsPerPage = $request->input('itemsPerPage') ?? 100000;
            $curentPage = $request->input('page', 1);
            $users = $users->where('name', 'like', "%$search%");

            Paginator::currentPageResolver(function () use ($curentPage) {
                return $curentPage;
            });
            $users = $users->paginate($itemsPerPage);
            $pagination = $users->links('pagination::bootstrap-5')->render();
            $total = $users->total();
            $table = view('users.partials.users_table', compact('users'))->render();
            return response()->json([
                'table' => $table,
                'total' => $total,
                'pagination' => $pagination,
            ]);
        }
        $users = $users->paginate(30);
        return view('users.users-management', compact('users', 'buildings'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // Validate the request data

        if (Auth::user()->user_type == 2) {
            $request->merge(['building' => Auth::user()->building_id]);
        }
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => [
                    'required',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{10,}$/'
                ],
                'phone' => 'required|numeric|digits:10|unique:users,phone',
                'user_type' => [
                    "required",
                    function ($attribute, $value, $fail) {
                        // if user is admin then user type can be 0,2,3 and if user is manager it can be only 0,3
                        if (Auth::user()->isManager && in_array($value, [0, 3])) {
                            return;
                        } elseif (Auth::user()->user_type == 1 && in_array($value, [0, 3, 2])) {
                            return;
                        } else {
                            $fail("invalid user type");
                        }
                    }

                ],
                'building' => "required|exists:building,id"
            ],
            [
                'password.required' => 'The password field is required.',
                'password.min' => 'The password must be at least 10 characters.',
                'password.regex' => 'The password must contain :<ul>
                <li>Minimum 8 characters </li>
                <li>At least one uppercase letter</li><li>At least one lowercase letter</li><li>At least one number</li><li>At least one special character</li></ul>',
                'phone.unique' => 'The phone number is already in use.',

            ]
        );

        if (Auth::user()->user_type == "2" && $request->user_type == "2") {
            // abort
            return response()->json([
                'message' => 'You can not create a manager for your building.',
            ], 400);
        }
        // Create a new user

        $user = new User();
        $user->name = $request->name;
        if (Auth::user()->isManager) {
            $user->building_id = Auth::user()->building_id;
        } else {
            $user->building_id = $request->building;
        }
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->phone = $request->phone;
        $user->user_type = $request->user_type;
        $user->status = "Active";
        // dd($user);
        $permissions = $request->permissions ?? [];
        $user->save();
        if ($user->user_type == '2') {
            $user->assignRole('manager');
        } else if ($user->user_type == '3') {
            $user->assignRole('submanager');
        }
        $allPermissions = Permission::pluck('name')->toArray();
        foreach ($permissions as $permission) {
            // check permission before assigning if it exists or not 
            if (in_array($permission, $allPermissions)) {
                $user->givePermissionTo($permission);
            }
        }

        $search = $request->search;
        $itemsPerPage = $request->input('itemsPerPage') ?? 100000;
        $curentPage = $request->input('currentPage', 1);
        $status = $request->status;
        if (Auth::user()->user_type == "2") {
            $users = User::latest()->where("building_id", Auth::user()->building_id)->whereIn("user_type", ["0", "3"]);
        } else {
            $users = User::latest()->whereIn('user_type', ['0', '2', '3']);
        }
        $users = $users->where('name', 'like', "%$search%");
        if ($status) {
            $users = $users->where('status', $status);
        }
        $lastPage = ceil($users->count() / $itemsPerPage);
        if ($curentPage > $lastPage) {
            $curentPage = $lastPage;
        }
        Paginator::currentPageResolver(function () use ($curentPage) {
            return $curentPage;
        });
        $users = $users->paginate($itemsPerPage);
        $pagination = $users->links('pagination::bootstrap-5')->render();

        $total = $users->total();
        $table = view('users.partials.users_table', compact('users'))->render();
        return response()->json([
            'table' => $table,
            'total' => $total,
            'pagination' => $pagination,
            'message' => 'User added successfully.',
        ]);
    }
    public function updateStatus(Request $request)
    {
        $request->validate(
            [
                'id' => 'required|integer|exists:users,id',
            ]
        );
        $request = request();
        $user = User::find($request->id);
        $status = $user->status == "Active" ? "Inactive" : "Active";
        if ($status == "Active") {
            $message = "User Activated Successfully";
        } else {
            $message = "User Inactived Successfully";
        }
        if ($user) {
            $user->status = $status;
            $user->save();
            $userStatus = $user->status;
            return Response()->json(['success' => 1, "message" => $message, 'userStatus' => $userStatus]);
        } else {
            return Response()->json(['success' => 0, "error" => "User Not found"]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
        $user = User::find($request->id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $permissions = $user->permissions->pluck("name");

        return response()->json(['user' => $user, 'permissions' => $permissions]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        if (Auth::user()->user_type == 2) {
            $request->merge(['building' => Auth::user()->building_id]);
        }
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $request->id,
                'password' => [
                    'nullable',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{10,}$/'
                ],
                'phone' => 'required|numeric|digits:10|unique:users,phone,' . $request->id,
                'building' => "required|exists:building,id",
                'user_type' => [
                    "required",
                    function ($attribute, $value, $fail) {
                        // if user is admin then user type can be 0,2,3 and if user is manager it can be only 0,3
                        if (Auth::user()->isManager && in_array($value, [0, 3])) {
                            return;
                        } elseif (Auth::user()->user_type == 1 && in_array($value, [0, 3, 2])) {
                            return;
                        } else {
                            $fail("invalid user type");
                        }
                    }

                ]

            ],
            [
                'password.regex' => 'The password must contain :<ul>
                <li>Minimum 10 characters </li>
                <li>At least one uppercase letter</li><li>At least one lowercase letter</li><li>At least one number</li><li>At least one special character</li></ul>',
                'phone.unique' => 'The phone number is already in use.',

            ]
        );
        // Create a new user

        $user = User::find($request->id);
        if (Auth::user()->isManager && $user->building_id != Auth::user()->building_id) {
            return response()->json(['error' => 'You can not edit this user'], 403);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type = $request->user_type;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->phone = $request->phone;
        if (Auth::user()->isManager) {
            $user->building_id = Auth::user()->building_id;
        } else {
            $user->building_id = $request->building;
        }
        $user->permissions()->detach();
        // deattach role
        $user->roles()->detach();

        if ($user->user_type == '2') {
            $user->assignRole('manager');
        } elseif ($user->user_type == '3') {
            $user->assignRole('submanager');
            $permissions = $request->permissions ?? [];
            $allPermissions = Permission::pluck('name')->toArray();
            foreach ($permissions as $permission) {
                // check permission before assigning if it exists or not 
                if (in_array($permission, $allPermissions)) {
                    $user->givePermissionTo($permission);
                }
            }
        }
        $user->save();



        $search = $request->search;
        $itemsPerPage = $request->input('itemsPerPage') ?? 100000;
        $curentPage = $request->input('currentPage', 1);
        $status = $request->status;
        if (Auth::user()->user_type == "2") {
            $users = User::latest()->where("building_id", Auth::user()->building_id)->whereIn("user_type", ["0", "3"]);
        } else {
            $users = User::latest()->whereIn('user_type', ['0', '2', '3']);
        }
        if ($status) {
            $users = $users->where('status', $status);
        }
        if ($request->search) {
            $users = $users->where('name', 'like', "%$search%");
        }
        Paginator::currentPageResolver(function () use ($curentPage) {
            return $curentPage;
        });
        $users = $users->paginate($itemsPerPage);
        $pagination = $users->links('pagination::bootstrap-5')->render();

        $total = $users->total();
        $table = view('users.partials.users_table', compact('users'))->render();
        return response()->json([
            'table' => $table,
            'total' => $total,
            'pagination' => $pagination,
            'message' => 'User updated successfully.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $user = User::find($request->id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        if (Auth::user()->isManager && $user->building_id != Auth::user()->building_id) {
            return response()->json(['error' => 'You can not delete this user'], 403);
        }
        // remove role and permissions
        $user->roles()->detach();
        $user->permissions()->detach();
        $user->delete();
        $search = $request->search;
        $itemsPerPage = $request->input('itemsPerPage') ?? 100000;
        $curentPage = $request->input('page', 1);
        $users = User::latest()->latest()->where('user_type', '0');
        if ($request->search) {
            $users = $users->where('name', 'like', "%$search%");
        }
        $status = $request->status;
        if ($status) {
            $users = $users->where('status', $status);
        }
        $lastPage = ceil($users->count() / $itemsPerPage);
        if ($curentPage > $lastPage) {
            $curentPage = $lastPage;
        }
        Paginator::currentPageResolver(function () use ($curentPage) {
            return $curentPage;
        });
        $users = $users->paginate($itemsPerPage);
        $pagination = $users->links('pagination::bootstrap-5')->render();

        $total = $users->total();
        $table = view('users.partials.users_table', compact('users'))->render();
        return response()->json([
            'table' => $table,
            'total' => $total,
            'pagination' => $pagination,
            'message' => 'User deleted successfully.',
        ]);
    }
}
