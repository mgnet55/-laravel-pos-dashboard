<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->json('description');
            $table->json('name');
            $table->foreignId('category_id')->constrained();
            $table->string('image')->nullable();
            $table->unsignedDouble('purchase_price', 8, 2)->default(0);
            $table->unsignedDouble('sell_price', 8, 2)->default(0);
            $table->integer('stock')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
