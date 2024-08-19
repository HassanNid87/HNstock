<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodebareAndEtagereToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('codebare')->nullable();
            $table->string('etagere')->nullable();
            $table->string('unite')->nullable(); // Ajout de la colonne unite
            $table->double('priceVgros');

        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('codebare');
            $table->dropColumn('etagere');
            $table->dropColumn('unite'); // Suppression de la colonne unite
            $table->dropColumn('priceVgros');

        });
    }
}
