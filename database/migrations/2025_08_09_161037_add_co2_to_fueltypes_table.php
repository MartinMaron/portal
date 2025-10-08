<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('fueltypes', function (Blueprint $table) {
            $table->decimal('co2', 8, 2)->nullable()->after('id'); // Adjust 'after' as needed
        });
    }

    public function down(): void
    {
        Schema::table('fueltypes', function (Blueprint $table) {
            $table->dropColumn('co2');
        });
    }
};

