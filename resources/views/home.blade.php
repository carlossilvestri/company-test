@extends('layouts.app')

@section('titulo')
General
@endsection

@section('contenido')

<div id="normal-section">
    <!-- Original Cards Section -->
    <div class="flex flex-col lg:flex-row justify-center items-center lg:items-start lg:space-x-4 p-3 lg:p-6 border border-default rounded-base shadow-xs gap-4 lg:gap-0">
        <!-- Card de usuario -->
        <div id="user-card" class="relative bg-neutral-primary-soft max-w-xs w-full p-4 lg:p-6 border border-default rounded-base shadow-xs">
            <div class="flex flex-col items-start">
                <h5 class="mb-2 text-xl lg:text-2xl font-bold tracking-tight text-heading">Usuario</h5>
                <h5 class="mb-0.5 text-lg lg:text-xl font-semibold tracking-tight text-heading">Nombre: {{ auth()->user()->name }}</h5>
                <div class="space-y-1 text-xs lg:text-sm text-body">
                    <span class="block">Email: {{ auth()->user()->email }}</span>
                    <span class="block">Empresa: {{ $companyDTO->businessName }}</span>
                </div>
            </div>
        </div>
        <!-- Card de la empresa -->
        @if(auth()->user()->company)
        <div id="company-card" class="relative bg-neutral-primary-soft max-w-md w-full lg:max-w-lg p-4 lg:p-6 border border-default rounded-base shadow-xs">
            <div class="flex flex-col items-start">
                <h5 class="mb-2 text-xl lg:text-2xl font-bold tracking-tight text-heading">Empresa del usuario</h5>
                <h5 class="mb-0.5 text-lg lg:text-xl font-semibold tracking-tight text-heading">Nombre: {{ $companyDTO->businessName }}</h5>
                <div class="space-y-1 text-xs lg:text-sm text-body">
                    <span class="block">Teléfono: {{ $companyDTO->phone }}</span>
                    <span class="block">Email: {{ $companyDTO->email }}</span>
                    <span class="block">IBAN: {{ $companyDTO->ibanParaAeat }}</span>
                    <span class="block">SWIFT/BIC: {{ $companyDTO->swiftBicParaAeat }}</span>
                    <span class="block">Inscrito en Registro Devolución Mensual: {{ $companyDTO->inscritoRegistroDevolucionMensual }}</span>
                    <span class="block">Tributa Exclusivamente Régimen Simplificado: {{ $companyDTO->tributaExclusivamenteRegimenSimplificado }}</span>
                    <span class="block">Autoliquidación Conjunta: {{ $companyDTO->autoliquidacionConjunta }}</span>
                    <span class="block">Decl. Concurso Acreedores: {{ $companyDTO->declaradoConcursoAcreedores }}</span>
                    <span class="block">Fecha Concurso Acreedores: {{ $companyDTO->fechaConcursoAcreedores }}</span>
                    <span class="block">Concurso Acreedores Autoliquidación Preconcursal: {{ $companyDTO->concursoAcreedoresAutoliquidacionPreconcursal }}</span>
                    <span class="block">Concurso Acreedores Autoliquidación Postconcursal: {{ $companyDTO->concursoAcreedoresAutoliquidacionPostconcursal }}</span>
                    <span class="block">Régimen Especial Criterio Caja: {{ $companyDTO->regimenEspecialCriterioCaja }}</span>
                    <span class="block">Opción Criterio Caja: {{ $companyDTO->opcionCriterioCaja }}</span>
                    <span class="block">Destinatario Operaciones Regimen Especial Criterio Caja: {{ $companyDTO->destinatarioOperacionesRegimenEspecialCriterioCaja }}</span>
                    <span class="block">Aplicación Prorrata Especial: {{ $companyDTO->aplicacionProrrataEspecial }}</span>
                    <span class="block">Revocación Prorrata Especial: {{ $companyDTO->revocacionProrrataEspecial }}</span>
                    <span class="block">Exonerado Modelo 390: {{ $companyDTO->exoneradoModelo390 }}</span>
                    <span class="block">Volumen Operaciones Modelo 390: {{ $companyDTO->volumenOperacionesModelo390 }}</span>
                </div>
                <div class="flex mt-4 md:mt-6 gap-4">
                    <a
                        class="inline-flex self-start w-auto text-body bg-neutral-secondary-medium box-border border border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none cursor-pointer"
                        href="{{ route('company.index', auth()->user()->company->id) }}">
                        Editar
                    </a>
                </div>
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

    <!-- Download Button -->
    <div class="flex justify-center mt-4 lg:mt-6 px-4">
        <button
            id="downloadBtn"
            onclick="downloadCardsAsPDF()"
            class="bg-blue-600 hover:bg-blue-700 transition-colors cursor-pointer uppercase font-bold px-4 lg:px-6 py-2 lg:py-3 text-white rounded-lg flex items-center gap-2 text-sm lg:text-base w-full sm:w-auto justify-center">
            <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span class="hidden sm:inline">Descargar Ficha en PDF</span>
            <span class="sm:hidden">Descargar PDF</span>
        </button>
    </div>

