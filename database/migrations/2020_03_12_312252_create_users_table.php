<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'users';

    /**
     * Run the migrations.
     * @table users
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable("users")){
            Schema::create($this->tableName, function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->bigIncrements('id');
                $table->string('username', 20)->nullable()->default(null);
                $table->string('name', 100)->nullable()->default(null);
                $table->string('email', 100)->nullable()->default(null);
                $table->string('contact_number', 15)->nullable()->default(null);
                $table->dateTime('email_verified_at')->nullable()->default(null);
                $table->string('password')->nullable()->default(null);
                $table->rememberToken();
                $table->string('activation_token', 100)->nullable()->default(null);
                $table->string('user_type', 50)->nullable()->default(null);
                $table->string('registration_id', 100)->nullable()->default(null);
                $table->string('device_id', 100)->nullable()->default(null);
                $table->string('image')->nullable()->default(null);
                $table->string('status', 50)->nullable()->default('active');
                $table->softDeletes();
                $table->nullableTimestamps();
            });
        }

        Schema::table("users", function (Blueprint $table){
            $table->integer("college_id")->nullable()->default(null);
            $table->integer("role_id")->nullable();      
        });

        Schema::table("users", function (Blueprint $table){
            $table->string("admin_assistant_roles", 255)->nullable()->default(null);  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
