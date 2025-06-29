<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
        $table->string('major')->nullable()->after('email');
        $table->string('university')->nullable()->after('major');
        $table->text('bio')->nullable()->after('university');
        $table->string('profile_photo_path', 2048)->nullable()->after('bio');
        });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['major', 'university', 'bio']);
    });
    }
};
