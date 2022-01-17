<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Grammars\PostgresGrammar;

class CreateAccessRightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection()->setSchemaGrammar(new class extends PostgresGrammar {
            protected function typeInt_array(\Illuminate\Support\Fluent $column)
            {
                return 'int[]';
            }
        });

        Schema::create('access_rights', function (Blueprint $table) {
            $table->id();
            $table->string('table_name');
            $table->smallInteger('role');
            $table->smallInteger('rights');
        });
        DB::table('access_rights')->insert(
            [
                'table_name' => 'places',
                'role' => 1,
                'rights' => 15
            ]
        );
        DB::table('access_rights')->insert(
            [
                'table_name' => 'places',
                'role' => 2,
                'rights' => 2
            ]
        );
        DB::table('access_rights')->insert(
            [
                'table_name' => 'access_rights',
                'role' => 1,
                'rights' => 11
            ]
        );
        DB::table('access_rights')->insert(
            [
                'table_name' => 'access_rights',
                'role' => 2,
                'rights' => 15
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('access_rights');
    }
}
