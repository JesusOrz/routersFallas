<?php
namespace App\Services;

use RouterOS\Client;
use RouterOS\Query;

class MikrotikService
{
    protected $client;

    public function __construct(array $config)
    {
        $this->client = new Client([
            'host' => $config['host'],
            'user' => $config['user'],
            'pass' => $config['password'], // CAMBIO AQUÍ
            'port' => $config['port'] ?? 8728,
        ]);
    }

    public function testConnection()
    {
        try {
            $this->client->connect();
            return 'Conexión exitosa al MikroTik.';
        } catch (\Exception $e) {
            return 'Error de conexión: ' . $e->getMessage();
        }
    }

    public function getLogs($limit = 50)
    {
        try {
            $query = new Query('/log/print');
            $logs = $this->client->query($query)->read();
            return array_slice(array_reverse($logs), 0, $limit);
        } catch (\Exception $e) {
            return [];
        }
    }
}
