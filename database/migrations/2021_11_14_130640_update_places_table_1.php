<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePlacesTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
/*        Schema::table('places', function(Blueprint $table) {
            $table->renameColumn('"ownersName"', 'owners_name');
            $table->renameColumn('"ownersSurame"', 'owners_surname');
            $table->renameColumn('"ownerPatronymic"', 'owners_patronymic');
            $table->renameColumn('"ownersPhone"', 'owners_phone');
            $table->renameColumn('"ownersEmail"', 'owners_email');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
