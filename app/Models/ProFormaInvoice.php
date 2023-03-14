<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProFormaInvoice extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'pro_forma_invoice';
    protected $primaryKey = 'id';

    protected $fillable = [
        'client_id',
        'shipment_Date',
        'currency',
        'total_bill'

    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
