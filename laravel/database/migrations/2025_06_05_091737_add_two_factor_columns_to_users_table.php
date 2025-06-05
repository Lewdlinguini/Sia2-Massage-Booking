<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::table('users', function (Blueprint $table) {
        $table->string('two_factor_code')->nullable();
        $table->dateTime('two_factor_expires_at')->nullable();
        $table->boolean('two_factor_enabled')->default(false);
    });
    }

    public function down()
    {
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['two_factor_code', 'two_factor_expires_at', 'two_factor_enabled']);
    });
    }
};