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
        $columnNames = config('permission.column_names');
        Schema::table('model_has_permissions', function (Blueprint $table) use($columnNames) {
            $table->uuid($columnNames['model_morph_key'])->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $columnNames = config('permission.column_names');
        Schema::table('model_has_permissions', function (Blueprint $table) use($columnNames) {
            $table->unsignedBigInteger($columnNames['model_morph_key'])->change();
        });
    }
};
