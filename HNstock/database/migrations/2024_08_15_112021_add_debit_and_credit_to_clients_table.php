<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->decimal('debit', 10, 2)->default(0); // Ajouter la colonne solde
            $table->decimal('credit', 10, 2)->default(0); // Ajouter la colonne solde
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('debit');
            $table->dropColumn('credit');
        });
    }
};