</div>

<!-- Toggle Button for Images Section -->
<div class="flex justify-center mt-4 lg:mt-6 mb-4 px-4">
    <button
        id="toggleImagesBtn"
        onclick="toggleImagesSection()"
        class="bg-purple-600 hover:bg-purple-700 transition-colors cursor-pointer font-medium px-4 lg:px-6 py-2 lg:py-3 text-white rounded-lg flex items-center gap-2 text-sm lg:text-base w-full sm:w-auto justify-center">
        <svg id="toggleIcon" class="w-4 h-4 lg:w-5 lg:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
        <span class="hidden sm:inline" id="toggleText">Mostrar Imágenes Generadas</span>
        <span class="sm:hidden" id="toggleTextMobile">Mostrar Imágenes</span>
    </button>
</div>

<!-- Generated Images Section -->
<div id="images-section" class="flex flex-col lg:flex-row justify-center items-center lg:items-start lg:space-x-4 p-4 lg:p-6 mb-6 gap-4 lg:gap-0" style="display: none;">
    <!-- User Image -->
    <div class="text-center w-full lg:w-auto">
        <div class="border-2 border-gray-300 rounded-lg overflow-hidden shadow-lg max-w-sm lg:max-w-xs mx-auto">
            <img src="{{ route('images.user') }}" alt="Datos del Usuario" class="w-full h-auto" />
        </div>
    </div>

    <!-- Company Image -->
    @if(auth()->user()->company)
    <div class="text-center w-full lg:w-auto">
        <div class="border-2 border-gray-300 rounded-lg overflow-hidden shadow-lg max-w-md lg:max-w-lg mx-auto">
            <img src="{{ route('images.company') }}" alt="Datos de la Empresa" class="w-full h-auto" />
        </div>
    </div>
    @endif

    <!-- PDF Download Section -->
    <div class="flex justify-center p-4 lg:p-6 mb-6">
        <div class="text-center w-full sm:w-auto">
            <a href="{{ route('images.pdf') }}" download="datos_usuario_empresa.pdf"
                class="inline-flex items-center justify-center w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white px-4 lg:px-6 py-2 lg:py-3 rounded-lg text-sm lg:text-base font-medium transition-colors shadow-lg">
                <svg class="w-4 h-4 lg:w-4 lg:h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"></path>
                </svg>
                <span class="hidden sm:inline">Descargar PDF con ambas imágenes</span>
                <span class="sm:hidden">Descargar PDF</span>
            </a>
            <p class="text-xs text-gray-500 mt-2">Formato PDF con todas las imágenes generadas</p>
        </div>
    </div>
</div>



