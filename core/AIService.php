<?php
/**
 * AI Service Module
 * 
 * Handles secure communication with AI Providers like Groq and OpenAI APIs.
 */
class AIService
{
    private $provider;
    private $apiKey;
    private $model;
    private $systemPrompt;

    public function __construct()
    {
        require_once '../models/Setting.php';
        $settingModel = new Setting();

        $this->provider = $settingModel->getSetting('ai_provider');
        $this->apiKey = $settingModel->getSetting('ai_api_key');
        $this->model = $settingModel->getSetting('ai_model');
        $this->systemPrompt = $settingModel->getSetting('ai_system_prompt');
    }

    /**
     * Generate content based on a user prompt intelligently routing to correct API
     *
     * @param string $userPrompt
     * @return string Generated text or error message
     */
    public function generateContent($userPrompt)
    {
        if (empty($this->apiKey)) {
            return "Error: Setup Required - You must enter an AI API Token into the Platform Settings dashboard first.";
        }

        if ($this->provider === 'groq') {
            return $this->queryGroq($userPrompt);
        } elseif ($this->provider === 'openai') {
            return $this->queryOpenAI($userPrompt);
        } else {
            return "Error: Architecture Unsupported - Unknown AI Provider selected.";
        }
    }

    private function queryGroq($userPrompt)
    {
        // Groq conveniently uses OpenAI's API standard schema format
        $url = "https://api.groq.com/openai/v1/chat/completions";
        $data = [
            "model" => $this->model ?: "llama3-8b-8192",
            "messages" => [
                [
                    "role" => "system",
                    "content" => $this->systemPrompt ?: "You are a professional, helpful assistant."
                ],
                [
                    "role" => "user",
                    "content" => $userPrompt
                ]
            ],
            "temperature" => 0.7
        ];

        return $this->makeCurlRequest($url, $data, "Bearer {$this->apiKey}");
    }

    private function queryOpenAI($userPrompt)
    {
        $url = "https://api.openai.com/v1/chat/completions";
        $data = [
            "model" => $this->model ?: "gpt-4o",
            "messages" => [
                [
                    "role" => "system",
                    "content" => $this->systemPrompt ?: "You are a professional, helpful assistant."
                ],
                [
                    "role" => "user",
                    "content" => $userPrompt
                ]
            ],
            "temperature" => 0.7
        ];

        return $this->makeCurlRequest($url, $data, "Bearer {$this->apiKey}");
    }

    private function makeCurlRequest($url, $data, $authHeader)
    {
        // Initialize high-speed cURL hook
        $ch = curl_init($url);

        $payload = json_encode($data);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: " . $authHeader
        ]);

        // Execute the curl and capture the returned JSON stream
        $response = curl_exec($ch);
        $err = curl_error($ch);

        curl_close($ch);

        if ($err) {
            return "Server Connectivity Error: cURL - " . $err;
        } else {
            $decodedResponse = json_decode($response, true);

            // Extract the Token cost for audit logging
            if (isset($decodedResponse['usage'])) {
                $prompt_tokens = $decodedResponse['usage']['prompt_tokens'] ?? 0;
                $completion_tokens = $decodedResponse['usage']['completion_tokens'] ?? 0;
                $this->logTokenUsage($url, $prompt_tokens, $completion_tokens);
            }

            // Parse through the OpenAI/Groq array tree mapping
            if (isset($decodedResponse['choices'][0]['message']['content'])) {
                return trim($decodedResponse['choices'][0]['message']['content']);
            } elseif (isset($decodedResponse['error']['message'])) {
                return "API Authentication Error: " . $decodedResponse['error']['message'];
            } else {
                return "Unknown Processing Error: The AI service returned an unrecognized payload structure.";
            }
        }
    }

    private function logTokenUsage($endpoint, $promptTokens, $completionTokens)
    {
        $db = (new Database())->connect();
        $stmt = $db->prepare('INSERT INTO ai_logs (endpoint, prompt_tokens, completion_tokens, created_by) VALUES (:endpoint, :pt, :ct, :user)');

        $userId = $_SESSION['user_id'] ?? null;

        $stmt->bindParam(':endpoint', $endpoint);
        $stmt->bindParam(':pt', $promptTokens);
        $stmt->bindParam(':ct', $completionTokens);
        $stmt->bindParam(':user', $userId);
        $stmt->execute();
    }
}
