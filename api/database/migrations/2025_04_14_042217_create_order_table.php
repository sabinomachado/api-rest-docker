<?php

use App\Enum\OrderStatusEnum;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_client');
            $table->unsignedBigInteger('id_city');
            $table->unsignedBigInteger('id_user');
            $table->date('boarding_date')->nullable();
            $table->date('return_date')->nullable();
            $table->enum('status', OrderStatusEnum::getValues())->default(OrderStatusEnum::PENDING);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_client')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('id_city')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
