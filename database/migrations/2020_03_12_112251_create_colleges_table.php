<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable("colleges")){
            Schema::create('colleges', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->bigIncrements('college_id');
                $table->string('name')->unique();
                $table->softDeletes();
                $table->nullableTimestamps();
            });
        }

        Schema::table("colleges", function (Blueprint $table){
            $table->string("address")->nullable();
            $table->string("gps")->nullable();
            $table->string("country")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colleges');
    }
}
