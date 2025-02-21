<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_notificacion')->constrained('notificaciones')->onDelete('cascade'); // Relación con Notificaciones
            $table->foreignId('destinatario_id')->constrained('destinatarios')->onDelete('cascade'); // Relación con Destinatarios
            $table->enum('status_abierto', ['UNREAD', 'READ'])->default('UNREAD'); // Enumeración de estado abierto
            $table->enum('status_envio', ['pending', 'send'])->default('pending'); // Enumeración de estado de envío
            $table->string('link');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('detalles');
    }
};



