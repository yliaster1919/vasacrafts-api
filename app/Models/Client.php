<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Client extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'clients';
    protected $primaryKey = 'id';

    protected $fillable = [
        'first_name',
        'last_name',
        'contact_num',
        'address',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
