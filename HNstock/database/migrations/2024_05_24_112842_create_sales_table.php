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
        if (!Schema::hasTable('sales')) {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('NFact');
            $table->date('DateFact');
            $table->integer('nbrArt')->default(0);
            $table->double('mht')->default(0);
            $table->double('ttva')->default(0);
            $table->double('mtva')->default(0);
            $table->double('tremise')->default(0);
            $table->double('mremise')->default(0);
            $table->double('mttc')->default(0);
	        $table->softDeletes();
            $table->timestamps();
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');


    }
};
