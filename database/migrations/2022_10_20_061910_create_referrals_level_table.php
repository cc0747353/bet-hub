<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referrals_level', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('referral_id')->nullable();
            $table->string('level');
            $table->string('commission');
            
            $table->foreign('referral_id')
                ->references('id')
                ->on('referrals')
                ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referrals_level');
    }
};
