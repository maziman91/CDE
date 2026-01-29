<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->date('date_of_visit');
            $table->string('patient_name');
            $table->string('ic_number')->unique();
            $table->string('phone_no')->nullable();
            $table->string('gender');
            $table->integer('age')->nullable();
            $table->string('visit_setting');
            $table->string('referral_source')->nullable();
            $table->string('triage_priority');
            $table->string('diabetes_type');
            $table->integer('duration_years')->nullable();
            $table->text('reason_for_referral')->nullable();
            $table->decimal('weight_kg', 5, 1)->nullable();
            $table->decimal('bmi', 5, 1)->nullable();
            $table->string('bp')->nullable();
            $table->decimal('hba1c', 4, 1)->nullable();
            $table->integer('egfr')->nullable();
            $table->text('current_meds')->nullable();
            $table->string('insulin_technique')->nullable();
            $table->string('adherence_issue')->nullable();
            $table->string('lipodystrophy')->nullable();
            $table->string('dietary_pattern')->nullable();
            $table->string('smoking_status')->nullable();
            $table->string('hypoglycemia_history')->nullable();
            $table->string('smbg_frequency')->nullable();
            $table->text('topics_covered')->nullable();
            $table->text('smart_goal')->nullable();
            $table->date('next_follow_up')->nullable();
            $table->string('educator_name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
