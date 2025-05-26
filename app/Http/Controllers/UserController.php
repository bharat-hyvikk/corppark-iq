<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InvoiceMgmt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;

class  UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::latest()->where('user_type', '0');
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
        return view('users.users-management', compact('users'));
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
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => [
                    'required',
                    'min:8',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
                ],
                'phone' => 'required|numeric|digits:10|unique:users,phone'
            ],
            [
                'password.required' => 'The password field is required.',
                'password.min' => 'The password must be at least 8 characters.',
                'password.regex' => 'The password must contain :<ul>
                <li>Minimum 8 characters </li>
                <li>At least one uppercase letter</li><li>At least one lowercase letter</li><li>At least one number</li><li>At least one special character</li></ul>',
                'phone.unique' => 'The phone number is already in use.',

            ]
        );
        // Create a new user

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->phone = $request->phone;
        $user->user_type = 0;
        $user->status = "Active";
        // dd($user);
        $user->save();
        $search = $request->search;
        $itemsPerPage = $request->input('itemsPerPage') ?? 100000;
        $curentPage = $request->input('currentPage', 1);
        $status = $request->status;
        $users = User::latest()->latest()->where('user_type', '0');
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
        return response()->json(['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $request->id,
                'password' => [
                    'nullable',
                    'min:8',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
                ],
                'phone' => 'required|numeric|digits:10|unique:users,phone,' . $request->id,
            ],
            [
                'password.regex' => 'The password must contain :<ul>
                <li>Minimum 8 characters </li>
                <li>At least one uppercase letter</li><li>At least one lowercase letter</li><li>At least one number</li><li>At least one special character</li></ul>',
                'phone.unique' => 'The phone number is already in use.',

            ]
        );
        // Create a new user
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->phone = $request->phone;
        $user->save();
        $search = $request->search;
        $itemsPerPage = $request->input('itemsPerPage') ?? 100000;
        $curentPage = $request->input('currentPage', 1);
        $status = $request->status;
        $users = User::latest()->where('user_type', '0');
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
