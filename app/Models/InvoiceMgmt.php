<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast;
use Illuminate\Database\Eloquent\SoftDeletes;
class InvoiceMgmt extends Model
{
    protected $table = 'invoice_mgmt';
   use HasFactory,SoftDeletes;
    protected $fillable = [
        'user_id',
        'invoice_id',
        'date',
        'amount',
        'pdf_path',
        'status',
        'point'
    ];
    protected $casts = [
        'date' => 'datetime',
    ];
    // specify invoiceFactory for this model

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
}
