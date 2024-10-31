<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('products')) return;

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->default("");
            $table->double('priceA')->default(0);
            $table->double('priceV')->default(0);
            $table->foreignIdFor(Category::class);
            $table->string('codebare')->default("");
            $table->string('etagere')->default("");
            $table->string("unite")->default("");
            $table->unsignedInteger("stockmax")->nullable();
            $table->unsignedInteger("stockmin")->nullable();
            $table->string('image');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
