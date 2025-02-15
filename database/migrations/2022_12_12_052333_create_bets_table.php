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
        Schema::create('bets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->double('amount');
            $table->uuid('currency_id');
            $table->uuid('user_id');
            $table->uuid('match_id');
            $table->uuid('question_id');
            $table->uuid('option_id');
            $table->double('win_amount');
            $table->integer('status')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('currency')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('match_id')->references('id')->on('all_matches')->onUpdate('cascade');
            $table->foreign('option_id')->references('id')->on('options')->onUpdate('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bets');
    }
};
