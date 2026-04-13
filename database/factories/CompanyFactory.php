<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'business_name' => fake()->company(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->unique()->companyEmail(),
            'iban_para_aeat' => fake()->iban('ES'),
            'swift_bic_para_aeat' => fake()->lexify('????'),
            'inscrito_registro_devolucion_mensual' => fake()->boolean(),
            'tributa_exclusivamente_regimen_simplificado' => fake()->boolean(),
            'autoliquidacion_conjunta' => fake()->boolean(),
            'declarado_concurso_acreedores' => fake()->boolean(20), // 20% chance
            'fecha_concurso_acreedores' => fake()->optional(0.2)->dateTimeBetween('-5 years', 'now'),
            'concurso_acreedores_autoliquidacion_preconcursal' => fake()->boolean(10), // 10% chance
            'concurso_acreedores_autoliquidacion_postconcursal' => fake()->boolean(10), // 10% chance
            'regimen_especial_criterio_caja' => fake()->boolean(),
            'opcion_criterio_caja' => fake()->boolean(),
            'destinatario_operaciones_regimen_especial_criterio_caja' => fake()->boolean(),
            'aplicacion_prorrata_especial' => fake()->boolean(),
            'revocacion_prorrata_especial' => fake()->boolean(15), // 15% chance
            'exonerado_modelo_390' => fake()->boolean(),
            'volumen_operaciones_modelo_390' => fake()->randomFloat(2, 0, 1000000),
        ];
    }
}
