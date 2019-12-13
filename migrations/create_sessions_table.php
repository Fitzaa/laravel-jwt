<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    private $tableName = 'jwt_sessions';

    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->char('user_agent', 200);
            $table->char('ip', 15);
            $table->uuid('refresh_token');
            $table->boolean('active')->default(false);
            $table->unsignedBigInteger('expires');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop($this->tableName);
    }
}
