<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\DTOs\CompanyDTO;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);
    }

    public function index(int $companyId)
    {
        $company = Company::where('id', $companyId)->first();

        return view('company.update', [
            'company' => $company
        ]);
    }

    public function update(UpdateCompanyRequest $request, int $companyId)
    {
        try {
            Log::info('Request data:', $request->all());
            $company = Company::findOrFail($companyId);

            // Get validated data from the form request
            $validated = $request->validated();

            // Debug: Log all request data
            Log::info('Request data:', $request->all());
            Log::info('Validated data:', $validated);

            // Debug specifically for volumen_operaciones_modelo_390
            Log::info('volumen_operaciones_modelo_390 in request: ' . $request->input('volumen_operaciones_modelo_390'));
            Log::info('volumen_operaciones_modelo_390 in validated: ' . ($validated['volumen_operaciones_modelo_390'] ?? 'NOT FOUND'));

            // Handle checkbox field conversions (checkboxes only send values when checked)
            $checkboxFields = [
                'inscrito_registro_devolucion_mensual',
                'tributa_exclusivamente_regimen_simplificado',
                'autoliquidacion_conjunta',
                'declarado_concurso_acreedores',
                'concurso_acreedores_autoliquidacion_preconcursal',
                'concurso_acreedores_autoliquidacion_postconcursal',
                'regimen_especial_criterio_caja',
                'opcion_criterio_caja',
                'destinatario_operaciones_regimen_especial_criterio_caja',
                'aplicacion_prorrata_especial',
                'revocacion_prorrata_especial',
                'exonerado_modelo_390'
            ];

            foreach ($checkboxFields as $field) {
                // Convert 'on' to true, missing field to false
                $checkboxValue = $request->input($field);
                $validated[$field] = $checkboxValue === 'on';
                Log::info("Checkbox {$field}: " . ($checkboxValue === 'on' ? 'CHECKED (on)' : 'NOT CHECKED (missing)'));
            }

            Log::info('Final data to update:', $validated);

            $result = $company->update($validated);
            Log::info('Update result: ' . ($result ? 'SUCCESS' : 'FAILED'));

            // Debug: Check what was actually saved
            $company->refresh();
            Log::info('volumen_operaciones_modelo_390 after update: ' . $company->volumen_operaciones_modelo_390);

            return redirect()
                ->route('company.index', $company->id)
                ->with('success', 'Empresa actualizada correctamente');
        } catch (\Exception $e) {
            Log::error('Update error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al actualizar la empresa: ' . $e->getMessage());
        }
    }
}
