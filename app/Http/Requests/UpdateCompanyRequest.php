<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'business_name' => ['required', 'string', 'max:255'],
            'phone' => ['string', 'max:20'],
            'email' => ['email', 'max:255'],
            'iban_para_aeat' => ['string', 'max:34'], // IBAN puede tener hasta 34 caracteres
            'swift_bic_para_aeat' => ['required', 'string', 'max:11'],
            'inscrito_registro_devolucion_mensual' => ['sometimes', 'in:on'],
            'tributa_exclusivamente_regimen_simplificado' => ['sometimes', 'in:on'],
            'autoliquidacion_conjunta' => ['sometimes', 'in:on'],
            'declarado_concurso_acreedores' => ['sometimes', 'in:on'],
            'fecha_concurso_acreedores' => ['date', 'before_or_equal:today'],
            'concurso_acreedores_autoliquidacion_preconcursal' => ['sometimes', 'in:on'],
            'concurso_acreedores_autoliquidacion_postconcursal' => ['sometimes', 'in:on'],
            'regimen_especial_criterio_caja' => ['sometimes', 'in:on'],
            'opcion_criterio_caja' => ['sometimes', 'in:on'],
            'destinatario_operaciones_regimen_especial_criterio_caja' => ['sometimes', 'in:on'],
            'aplicacion_prorrata_especial' => ['sometimes', 'in:on'],
            'revocacion_prorrata_especial' => ['sometimes', 'in:on'],
            'exonerado_modelo_390' => ['sometimes', 'in:on'],
            'volumen_operaciones_modelo_390' => ['numeric', 'min:0', 'regex:/^\d+(\.\d{1,2})?$/'],
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'business_name.required' => 'El nombre comercial es obligatorio.',
            'business_name.max' => 'El nombre comercial no puede superar los 255 caracteres.',
            'email.email' => 'Debe ser una dirección de correo electrónico válida.',
            'fecha_concurso_acreedores.before_or_equal' => 'La fecha del concurso no puede ser futura.',
            'volumen_operaciones_modelo_390.numeric' => 'El volumen de operaciones debe ser un número.',
            'volumen_operaciones_modelo_390.regex' => 'El volumen de operaciones debe tener hasta dos decimales.',
            'volumen_operaciones_modelo_390.min' => 'El volumen de operaciones no puede ser negativo.',
        ];
    }
}
