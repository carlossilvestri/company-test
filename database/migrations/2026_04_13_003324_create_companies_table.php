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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('iban_para_aeat')->nullable();
            $table->string('swift_bic_para_aeat')->nullable();
            $table->boolean('inscrito_registro_devolucion_mensual')->default(false);
            $table->boolean('tributa_exclusivamente_regimen_simplificado')->default(false);
            $table->boolean('autoliquidacion_conjunta')->default(false);
            $table->boolean('declarado_concurso_acreedores')->default(false);
            $table->date('fecha_concurso_acreedores')->nullable();
            $table->boolean('concurso_acreedores_autoliquidacion_preconcursal')->nullable();
            $table->boolean('concurso_acreedores_autoliquidacion_postconcursal')->nullable();
            $table->boolean('regimen_especial_criterio_caja')->default(false);
            $table->boolean('opcion_criterio_caja')->nullable();
            $table->boolean('destinatario_operaciones_regimen_especial_criterio_caja')->nullable();
            $table->boolean('aplicacion_prorrata_especial')->default(false);
            $table->boolean('revocacion_prorrata_especial')->default(false);
            $table->boolean('exonerado_modelo_390')->default(false);
            $table->decimal('volumen_operaciones_modelo_390', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
