<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Account extends Model
{
    use HasFactory,Notifiable;

    protected $table = 'accounts';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'contact_num',
        'address',
        'profile_image',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'email_verified_at'
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function user(){
        return $this->hasOne(User::class);
    }
}
