<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClientIdToPaymentsTable extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->nullable()->after('id');

            // Définir la clé étrangère pour la relation avec la table clients
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            // Supprimer la clé étrangère et la colonne
            $table->dropForeign(['client_id']);
            $table->dropColumn('client_id');
        });
    }
}

