<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqRespuestasSeeder extends Seeder
{
    public function run(): void
    {
        $faq = [
            // API Keys y servidores IA
            ['pregunta_clave' => 'api key', 'respuesta' => 'Puedes ingresar tu API Key desde el apartado "Mis API Keys" en el menú lateral. Aceptamos claves de OpenAI, Gemini y OpenRouter.'],
            ['pregunta_clave' => 'openai', 'respuesta' => 'OpenAI es uno de los proveedores de IA que puedes usar. Asegúrate de tener una API Key válida y suficiente cuota.'],
            ['pregunta_clave' => 'openrouter', 'respuesta' => 'OpenRouter permite acceder a modelos de múltiples proveedores. Puedes configurar tu clave desde el panel de API Keys.'],
            ['pregunta_clave' => 'gemini', 'respuesta' => 'Gemini (de Google) es otro motor de IA disponible. Puedes seleccionar este proveedor si has cargado una clave válida.'],

            // Routers
            ['pregunta_clave' => 'registrar router', 'respuesta' => 'Ve a la sección "Tables", se desplegará una lista de opciones, da click en "Mis Routers" y haz clic en "Agregar Router" para registrar uno nuevo.'],
            ['pregunta_clave' => 'eliminar router', 'respuesta' => 'En la lista de routers, puedes hacer clic en el ícono de eliminar para quitarlo de tu cuenta.'],
            ['pregunta_clave' => 'router desconectado', 'respuesta' => 'El router no necesita estar en línea si usas análisis con logs subidos manualmente con el archivo.'],

            // Análisis
            ['pregunta_clave' => 'tipo de análisis', 'respuesta' => 'Puedes elegir entre análisis de Fallos de conexión, Errores del sistema, Ataques bloqueados, entre otros, puedes verificar los tipos de analisis en el apartado "Tables" dando click en "Tipos de Analisis".'],
            ['pregunta_clave' => 'análisis fallas', 'respuesta' => 'El sistema analiza los logs y detecta patrones anómalos o fallas de red como caídas, errores de conexión o mal uso de reglas.'],
            ['pregunta_clave' => 'modelo ia', 'respuesta' => 'Puedes seleccionar el modelo IA deseado después de elegir el servidor (por ejemplo: GPT-4, Gemini Pro, Claude, etc.).'],
            ['pregunta_clave' => 'recomendaciones', 'respuesta' => 'Después del análisis, el sistema genera una respuesta detallada junto con recomendaciones técnicas.'],

            // Logs manuales
            ['pregunta_clave' => 'subir log', 'respuesta' => 'Ve a la sección  "Logs" , se desplegará una lista de opciones, da click en "Cargar archivo" y selecciona el archivo `.log o .txt`  que deseas analizar.'],
            ['pregunta_clave' => 'formato de log', 'respuesta' => 'El archivo log debe estar en texto plano exportado desde el sistema MikroTik, solo se permiten archivos `.log o .txt`.'],
            ['pregunta_clave' => 'log incorrecto', 'respuesta' => 'Si el log tiene un formato inválido, el sistema no podrá procesarlo. Intenta exportarlo nuevamente desde MikroTik.'],

            // Resultados
            ['pregunta_clave' => 'ver resultados', 'respuesta' => 'Los resultados aparecen automáticamente después del análisis. Puedes volver a consultarlos desde el historial.'],
            ['pregunta_clave' => 'descargar resultados', 'respuesta' => 'Puedes descargar los resultados del análisis en formato PDF para archivarlos o compartirlos.'],

            // Cuenta
            ['pregunta_clave' => 'crear cuenta', 'respuesta' => 'Puedes crear una cuenta desde la página de inicio seleccionando "Registrarse".'],
            ['pregunta_clave' => 'cambiar contraseña', 'respuesta' => 'Ve a tu perfil de usuario y haz clic en "Cambiar contraseña".'],
            ['pregunta_clave' => 'eliminar cuenta', 'respuesta' => 'Para eliminar tu cuenta, contáctanos por el formulario de soporte.'],

            // Seguridad y privacidad
            ['pregunta_clave' => 'seguridad', 'respuesta' => 'Tus logs y claves API están encriptados y solo accesibles por ti. No compartimos información sin tu consentimiento.'],
            ['pregunta_clave' => 'privacidad', 'respuesta' => 'El sistema sigue buenas prácticas de protección de datos. Consulta la política de privacidad para más detalles.'],

            // Soporte
            ['pregunta_clave' => 'no funciona', 'respuesta' => 'Intenta recargar la página o revisar tu conexión. Si el error persiste, contáctanos desde la sección de soporte.'],
            ['pregunta_clave' => 'contacto', 'respuesta' => 'Puedes escribirnos al correo info@mubu.com.mx.'],
        ];

        DB::table('faq_respuestas')->insert($faq);
    }
}

