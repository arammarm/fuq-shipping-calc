<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalculatorShipping extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address_line_1',
        'address_line_2',
        'address_line_3',
        'city',
        'state_province',
        'postal_code',
        'country_code',
        'weight',
        'done',
        'shipping_carrier',
        'carrier_detail',
        'verified_address',
        'paid',
        'required_payment',
    ];
}
