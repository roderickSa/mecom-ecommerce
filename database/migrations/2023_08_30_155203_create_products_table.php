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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId("brand_id")->constrained();
            $table->foreignId("category_id")->constrained();
            $table->foreignId("sub_category_id")->constrained();
            $table->string("product_name");
            $table->string("product_slug");
            $table->string("product_code");
            $table->string("product_qty");
            $table->string("product_tags")->nullable();
            $table->string("product_size")->nullable();
            $table->string("product_color")->nullable();
            $table->string("selling_price");
            $table->string("discount_price")->nullable();
            $table->text("short_descp");
            $table->text("long_descp");
            $table->string("product_thumbnail");
            $table->foreignId("vendor_id")->constrained("users")->nullable();
            $table->integer("hot_deals")->nullable();
            $table->integer("featured")->nullable();
            $table->integer("special_offer")->nullable();
            $table->integer("special_deals")->nullable();
            $table->integer("status")->default(0);
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
