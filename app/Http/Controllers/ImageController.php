<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Barryvdh\DomPDF\Facade\Pdf;

class ImageController extends Controller
{
    /**
     * Generate user data image
     */
    public function generateUserImage()
    {
        $user = Auth::user();

        if (!$user) {
            abort(404);
        }

        // Create image
        $width = 400;
        $height = 300;
        $image = imagecreatetruecolor($width, $height);

        // Colors - Tailwind CSS inspired
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        $sky600 = imagecolorallocate($image, 2, 132, 199); // sky-600
        $gray100 = imagecolorallocate($image, 243, 244, 246); // gray-100
        $gray200 = imagecolorallocate($image, 229, 231, 235); // gray-200
        $gray500 = imagecolorallocate($image, 107, 114, 128); // gray-500
        $gray600 = imagecolorallocate($image, 75, 85, 99);    // gray-600

        // Fill background with gray-100
        imagefill($image, 0, 0, $gray100);

        // Add white card background with padding
        imagefilledrectangle($image, 15, 15, $width - 15, $height - 15, $white);

        // Add subtle border
        imagerectangle($image, 15, 15, $width - 15, $height - 15, $gray200);


        // Find a suitable TrueType font for cross-platform compatibility
        $fontFile = $this->findFontFile();
        if (!$fontFile) {
            // Fallback to built-in fonts if no TrueType font found
            $titleFont = 5;
            $textFont = 3;
            $smallFont = 2;
            $useTTF = false;
        } else {
            $titleSize = 18;
            $labelSize = 14;
            $valueSize = 14;
            $smallSize = 11;
            $useTTF = true;
        }

        // Title with better positioning
        $title = "DATOS DEL USUARIO";
        if ($useTTF) {
            $titleBox = imagettfbbox($titleSize, 0, $fontFile, $title);
            $titleWidth = $titleBox[2] - $titleBox[0];
            $titleX = ($width - $titleWidth) / 2;
            imagettftext($image, $titleSize, 0, $titleX, 40, $black, $fontFile, $title);
        } else {
            $titleWidth = imagefontwidth($titleFont) * strlen($title);
            $titleX = ($width - $titleWidth) / 2;
            imagestring($image, $titleFont, $titleX, 25, $title, $black);
        }

        // User data with better spacing
        $y = 65;
        $lineHeight = 30;

        // Name
        if ($useTTF) {
            imagettftext($image, $labelSize, 0, 35, $y, $gray600, $fontFile, "Nombre:");
            imagettftext($image, $valueSize, 0, 115, $y, $black, $fontFile, $user->name);
        } else {
            imagestring($image, $textFont, 35, $y, "Nombre:", $gray600);
            imagestring($image, $textFont, 115, $y, $user->name, $black);
        }
        $y += $lineHeight;

        // Email
        if ($useTTF) {
            imagettftext($image, $labelSize, 0, 35, $y, $gray600, $fontFile, "Email:");
            imagettftext($image, $smallSize, 0, 115, $y + 3, $gray500, $fontFile, $user->email);
        } else {
            imagestring($image, $textFont, 35, $y, "Email:", $gray600);
            imagestring($image, $smallFont, 115, $y + 5, $user->email, $gray500);
        }
        $y += $lineHeight;

        // Company
        if ($user->company) {
            if ($useTTF) {
                imagettftext($image, $labelSize, 0, 25, $y, $gray600, $fontFile, "Empresa:");
                imagettftext($image, $smallSize, 0, 125, $y + 3, $gray500, $fontFile, $user->company->business_name);
            } else {
                imagestring($image, $textFont, 25, $y, "Empresa:", $gray600);
                imagestring($image, $smallFont, 135, $y + 5, $user->company->business_name, $gray500);
            }
            $y += $lineHeight;
        }

        // Set content type and output
        header('Content-Type: image/png');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');

        imagepng($image);
        imagedestroy($image);
        exit;
    }

