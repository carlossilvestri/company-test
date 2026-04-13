@extends('layouts.app')

@section('titulo')
    Editar empresa {{ $company->business_name }}
@endsection

@section('contenido')
   

<div >
    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif
    <!-- Card de la empresa -->
    @if($company)
    <div class="md:flex md:items-center md:justify-center">
        <div class="md:w-1/2 p-10 bg-white  rounded-lg shadow-xl mt-10 md:mt-0">
            <form action="{{ route('company.update', $company->id) }}" method="POST" novalidate>
                @csrf   
                @method('PUT')
                <div class="mb-5">
                    <label for="business_name" class="mb-2 block uppercase text-gray-500 font-bold">
                           Nombre
                    </label>
                    <input 
                        id="business_name"
                        name="business_name"
                        type="text"
                        placeholder="Nombre"
                        class="border p-3 w-full rounded-lg @error('business_name') border-red-500 @enderror"
                        value="{{ old('business_name', $company->business_name) }}"
                    />

                    @error('business_name')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }} </p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="phone" class="mb-2 block uppercase text-gray-500 font-bold">
                           Teléfono
                    </label>
                    <input 
                        id="phone"
                        name="phone"
                        type="text"
                        placeholder="Teléfono"
                        class="border p-3 w-full rounded-lg @error('phone') border-red-500 @enderror"
                        value="{{ old('phone', $company->phone) }}"
                    />

                    @error('phone')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }} </p>
                    @enderror
                </div>

                 <div class="mb-5">
                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">
                           Email
                    </label>
                    <input 
                        id="email"
                        name="email"
                        type="email"
                        placeholder="Email"
                        class="border p-3 w-full rounded-lg @error('email') border-red-500 @enderror"
                        value="{{ old('email', $company->email) }}"
                    />

                    @error('email')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }} </p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="iban_para_aeat" class="mb-2 block uppercase text-gray-500 font-bold">
                           IBAN para AEAT
                    </label>
                    <input 
                        id="iban_para_aeat"
                        name="iban_para_aeat"
                        type="text"
                        placeholder="IBAN para AEAT"
                        class="border p-3 w-full rounded-lg @error('iban_para_aeat') border-red-500 @enderror"
                        value="{{ old('iban_para_aeat', $company->iban_para_aeat) }}"
                    />

                    @error('iban_para_aeat')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }} </p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="swift_bic_para_aeat" class="mb-2 block uppercase text-gray-500 font-bold">
                           Swift BIC para AEAT
                    </label>
                    <input 
                        id="swift_bic_para_aeat"
                        name="swift_bic_para_aeat"
                        type="text"
                        placeholder="Swift BIC para AEAT"
                        class="border p-3 w-full rounded-lg @error('swift_bic_para_aeat') border-red-500 @enderror"
                        value="{{ old('swift_bic_para_aeat', $company->swift_bic_para_aeat) }}"
                    />

                    @error('swift_bic_para_aeat')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }} </p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="inscrito_registro_devolucion_mensual" class="mb-2 block uppercase text-gray-500 font-bold">
                           Inscrito en el Registro de Devolución Mensual
                    </label>
                    <input 
                        id="inscrito_registro_devolucion_mensual"
                        name="inscrito_registro_devolucion_mensual"
                        type="checkbox"
                        class="p-3 rounded-lg cursor-pointer"
                        @checked(old('inscrito_registro_devolucion_mensual', $company->inscrito_registro_devolucion_mensual) == 1)
                    />
                </div>

                <div class="mb-5">
                    <label for="tributa_exclusivamente_regimen_simplificado" class="mb-2 block uppercase text-gray-500 font-bold">
                           Tributa Exclusivamente Régimen Simplificado
                    </label>
                    <input 
                        id="tributa_exclusivamente_regimen_simplificado"
                        name="tributa_exclusivamente_regimen_simplificado"
                        type="checkbox"
                        class="p-3 rounded-lg cursor-pointer"
                        @checked(old('tributa_exclusivamente_regimen_simplificado', $company->tributa_exclusivamente_regimen_simplificado) == 1)
                    />
                </div>

                <div class="mb-5">
                    <label for="autoliquidacion_conjunta" class="mb-2 block uppercase text-gray-500 font-bold">
                           Autoliquidación Conjunta
                    </label>
                    <input 
                        id="autoliquidacion_conjunta"
                        name="autoliquidacion_conjunta"
                        type="checkbox"
                        class="p-3 rounded-lg cursor-pointer"
                        @checked(old('autoliquidacion_conjunta', $company->autoliquidacion_conjunta) == 1)
                    />
                </div>

                <div class="mb-5">
                    <label for="declarado_concurso_acreedores" class="mb-2 block uppercase text-gray-500 font-bold">
                           Declarado Concurso de Acreedores
                    </label>
                    <input 
                        id="declarado_concurso_acreedores"
                        name="declarado_concurso_acreedores"
                        type="checkbox"
                        class="p-3 rounded-lg cursor-pointer"
                        @checked(old('declarado_concurso_acreedores', $company->declarado_concurso_acreedores) == 1)
                    />
                </div>

                <div class="mb-5">
                    <label for="fecha_concurso_acreedores" class="mb-2 block uppercase text-gray-500 font-bold">
                           Fecha Concurso de Acreedores
                    </label>
                    <input 
                        id="fecha_concurso_acreedores"
                        name="fecha_concurso_acreedores"
                        type="date"
                        class="border p-3 w-full rounded-lg @error('fecha_concurso_acreedores') border-red-500 @enderror"
                        value="{{ old('fecha_concurso_acreedores', $company->fecha_concurso_acreedores) }}"
                    />

                    @error('fecha_concurso_acreedores')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }} </p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="concurso_acreedores_autoliquidacion_preconcursal" class="mb-2 block uppercase text-gray-500 font-bold">
                           Concurso Acreedores Autoliquidación Preconcursal
                    </label>
                    <input 
                        id="concurso_acreedores_autoliquidacion_preconcursal"
                        name="concurso_acreedores_autoliquidacion_preconcursal"
                        type="checkbox"
                        class="p-3 rounded-lg cursor-pointer"
                        @checked(old('concurso_acreedores_autoliquidacion_preconcursal', $company->concurso_acreedores_autoliquidacion_preconcursal) == 1)
                    />
                </div>

                <div class="mb-5">
                    <label for="concurso_acreedores_autoliquidacion_postconcursal" class="mb-2 block uppercase text-gray-500 font-bold">
                           Concurso Acreedores Autoliquidación Postconcursal
                    </label>
                    <input 
                        id="concurso_acreedores_autoliquidacion_postconcursal"
                        name="concurso_acreedores_autoliquidacion_postconcursal"
                        type="checkbox"
                        class="p-3 rounded-lg cursor-pointer"
                        @checked(old('concurso_acreedores_autoliquidacion_postconcursal', $company->concurso_acreedores_autoliquidacion_postconcursal) == 1)
                    />
                </div>

                <div class="mb-5">
                    <label for="regimen_especial_criterio_caja" class="mb-2 block uppercase text-gray-500 font-bold">
                           Régimen Especial Criterio de Caja
                    </label>
                    <input 
                        id="regimen_especial_criterio_caja"
                        name="regimen_especial_criterio_caja"
                        type="checkbox"
                        class="p-3 rounded-lg cursor-pointer"
                        @checked(old('regimen_especial_criterio_caja', $company->regimen_especial_criterio_caja) == 1)
                    />
                </div>

                <div class="mb-5">
                    <label for="opcion_criterio_caja" class="mb-2 block uppercase text-gray-500 font-bold">
                           Opción Criterio de Caja
                    </label>
                    <input 
                        id="opcion_criterio_caja"
                        name="opcion_criterio_caja"
                        type="checkbox"
                        class="p-3 rounded-lg cursor-pointer"
                        @checked(old('opcion_criterio_caja', $company->opcion_criterio_caja) == 1)
                    />
                </div>

                <div class="mb-5">
                    <label for="destinatario_operaciones_regimen_especial_criterio_caja" class="mb-2 block uppercase text-gray-500 font-bold">
                           Destinatario Operaciones Régimen Especial Criterio de Caja
                    </label>
                    <input 
                        id="destinatario_operaciones_regimen_especial_criterio_caja"
                        name="destinatario_operaciones_regimen_especial_criterio_caja"
                        type="checkbox"
                        class="p-3 rounded-lg cursor-pointer"
                        @checked(old('destinatario_operaciones_regimen_especial_criterio_caja', $company->destinatario_operaciones_regimen_especial_criterio_caja) == 1)
                    />
                </div>

                <div class="mb-5">
                    <label for="aplicacion_prorrata_especial" class="mb-2 block uppercase text-gray-500 font-bold">
                           Aplicación Prorrata Especial
                    </label>
                    <input 
                        id="aplicacion_prorrata_especial"
                        name="aplicacion_prorrata_especial"
                        type="checkbox"
                        class="p-3 rounded-lg cursor-pointer"
                        @checked(old('aplicacion_prorrata_especial', $company->aplicacion_prorrata_especial) == 1)
                    />
                </div>

                <div class="mb-5">
                    <label for="revocacion_prorrata_especial" class="mb-2 block uppercase text-gray-500 font-bold">
                           Revocación Prorrata Especial
                    </label>
                    <input 
                        id="revocacion_prorrata_especial"
                        name="revocacion_prorrata_especial"
                        type="checkbox"
                        class="p-3 rounded-lg cursor-pointer"
                        @checked(old('revocacion_prorrata_especial', $company->revocacion_prorrata_especial) == 1)
                    />
                </div>

                <div class="mb-5">
                    <label for="exonerado_modelo_390" class="mb-2 block uppercase text-gray-500 font-bold">
                           Exonerado Modelo 390
                    </label>
                    <input 
                        id="exonerado_modelo_390"
                        name="exonerado_modelo_390"
                        type="checkbox"
                        class="p-3 rounded-lg cursor-pointer"
                        @checked(old('exonerado_modelo_390', $company->exonerado_modelo_390) == 1)
                    />
                </div>

                <div class="mb-5">
                    <label for="volumen_operaciones_modelo_390" class="mb-2 block uppercase text-gray-500 font-bold">
                           Volumen Operaciones Modelo 390
                    </label>
                    <input 
                        id="volumen_operaciones_modelo_390"
                        name="volumen_operaciones_modelo_390"
                        type="number"
                        step="0.01"
                        placeholder="Volumen Operaciones Modelo 390"
                        class="border p-3 w-full rounded-lg @error('volumen_operaciones_modelo_390') border-red-500 @enderror"
                        value="{{ old('volumen_operaciones_modelo_390', $company->volumen_operaciones_modelo_390) }}"
                    />

                    @error('volumen_operaciones_modelo_390')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center">{{ $message }} </p>
                    @enderror
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('home') }}" class="bg-red-600 hover:bg-red-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg text-center">Volver</a>

                    <input
                    type="submit"
                    value="Actualizar"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg"
                />
            </form>
        </div>
    </div>
    @else
        <div class="relative bg-neutral-primary-soft max-w-xs w-full p-6 border border-default rounded-base shadow-xs">
            <div class="flex flex-col items-center">
                <p class="text-sm text-body">No hay información de empresa disponible</p>
            </div>
        </div>
    @endif


</div>

@endsection