<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    public function up()
    {
    Schema::create('companies', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('name');
    $table->string('address');
    $table->string('industry');
    $table->timestamps();
    $table->softDeletes();
    });
    }


    public function down()
    {
    Schema::dropIfExists('companies');
    }
}
