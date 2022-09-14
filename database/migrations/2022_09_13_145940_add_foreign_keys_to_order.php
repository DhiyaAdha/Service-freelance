<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->foreign('buyer_id', 'fk_order_buyer_id_to_users')->references('id')
            ->on('users')->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('freelancer_id', 'fk_order_freelancer_to_users')->references('id')
            ->on('users')->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreign('service_id', 'fk_order_to_service')->references('id')
            ->on('service')->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreign('order_status_id', 'fk_order_to_order_status')->references('id')
            ->on('order_status')->onUpdate('cascade')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order', function (Blueprint $table) {
            $table->dropForeig ('fk_order_buyer_to_service');
            $table->dropForeig ('fk_order_freelancer_to_users');
            $table->dropForeig ('fk_order_to_service');
            $table->dropForeig ('fk_order_to_order_status');
        });
    }
};
