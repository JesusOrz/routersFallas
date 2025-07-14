<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalysisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $now = Carbon::now();
        $analysis = [
            [
                'analysis' => 'Fallos de conexión',
                'description' => 'Identificación de pérdidas de enlace en interfaces cableadas o inalámbricas.',
            'created_at' => $now, 'updated_at' => $now],
            [
                'analysis' => 'Intentos de acceso no autorizado',
                'description' => 'Detección de accesos fallidos al sistema o posibles ataques por fuerza bruta.',
            'created_at' => $now, 'updated_at' => $now],
            [
                'analysis' => 'Conflictos de IP',
                'description' => 'Análisis de conflictos en la asignación de direcciones IP por DHCP.',
            'created_at' => $now, 'updated_at' => $now],
            [
                'analysis' => 'Errores del sistema',
                'description' => 'Diagnóstico de errores críticos como kernel panic, watchdog timeout, etc.',
            'created_at' => $now, 'updated_at' => $now],
            [
                'analysis' => 'Problemas de DNS',
                'description' => 'Evaluación de fallas en la resolución de analysiss de dominio.',
            'created_at' => $now, 'updated_at' => $now],
            [
                'analysis' => 'Ataques bloqueados',
                'description' => 'Revisión de paquetes sospechosos bloqueados por el firewall.',
            'created_at' => $now, 'updated_at' => $now],
            [
                'analysis' => 'Fallos en scripts programados',
                'description' => 'Identificación de errores en la ejecución de scripts automáticos.',
            'created_at' => $now, 'updated_at' => $now],
            [
                'analysis' => 'Rendimiento inalámbrico',
                'description' => 'Análisis de caídas de señal o interferencias en redes WiFi.',
            'created_at' => $now, 'updated_at' => $now],
            [
                'analysis' => 'Reinicios inesperados',
                'description' => 'Registro y análisis de eventos que provocan reinicios no planificados del sistema.',
            'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('analysis_types')->insert($analysis);
    }
}