<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    use HasFactory;
    protected $table = 'job_orders';
    protected $primaryKey = 'id';

    protected $fillable = [
        'client_id',
        'date_release',
        'contact_num',
        'delivery_address',
        'pfi_id',
        'shipment_date',
        'approved_by',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
