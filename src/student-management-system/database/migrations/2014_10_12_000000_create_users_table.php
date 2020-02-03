<?php

use App\Constants as ConstantsAlias;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('login_id', 50)->unique();
            $table->string('email', 50)->unique();
            $table->string('phone_number',13);
            $table->string('alternate_phone_number', 13)->nullable();
            $table->enum('base_role', ConstantsAlias::BASE_ROLE);
            $table->unsignedBigInteger('last_updated_by')
                ->nullable();
            $table->string('password');
            $table->enum('status', ConstantsAlias::USER_STATUS);
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('last_updated_by')
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
        Schema::dropIfExists('users');
    }
}
