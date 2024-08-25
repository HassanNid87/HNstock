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
        Schema::table('sales', function (Blueprint $table) {
            $table->text('notes')->nullable(); // Ajoute une colonne 'notes' de type texte qui peut être nul
            $table->decimal('avance', 10, 2)->default(0); // Ajoute une colonne 'avance' de type décimal avec une valeur par défaut de 0
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['notes', 'avance']); // Supprime les colonnes 'notes' et 'avance'
        });
    }

};
