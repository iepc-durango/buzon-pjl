<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notificación</title>
</head>
<body style="margin:0; padding:0; font-family: helvetica,sans-serif; background-color: #c0c0c0;">
<table style="background-color: #f5f5f5; padding: 20px 0;">
    <tr>
        <td align="center">
            <!-- Contenedor principal -->
            <table width="600" style="background-color: #ffffff;">
                <!-- Encabezado con logo -->
                <tr style="background-color: #f3f3f3;">
                    <td align="center">
                        <img src="https://i.imgur.com/9TJfat5.png" alt="Logo" style="max-width: 200px; width: 100%; height: auto; display: block;">
                    </td>
                </tr>
                <!-- Cuerpo del mensaje -->
                <tr>
                    <td style="color: #333333; font-size: 16px; line-height: 1.5;">
                        <h2 style="font-weight:bold;margin:0;padding:0;font-size:12pt;">Estimada persona Candidata.</h2>
                        <h2 style="font-weight:bold;margin:0;padding:0;font-size:12pt;">PRESENTE.</h2>

                        <p style="margin-top:1pc;text-align:justify;">Con fundamento en lo dispuesto por el Artículo 164, numeral 3 BIS, fracción I, inciso g), párrafo segundo de la Ley de Instituciones y Procedimientos Electorales para el estado de Durango, por medio del presente se notifica diverso documento que se encuentra para su lectura en el vínculo siguiente:</p>

                        <!-- Botón -->
                        <table cellspacing="0" cellpadding="0" border="0" align="center" style="margin: 20px 0;">
                            <tr>
                                <td align="center" bgcolor="#000000" style="border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                                    <a href="{{ $link }}" target="_blank" style="display:block; padding: 12px 20px; font-size: 16px; color: #ffffff; text-decoration: none; font-family: sans-serif;">
                                        Acceder a los documentos
                                    </a>
                                </td>
                            </tr>
                        </table>

                        <p>Lo anterior para los efectos legales a que haya lugar. <br>
                            Saludos cordiales.</p>

                        <p style="font-weight:bold;">Instituto Electoral y de Participación Ciudadana del Estado de Durango.</p>
                    </td>
                </tr>
                <!-- Pie de página o disclaimer -->
                <tr>
                    <td style="color: #777777; font-size: 12px; text-align: center;">
                        <p>Este correo es una notificación automática. Por favor, no responda a este mensaje.</p>
                    </td>
                </tr>
            </table>
            <!-- Fin del contenedor principal -->
        </td>
    </tr>
</table>
</body>
</html>
