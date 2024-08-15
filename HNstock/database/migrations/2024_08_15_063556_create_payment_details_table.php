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
        Schema::create('payment_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('payment_id')->constrained()->onDelete('cascade');
            $table->foreignId('sale_id')->constrained();

            $table->string('NFact');
            $table->date('DateFact');
            $table->double('mttc')->default(0);
            $table->double('montant_regle')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_details');
    }
};
