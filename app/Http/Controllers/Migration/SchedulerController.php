<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class SchedulerController extends Controller
{
    /**
     * Display the scheduler interface
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tasks = [
            ['command' => 'queue:work', 'description' => 'Process queued jobs'],
            ['command' => 'schedule:run', 'description' => 'Run due tasks'],
            ['command' => 'cache:clear', 'description' => 'Clear application cache'],
            ['command' => 'config:clear', 'description' => 'Clear configuration cache'],
            ['command' => 'view:clear', 'description' => 'Clear view cache'],
            ['command' => 'route:clear', 'description' => 'Clear route cache']
        ];

        return view('admin.scheduler', compact('tasks'));
    }

    /**
     * Run a specific task
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function runTask(Request $request)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            Log::warning('Unauthorized task execution attempt', [
                'user_id' => auth()->id(),
                'ip' => $request->ip(),
                'command' => $request->input('command')
            ]);
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $command = $request->input('command');
        $allowedCommands = ['queue:work', 'schedule:run', 'cache:clear', 'config:clear', 'view:clear', 'route:clear'];

        if (!in_array($command, $allowedCommands)) {
            Log::warning('Invalid command attempt', [
                'user_id' => auth()->id(),
                'ip' => $request->ip(),
                'command' => $command
            ]);
            return response()->json(['error' => 'Invalid command'], 400);
        }

        try {
            Log::info('Executing scheduled task', [
                'user_id' => auth()->id(),
                'ip' => $request->ip(),
                'command' => $command
            ]);

            Artisan::call($command);

            return response()->json([
                'status' => 'success',
                'message' => 'Task executed successfully',
                'output' => Artisan::output()
            ]);
        } catch (\Exception $e) {
            Log::error('Task execution failed', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'ip' => $request->ip(),
                'command' => $command
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Task execution failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 