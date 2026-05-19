<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Vacunación - {{ $historial->mascota->nombre }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333333;
            margin: 0;
            padding: 0;
            line-height: 1.4;
        }
        .contenedor-comprobante {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 30px;
            background: #ffffff;
        }
        .tabla-cabecera {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            border-bottom: 2px solid #059669;
            padding-bottom: 15px;
        }
        .texto-logo {
            font-size: 26px;
            font-weight: bold;
            color: #059669;
        }
        .subtitulo {
            font-size: 12px;
            color: #666666;
            margin-top: 3px;
        }
        .titulo-documento {
            font-size: 20px;
            font-weight: bold;
            color: #0f172a;
            text-align: right;
            text-transform: uppercase;
        }
        .caja-folio {
            font-size: 13px;
            font-weight: bold;
            color: #4b5563;
            text-align: right;
            margin-top: 5px;
        }
        .tabla-datos {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .tabla-datos td {
            padding: 8px 0;
            font-size: 13px;
            vertical-align: top;
        }
        .etiqueta {
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
            display: block;
            margin-bottom: 2px;
        }
        .valor {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }
        .tabla-detalles {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .tabla-detalles th {
            background: #f1f5f9;
            color: #475569;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: left;
            padding: 12px 15px;
            border-bottom: 1px solid #cbd5e1;
        }
        .tabla-detalles td {
            padding: 15px;
            font-size: 14px;
            border-bottom: 1px solid #e2e8f0;
        }
        .caja-totales {
            width: 100%;
            border-collapse: collapse;
        }
        .caja-totales td {
            padding: 8px 15px;
            font-size: 14px;
        }
        .etiqueta-total {
            font-weight: bold;
            color: #475569;
            text-align: right;
        }
        .valor-total {
            font-size: 18px;
            font-weight: bold;
            color: #059669;
            text-align: right;
        }
        .contenedor-sello {
            margin-top: 20px;
            text-align: center;
        }
        .sello-pagado {
            display: inline-block;
            border: 3px solid #059669;
            color: #059669;
            font-size: 20px;
            font-weight: 900;
            text-transform: uppercase;
            padding: 8px 25px;
            border-radius: 6px;
            transform: rotate(-5deg);
            opacity: 0.85;
            letter-spacing: 2px;
        }
        .pie-pagina {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            padding-top: 15px;
        }
    </style>
</head>
<body>

    <div class="contenedor-comprobante">
        <table class="tabla-cabecera">
            <tr>
                <td>
                    <div class="texto-logo">Veterinaria Patitas</div>
                    <div class="subtitulo">Tu mascota, nuestro compromiso</div>
                </td>
                <td style="text-align: right;">
                    <div class="titulo-documento">Comprobante de Pago</div>
                    <div class="caja-folio">FOLIO VAC-#{{ $historial->id }}</div>
                </td>
            </tr>
        </table>

        <table class="tabla-datos">
            <tr>
                <td style="width: 50%;">
                    <span class="etiqueta">Cliente / Propietario</span>
                    <span class="valor">{{ $historial->mascota->dueno_nombre }}</span>
                    <span style="font-size: 12px; color: #64748b; display: block; margin-top: 3px;">
                        Correo: {{ $historial->mascota->dueno_correo ?? 'N/A' }}
                    </span>
                </td>
                <td style="width: 50%; text-align: right;">
                    <span class="etiqueta">Fecha de Emisión</span>
                    <span class="valor">{{ $historial->fecha_consulta->format('d/m/Y H:i') }} hrs</span>
                </td>
            </tr>
            <tr>
                <td style="padding-top: 15px;">
                    <span class="etiqueta">Paciente / Mascota</span>
                    <span class="valor">{{ $historial->mascota->nombre }} ({{ $historial->mascota->especie }})</span>
                </td>
                <td style="padding-top: 15px; text-align: right;">
                    <span class="etiqueta">Médico Veterinario</span>
                    <span class="valor">{{ $historial->veterinario->nombre }}</span>
                </td>
            </tr>
        </table>

        <table class="tabla-detalles">
            <thead>
                <tr>
                    <th style="width: 70%;">Concepto / Descripción</th>
                    <th style="width: 30%; text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>Aplicación de Biológico: {{ $historial->vacuna_nombre }}</strong>
                        <div style="font-size: 12px; color: #64748b; margin-top: 3px;">
                            Incluye jeringa estéril, preparación, aplicación y registro en cartilla de vacunación.
                        </div>
                    </td>
                    <td style="text-align: right; font-weight: bold; color: #1e293b;">
                        ${{ number_format($historial->vacuna_precio, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="caja-totales">
            <tr>
                <td style="width: 70%;" class="etiqueta-total">Subtotal:</td>
                <td style="width: 30%;" class="valor-total" style="font-size: 14px; color: #475569;">
                    ${{ number_format($historial->vacuna_precio, 2) }}
                </td>
            </tr>
            <tr>
                <td class="etiqueta-total">Total Pagado (MXN):</td>
                <td class="valor-total">
                    ${{ number_format($historial->vacuna_precio, 2) }}
                </td>
            </tr>
        </table>

        <div class="contenedor-sello">
            <div class="sello-pagado">PAGADO</div>
        </div>

        <div class="pie-pagina">
            Este documento es un comprobante simplificado de pago por servicios médicos de vacunación.<br>
            Veterinaria Patitas S.A. de C.V. • contacto@veterinariapatitas.com<br>
            ¡Gracias por cuidar de tu mascota con nosotros!
        </div>
    </div>

</body>
</html>
