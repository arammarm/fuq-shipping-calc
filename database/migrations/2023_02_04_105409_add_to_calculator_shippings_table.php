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
        Schema::table( 'calculator_shippings', function ( Blueprint $table ) {
            $table->text( 'carrier_detail' )->nullable();
            $table->text( 'verified_address' )->nullable();
            $table->decimal( 'required_payment', 10, 2 )->nullable();
            $table->boolean( 'paid' )->nullable();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table( 'calculator_shippings', function ( Blueprint $table ) {
            $table->dropColumn( 'carrier_detail' );
            $table->dropColumn( 'verified_address' );
            $table->boolean( 'required_payment' );
            $table->boolean( 'paid' );
        } );
    }
};
