<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create( 'calculator_shippings', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'name' );
            $table->string( 'email' )->nullable();
            $table->string( 'phone' )->nullable();
            $table->string( 'address_line_1' );
            $table->string( 'address_line_2' )->nullable();
            $table->string( 'address_line_3' )->nullable();
            $table->string( 'city' );
            $table->string( 'state_province' );
            $table->string( 'postal_code' );
            $table->string( 'country_code' );
            $table->integer( 'weight' );
            $table->boolean( 'done' )->default( 0 );
            $table->string( 'shipping_carrier' )->nullable();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'calculator_shippings' );
    }
};
