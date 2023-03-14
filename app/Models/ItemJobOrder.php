<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemJobOrder extends Model
{
    use HasFactory;
    protected $table = 'item_job_orders';
    protected $primaryKey = 'id';

    protected $fillable = [
        'job_order_id',
        'item_id',
        'quantity',
        'total_points',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function user(){
        return $this->HasOne(Item::class);
    }
    public function job_order(){
        return $this->HasOne(JobOrder::class);
    }
}
