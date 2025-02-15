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
        Schema::create('questions', function (Blueprint $table) {
            $table->uuid('id')->primary();  
            $table->uuid('match_id');
            $table->string('question');
            $table->boolean('status');
            $table->boolean('is_locked')->default(false);
            $table->boolean('result_declared')->default(false);

            $table->foreign('match_id')
                ->references('id')
                ->on('all_matches')
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
        Schema::dropIfExists('questions');
    }
};
