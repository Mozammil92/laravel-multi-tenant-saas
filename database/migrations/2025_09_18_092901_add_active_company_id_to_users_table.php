<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActiveCompanyIdToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
        // add nullable unsigned big int to avoid FK circular issues
        $table->unsignedBigInteger('active_company_id')->nullable()->after('password');


        // Optional: Add FK later with a separate migration after companies exist
        // $table->foreign('active_company_id')->references('id')->on('companies')->nullOnDelete();
        });
    }


    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
        // if you added a foreign key, drop it first
        // $table->dropForeign(['active_company_id']);
        $table->dropColumn('active_company_id');
        });
    }
}
