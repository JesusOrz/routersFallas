<?php

namespace App\Services;

use RouterOS\Client;
use RouterOS\Query;

class MikrotikService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'host' => '14.14.14.109',   // Cambia por la IP de tu router
            'user' => 'admin',          // Usuario de MikroTik
            'pass' => '142003',       // Contraseña de MikroTik
            'port' => 8728,             // Puerto API (por defecto 8728)
        ]);
    }

    public function testConnection()
    {
        try {
            $this->client->connect();
            return '✅ Conexión exitosa al MikroTik.';
        } catch (\Exception $e) {
            return '❌ Error de conexión: ' . $e->getMessage();
        }
    }

    public function getLogs($limit = 50)
{
    try {
        $query = new Query('/log/print');
        $logs = $this->client->query($query)->read();

        // Devolver los últimos $limit logs
        return array_slice(array_reverse($logs), 0, $limit);
    } catch (\Exception $e) {
        return [];
    }
}

}
