<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Resumen de Atención Veterinaria</title>
</head>
<body style="margin:0;padding:0;background:#f3f4f6;font-family:'Segoe UI',Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 20px;">
  <tr><td align="center">
    <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;">

      {{-- HEADER --}}
      <tr>
        <td style="background:linear-gradient(135deg,#0d9488,#0f766e,#115e59);border-radius:16px 16px 0 0;padding:40px;text-align:center;">
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="#e2fdfb" stroke-width="1.5" style="display:inline-block;margin-bottom:12px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15m-15 0 2.212-2.212a2.25 2.25 0 0 1 1.591-.659h6.794a2.25 2.25 0 0 1 1.59.659L19.8 15m-15 0v2.25A2.25 2.25 0 0 0 7.05 19.5h9.9A2.25 2.25 0 0 0 19.2 17.25v-2.25" />
          </svg>
          <h1 style="margin:0;color:#fff;font-size:26px;font-weight:700;">Atención Clínica Finalizada</h1>
          <p style="margin:8px 0 0;color:#e2fdfb;font-size:14px;">Veterinaria Patitas • Cuidado y bienestar profesional</p>
        </td>
      </tr>

      {{-- BODY --}}
      <tr>
        <td style="background:#fff;padding:40px;">

          <h2 style="margin:0 0 8px;font-size:22px;color:#1f2937;font-weight:700;">
            Hola, {{ $historial->mascota->dueno_nombre }} 👋
          </h2>
          
          <p style="margin:0 0 28px;color:#6b7280;font-size:15px;line-height:1.6;">
            Te informamos que la consulta médica de tu mascota <strong>{{ $historial->mascota->nombre }}</strong> ha sido completada con éxito. Hemos adjuntado a este correo tu <strong>Receta Médica</strong> oficial en PDF, y el <strong>Comprobante de Vacunación</strong> si fue aplicado.
          </p>

          {{-- TARJETA DE RESUMEN --}}
          <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;margin-bottom:28px;">
            
            <tr><td style="padding:14px 24px;border-bottom:1px solid #e2e8f0;">
              <p style="margin:0;font-size:11px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.8px;font-weight:700;">RESUMEN DE LA CONSULTA</p>
            </td></tr>

            {{-- Mascota --}}
            <tr>
              <td style="padding:14px 24px;border-bottom:1px solid #f1f5f9;">
                <table cellpadding="0" cellspacing="0">
                  <tr>
                    <td style="width:32px;vertical-align:middle;">
                      <div style="width:32px;height:32px;background:#ede9fe;border-radius:8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#7c3aed" stroke-width="1.75" style="display:block;margin:7px auto;">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                      </div>
                    </td>
                    <td style="vertical-align:middle;padding-left:12px;">
                      <p style="margin:0;font-size:11px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Paciente</p>
                      <p style="margin:2px 0 0;font-size:15px;color:#1f2937;font-weight:600;">{{ $historial->mascota->nombre }}</p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            {{-- Veterinario --}}
            <tr>
              <td style="padding:14px 24px;border-bottom:1px solid #f1f5f9;">
                <table cellpadding="0" cellspacing="0">
                  <tr>
                    <td style="width:32px;vertical-align:middle;">
                      <div style="width:32px;height:32px;background:#dbeafe;border-radius:8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#1d4ed8" stroke-width="1.75" style="display:block;margin:7px auto;">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 0 1-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 0 1 4.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15m-15 0 2.212-2.212a2.25 2.25 0 0 1 1.591-.659h6.794a2.25 2.25 0 0 1 1.59.659L19.8 15m-15 0v2.25A2.25 2.25 0 0 0 7.05 19.5h9.9A2.25 2.25 0 0 0 19.2 17.25v-2.25" />
                        </svg>
                      </div>
                    </td>
                    <td style="vertical-align:middle;padding-left:12px;">
                      <p style="margin:0;font-size:11px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Atendido por</p>
                      <p style="margin:2px 0 0;font-size:15px;color:#1f2937;font-weight:600;">{{ $historial->veterinario->nombre }}</p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            {{-- Diagnostico --}}
            <tr>
              <td style="padding:14px 24px;border-bottom:1px solid #f1f5f9;">
                <table cellpadding="0" cellspacing="0">
                  <tr>
                    <td style="width:32px;vertical-align:middle;">
                      <div style="width:32px;height:32px;background:#f0fdf4;border-radius:8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#15803d" stroke-width="1.75" style="display:block;margin:7px auto;">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z" />
                        </svg>
                      </div>
                    </td>
                    <td style="vertical-align:middle;padding-left:12px;">
                      <p style="margin:0;font-size:11px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Diagnóstico</p>
                      <p style="margin:2px 0 0;font-size:15px;color:#1f2937;">{{ $historial->diagnostico }}</p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            {{-- Vacuna --}}
            @if($historial->aplico_vacuna)
            <tr>
              <td style="padding:14px 24px;">
                <table cellpadding="0" cellspacing="0">
                  <tr>
                    <td style="width:32px;vertical-align:middle;">
                      <div style="width:32px;height:32px;background:#fdf2f8;border-radius:8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#9d174d" stroke-width="1.75" style="display:block;margin:7px auto;">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L9.568 3Z" />
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                        </svg>
                      </div>
                    </td>
                    <td style="vertical-align:middle;padding-left:12px;">
                      <p style="margin:0;font-size:11px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Biológico Aplicado</p>
                      <p style="margin:2px 0 0;font-size:15px;color:#1f2937;font-weight:600;">{{ $historial->vacuna_nombre }}</p>
                      <p style="margin:2px 0 0;font-size:13px;color:#0d9488;font-weight:600;">Costo: ${{ number_format($historial->vacuna_precio, 2) }} (Pagado)</p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            @endif

          </table>

          {{-- NOTA --}}
          <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
            <tr>
              <td style="background:#eff6ff;border-left:4px solid #0d9488;border-radius:0 8px 8px 0;padding:14px 18px;">
                <table cellpadding="0" cellspacing="0">
                  <tr>
                    <td style="vertical-align:top;padding-right:10px;">
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#0f766e" stroke-width="2" style="display:block;margin-top:1px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                      </svg>
                    </td>
                    <td>
                      <p style="margin:0;font-size:14px;color:#1e40af;line-height:1.5;">
                        <strong>Archivos Adjuntos:</strong> Encontrarás los documentos PDF adjuntos a este correo electrónico. Consérvalos para tu registro personal o impresión.
                      </p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>

        </td>
      </tr>

      {{-- FOOTER --}}
      <tr>
        <td style="background:#f8fafc;border-top:1px solid #e5e7eb;border-radius:0 0 16px 16px;padding:24px 40px;text-align:center;">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#0d9488" stroke-width="1.5" style="display:inline-block;margin-bottom:8px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
          </svg>
          <p style="margin:0 0 4px;font-size:13px;color:#6b7280;font-weight:600;">Veterinaria Patitas &copy; {{ date('Y') }}</p>
          <p style="margin:0;font-size:12px;color:#9ca3af;">Este correo fue generado automáticamente, por favor no respondas.</p>
        </td>
      </tr>

    </table>
  </td></tr>
</table>
</body>
</html>
