<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $table = 'items';
    protected $primaryKey = 'id';

    protected $fillable = [
        'item_code',
        'photo',
        'description',
        'dimensions',
        'finish',
        'unit_points',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
