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
        Schema::create('request_lists', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('quantity');
            $table->decimal('fee',12,2)->default(0.00);
            $table->decimal('total',12,2)->default(0.00);
            $table->tinyInteger('status_id')->unsigned()->index();
            $table->foreign('status_id')->references('id')->on('list_statuses')->onDelete('cascade');
            $table->tinyInteger('document_id')->unsigned()->index();
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->integer('request_id')->unsigned()->index();
            $table->foreign('request_id')->references('id')->on('requests')->onDelete('cascade');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_lists');
    }
};
