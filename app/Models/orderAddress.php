<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderAddress extends Model
{
    use HasFactory;


    protected $fillable = [
        'order_id', 'type', 'first_name', 'last_name', 'email', 'phone_number',
        'street_address', 'city', 'postal_code', 'state', 'country',
    ];

    public $timestamps = false;

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
