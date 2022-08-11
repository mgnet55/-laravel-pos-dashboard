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
        Schema::create('order_product', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Order::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(\App\Models\Product::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedFloat('unit_price');

            $table->primary(['product_id', 'order_id']);
            $table->index('product_id');
            $table->index('order_id');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_product');
    }
};
