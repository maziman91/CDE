<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScreeningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screenings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ic_number')->nullable();
            $table->integer('age');
            $table->enum('gender', ['Male', 'Female']);
            $table->decimal('bmi', 4, 1);
            $table->boolean('physical_activity')->default(false);
            $table->enum('family_history', ['none', 'distant', 'immediate'])->default('none');
            $table->boolean('history_high_bp')->default(false);
            $table->boolean('history_high_glucose')->default(false);
            $table->integer('total_score');
            $table->enum('risk_level', ['Low', 'Moderate', 'High']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('screenings');
    }
}
