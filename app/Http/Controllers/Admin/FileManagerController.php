<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Storage;


class FileManagerController extends Controller
{
    private $editablePaths = [
        'resources/views/',
        'app/Http/Controllers/',
        'routes/',
        'app/Models/',
    ];

    public function index()
    {
        return view('admin.file-manager');
    }

    public function loadFile(Request $request)
    {
        $path = base_path($request->input('path'));
        
        // dd($path);
        if (!File::exists($path)) return response()->json(['error' => 'File not found'], 404);
        return response()->json(['content' => File::get($path)]);
    }

    // public function saveFile(Request $request)
    // {
    //     $path = base_path($request->input('path'));
    //     $realPath = realpath($path);
    //     $isValid = collect($this->editablePaths)->contains(fn($allowed) => str_starts_with($realPath, base_path($allowed)));
    //     if (!$isValid) return response()->json(['error' => 'Invalid file path'], 403);
    
    //     // ✅ Versioning before save
    //     $historyPath = storage_path('app/file_versions');
    //     if (!file_exists($historyPath)) mkdir($historyPath, 0755, true);
    //     $filename = str_replace(['/', '\\'], '_', $request->input('path'));
    //     $timestamp = now()->format('Ymd_His');
    //     file_put_contents("$historyPath/{$filename}_{$timestamp}.bak", file_get_contents($path));
    
    //     // Save new content
    //     File::put($path, $request->input('content'));
    //     return response()->json(['status' => 'File saved']);
    // }


    public function saveFile(Request $request)
{
    $path = base_path($request->input('path'));
    $realPath = realpath($path);
    $isValid = collect($this->editablePaths)->contains(fn($allowed) => str_starts_with($realPath, base_path($allowed)));
    if (!$isValid) {
        return response()->json(['error' => 'Invalid file path'], 403);
    }

    $historyPath = storage_path('app/file_versions');
    if (!file_exists($historyPath)) mkdir($historyPath, 0755, true);

    $filename = str_replace(['/', '\\'], '_', $request->input('path'));

    // Get previous backups for this file
    $backups = collect(glob("$historyPath/{$filename}_*.bak"))->sortDesc();

    $shouldBackup = true;

    if ($backups->isNotEmpty()) {
        // Get timestamp from latest backup file
        $latest = $backups->first();
        $basename = basename($latest);
        $timestampStr = substr($basename, strlen($filename) + 1, 15); // Format: Ymd_His
        $lastBackupTime = \Carbon\Carbon::createFromFormat('Ymd_His', $timestampStr);

        // Skip backup if last was within 30 minutes
        if (now()->diffInMinutes($lastBackupTime) < 30) {
            $shouldBackup = false;
        }
    }

    // Cleanup: delete backups older than 48 hours
    $backups->each(function ($file) {
        if (filemtime($file) < now()->subHours(8)->getTimestamp()) {
            @unlink($file);
        }
    });

    // Create backup if needed
    if ($shouldBackup) {
        $timestamp = now()->format('Ymd_His');
        file_put_contents("$historyPath/{$filename}_{$timestamp}.bak", file_get_contents($path));
    }

    // Save new content
    File::put($path, $request->input('content'));

    return response()->json([
        'status' => 'File saved',
        'backup_created' => $shouldBackup,
    ]);
}


    public function fileTree(Request $request)
    {
        $base = base_path();
        $tree = [];
        foreach ($this->editablePaths as $folder) {
            $tree[$folder] = $this->scanDirRecursive($base . '/' . $folder);
        }
        return response()->json($tree);
    }

    private function scanDirRecursive($dir)
    {
        $result = [];
        foreach (scandir($dir) as $file) {
            if ($file === '.' || $file === '..') continue;
            $path = $dir . '/' . $file;
            $relative = str_replace(base_path() . '/', '', $path);
            if (is_dir($path)) {
                $result[] = ["type" => "dir", "name" => $file, "path" => $relative, "children" => $this->scanDirRecursive($path)];
            } else {
                $result[] = ["type" => "file", "name" => $file, "path" => $relative];
            }
        }
        return $result;
    }

    public function createFile(Request $request)
    {
        $path = base_path($request->input('path'));
        $type = $request->input('type');
        $content = $type === 'file' ? "" : null;

        if ($type === 'file') {
            File::put($path, $content);
        } elseif ($type === 'dir') {
            File::makeDirectory($path, 0755, true, true);
        }

        return response()->json(['status' => 'Created', 'path' => $path]);
    }

        public function fileHistory(Request $request)
    {
        $filename = str_replace(['/', '\\'], '_', $request->input('path'));
        $historyPath = storage_path("app/file_versions");
        $files = glob("$historyPath/{$filename}_*.bak");
        $versions = collect($files)->map(function ($file) {
            return [
                'file' => basename($file),
                'timestamp' => substr(basename($file), strrpos(basename($file), '_') + 1, 15),
            ];
        });
        return response()->json($versions);
    }

    public function loadHistoryVersion(Request $request)
    {
        $filename = $request->input('file');
        $historyPath = storage_path("app/file_versions/$filename");
        if (!file_exists($historyPath)) return response()->json(['error' => 'Not found'], 404);
        return response()->json(['content' => file_get_contents($historyPath)]);
    }


    //categories page code
    
    public function saveDynamicPage(Request $req)
    {
        $slug = str_replace('/', '_', $req->slug);
        $pathSlug = str_replace('/', '-', $req->slug); // e.g., services-seo
    
        // Define paths
        $routePath = base_path("routes/dynamic/web/{$pathSlug}.php");
        $controllerPath = app_path("Http/Controllers/Dynamic/{$slug}Controller.php");
        $viewPath = resource_path("views/dynamic/pages/{$pathSlug}.blade.php");
        $modelPath = app_path("Models/Dynamic/{$slug}.php");
    
        File::ensureDirectoryExists(dirname($routePath));
        File::ensureDirectoryExists(dirname($controllerPath));
        File::ensureDirectoryExists(dirname($viewPath));
        File::ensureDirectoryExists(dirname($modelPath));
    
        File::put($routePath, $req->route);
        File::put($controllerPath, $req->controller);
        File::put($viewPath, $req->view);
    
        if ($req->model) {
            File::put($modelPath, $req->model);
        }
    
        return response()->json(['status' => 'success']);
    }


}