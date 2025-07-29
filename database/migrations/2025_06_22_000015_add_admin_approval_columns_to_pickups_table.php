<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminApprovalColumnsToPickupsTable extends Migration
{
    public function up()
    {
        Schema::table('pickups', function (Blueprint $table) {
            $table->unsignedBigInteger('admin_id')->nullable()->after('staff_id');
            $table->timestamp('approved_at')->nullable()->after('admin_id');
            $table->text('approval_note')->nullable()->after('approved_at');

            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('pickups', function (Blueprint $table) {
            $table->dropForeign(['admin_id']);
            $table->dropColumn(['admin_id', 'approved_at', 'approval_note']);
        });
    }
}
