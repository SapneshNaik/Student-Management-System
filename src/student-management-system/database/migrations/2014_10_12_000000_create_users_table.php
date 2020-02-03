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
            $table->string('login_id', 50)->unique()->nullable(false);
            $table->string('email', 50)->unique()->nullable(false);
            $table->string('phone_number',13)->nullable(false);
            $table->string('alternate_phone_number', 13)->nullable();
            $table->enum('base_role', ConstantsAlias::BASE_ROLE)->nullable(false);
            $table->unsignedBigInteger('last_updated_by')
                ->nullable();
            $table->string('password')->nullable(false);
            $table->enum('status', ConstantsAlias::USER_STATUS)
                ->nullable(false)->default('Inactive');
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
