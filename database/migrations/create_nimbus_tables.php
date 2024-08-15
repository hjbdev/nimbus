<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('nimbus_exceptions', function (Blueprint $table) {
            $table->id();
            $table->text('message');
            $table->integer('code');
            $table->text('file');
            $table->unsignedInteger('line');

            $table->index(['created_at']);

            $table->timestamps();
        });

        Schema::create('nimbus_trace_lines', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('index')->index();
            $table->foreignId('exception_id');
            $table->text('file');
            $table->unsignedInteger('line');
            $table->string('function');
            $table->json('args')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nimbus_trace_lines');
        Schema::dropIfExists('nimbus_exceptions');
    }
};
