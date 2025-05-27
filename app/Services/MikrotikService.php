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
            'host' => '14.14.14.114',
            'user' => 'admin',
            'pass' => '142003',
            'port' => 8728,
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
