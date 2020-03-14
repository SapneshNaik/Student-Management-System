<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_parents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')
                ->nullable(false)
                ->unique();

            $table->string('father_full_name', 150);
            $table->string('mother_full_name', 150);
            $table->unsignedBigInteger('staff_linked_id')->nullable();
            $table->string('father_qualification', 50);
            $table->string('mother_qualification', 50);
            $table->string('father_contact_number', 13);
            $table->string('mother_contact_number', 13)->nullable(true);
            $table->string('father_profession', 50);
            $table->string('mother_profession', 50)->nullable(true);
            $table->string('father_designation', 50);
            $table->string('mother_designation', 50)->nullable(true);
            $table->string('father_net_annual_income', 50);
            $table->string('mother_net_annual_income', 50)->nullable(true);
            $table->string('father_pan', 10);
            $table->string('mother_pan', 10)->nullable(true);
            $table->boolean('is_father_alumni')->default(false);
            $table->boolean('is_mother_alumni')->default(false);
            $table->year('father_joining_year')->nullable(true);
            $table->year('father_leaving_year')->nullable(true);
            $table->year('mother_joining_year')->nullable(true);
            $table->year('mother_leaving_year')->nullable(true);
//            $table->string('mother_pan', 10);


            $table->foreign('staff_linked_id')
                ->references('id')
                ->on('users');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
    }
     */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_parents');
    }
}
