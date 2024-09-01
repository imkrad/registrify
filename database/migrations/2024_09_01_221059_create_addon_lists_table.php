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
        Schema::create('addon_lists', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->tinyIncrements('id');
            $table->integer('quantity')->default(1);
            $table->tinyInteger('name_id')->unsigned()->index();
            $table->foreign('name_id')->references('id')->on('list_names')->onDelete('cascade');            
            $table->tinyInteger('addon_id')->unsigned()->index();
            $table->foreign('addon_id')->references('id')->on('addons')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addon_lists');
    }
};
