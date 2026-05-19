<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Veterinaria Patitas</title>
</head>
<body style="margin:0;padding:0;background:#f3f4f6;font-family:'Segoe UI',Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 20px;">
  <tr><td align="center">
    <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%;">

      {{-- HEADER --}}
      <tr>
        <td style="background:linear-gradient(135deg,#6366f1,#8b5cf6,#a855f7);border-radius:16px 16px 0 0;padding:40px;text-align:center;">
          <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="#e0e7ff" stroke-width="1.5" style="display:inline-block;margin-bottom:12px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
          </svg>
          <h1 style="margin:0;color:#fff;font-size:26px;font-weight:700;">Veterinaria Patitas</h1>
          <p style="margin:8px 0 0;color:#e0e7ff;font-size:14px;">Tu mascota, nuestro compromiso</p>
        </td>
      </tr>

      {{-- BODY --}}
      <tr>
        <td style="background:#fff;padding:40px;">

          {{-- Badge de estado --}}
          <div style="text-align:center;margin-bottom:28px;">
            @if($tipo === 'creada')
              <span style="display:inline-flex;align-items:center;gap:6px;background:#d1fae5;color:#065f46;font-size:13px;font-weight:600;padding:6px 16px;border-radius:999px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#065f46" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                Cita confirmada
              </span>
            @elseif($tipo === 'actualizada')
              <span style="display:inline-flex;align-items:center;gap:6px;background:#dbeafe;color:#1e40af;font-size:13px;font-weight:600;padding:6px 16px;border-radius:999px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#1e40af" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
                Cita actualizada
              </span>
            @else
              <span style="display:inline-flex;align-items:center;gap:6px;background:#fee2e2;color:#991b1b;font-size:13px;font-weight:600;padding:6px 16px;border-radius:999px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#991b1b" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                Cita cancelada
              </span>
            @endif
          </div>

          <h2 style="margin:0 0 8px;font-size:22px;color:#1f2937;font-weight:700;">
            Hola, {{ $cita->mascota->dueno_nombre ?? 'estimado/a' }} 👋
          </h2>
          
          <p style="margin:0 0 28px;color:#6b7280;font-size:15px;line-height:1.6;">
            @if($tipo === 'creada')
              Te confirmamos que la cita para tu mascota ha sido <strong>registrada exitosamente</strong>.
            @elseif($tipo === 'actualizada')
              Los datos de la cita para tu mascota han sido <strong>actualizados</strong>.
            @else
              La cita para tu mascota ha sido <strong>cancelada</strong>.
            @endif
          </p>

          {{-- TARJETA DE DETALLES --}}
          <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;margin-bottom:28px;">
            
            <tr><td style="padding:14px 24px;border-bottom:1px solid #e2e8f0;">
              <p style="margin:0;font-size:11px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.8px;font-weight:700;">DETALLES DE LA CITA</p>
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
                      <p style="margin:0;font-size:11px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Mascota</p>
                      <p style="margin:2px 0 0;font-size:15px;color:#1f2937;font-weight:600;">{{ $cita->mascota->nombre ?? '-' }}</p>
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
                      <p style="margin:0;font-size:11px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Veterinario</p>
                      <p style="margin:2px 0 0;font-size:15px;color:#1f2937;font-weight:600;">{{ $cita->veterinario->nombre ?? '-' }}</p>
                      @if($cita->veterinario && $cita->veterinario->especialidad)
                        <p style="margin:2px 0 0;font-size:12px;color:#6366f1;font-weight:600;">{{ $cita->veterinario->especialidad }}</p>
                      @endif
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            {{-- Fecha --}}
            <tr>
              <td style="padding:14px 24px;border-bottom:1px solid #f1f5f9;">
                <table cellpadding="0" cellspacing="0">
                  <tr>
                    <td style="width:32px;vertical-align:middle;">
                      <div style="width:32px;height:32px;background:#fef3c7;border-radius:8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#b45309" stroke-width="1.75" style="display:block;margin:7px auto;">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                      </div>
                    </td>
                    <td style="vertical-align:middle;padding-left:12px;">
                      <p style="margin:0;font-size:11px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Fecha y Hora</p>
                      <p style="margin:2px 0 0;font-size:15px;color:#1f2937;font-weight:600;">
                        {{ $cita->fecha_hora->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                      </p>
                      <p style="margin:2px 0 0;font-size:12px;color:#6366f1;font-weight:600;">
                        {{ $cita->fecha_hora->format('H:i') }} hrs
                      </p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            {{-- Motivo --}}
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
                      <p style="margin:0;font-size:11px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Motivo</p>
                      <p style="margin:2px 0 0;font-size:15px;color:#1f2937;">{{ $cita->motivo }}</p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            {{-- Estado --}}
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
                      <p style="margin:0;font-size:11px;color:#9ca3af;text-transform:uppercase;letter-spacing:0.5px;">Estado</p>
                      <p style="margin:2px 0 0;font-size:15px;color:#1f2937;font-weight:600;">{{ $cita->estado }}</p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

          </table>

          {{-- NOTA --}}
          @if($tipo !== 'cancelada')
          <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
            <tr>
              <td style="background:#eff6ff;border-left:4px solid #6366f1;border-radius:0 8px 8px 0;padding:14px 18px;">
                <table cellpadding="0" cellspacing="0">
                  <tr>
                    <td style="vertical-align:top;padding-right:10px;">
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#3730a3" stroke-width="2" style="display:block;margin-top:1px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                      </svg>
                    </td>
                    <td>
                      <p style="margin:0;font-size:14px;color:#1e40af;line-height:1.5;">
                        <strong>Recuerda:</strong> Llega 10 minutos antes. Si necesitas cancelar, contáctanos con anticipación.
                      </p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          @endif

        </td>
      </tr>

      {{-- FOOTER --}}
      <tr>
        <td style="background:#f8fafc;border-top:1px solid #e5e7eb;border-radius:0 0 16px 16px;padding:24px 40px;text-align:center;">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#a855f7" stroke-width="1.5" style="display:inline-block;margin-bottom:8px;">
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
