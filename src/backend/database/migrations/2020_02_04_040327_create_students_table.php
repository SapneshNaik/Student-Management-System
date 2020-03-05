<?php

use App\Constants as ConstantsAlias;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')
                ->nullable(false)
                ->unique();
            $table->unsignedBigInteger('parent_id')->nullable(true);
            $table->enum('prefix', ConstantsAlias::PREFIXES);
            $table->string('first_name', 50);
            $table->string('middle_name', 50);
            $table->string('last_name', 50);
            $table->enum('gender', ConstantsAlias::GENDER);
            $table->string('caste', 30);
            $table->string('caste_category', 30);
            $table->enum('religion', ConstantsAlias::RELIGIONS);
            $table->enum('blood_group', ConstantsAlias::BLOOD_GROUP);
            $table->string('aadhaar_no')->nullable(false)->unique();
            $table->string('passport_no')->nullable(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            //DONE: add parent ID to student during Parent Create [DONE]
            $table->foreign('parent_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
