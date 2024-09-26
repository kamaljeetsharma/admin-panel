<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();  // Session ID
            $table->foreignId('user_id')->nullable()->index(); // Reference to user table (nullable if not logged in)
            $table->string('ip_address', 45)->nullable(); // IP address of user
            $table->text('user_agent')->nullable(); // Browser/device details
            $table->text('payload'); // Session data
            $table->integer('last_activity')->index(); // Last active time (Unix timestamp)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
