<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AIController extends Controller
{
    public function summarize(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'category' => 'required|string',
            'year'     => 'required|integer',
            'month'    => 'required', 
        ]);

        $categoryKey = $request->category;
        $year        = $request->year;
        $month       = $request->month;

        // 2. Tentukan Nama Kolom Database
        $columnName = $categoryKey . '_feedback';

        try {
            // 3. Query Data Aspirasi
            $query = DB::table('survey_responses')
                        ->whereYear('created_at', $year)
                        ->whereNotNull($columnName)
                        ->where($columnName, '!=', '');

            if ($month !== 'all') {
                $query->whereMonth('created_at', $month);
            }

            // Ambil data (limit 50)
            $feedbacks = $query->latest('created_at')
                               ->limit(50)
                               ->pluck($columnName)
                               ->toArray();

            // 4. Cek Jika Data Kosong
            if (empty($feedbacks)) {
                return response()->json([
                    'summary' => '<p class="text-gray-500 italic">Belum ada data aspirasi masuk pada periode ini.</p>'
                ]);
            }

            // 5. Persiapan Data
            $textData = implode("\n- ", $feedbacks);

            // =================================================================
            // 6. PROMPT ENGINEERING (FULL BAHASA INDONESIA)
            // =================================================================
            
            // System Prompt: Menentukan Persona
            $systemPrompt = "Anda adalah Konsultan Penjaminan Mutu Akademik di sebuah Universitas di Indonesia. " .
                            "Tugas Anda adalah membaca aspirasi mahasiswa dan merangkumnya menjadi laporan kinerja yang objektif. " .
                            "Gunakan HANYA Bahasa Indonesia yang baku, formal, dan profesional. Jangan gunakan Bahasa Inggris.";

            // User Prompt: Instruksi Spesifik
            // Kita tambahkan logika: Jika positif, berikan saran mempertahankan. Jika negatif, berikan solusi.
            $userPrompt   = "Berikut adalah daftar aspirasi mahasiswa untuk kategori '{$categoryKey}' pada tahun {$year}:\n\n" .
                            "DATA MENTAH:\n" .
                            "- {$textData}\n\n" .
                            "INSTRUKSI ANALISIS:\n" .
                            "1. **Analisis Sentimen**: Tentukan apakah aspirasi ini cenderung Positif, Negatif, atau Netral. Jelaskan alasannya dalam satu kalimat.\n" .
                            "2. **Isu atau Poin Utama**: Apa hal yang paling disorot oleh mahasiswa? (Bisa berupa keluhan utama ATAU aspek yang paling dipuji).\n" .
                            "3. **Rekomendasi Tindak Lanjut**: Berikan 3 langkah konkret.\n" .
                            "   - Jika sentimen NEGATIF: Berikan solusi perbaikan.\n" .
                            "   - Jika sentimen POSITIF: Berikan saran untuk mempertahankan kualitas atau memberikan apresiasi kepada staf terkait.\n\n" .
                            "FORMAT JAWABAN (Gunakan Poin-Poin):\n" .
                            "- **Analisis Sentimen**: [Positif/Negatif/Netral] - [Alasan Singkat]\n" .
                            "- **Poin Utama**: [Penjelasan]\n" .
                            "- **Rekomendasi Strategis**:\n" .
                            "  1. [Langkah 1]\n" .
                            "  2. [Langkah 2]\n" .
                            "  3. [Langkah 3]";

            // 7. Request ke OpenRouter
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENROUTER_API_KEY'),
                'HTTP-Referer'  => url('/'),
                'X-Title'       => 'Dashboard Admin',
                'Content-Type'  => 'application/json',
            ])->timeout(45)
              ->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'qwen/qwen-2.5-coder-32b-instruct',
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userPrompt],
                ],
                'temperature' => 0.4, // Sedikit dinaikkan agar bahasanya lebih luwes tapi tetap terarah
                'max_tokens'  => 800,
            ]);

            // 8. Error Handling
            if ($response->failed()) {
                Log::error('OpenRouter Error: ' . $response->body());
                throw new \Exception('Gagal menghubungi layanan AI (Status: ' . $response->status() . ')');
            }

            $result = $response->json();
            $aiText = $result['choices'][0]['message']['content'] ?? 'Tidak ada respon dari AI.';

            // 9. Formatting Output (Markdown -> HTML)
            $formattedText = e($aiText); 
            // Bold treatment
            $formattedText = preg_replace('/\*\*(.*?)\*\*/', '<strong class="text-indigo-700 font-bold">$1</strong>', $formattedText);
            // Newline treatment
            $formattedText = nl2br($formattedText);

            return response()->json([
                'summary' => $formattedText
            ]);

        } catch (\Exception $e) {
            Log::error("AI Controller Error: " . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
}