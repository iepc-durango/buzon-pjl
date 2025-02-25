<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacionArchivosTable extends Migration
{
    public function up()
    {
        Schema::create('notificacion_archivos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notificacion_id');
            $table->string('file_path');
            $table->string('file_name');
            $table->timestamps();

            $table->foreign('notificacion_id')
                  ->references('id')
                  ->on('notificaciones') 
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notificacion_archivos');
    }
}
