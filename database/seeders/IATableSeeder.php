<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class IATableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        $ias = [
            // 🔗 OpenRouter
            ['ia' => 'openrouter', 'model' => 'openai/gpt-4o', 'type' => 'pago', 'created_at' => $now, 'updated_at' => $now],
            ['ia' => 'openrouter', 'model' => 'openai/gpt-4.1-nano', 'type' => 'libre', 'created_at' => $now, 'updated_at' => $now],
            ['ia' => 'openrouter', 'model' => 'openai/gpt-4-turbo', 'type' => 'pago', 'created_at' => $now, 'updated_at' => $now],
            ['ia' => 'openrouter', 'model' => 'openai/gpt-3.5-turbo', 'type' => 'libre (limitado)', 'created_at' => $now, 'updated_at' => $now],
            ['ia' => 'openrouter', 'model' => 'anthropic/claude-3-opus', 'type' => 'pago', 'created_at' => $now, 'updated_at' => $now],
            ['ia' => 'openrouter', 'model' => 'anthropic/claude-3-sonnet', 'type' => 'libre (limitado)', 'created_at' => $now, 'updated_at' => $now],
            ['ia' => 'openrouter', 'model' => 'anthropic/claude-3-haiku', 'type' => 'libre', 'created_at' => $now, 'updated_at' => $now],
            ['ia' => 'openrouter', 'model' => 'mistral/mistral-medium', 'type' => 'libre (limitado)', 'created_at' => $now, 'updated_at' => $now],
            ['ia' => 'openrouter', 'model' => 'mistral/mistral-small', 'type' => 'libre', 'created_at' => $now, 'updated_at' => $now],
            ['ia' => 'openrouter', 'model' => 'mistral/tiny-llama', 'type' => 'libre', 'created_at' => $now, 'updated_at' => $now],
            ['ia' => 'openrouter', 'model' => 'meta-llama/llama-3-70b-instruct', 'type' => 'libre (limitado)', 'created_at' => $now, 'updated_at' => $now],
            ['ia' => 'openrouter', 'model' => 'meta-llama/llama-3-8b-instruct', 'type' => 'libre', 'created_at' => $now, 'updated_at' => $now],
            ['ia' => 'openrouter', 'model' => 'cohere/command-r-plus', 'type' => 'libre (limitado)', 'created_at' => $now, 'updated_at' => $now],
            ['ia' => 'openrouter', 'model' => 'google/gemini-pro', 'type' => 'libre (limitado)', 'created_at' => $now, 'updated_at' => $now],

            // 🧠 OpenAI
            ['ia' => 'openai', 'model' => 'gpt-4o', 'type' => 'pago', 'created_at' => $now, 'updated_at' => $now],
            ['ia' => 'openai', 'model' => 'gpt-4-turbo', 'type' => 'pago', 'created_at' => $now, 'updated_at' => $now],
            ['ia' => 'openai', 'model' => 'gpt-4', 'type' => 'pago', 'created_at' => $now, 'updated_at' => $now],
            ['ia' => 'openai', 'model' => 'gpt-3.5-turbo', 'type' => 'libre (limitado)', 'created_at' => $now, 'updated_at' => $now],
            ['ia' => 'openai', 'model' => 'gpt-3.5-turbo-16k', 'type' => 'libre (limitado)', 'created_at' => $now, 'updated_at' => $now],

            // 🔮 Gemini (Google)
            ['ia' => 'gemini', 'model' => 'gemini-pro', 'type' => 'libre (limitado)', 'created_at' => $now, 'updated_at' => $now],
            ['ia' => 'gemini', 'model' => 'gemini-1.5-pro-latest', 'type' => 'pago', 'created_at' => $now, 'updated_at' => $now],
            ['ia' => 'gemini', 'model' => 'gemini-1.5-flash-latest', 'type' => 'libre', 'created_at' => $now, 'updated_at' => $now],
            ['ia' => 'gemini', 'model' => 'gemini-2.0-flash', 'type' => 'libre', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('artificial_intelligence')->insert($ias);
    }
}
