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
        Schema::create('user_referrals_commission', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('referral_by_id');
            $table->uuid('referral_to_id');
            $table->integer('type');
            $table->uuid('deposit_id');
            $table->timestamps();

            $table->foreign('referral_by_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('referral_to_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('deposit_id')->references('id')->on('deposit_payment_transactions')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_referrals_commission');
    }
};
