<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Receta Médica - {{ $historial->mascota->nombre }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333333;
            margin: 0;
            padding: 0;
            line-height: 1.4;
        }
        .tabla-cabecera {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            border-bottom: 2px solid #0d9488;
            padding-bottom: 15px;
        }
        .texto-logo {
            font-size: 26px;
            font-weight: bold;
            color: #0d9488;
        }
        .subtitulo {
            font-size: 12px;
            color: #666666;
            margin-top: 3px;
        }
        .titulo-documento {
            font-size: 22px;
            font-weight: bold;
            color: #0f172a;
            text-align: right;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .caja-fecha {
            font-size: 12px;
            color: #4b5563;
            text-align: right;
            margin-top: 5px;
        }
        .tabla-datos {
            width: 100%;
            border-collapse: collapse;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        .tabla-datos td {
            padding: 10px 15px;
            font-size: 13px;
            vertical-align: top;
        }
        .etiqueta {
            font-weight: bold;
            color: #475569;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 0.5px;
            display: block;
            margin-bottom: 3px;
        }
        .valor {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }
        .titulo-seccion {
            font-size: 15px;
            font-weight: bold;
            color: #0d9488;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 6px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .contenido-seccion {
            font-size: 14px;
            color: #334155;
            margin-bottom: 25px;
            padding-left: 5px;
        }
        .texto-receta {
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
            background: #fafafa;
            border: 1px solid #e2e8f0;
            padding: 15px;
            border-radius: 6px;
            color: #1e293b;
            white-space: pre-wrap;
            line-height: 1.6;
        }
        .tabla-pie {
            width: 100%;
            margin-top: 80px;
            border-collapse: collapse;
        }
        .linea-firma {
            width: 200px;
            border-bottom: 1px solid #94a3b8;
            margin: 0 auto 5px;
        }
    </style>
</head>
<body>

    <table class="tabla-cabecera">
        <tr>
            <td>
                <div class="texto-logo">Veterinaria Patitas</div>
                <div class="subtitulo">Tu mascota, nuestro compromiso</div>
            </td>
            <td style="text-align: right;">
                <div class="titulo-documento">Receta Médica</div>
                <div class="caja-fecha">Fecha: {{ $historial->fecha_consulta->format('d/m/Y') }}</div>
            </td>
        </tr>
    </table>

    <table class="tabla-datos">
        <tr>
            <td style="width: 25%; border-right: 1px solid #e2e8f0;">
                <span class="etiqueta">Mascota</span>
                <span class="valor">{{ $historial->mascota->nombre }}</span>
            </td>
            <td style="width: 25%; border-right: 1px solid #e2e8f0;">
                <span class="etiqueta">Especie / Raza</span>
                <span class="valor">{{ $historial->mascota->especie }} / {{ $historial->mascota->raza ?? 'Mestizo' }}</span>
            </td>
            <td style="width: 25%; border-right: 1px solid #e2e8f0;">
                <span class="etiqueta">Propietario</span>
                <span class="valor">{{ $historial->mascota->dueno_nombre }}</span>
            </td>
            <td style="width: 25%;">
                <span class="etiqueta">Médico Veterinario</span>
                <span class="valor">{{ $historial->veterinario->nombre }}</span>
            </td>
        </tr>
        <tr>
            <td style="border-right: 1px solid #e2e8f0; border-top: 1px solid #e2e8f0;">
                <span class="etiqueta">Peso</span>
                <span class="valor">{{ $historial->peso ?? '-' }} kg</span>
            </td>
            <td style="border-right: 1px solid #e2e8f0; border-top: 1px solid #e2e8f0;">
                <span class="etiqueta">Temperatura</span>
                <span class="valor">{{ $historial->temperatura ?? '-' }} °C</span>
            </td>
            <td style="border-right: 1px solid #e2e8f0; border-top: 1px solid #e2e8f0;">
                <span class="etiqueta">Frec. Cardíaca</span>
                <span class="valor">{{ $historial->frecuencia_cardiaca ?? '-' }} lpm</span>
            </td>
            <td style="border-top: 1px solid #e2e8f0;">
                <span class="etiqueta">Próxima Consulta</span>
                <span class="valor">{{ $historial->proxima_cita_estimada ? $historial->proxima_cita_estimada->format('d/m/Y') : 'N/A' }}</span>
            </td>
        </tr>
    </table>

    <div class="titulo-seccion">Diagnóstico</div>
    <div class="contenido-seccion" style="font-weight: 600;">
        {{ $historial->diagnostico }}
    </div>

    <div class="titulo-seccion">Prescripción / Indicaciones de Tratamiento</div>
    <div class="contenido-seccion">
        <div class="texto-receta">{{ $historial->tratamiento }}</div>
    </div>

    <table class="tabla-pie">
        <tr>
            <td style="text-align: center; width: 50%;">
                <!-- Espacio firma doctor -->
                <div class="linea-firma"></div>
                <div style="font-size: 12px; font-weight: bold; color: #475569;">{{ $historial->veterinario->nombre }}</div>
                <div style="font-size: 10px; color: #94a3b8;">Médico Veterinario Firmante</div>
            </td>
            <td style="text-align: center; width: 50%; vertical-align: middle;">
                <div style="font-size: 11px; color: #94a3b8;">
                    Veterinaria Patitas S.A. de C.V.<br>
                    Contacto: +52 555-123-4567<br>
                    contacto@veterinariapatitas.com
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
