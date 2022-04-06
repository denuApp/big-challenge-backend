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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->references('id')->on('users');
            $table->foreignId('doctor_id')->nullable()->references('id')->on('users');
            $table->text('symptoms');
            $table->string('prescription')->nullable();
            $table->enum('status', ['Pending', 'In Progress', 'Ready'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submission');
    }
};
