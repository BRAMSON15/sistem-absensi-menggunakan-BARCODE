<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $token;

    public function __construct()
    {
        $this->token = env('FONNTE_TOKEN', '');
    }

    /**
     * Send a WhatsApp message with an optional file attachment using Fonnte API
     *
     * @param string $target WhatsApp number (e.g. 08123456789)
     * @param string $message Text message
     * @param string|null $filePath Absolute path to the file to be attached
     * @param string|null $fileName Custom filename
     * @return array Response from Fonnte
     */
    public function sendMessageWithFile(string $target, string $message, ?string $filePath = null, ?string $fileName = null)
    {
        if (empty($this->token)) {
            Log::warning('Fonnte token is not set. Cannot send WhatsApp message.');
            return ['status' => false, 'reason' => 'Fonnte token not configured'];
        }

        try {
            $request = Http::withHeaders([
                'Authorization' => $this->token
            ]);

            if ($filePath && file_exists($filePath)) {
                $filename = $fileName ?? basename($filePath);
                $request->attach('file', file_get_contents($filePath), $filename);
            }

            $response = $request->post('https://api.fonnte.com/send', [
                'target' => $target,
                'message' => $message,
                'delay' => '1',
            ]);

            $result = $response->json();
            
            if (!$response->successful() || (isset($result['status']) && $result['status'] === false)) {
                Log::error('Fonnte API Error: ' . json_encode($result));
                return ['status' => false, 'reason' => $result['reason'] ?? 'Unknown API error'];
            }

            return ['status' => true, 'response' => $result];

        } catch (\Exception $e) {
            Log::error('WhatsApp Service Exception: ' . $e->getMessage());
            return ['status' => false, 'reason' => $e->getMessage()];
        }
    }
}
