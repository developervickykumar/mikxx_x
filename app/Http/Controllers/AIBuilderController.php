<?php

namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class AIBuilderController extends Controller
{
    // ❌ Remove this line:
    // use OpenAI\Laravel\Facades\OpenAI;

    public function generateHtml(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:1000'
        ]);

        $response = OpenAI::chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'system', 'content' => 'You are an expert frontend developer. Return clean HTML only.'],
                ['role' => 'user', 'content' => $request->input('prompt')],
            ],
        ]);

        $html = $response->choices[0]->message->content;

        return response()->json([
            'generated_html' => $html
        ]);
    }
}
