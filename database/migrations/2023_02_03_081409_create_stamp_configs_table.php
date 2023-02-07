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
        Schema::create( 'stamp_configs', function ( Blueprint $table ) {
            $table->id();
            $table->string( 'client_id' );
            $table->text( 'access_token' )->nullable();
            $table->text( 'refresh_token' )->nullable();
            $table->dateTime( 'expired_at' )->nullable();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists( 'stamp_configs' );
    }
};
