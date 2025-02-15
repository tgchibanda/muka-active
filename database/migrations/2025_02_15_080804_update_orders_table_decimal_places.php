<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('grand_total', 10, 2)->change();
            $table->decimal('shipping_cost', 10, 2)->change();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('grand_total', 10, 0)->change(); // Revert to original if necessary
            $table->decimal('shipping_cost', 10, 0)->change(); // Adjust as needed
        });
    }
};
