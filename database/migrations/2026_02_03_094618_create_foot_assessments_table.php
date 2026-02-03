<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFootAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foot_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->date('assessment_date');

            // Right Foot
            $table->enum('r_pulse_dp', ['Present', 'Reduced', 'Absent'])->default('Present');
            $table->enum('r_pulse_pt', ['Present', 'Reduced', 'Absent'])->default('Present');
            $table->boolean('r_sensation')->default(true); // true = intact, false = loss (LOPS)
            $table->boolean('r_deformity')->default(false);
            $table->boolean('r_callus')->default(false);
            $table->boolean('r_ulcer')->default(false);
            $table->boolean('r_amputation')->default(false);

            // Left Foot
            $table->enum('l_pulse_dp', ['Present', 'Reduced', 'Absent'])->default('Present');
            $table->enum('l_pulse_pt', ['Present', 'Reduced', 'Absent'])->default('Present');
            $table->boolean('l_sensation')->default(true);
            $table->boolean('l_deformity')->default(false);
            $table->boolean('l_callus')->default(false);
            $table->boolean('l_ulcer')->default(false);
            $table->boolean('l_amputation')->default(false);

            // Overall Assessment
            $table->text('remarks')->nullable();
            $table->enum('risk_category', ['0', '1', '2', '3'])->default('0');
            $table->string('risk_level')->default('Low Risk');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('foot_assessments');
    }
}
