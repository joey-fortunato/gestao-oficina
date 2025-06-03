<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pecas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->decimal('preco', 10, 2);
            $table->integer('quantidade_estoque');
            $table->integer('quantidade_minima');
            $table->string('localizacao')->nullable();
    
    // Correção crucial:
    $table->unsignedBigInteger('fornecedor_id')->nullable();
    
    $table->timestamps();
    $table->softDeletes();

    // Chave estrangeira explícita
    $table->foreign('fornecedor_id')
          ->references('id')
          ->on('fornecedores')
          ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pecas');
    }
};
