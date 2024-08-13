<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMontantRestantToSalesTable extends Migration
{
    /**
     * La montée de la migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            // Ajouter une colonne pour le montant restant
            $table->double('montant_restant', 10, 2)->default(0); // Précision et échelle peuvent être ajustées selon vos besoins
        });
    }

    /**
     * La descente de la migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            // Supprimer la colonne en cas de rollback
            $table->dropColumn('montant_restant');
        });
    }
}
