<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('approved')->default(false)->after('remember_token');
            $table->string('approval_token')->nullable()->after('approved');
            $table->timestamp('approved_at')->nullable()->after('approval_token');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['approved','approval_token','approved_at']);
        });
    }
};
