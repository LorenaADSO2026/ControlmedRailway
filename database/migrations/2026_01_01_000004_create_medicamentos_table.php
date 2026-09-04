<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicamentos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->string('codigo', 50)->unique();
            $table->string('lote', 50);
            $table->date('fecha_vencimiento');
            $table->unsignedInteger('cantidad')->default(0);
            $table->text('observaciones')->nullable();
            $table->foreignId('proveedor_id')->nullable()->constrained('proveedor')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicamentos');
    }
};
