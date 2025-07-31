<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;
use Illuminate\Support\Facades\Log;

class AIBuilderController extends Controller
{
    /**
     * Generate Laravel code from a prompt using OpenAI
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateLaravelCode(Request $request)
    {
        try {
            $prompt = $request->input('prompt');

            // Validate prompt
            if (empty($prompt)) {
                return response()->json([
                    'error' => 'Prompt is required'
                ], 400);
            }

            // Check if OpenAI is configured
            if (!config('openai.api_key')) {
                Log::warning('OpenAI API key not configured, using fallback response');
                return $this->getFallbackResponse();
            }

            // Generate code using OpenAI
            $response = OpenAI::client(config('openai.api_key'))->chat()->create([
                'model' => 'gpt-4',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a Laravel developer. Generate code in the following format:
                            <blade>
                            // Blade view code here
                            </blade>
                            <controller>
                            // Controller code here
                            </controller>
                            <route>
                            // Route code here
                            </route>'
                    ],
                    [
                        'role' => 'user',
                        'content' => "Generate Laravel code for: $prompt"
                    ]
                ],
                'temperature' => 0.7,
                'max_tokens' => 2000
            ]);

            $aiContent = $response->choices[0]->message['content'];

            // Parse the response into sections
            return response()->json([
                'blade_code' => $this->extractCode($aiContent, 'blade'),
                'controller_code' => $this->extractCode($aiContent, 'controller'),
                'route_code' => $this->extractCode($aiContent, 'route')
            ]);

        } catch (\Exception $e) {
            Log::error('Error generating Laravel code: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to generate code',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Extract code from a specific section in the AI response
     *
     * @param string $text
     * @param string $type
     * @return string
     */
    private function extractCode($text, $type)
    {
        preg_match("/<$type>(.*?)<\/$type>/s", $text, $matches);
        return trim($matches[1] ?? "/* No $type code found */");
    }

    /**
     * Get fallback response when OpenAI is not available
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function getFallbackResponse()
    {
        return response()->json([
            'blade_code' => <<<'EOD'
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Example Page</h1>
        <p>This is an example Blade template.</p>
    </div>
@endsection
EOD,
            'controller_code' => <<<'EOD'
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function index()
    {
        return view('example');
    }
}
EOD,
            'route_code' => <<<'EOD'
use App\Http\Controllers\ExampleController;

Route::get('/example', [ExampleController::class, 'index'])->name('example');
EOD
        ]);
    }
} 