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
        Schema::create('request_logs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('prepared_by')->unsigned()->nullable();
            $table->foreign('prepared_by')->references('id')->on('users')->onDelete('cascade');
            $table->datetime('prepared_date')->nullable();
            $table->integer('processed_by')->unsigned()->nullable();
            $table->foreign('processed_by')->references('id')->on('users')->onDelete('cascade');
            $table->datetime('processed_date')->nullable();
            $table->integer('completed_by')->unsigned()->nullable();
            $table->foreign('completed_by')->references('id')->on('users')->onDelete('cascade');
            $table->datetime('completed_date')->nullable();
            $table->integer('released_by')->unsigned()->nullable();
            $table->foreign('released_by')->references('id')->on('users')->onDelete('cascade');
            $table->datetime('released_date')->nullable();
            $table->integer('request_id')->unsigned()->index();
            $table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_logs');
    }
};
