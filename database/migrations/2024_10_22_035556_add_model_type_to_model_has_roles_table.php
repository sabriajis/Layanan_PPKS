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
        Schema::table('model_has_roles', function (Blueprint $table) {
          // Mengubah kolom model_type agar memiliki default value
          $table->string('model_type')->default('App\Models\User')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('model_has_roles', function (Blueprint $table) {
             // Kembali ke pengaturan sebelumnya jika perlu
             $table->string('model_type')->nullable(false)->change();
        });
    }
};
