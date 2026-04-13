<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Datos de Usuario y Empresa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #0284c7;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #0284c7;
            margin: 0;
            font-size: 24px;
        }
        .section {
            margin-bottom: 30px;
            text-align: center;
        }
        .section h2 {
            color: #0284c7;
            margin-bottom: 15px;
            font-size: 18px;
        }
        .image-container {
            display: inline-block;
            border: 1px solid #ddd;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 5px;
        }
        .image-container img {
            max-width: 100%;
            height: auto;
            display: block;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Informe de Datos de Usuario y Empresa</h1>
        <p>Generado el: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <div class="section">
        <h2>Datos del Usuario</h2>
        <div class="image-container">
            <img src="{{ $userImageData }}" alt="Datos del Usuario" />
        </div>
    </div>

    @if($companyImageData)
    <div class="section">
        <h2>Datos de la Empresa</h2>
        <div class="image-container">
            <img src="{{ $companyImageData }}" alt="Datos de la Empresa" />
        </div>
    </div>
    @endif

    <div class="footer">
        <p>Documento generado automáticamente desde el sistema</p>
        <p>Usuario: {{ $user->name }} ({{ $user->email }})</p>
    </div>
</body>
</html>
