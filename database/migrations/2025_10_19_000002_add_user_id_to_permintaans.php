<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('permintaans', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete()->after('id');
        });
    }

    public function down()
    {
        Schema::table('permintaans', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
