<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambio de Estado - Solicitud de Software</title>
</head>
<body style="margin:0; padding:0; background-color:#f3f4f6; font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="padding:30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1);">

                    {{-- Header --}}
                    <tr>
                        <td style="background:linear-gradient(135deg,#4f46e5,#6366f1); padding:30px; text-align:center;">
                            <h1 style="color:#ffffff; margin:0; font-size:22px;">📬 Actualización de Solicitud</h1>
                            <p style="color:#c7d2fe; margin:5px 0 0; font-size:14px;">Sistema de Bitácoras de Laboratorio</p>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding:30px;">
                            <p style="color:#374151; font-size:16px; margin:0 0 20px;">
                                Tu solicitud de software ha sido actualizada:
                            </p>

                            <table width="100%" cellpadding="10" cellspacing="0" style="background:#f9fafb; border-radius:8px; border:1px solid #e5e7eb;">
                                <tr>
                                    <td style="color:#6b7280; font-size:14px; border-bottom:1px solid #e5e7eb; width:40%;">Software:</td>
                                    <td style="color:#111827; font-size:14px; border-bottom:1px solid #e5e7eb; font-weight:600;">
                                        {{ $solicitud->software }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color:#6b7280; font-size:14px; border-bottom:1px solid #e5e7eb;">Nuevo estado:</td>
                                    <td style="font-size:14px; border-bottom:1px solid #e5e7eb; font-weight:700;
                                        @if(strtolower($nuevoEstado) === 'aprobada' || strtolower($nuevoEstado) === 'instalado')
                                            color:#059669;
                                        @elseif(strtolower($nuevoEstado) === 'rechazada')
                                            color:#dc2626;
                                        @else
                                            color:#d97706;
                                        @endif
                                    ">
                                        {{ ucfirst($nuevoEstado) }}
                                    </td>
                                </tr>
                                @if($comentarioTecnico)
                                <tr>
                                    <td style="color:#6b7280; font-size:14px;">Comentario del técnico:</td>
                                    <td style="color:#111827; font-size:14px;">
                                        {{ $comentarioTecnico }}
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background:#f9fafb; padding:20px; text-align:center; border-top:1px solid #e5e7eb;">
                            <p style="color:#9ca3af; font-size:12px; margin:0;">
                                Este correo fue enviado automáticamente por el Sistema de Bitácoras.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
