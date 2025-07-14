<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class FaqRespuestasSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $faq = [
            // API Keys y servidores IA
            ['pregunta_clave' => 'api key', 'respuesta' => 'Puedes ingresar tu API Key desde el apartado "Mis API Keys" en el menú lateral. Aceptamos claves de OpenAI, Gemini y OpenRouter.', 'created_at' => $now, 'updated_at' => $now],
            ['pregunta_clave' => 'openai', 'respuesta' => 'OpenAI es uno de los proveedores de IA que puedes usar. Asegúrate de tener una API Key válida y suficiente cuota.', 'created_at' => $now, 'updated_at' => $now],
            ['pregunta_clave' => 'openrouter', 'respuesta' => 'OpenRouter permite acceder a modelos de múltiples proveedores. Puedes configurar tu clave desde el panel de API Keys.', 'created_at' => $now, 'updated_at' => $now],
            ['pregunta_clave' => 'gemini', 'respuesta' => 'Gemini (de Google) es otro motor de IA disponible. Puedes seleccionar este proveedor si has cargado una clave válida.', 'created_at' => $now, 'updated_at' => $now],

            // Routers
            ['pregunta_clave' => 'registrar router', 'respuesta' => 'Ve a la sección "Tables", se desplegará una lista de opciones, da click en "Mis Routers" y haz clic en "Agregar Router" para registrar uno nuevo.', 'created_at' => $now, 'updated_at' => $now],
            ['pregunta_clave' => 'eliminar router', 'respuesta' => 'En la lista de routers, puedes hacer clic en el ícono de eliminar para quitarlo de tu cuenta.', 'created_at' => $now, 'updated_at' => $now],
            ['pregunta_clave' => 'router desconectado', 'respuesta' => 'El router no necesita estar en línea si usas análisis con logs subidos manualmente con el archivo.', 'created_at' => $now, 'updated_at' => $now],

            // Análisis
            ['pregunta_clave' => 'tipo de análisis', 'respuesta' => 'Puedes elegir entre análisis de Fallos de conexión, Errores del sistema, Ataques bloqueados, entre otros, puedes verificar los tipos de analisis en el apartado "Tables" dando click en "Tipos de Analisis".', 'created_at' => $now, 'updated_at' => $now],
            ['pregunta_clave' => 'análisis fallas', 'respuesta' => 'El sistema analiza los logs y detecta patrones anómalos o fallas de red como caídas, errores de conexión o mal uso de reglas.', 'created_at' => $now, 'updated_at' => $now],
            ['pregunta_clave' => 'modelo ia', 'respuesta' => 'Puedes seleccionar el modelo IA deseado después de elegir el servidor (por ejemplo: GPT-4, Gemini Pro, Claude, etc.).', 'created_at' => $now, 'updated_at' => $now],
            ['pregunta_clave' => 'recomendaciones', 'respuesta' => 'Después del análisis, el sistema genera una respuesta detallada junto con recomendaciones técnicas.', 'created_at' => $now, 'updated_at' => $now],

            // Logs manuales
            ['pregunta_clave' => 'subir log', 'respuesta' => 'Ve a la sección  "Logs" , se desplegará una lista de opciones, da click en "Cargar archivo" y selecciona el archivo `.log o .txt`  que deseas analizar.', 'created_at' => $now, 'updated_at' => $now],
            ['pregunta_clave' => 'formato de log', 'respuesta' => 'El archivo log debe estar en texto plano exportado desde el sistema MikroTik, solo se permiten archivos `.log o .txt`.', 'created_at' => $now, 'updated_at' => $now],
            ['pregunta_clave' => 'log incorrecto', 'respuesta' => 'Si el log tiene un formato inválido, el sistema no podrá procesarlo. Intenta exportarlo nuevamente desde MikroTik.', 'created_at' => $now, 'updated_at' => $now],

            // Resultados
            ['pregunta_clave' => 'ver resultados', 'respuesta' => 'Los resultados aparecen automáticamente después del análisis. Puedes volver a consultarlos desde el historial.', 'created_at' => $now, 'updated_at' => $now],
            ['pregunta_clave' => 'descargar resultados', 'respuesta' => 'Puedes descargar los resultados del análisis en formato PDF para archivarlos o compartirlos.', 'created_at' => $now, 'updated_at' => $now],

            // Cuenta
            ['pregunta_clave' => 'crear cuenta', 'respuesta' => 'Puedes crear una cuenta desde la página de inicio seleccionando "Registrarse".', 'created_at' => $now, 'updated_at' => $now],
            ['pregunta_clave' => 'cambiar contraseña', 'respuesta' => 'Ve a tu perfil de usuario y haz clic en "Cambiar contraseña".', 'created_at' => $now, 'updated_at' => $now],
            ['pregunta_clave' => 'eliminar cuenta', 'respuesta' => 'Para eliminar tu cuenta, contáctanos por el formulario de soporte.', 'created_at' => $now, 'updated_at' => $now],

            // Seguridad y privacidad
            ['pregunta_clave' => 'seguridad', 'respuesta' => 'Tus logs y claves API están encriptados y solo accesibles por ti. No compartimos información sin tu consentimiento.', 'created_at' => $now, 'updated_at' => $now],
            ['pregunta_clave' => 'privacidad', 'respuesta' => 'El sistema sigue buenas prácticas de protección de datos. Consulta la política de privacidad para más detalles.', 'created_at' => $now, 'updated_at' => $now],

            // Soporte
            ['pregunta_clave' => 'no funciona', 'respuesta' => 'Intenta recargar la página o revisar tu conexión. Si el error persiste, contáctanos desde la sección de soporte.', 'created_at' => $now, 'updated_at' => $now],
            ['pregunta_clave' => 'contacto', 'respuesta' => 'Puedes escribirnos al correo info@mubu.com.mx.', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('faq_respuestas')->insert($faq);
    }
}