    /**
     * Generate company data image
     */
    public function generateCompanyImage()
    {
        $user = Auth::user();

        if (!$user || !$user->company) {
            abort(404);
        }

        $company = $user->company;

        // Create image (larger for company data)
        $width = 500;
        $height = 600;
        $image = imagecreatetruecolor($width, $height);

        // Colors - Tailwind CSS inspired
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        $sky600 = imagecolorallocate($image, 2, 132, 199); // sky-600
        $sky700 = imagecolorallocate($image, 3, 105, 161);  // sky-700
        $gray100 = imagecolorallocate($image, 243, 244, 246); // gray-100
        $gray200 = imagecolorallocate($image, 229, 231, 235); // gray-200
        $gray500 = imagecolorallocate($image, 107, 114, 128); // gray-500
        $gray600 = imagecolorallocate($image, 75, 85, 99);    // gray-600
        $green = imagecolorallocate($image, 34, 197, 94);    // green-500
        $red = imagecolorallocate($image, 239, 68, 68);      // red-500

        // Fill background with gray-100
        imagefill($image, 0, 0, $gray100);

        // Add white card background with padding
        imagefilledrectangle($image, 15, 15, $width - 15, $height - 15, $white);

        // Add subtle border
        imagerectangle($image, 15, 15, $width - 15, $height - 15, $gray200);


        // Find a suitable TrueType font for cross-platform compatibility
        $fontFile = $this->findFontFile();
        if (!$fontFile) {
            // Fallback to built-in fonts if no TrueType font found
            $titleFont = 5;
            $textFont = 3;
            $smallFont = 2;
            $useTTF = false;
        } else {
            $titleSize = 18;
            $labelSize = 14;
            $valueSize = 14;
            $smallSize = 11;
            $useTTF = true;
        }

        // Title with better positioning
        $title = "DATOS DE LA EMPRESA";
        if ($useTTF) {
            $titleBox = imagettfbbox($titleSize, 0, $fontFile, $title);
            $titleWidth = $titleBox[2] - $titleBox[0];
            $titleX = ($width - $titleWidth) / 2;
            imagettftext($image, $titleSize, 0, $titleX, 40, $black, $fontFile, $title);
        } else {
            $titleWidth = imagefontwidth($titleFont) * strlen($title);
            $titleX = ($width - $titleWidth) / 2;
            imagestring($image, $titleFont, $titleX, 25, $title, $black);
        }

        // Company data with better spacing
        $y = 65;
        $lineHeight = 25;

        // Business Name
        if ($useTTF) {
            imagettftext($image, $labelSize, 0, 35, $y, $gray600, $fontFile, "Nombre Comercial:");
            $this->wrapTextTTF($image, $company->business_name, 35, $y + 15, $width - 50, $smallSize, $gray500, $fontFile);
        } else {
            imagestring($image, $textFont, 35, $y, "Nombre Comercial:", $gray600);
            $this->wrapText($image, $company->business_name, 35, $y + 15, $width - 50, $smallFont, $gray500);
        }
        $y += $lineHeight * 2;

        // Phone
        if ($company->phone) {
            if ($useTTF) {
                imagettftext($image, $labelSize, 0, 35, $y, $gray600, $fontFile, "Teléfono:");
                imagettftext($image, $smallSize, 0, 145, $y + 3, $gray500, $fontFile, $company->phone);
            } else {
                imagestring($image, $textFont, 35, $y, "Teléfono:", $gray600);
                imagestring($image, $smallFont, 145, $y + 5, $company->phone, $gray500);
            }
            $y += $lineHeight;
        }

        // Email
        if ($company->email) {
            if ($useTTF) {
                imagettftext($image, $labelSize, 0, 35, $y, $gray600, $fontFile, "Email:");
                imagettftext($image, $smallSize, 0, 145, $y + 3, $gray500, $fontFile, $company->email);
            } else {
                imagestring($image, $textFont, 35, $y, "Email:", $gray600);
                imagestring($image, $smallFont, 145, $y + 5, $company->email, $gray500);
            }
            $y += $lineHeight;
        }

        // IBAN
        if ($company->iban_para_aeat) {
            if ($useTTF) {
                imagettftext($image, $labelSize, 0, 35, $y, $gray600, $fontFile, "IBAN:");
                imagettftext($image, $smallSize, 0, 145, $y + 3, $gray500, $fontFile, $company->iban_para_aeat);
            } else {
                imagestring($image, $textFont, 35, $y, "IBAN:", $gray600);
                imagestring($image, $smallFont, 145, $y + 5, $company->iban_para_aeat, $gray500);
            }
            $y += $lineHeight;
        }

        // SWIFT/BIC
        if ($company->swift_bic_para_aeat) {
            if ($useTTF) {
                imagettftext($image, $labelSize, 0, 35, $y, $gray600, $fontFile, "SWIFT/BIC:");
                imagettftext($image, $smallSize, 0, 145, $y + 3, $gray500, $fontFile, $company->swift_bic_para_aeat);
            } else {
                imagestring($image, $textFont, 35, $y, "SWIFT/BIC:", $gray600);
                imagestring($image, $smallFont, 145, $y + 5, $company->swift_bic_para_aeat, $gray500);
            }
            $y += $lineHeight;
        }

        // Separator with better styling
        $y += 15;
        imageline($image, 35, $y, $width - 35, $y, $gray200);
        $y += 20;

        // Boolean fields with colored indicators
        $booleanFields = [
            'inscrito_registro_devolucion_mensual' => 'Inscrito Registro Devolución Mensual',
            'tributa_exclusivamente_regimen_simplificado' => 'Tributa Régimen Simplificado',
            'autoliquidacion_conjunta' => 'Autoliquidación Conjunta',
            'declarado_concurso_acreedores' => 'Declarado Concurso Acreedores',
            'regimen_especial_criterio_caja' => 'Régimen Especial Criterio Caja',
            'opcion_criterio_caja' => 'Opción Criterio Caja',
            'aplicacion_prorrata_especial' => 'Aplicación Prorrata Especial',
            'revocacion_prorrata_especial' => 'Revocación Prorrata Especial',
            'exonerado_modelo_390' => 'Exonerado Modelo 390',
        ];

        foreach ($booleanFields as $field => $label) {
            if ($y > $height - 60) break; // Prevent overflow

            $value = $company->$field;
            $color = $value ? $green : $red;
            $text = $value ? 'Sí' : 'No';

            if ($useTTF) {
                imagettftext($image, $smallSize, 0, 35, $y, $gray600, $fontFile, $label . ":");
                imagettftext($image, $smallSize, 0, 380, $y, $color, $fontFile, $text);
            } else {
                imagestring($image, $smallFont, 35, $y, $label . ":", $gray600);
                imagestring($image, $smallFont, 380, $y, $text, $color);
            }
            $y += 20;
        }

        // Volumen Operaciones Modelo 390
        if ($company->volumen_operaciones_modelo_390) {
            $y += 10;
            if ($useTTF) {
                imagettftext($image, $labelSize, 0, 35, $y, $gray600, $fontFile, "Volumen Operaciones M390:");
                imagettftext($image, $smallSize, 0, 345, $y, $gray600, $fontFile, number_format($company->volumen_operaciones_modelo_390, 2));
            } else {
                imagestring($image, $textFont, 35, $y, "Volumen Operaciones M390:", $gray600);
                imagestring($image, $smallFont, 45, $y + 15, number_format($company->volumen_operaciones_modelo_390, 2), $gray500);
            }
        }

        // Set content type and output
        header('Content-Type: image/png');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');

        imagepng($image);
        imagedestroy($image);
        exit;
    }

