<?php

require 'config.php';

use Gemini\GeminiClient;

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true) ?? [];
$action = $data['action'] ?? '';

if($action === 'Ai'){

    $feedback = $data['feedback'];
    //add the date here fgt
    //kys

    global $yourApiKey;

    try {
        $client = Gemini::client($yourApiKey);
        $model = $client->generativeModel('gemini-2.0-flash');

        $questions = implode(',', $test);
        $prompt = "Give me a summary of this evaluation here is the feedback $feedback and 
        here are the questions $temp and here are the answers $temp give a brief but detailed 
        comment regarding this evaluation.";

        $result = $model->generateContent($prompt);
        
        return $result->text();
    }catch(Exception $e){
        error_log("AI Summarizer Error: " . $e->getMessage());
    }
    
}