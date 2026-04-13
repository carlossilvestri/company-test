<?php

namespace App\DTOs;

use App\Models\Company;

class CompanyDTO
{
    public function __construct(
        public readonly string $businessName,
        public readonly ?string $phone,
        public readonly ?string $email,
        public readonly ?string $ibanParaAeat,
        public readonly ?string $swiftBicParaAeat,
        public readonly string $inscritoRegistroDevolucionMensual,
        public readonly string $tributaExclusivamenteRegimenSimplificado,
        public readonly string $autoliquidacionConjunta,
        public readonly string $declaradoConcursoAcreedores,
        public readonly ?string $fechaConcursoAcreedores,
        public readonly string $concursoAcreedoresAutoliquidacionPreconcursal,
        public readonly string $concursoAcreedoresAutoliquidacionPostconcursal,
        public readonly string $regimenEspecialCriterioCaja,
        public readonly string $opcionCriterioCaja,
        public readonly string $destinatarioOperacionesRegimenEspecialCriterioCaja,
        public readonly string $aplicacionProrrataEspecial,
        public readonly string $revocacionProrrataEspecial,
        public readonly string $exoneradoModelo390,
        public readonly ?string $volumenOperacionesModelo390,
    ) {}

    public static function fromModel(Company $company): self
    {
        return new self(
            businessName: $company->business_name,
            phone: $company->phone,
            email: $company->email,
            ibanParaAeat: $company->iban_para_aeat,
            swiftBicParaAeat: $company->swift_bic_para_aeat,
            inscritoRegistroDevolucionMensual: self::formatBoolean($company->inscrito_registro_devolucion_mensual),
            tributaExclusivamenteRegimenSimplificado: self::formatBoolean($company->tributa_exclusivamente_regimen_simplificado),
            autoliquidacionConjunta: self::formatBoolean($company->autoliquidacion_conjunta),
            declaradoConcursoAcreedores: self::formatBoolean($company->declarado_concurso_acreedores),
            fechaConcursoAcreedores: $company->fecha_concurso_acreedores,
            concursoAcreedoresAutoliquidacionPreconcursal: self::formatBoolean($company->concurso_acreedores_autoliquidacion_preconcursal),
            concursoAcreedoresAutoliquidacionPostconcursal: self::formatBoolean($company->concurso_acreedores_autoliquidacion_postconcursal),
            regimenEspecialCriterioCaja: self::formatBoolean($company->regimen_especial_criterio_caja),
            opcionCriterioCaja: self::formatBoolean($company->opcion_criterio_caja),
            destinatarioOperacionesRegimenEspecialCriterioCaja: self::formatBoolean($company->destinatario_operaciones_regimen_especial_criterio_caja),
            aplicacionProrrataEspecial: self::formatBoolean($company->aplicacion_prorrata_especial),
            revocacionProrrataEspecial: self::formatBoolean($company->revocacion_prorrata_especial),
            exoneradoModelo390: self::formatBoolean($company->exonerado_modelo_390),
            volumenOperacionesModelo390: $company->volumen_operaciones_modelo_390,
        );
    }

    private static function formatBoolean(?bool $value): string
    {
        return $value ? 'Sí' : 'No';
    }

    public function toArray(): array
    {
        return [
            'business_name' => $this->businessName,
            'phone' => $this->phone,
            'email' => $this->email,
            'iban_para_aeat' => $this->ibanParaAeat,
            'swift_bic_para_aeat' => $this->swiftBicParaAeat,
            'inscrito_registro_devolucion_mensual' => $this->inscritoRegistroDevolucionMensual,
            'tributa_exclusivamente_regimen_simplificado' => $this->tributaExclusivamenteRegimenSimplificado,
            'autoliquidacion_conjunta' => $this->autoliquidacionConjunta,
            'declarado_concurso_acreedores' => $this->declaradoConcursoAcreedores,
            'fecha_concurso_acreedores' => $this->fechaConcursoAcreedores,
            'concurso_acreedores_autoliquidacion_preconcursal' => $this->concursoAcreedoresAutoliquidacionPreconcursal,
            'concurso_acreedores_autoliquidacion_postconcursal' => $this->concursoAcreedoresAutoliquidacionPostconcursal,
            'regimen_especial_criterio_caja' => $this->regimenEspecialCriterioCaja,
            'opcion_criterio_caja' => $this->opcionCriterioCaja,
            'destinatario_operaciones_regimen_especial_criterio_caja' => $this->destinatarioOperacionesRegimenEspecialCriterioCaja,
            'aplicacion_prorrata_especial' => $this->aplicacionProrrataEspecial,
            'revocacion_prorrata_especial' => $this->revocacionProrrataEspecial,
            'exonerado_modelo_390' => $this->exoneradoModelo390,
            'volumen_operaciones_modelo_390' => $this->volumenOperacionesModelo390,
        ];
    }
}
