<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collectionreceipt extends Model
{
    use HasFactory;
    protected $table = 'collection_receipt';
    protected $primaryKey = 'id';

    protected $fillable = [
        'description_of_goods',
        'price',
        'fees'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
