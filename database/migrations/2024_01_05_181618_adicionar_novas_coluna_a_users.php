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
            $table->unsignedBigInteger('perfils_id')->nullable();
            $table->string('telefone')->nullable();
            $table->string('endereco');
            $table->string('rg')->nullable();
            $table->string('cpf')->unique();

            $table->foreign('perfils_id')->references('id')->on('perfils');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['perfils_id', 'telefone', 'endereco', 'rg', 'cpf']);
        });
    }
};
