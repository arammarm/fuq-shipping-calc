<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StampConfig extends Model {
    use HasFactory;

    protected $fillable = [
        'client_id',
        'access_token',
        'refresh_token',
        'expired_at',
        'updated_at'
    ];
}