<!-- JavaScript Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<!-- JavaScript Function -->
<script>
    function downloadCardsAsPDF() {
        const {
            jsPDF
        } = window.jspdf;

        // Show loading state
        const button = document.getElementById('downloadBtn');
        const originalText = button.innerHTML;
        button.innerHTML = 'Generando PDF...';
        button.disabled = true;

        // Get both cards
        const userCard = document.querySelector('#user-card');
        const companyCard = document.querySelector('#company-card');

        if (!userCard) {
            alert('No se encontró la tarjeta de usuario');
            button.innerHTML = originalText;
            button.disabled = false;
            return;
        }

        // Create PDF
        const pdf = new jsPDF('p', 'mm', 'a4');
        const pageWidth = pdf.internal.pageSize.getWidth();
        const pageHeight = pdf.internal.pageSize.getHeight();

        // Function to add a card to PDF
        function addCardToPDF(card, yPosition, title, isNewPage = false) {
            if (isNewPage) {
                pdf.addPage();
                yPosition = 20;
            }

            return html2canvas(card, {
                scale: 2,
                useCORS: true,
                backgroundColor: '#ffffff',
                allowTaint: true,
                useCORS: true,
                ignoreElements: function(element) {
                    // Skip elements that might cause color parsing issues
                    return element.tagName === 'STYLE' || element.tagName === 'SCRIPT';
                },
                onclone: function(clonedDoc) {
                    // Force all elements to use safe colors
                    const allElements = clonedDoc.querySelectorAll('*');
                    allElements.forEach(el => {
                        const computedStyle = window.getComputedStyle(el);
                        if (computedStyle.color && computedStyle.color.includes('oklch')) {
                            el.style.color = '#000000';
                        }
                        if (computedStyle.backgroundColor && computedStyle.backgroundColor.includes('oklch')) {
                            el.style.backgroundColor = '#ffffff';
                        }
                    });
                }
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const imgWidth = pageWidth - 40; // 20mm margin on each side
                const imgHeight = (canvas.height * imgWidth) / canvas.width;

                // Calculate total height needed (title + image + margins)
                const totalHeightNeeded = 30 + imgHeight + 20; // title(30) + image + bottom margin(20)

                // Check if we need a new page
                if (yPosition + totalHeightNeeded > pageHeight - 20) {
                    pdf.addPage();
                    yPosition = 20;
                }

                // Add title
                pdf.setFontSize(16);
                pdf.setFont('helvetica', 'bold');
                pdf.text(title, pageWidth / 2, yPosition + 10, {
                    align: 'center'
                });

                // Add image
                pdf.addImage(imgData, 'PNG', 20, yPosition + 20, imgWidth, imgHeight);

                return yPosition + 20 + imgHeight + 20; // Return new y position with bottom margin
            }).catch(error => {
                console.error('html2canvas error:', error);
                // Fallback: try with simpler configuration
                return html2canvas(card, {
                    scale: 1,
                    backgroundColor: '#ffffff',
                    logging: false
                }).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const imgWidth = pageWidth - 40;
                    const imgHeight = (canvas.height * imgWidth) / canvas.width;

                    const totalHeightNeeded = 30 + imgHeight + 20;

                    if (yPosition + totalHeightNeeded > pageHeight - 20) {
                        pdf.addPage();
                        yPosition = 20;
                    }

                    pdf.setFontSize(16);
                    pdf.setFont('helvetica', 'bold');
                    pdf.text(title, pageWidth / 2, yPosition + 10, {
                        align: 'center'
                    });
                    pdf.addImage(imgData, 'PNG', 20, yPosition + 20, imgWidth, imgHeight);

                    return yPosition + 20 + imgHeight + 20;
                });
            });
        }

        // Add user card
        addCardToPDF(userCard, 20, 'Datos del Usuario')
            .then(newUserY => {
                if (companyCard) {
                    // Add company card - the function will handle page breaks automatically
                    return addCardToPDF(companyCard, newUserY, 'Datos de la Empresa');
                }
                return Promise.resolve();
            })
            .then(() => {
                // Save PDF
                const userName = '{{ auth()->user()->name }}';
                const companyName = '{{ $companyDTO->businessName ?? "SinEmpresa" }}';
                const fileName = `ficha_${userName}_${companyName}.pdf`;

                pdf.save(fileName);

                // Restore button
                button.innerHTML = originalText;
                button.disabled = false;
            })
            .catch(error => {
                console.error('Error generating PDF:', error);
                alert('Error al generar el PDF. Por favor, inténtelo de nuevo.');

                // Restore button
                button.innerHTML = originalText;
                button.disabled = false;
            });
    }

    function toggleImagesSection() {
        const imagesSection = document.getElementById('images-section');
        const toggleText = document.getElementById('toggleText');
        const toggleTextMobile = document.getElementById('toggleTextMobile');
        const toggleIcon = document.getElementById('toggleIcon');

        if (imagesSection.style.display === 'none') {
            // Show images section
            imagesSection.style.display = 'flex';
            if (toggleText) toggleText.textContent = 'Ocultar Imágenes Generadas';
            if (toggleTextMobile) toggleTextMobile.textContent = 'Ocultar Imágenes';
            // Change icon to X or up arrow
            toggleIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
        } else {
            // Hide images section
            imagesSection.style.display = 'none';
            if (toggleText) toggleText.textContent = 'Mostrar Imágenes Generadas';
            if (toggleTextMobile) toggleTextMobile.textContent = 'Mostrar Imágenes';
            // Change icon back to menu
            toggleIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>';
        }
    }
</script>

<!-- Styles -->
<style>
    #downloadBtn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>

@endsection