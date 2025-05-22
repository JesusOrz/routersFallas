<?php

namespace App\Services;

use RouterOS\Client;

class MikrotikService
{
    public function testConnection()
    {
        try {
            $client = new Client([
                'host' => '14.14.14.109',  // IP del MikroTik
                'user' => 'admin',         // Usuario
                'pass' => '142003',      // Contraseña
                'port' => 8728             // Puerto API
            ]);

            return '✅ Conexión exitosa al MikroTik.';
        } catch (\Exception $e) {
            return '❌ Error de conexión: ' . $e->getMessage();
        }
    }
}
