<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // obligatorio
            $table->foreignId('tipo_id')->constrained('tipos')->onDelete('cascade'); // obligatorio
            $table->text('titulo')->nullable();
            $table->string('no_acuerdo')->nullable();
            $table->string('sesion')->nullable();
            $table->text('descripcion')->nullable();
            $table->date('fecha_aprobacion')->nullable();
            $table->string('no_expediente')->nullable();
            $table->string('denunciante')->nullable();
            $table->string('denunciado')->nullable();
            $table->string('municipio')->nullable();
            $table->text('descripcion_fundamento')->nullable();
            $table->text('descripcion_docu')->nullable();
            $table->text('frag_doc')->nullable();
            $table->text('descripcion_notificado')->nullable();
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('notificaciones');
    }
};
