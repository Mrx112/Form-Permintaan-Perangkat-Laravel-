<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('permintaans', function (Blueprint $table) {
            // Basic categorization and priority
            $table->string('category')->nullable()->after('deskripsi');
            $table->string('priority')->default('normal')->after('category');

            // Asset / hardware specific fields
            $table->string('asset_tag')->nullable()->after('priority');
            $table->string('hardware_type')->nullable()->after('asset_tag');
            $table->string('location')->nullable()->after('hardware_type');

            // Request workflow fields
            $table->timestamp('requested_at')->nullable()->after('location');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete()->after('requested_at');

            // Approval workflow
            $table->foreignId('approver_id')->nullable()->constrained('users')->nullOnDelete()->after('assigned_to');
            $table->timestamp('approved_at')->nullable()->after('approver_id');
            $table->text('approval_note')->nullable()->after('approved_at');

            // Estimated completion and attachments
            $table->timestamp('estimated_completion')->nullable()->after('approval_note');
            $table->json('attachments')->nullable()->after('estimated_completion');
        });
    }

    public function down()
    {
        Schema::table('permintaans', function (Blueprint $table) {
            $table->dropColumn([
                'category', 'priority', 'asset_tag', 'hardware_type', 'location', 'requested_at',
                'assigned_to', 'approver_id', 'approved_at', 'approval_note', 'estimated_completion', 'attachments'
            ]);
        });
    }
};
