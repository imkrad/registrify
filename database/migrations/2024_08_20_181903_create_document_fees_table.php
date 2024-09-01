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
        Schema::create('document_fees', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->tinyIncrements('id');
            $table->decimal('fee',12,2);
            $table->tinyInteger('type_id')->unsigned()->index();
            $table->foreign('type_id')->references('id')->on('list_dropdowns')->onDelete('cascade');
            $table->tinyInteger('document_id')->unsigned()->index();
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_fees');
    }
};
