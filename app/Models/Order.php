<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['concessions', 'send_to_kitchen_time', 'status'];

    protected $casts = [
        'concessions' => 'array',
        'send_to_kitchen_time' => 'datetime',
    ];
}