    /**
     * Find a suitable TrueType font file across different platforms
     */
    private function findFontFile()
    {
        // Common font paths for different operating systems
        $fontPaths = [
            // macOS
            '/System/Library/Fonts/Arial.ttf',
            '/System/Library/Fonts/Helvetica.ttc',
            '/System/Library/Fonts/Times.ttf',
            '/Library/Fonts/Arial.ttf',

            // Linux
            '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf',
            '/usr/share/fonts/truetype/liberation/LiberationSans-Regular.ttf',
            '/usr/share/fonts/truetype/ubuntu-font-family/Ubuntu-R.ttf',
            '/usr/share/fonts/TTF/arial.ttf',

            // Windows
            'C:\\Windows\\Fonts\\arial.ttf',
            'C:\\Windows\\Fonts\\arialbd.ttf',
            'C:\\Windows\\Fonts\\calibri.ttf',
            'C:\\Windows\\Fonts\\verdana.ttf',

            // Fallback: try to find any .ttf file in common directories
        ];

        foreach ($fontPaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        // Try to find any .ttf file in common font directories
        $searchDirs = [
            '/usr/share/fonts/',
            '/usr/local/share/fonts/',
            '/System/Library/Fonts/',
            '/Library/Fonts/',
            'C:\\Windows\\Fonts\\',
        ];

        foreach ($searchDirs as $dir) {
            if (is_dir($dir)) {
                $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
                foreach ($iterator as $file) {
                    if ($file->isFile() && strtolower($file->getExtension()) === 'ttf') {
                        return $file->getPathname();
                    }
                }
            }
        }

        return null; // No font found
    }

    /**
     * Helper function to wrap text
     */
    private function wrapText($image, $text, $x, $y, $maxWidth, $font, $color)
    {
        $words = explode(' ', $text);
        $lines = [];
        $currentLine = '';

        foreach ($words as $word) {
            $testLine = $currentLine ? $currentLine . ' ' . $word : $word;
            $testWidth = imagefontwidth($font) * strlen($testLine);

            if ($testWidth <= $maxWidth) {
                $currentLine = $testLine;
            } else {
                if ($currentLine) {
                    $lines[] = $currentLine;
                }
                $currentLine = $word;
            }
        }

        if ($currentLine) {
            $lines[] = $currentLine;
        }

        foreach ($lines as $index => $line) {
            imagestring($image, $font, $x, $y + ($index * 15), $line, $color);
        }
    }

    /**
     * Helper function to wrap text for TrueType fonts
     */
    private function wrapTextTTF($image, $text, $x, $y, $maxWidth, $fontSize, $color, $fontFile)
    {
        $words = explode(' ', $text);
        $lines = [];
        $currentLine = '';

        foreach ($words as $word) {
            $testLine = $currentLine ? $currentLine . ' ' . $word : $word;
            $testBox = imagettfbbox($fontSize, 0, $fontFile, $testLine);
            $testWidth = $testBox[2] - $testBox[0];

            if ($testWidth <= $maxWidth) {
                $currentLine = $testLine;
            } else {
                if ($currentLine) {
                    $lines[] = $currentLine;
                }
                $currentLine = $word;
            }
        }

        if ($currentLine) {
            $lines[] = $currentLine;
        }

        foreach ($lines as $index => $line) {
            imagettftext($image, $fontSize, 0, $x, $y + ($index * 15), $color, $fontFile, $line);
        }
    }

    /**
     * Generate PDF with both user and company images
     */
    public function generatePDF()
    {
        $user = Auth::user();

        if (!$user) {
            abort(404);
        }

        try {
            // Generate user image data
            $userImageData = $this->generateUserImageData();

            // Generate company image data if user has company
            $companyImageData = null;
            if ($user->company) {
                $companyImageData = $this->generateCompanyImageData();
            }

            // Create PDF
            $pdf = Pdf::setOptions([
                'defaultFont' => 'Arial',
                'isRemoteEnabled' => true,
                'isHtml5ParserEnabled' => true,
                'enable_php' => true
            ]);

            // Create HTML content for PDF
            $html = view('pdf.images', [
                'user' => $user,
                'userImageData' => 'data:image/png;base64,' . base64_encode($userImageData),
                'companyImageData' => $companyImageData ? 'data:image/png;base64,' . base64_encode($companyImageData) : null
            ])->render();

            $pdf->loadHTML($html);
            $pdf->setPaper('A4', 'portrait');

            // Download PDF
            return $pdf->download('datos_usuario_empresa.pdf');
        } catch (\Exception $e) {
            // Log error and return simple error response
            \Log::error('PDF generation error: ' . $e->getMessage());
            abort(500, 'Error generating PDF. Please try again.');
        }
    }

    /**
     * Generate user image data (returns image data instead of outputting)
     */
    private function generateUserImageData()
    {
        $user = Auth::user();

        if (!$user) {
            abort(404);
        }

        // Create image
        $width = 400;
        $height = 300;
        $image = imagecreatetruecolor($width, $height);

        // Colors - Tailwind CSS inspired
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        $sky600 = imagecolorallocate($image, 2, 132, 199); // sky-600
        $gray100 = imagecolorallocate($image, 243, 244, 246); // gray-100
        $gray200 = imagecolorallocate($image, 229, 231, 235); // gray-200
        $gray500 = imagecolorallocate($image, 107, 114, 128); // gray-500
        $gray600 = imagecolorallocate($image, 75, 85, 99);    // gray-600

        // Fill background with gray-100
        imagefill($image, 0, 0, $gray100);

        // Add white card background with padding
        imagefilledrectangle($image, 15, 15, $width - 15, $height - 15, $white);

        // Add subtle border
        imagerectangle($image, 15, 15, $width - 15, $height - 15, $gray200);

        // Find a suitable TrueType font for cross-platform compatibility
        $fontFile = $this->findFontFile();
        if (!$fontFile) {
            // Fallback to built-in fonts if no TrueType font found
            $titleFont = 5;
            $textFont = 3;
            $smallFont = 2;
            $useTTF = false;
        } else {
            $titleSize = 18;
            $labelSize = 14;
            $valueSize = 14;
            $smallSize = 11;
            $useTTF = true;
        }

        // Title with better positioning
        $title = "DATOS DEL USUARIO";
        if ($useTTF) {
            $titleBox = imagettfbbox($titleSize, 0, $fontFile, $title);
            $titleWidth = $titleBox[2] - $titleBox[0];
            $titleX = ($width - $titleWidth) / 2;
            imagettftext($image, $titleSize, 0, $titleX, 40, $black, $fontFile, $title);
        } else {
            $titleWidth = imagefontwidth($titleFont) * strlen($title);
            $titleX = ($width - $titleWidth) / 2;
            imagestring($image, $titleFont, $titleX, 25, $title, $black);
        }

        // User data with better spacing
        $y = 65;
        $lineHeight = 30;

        // Name
        if ($useTTF) {
            imagettftext($image, $labelSize, 0, 35, $y, $gray600, $fontFile, "Nombre:");
            imagettftext($image, $valueSize, 0, 115, $y, $black, $fontFile, $user->name);
        } else {
            imagestring($image, $textFont, 35, $y, "Nombre:", $gray600);
            imagestring($image, $textFont, 115, $y, $user->name, $black);
        }
        $y += $lineHeight;

        // Email
        if ($useTTF) {
            imagettftext($image, $labelSize, 0, 35, $y, $gray600, $fontFile, "Email:");
            imagettftext($image, $smallSize, 0, 115, $y + 3, $gray500, $fontFile, $user->email);
        } else {
            imagestring($image, $textFont, 35, $y, "Email:", $gray600);
            imagestring($image, $smallFont, 115, $y + 5, $user->email, $gray500);
        }
        $y += $lineHeight;

        // Company
        if ($user->company) {
            if ($useTTF) {
                imagettftext($image, $labelSize, 0, 25, $y, $gray600, $fontFile, "Empresa:");
                imagettftext($image, $smallSize, 0, 125, $y + 3, $gray500, $fontFile, $user->company->business_name);
            } else {
                imagestring($image, $textFont, 25, $y, "Empresa:", $gray600);
                imagestring($image, $smallFont, 135, $y + 5, $user->company->business_name, $gray500);
            }
            $y += $lineHeight;
        }

        // Capture image to string
        ob_start();
        imagepng($image);
        $imageData = ob_get_contents();
        ob_end_clean();

        imagedestroy($image);
        return $imageData;
    }

    /**
     * Generate company image data (returns image data instead of outputting)
     */
    private function generateCompanyImageData()
    {
        $user = Auth::user();

        if (!$user || !$user->company) {
            abort(404);
        }

        $company = $user->company;

        // Create image (larger for company data)
        $width = 500;
        $height = 600;
        $image = imagecreatetruecolor($width, $height);

        // Colors - Tailwind CSS inspired
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        $sky600 = imagecolorallocate($image, 2, 132, 199); // sky-600
        $sky700 = imagecolorallocate($image, 3, 105, 161);  // sky-700
        $gray100 = imagecolorallocate($image, 243, 244, 246); // gray-100
        $gray200 = imagecolorallocate($image, 229, 231, 235); // gray-200
        $gray500 = imagecolorallocate($image, 107, 114, 128); // gray-500
        $gray600 = imagecolorallocate($image, 75, 85, 99);    // gray-600
        $green = imagecolorallocate($image, 34, 197, 94);    // green-500
        $red = imagecolorallocate($image, 239, 68, 68);      // red-500

        // Fill background with gray-100
        imagefill($image, 0, 0, $gray100);

        // Add white card background with padding
        imagefilledrectangle($image, 15, 15, $width - 15, $height - 15, $white);

        // Add subtle border
        imagerectangle($image, 15, 15, $width - 15, $height - 15, $gray200);

        // Find a suitable TrueType font for cross-platform compatibility
        $fontFile = $this->findFontFile();
        if (!$fontFile) {
            // Fallback to built-in fonts if no TrueType font found
            $titleFont = 5;
            $textFont = 3;
            $smallFont = 2;
            $useTTF = false;
        } else {
            $titleSize = 18;
            $labelSize = 14;
            $valueSize = 14;
            $smallSize = 11;
            $useTTF = true;
        }

        // Title with better positioning
        $title = "DATOS DE LA EMPRESA";
        if ($useTTF) {
            $titleBox = imagettfbbox($titleSize, 0, $fontFile, $title);
            $titleWidth = $titleBox[2] - $titleBox[0];
            $titleX = ($width - $titleWidth) / 2;
            imagettftext($image, $titleSize, 0, $titleX, 40, $black, $fontFile, $title);
        } else {
            $titleWidth = imagefontwidth($titleFont) * strlen($title);
            $titleX = ($width - $titleWidth) / 2;
            imagestring($image, $titleFont, $titleX, 25, $title, $black);
        }

        // Company data with better spacing
        $y = 65;
        $lineHeight = 25;

        // Business Name
        if ($useTTF) {
            imagettftext($image, $labelSize, 0, 35, $y, $gray600, $fontFile, "Nombre Comercial:");
            $this->wrapTextTTF($image, $company->business_name, 35, $y + 15, $width - 50, $smallSize, $gray500, $fontFile);
        } else {
            imagestring($image, $textFont, 35, $y, "Nombre Comercial:", $gray600);
            $this->wrapText($image, $company->business_name, 35, $y + 15, $width - 50, $smallFont, $gray500);
        }
        $y += $lineHeight * 2;

        // Phone
        if ($company->phone) {
            if ($useTTF) {
                imagettftext($image, $labelSize, 0, 35, $y, $gray600, $fontFile, "Teléfono:");
                imagettftext($image, $smallSize, 0, 145, $y + 3, $gray500, $fontFile, $company->phone);
            } else {
                imagestring($image, $textFont, 35, $y, "Teléfono:", $gray600);
                imagestring($image, $smallFont, 145, $y + 5, $company->phone, $gray500);
            }
            $y += $lineHeight;
        }

        // Email
        if ($company->email) {
            if ($useTTF) {
                imagettftext($image, $labelSize, 0, 35, $y, $gray600, $fontFile, "Email:");
                imagettftext($image, $smallSize, 0, 145, $y + 3, $gray500, $fontFile, $company->email);
            } else {
                imagestring($image, $textFont, 35, $y, "Email:", $gray600);
                imagestring($image, $smallFont, 145, $y + 5, $company->email, $gray500);
            }
            $y += $lineHeight;
        }

        // IBAN
        if ($company->iban_para_aeat) {
            if ($useTTF) {
                imagettftext($image, $labelSize, 0, 35, $y, $gray600, $fontFile, "IBAN:");
                imagettftext($image, $smallSize, 0, 145, $y + 3, $gray500, $fontFile, $company->iban_para_aeat);
            } else {
                imagestring($image, $textFont, 35, $y, "IBAN:", $gray600);
                imagestring($image, $smallFont, 145, $y + 5, $company->iban_para_aeat, $gray500);
            }
            $y += $lineHeight;
        }

        // SWIFT/BIC
        if ($company->swift_bic_para_aeat) {
            if ($useTTF) {
                imagettftext($image, $labelSize, 0, 35, $y, $gray600, $fontFile, "SWIFT/BIC:");
                imagettftext($image, $smallSize, 0, 145, $y + 3, $gray500, $fontFile, $company->swift_bic_para_aeat);
            } else {
                imagestring($image, $textFont, 35, $y, "SWIFT/BIC:", $gray600);
                imagestring($image, $smallFont, 145, $y + 5, $company->swift_bic_para_aeat, $gray500);
            }
            $y += $lineHeight;
        }

        // Separator with better styling
        $y += 15;
        imageline($image, 35, $y, $width - 35, $y, $gray200);
        $y += 20;

        // Boolean fields with colored indicators
        $booleanFields = [
            'inscrito_registro_devolucion_mensual' => 'Inscrito Registro Devolución Mensual',
            'tributa_exclusivamente_regimen_simplificado' => 'Tributa Régimen Simplificado',
            'autoliquidacion_conjunta' => 'Autoliquidación Conjunta',
            'declarado_concurso_acreedores' => 'Declarado Concurso Acreedores',
            'regimen_especial_criterio_caja' => 'Régimen Especial Criterio Caja',
            'opcion_criterio_caja' => 'Opción Criterio Caja',
            'aplicacion_prorrata_especial' => 'Aplicación Prorrata Especial',
            'revocacion_prorrata_especial' => 'Revocación Prorrata Especial',
            'exonerado_modelo_390' => 'Exonerado Modelo 390',
        ];

        foreach ($booleanFields as $field => $label) {
            if ($y > $height - 60) break; // Prevent overflow

            $value = $company->$field;
            $color = $value ? $green : $red;
            $text = $value ? 'Sí' : 'No';

            if ($useTTF) {
                imagettftext($image, $smallSize, 0, 35, $y, $gray600, $fontFile, $label . ":");
                imagettftext($image, $smallSize, 0, 380, $y, $color, $fontFile, $text);
            } else {
                imagestring($image, $smallFont, 35, $y, $label . ":", $gray600);
                imagestring($image, $smallFont, 380, $y, $text, $color);
            }
            $y += 20;
        }

        // Volumen Operaciones Modelo 390
        if ($company->volumen_operaciones_modelo_390) {
            $y += 10;
            if ($useTTF) {
                imagettftext($image, $labelSize, 0, 35, $y, $gray600, $fontFile, "Volumen Operaciones M390:");
                imagettftext($image, $smallSize, 0, 345, $y, $gray600, $fontFile, number_format($company->volumen_operaciones_modelo_390, 2));
            } else {
                imagestring($image, $textFont, 35, $y, "Volumen Operaciones M390:", $gray600);
                imagestring($image, $smallFont, 45, $y + 15, number_format($company->volumen_operaciones_modelo_390, 2), $gray500);
            }
        }

        // Capture image to string
        ob_start();
        imagepng($image);
        $imageData = ob_get_contents();
        ob_end_clean();

        imagedestroy($image);
        return $imageData;
    }
}
