<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model {
    use HasFactory;

    protected $fillable = [
        'key',
        'content',
        'additional',
        'type'
    ];


    public static function getAdminAddress() {

        $address = self::whereIn( 'key', [
            'admin_name',
            'admin_email',
            'admin_phone',
            'admin_address_line_1',
            'admin_address_line_2',
            'admin_address_line_3',
            'admin_city',
            'admin_state_province',
            'admin_postal_code',
            'admin_country_code'
        ] )->get()->toArray();

        if ( ! empty( $address ) ) {
            $ar = [];
            foreach ( $address as $ad ) {
                 $ar[ $ad['key'] ] = $ad['content'];
            }
            return $ar;
        }

        return null;
    }
}
