<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cus_id');
            $table->date('date_booking');
            $table->unsignedBigInteger('price_id');
            $table->decimal('total');
            $table->string('status'. 30)->default('booking');
            $table->text('slip_payment');
            $table->unsignedBigInteger('emp_id')->nullable();
            $table->timestamps();
            $table->foreign('emp_id')
            ->references('id')
            ->on('employees')
            ->onDelete('CASCADE');
            $table->foreign('price_id')
            ->references('id')
            ->on('prices')
            ->onDelete('CASCADE');
            $table->foreign('cus_id')
            ->references('id')
            ->on('customers')
            ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
