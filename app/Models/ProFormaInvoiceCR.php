<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProFormaInvoiceCR extends Model
{
    use HasFactory;
    protected $fillable = [
        'pfi_id',
        'collection_receipt_id',
        'quantity',
        'subtotal'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}   

