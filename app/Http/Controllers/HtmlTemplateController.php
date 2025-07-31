<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\HtmlTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class HtmlTemplateController extends Controller
{
    
    
   public function fetchTemplate($id)
{
    $template = HtmlTemplate::find($id);

    if (!$template) {
        return response()->json(null);
    }

    $template->label_json = json_decode($template->label_json, true) ?? ['label' => null];

    return response()->json([
        'id' => $template->id,
        'name' => $template->name,
        'code' => $template->html_code,
        'label_json' => $template->label_json,
        'tags' => $template->tags,
    ]);
}

    
    /**
     * Save or update the HTML template.
     */
    public function saveOrUpdate(Request $request)
    {
        try {
            $data = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'html_code' => 'required|string',
                'tags' => 'nullable|string',
                'improvement_notes' => 'nullable|string',
                'usable_in_user' => 'nullable|boolean',
                'usable_in_business' => 'nullable|boolean',
                'usable_in_mikxx' => 'nullable|boolean',
                'usable_in_modules' => 'nullable|boolean',
                'usable_in_admin' => 'nullable|boolean',
            ]);
        } catch (ValidationException $e) {
            Log::error('Validation failed in saveOrUpdate:', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            return response()->json(['errors' => $e->errors()], 422);
        }
    
        // Continue with save
        $template = HtmlTemplate::firstOrNew(['category_id' => $data['category_id']]);
    
        $template->fill([
            'name' => $data['name'],
            'html_code' => $data['html_code'],
            'tags' => $data['tags'],
            'improvement_notes' => $data['improvement_notes'],
            'usable_in_user' => $request->boolean('usable_in_user'),
            'usable_in_business' => $request->boolean('usable_in_business'),
            'usable_in_mikxx' => $request->boolean('usable_in_mikxx'),
            'usable_in_modules' => $request->boolean('usable_in_modules'),
            'usable_in_admin' => $request->boolean('usable_in_admin'),
            'created_by' => auth()->id(),
        ]);
    
        $template->slug = \Str::slug($data['name']);
        $template->save();
    
        return response()->json(['message' => 'Saved successfully']);
    }


    private function chunkHtmlForAnalysis($html, $linesPerChunk = 300)
{
    $lines = explode("\n", $html);
    $chunks = array_chunk($lines, $linesPerChunk);
    
    $results = [];
    $totalChunks = count($chunks);

    foreach ($chunks as $index => $linesChunk) {
        $chunk = implode("\n", $linesChunk);
        $chunk = strlen($chunk) > 10000 ? substr($chunk, 0, 10000) : $chunk;

        $chunkNum = $index + 1;
        $systemPrompt = "You're reviewing part of a large HTML file (chunk $chunkNum of $totalChunks). Do not assume completeness. Analyze this part and point out any issues or improvements.";
        $userPrompt = "🔍 HTML Chunk $chunkNum/$totalChunks:\n\n{$chunk}";

        $result = $this->sendToOpenAI($systemPrompt, $userPrompt);

        if ($result['status'] === 'success') {
            $results[] = "✅ Chunk {$chunkNum}:\n" . trim($result['content']);
        } else {
            $results[] = "❌ Chunk {$chunkNum}:\n" . $result['content'];
        }

        usleep(200000); // throttle to avoid OpenAI rate limit
    }

    return $results;
}


private function sendToOpenAI($systemPrompt, $userPrompt, $model = 'gpt-3.5-turbo', $maxRetries = 3)
{
    $retry = 0;

    while ($retry < $maxRetries) {
        $response = Http::withToken(env('OPENAI_API_KEY'))->post('https://api.openai.com/v1/chat/completions', [
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => $userPrompt],
            ],
            'temperature' => 0.2,
            'max_tokens' => 1024,
        ]);

        if ($response->successful()) {
            return ['status' => 'success', 'content' => $response['choices'][0]['message']['content']];
        }

        if ($response->status() == 429) {
            $retry++;
            sleep(pow(2, $retry)); // exponential backoff: 2s, 4s, 8s...
        } else {
            return ['status' => 'error', 'content' => "❌ Failed with status: {$response->status()}"];
        }
    }

    return ['status' => 'error', 'content' => "❌ Failed after $maxRetries retries"];
}


    /**
     * Recheck HTML code using GPT in chunks.
     */
    public function recheck(Request $request)
    {
        $html = $request->input('html');
    
        if (!$html) {
            return response()->json(['error' => 'No HTML provided'], 422);
        }
    
        try {
            $analysis = $this->chunkHtmlForAnalysis($html);
            return response()->json(['analysis' => $analysis]);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'AI analysis failed: ' . $e->getMessage()
            ], 500);
        }
    }
    
    
    
    
    
    public function customPrompt(Request $request)
    {
        $html = $request->input('html');
        $prompt = $request->input('prompt');
    
        
    
        try {
            $response = Http::withToken(env('OPENAI_API_KEY'))->timeout(60)->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4', // or 'gpt-3.5-turbo'
                'messages' => [
                    ['role' => 'system', 'content' => 'You are an expert HTML/code assistant.'],
                    ['role' => 'user', 'content' => "Custom Instruction: {$prompt}\n\nHTML Code:\n\n{$html}"],
                ],
                'temperature' => 0.3,
                'max_tokens' => 2048,
            ]);
    
            if ($response->successful()) {
                return response()->json(['result' => $response['choices'][0]['message']['content']]);
            }
    
            return response()->json(['error' => 'Failed to process request'], $response->status());
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Server Error: ' . $e->getMessage()], 500);
        }
    }
public function store(Request $request)
{
    $data = $request->validate([
        'category_id' => 'required|exists:categories,id',
        'route' => 'required|unique:html_templates,route',
        'method' => 'required',
        'controller' => 'nullable',
        'controller_method' => 'nullable',
        'view_file' => 'nullable',
        'custom_logic' => 'nullable',
    ]);

    HtmlTemplate::create($data);

    return redirect()->back()->with('success', 'Route created successfully!');
}


    
}
