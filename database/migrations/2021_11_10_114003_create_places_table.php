<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32)->unique();
            $table->string('coords')->nullable();
            $table->smallInteger('type')->default(1);
            $table->string('ownersName')->nullable();
            $table->string('ownersSurname')->nullable();
            $table->string('ownersPatronymic')->nullable();
            $table->string('ownersEmail')->nullable();
            $table->string('ownersPhone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('places');
    }
}
