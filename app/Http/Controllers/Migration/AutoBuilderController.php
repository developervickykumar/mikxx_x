<?php

namespace App\Http\Controllers\Migration;

use Illuminate\Http\Request;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Migration\GeneratedModule;
use App\Http\Controllers\Controller;

class AutoBuilderController extends Controller
{
    /**
     * Export files as a ZIP archive
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportZip(Request $request)
    {
        try {
            $files = $request->input('files');

            // Validate input
            if (empty($files) || !is_array($files)) {
                return response()->json([
                    'error' => 'No files provided'
                ], 400);
            }

            // Generate unique filename
            $timestamp = now()->timestamp;
            $zipFilename = "laravel_feature_{$timestamp}.zip";
            $zipPath = storage_path("app/exports/{$zipFilename}");

            // Ensure export directory exists
            Storage::makeDirectory('exports');

            // Create ZIP archive
            $zip = new ZipArchive;
            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                throw new \Exception('Failed to create ZIP archive');
            }

            // Add files to ZIP
            foreach ($files as $file) {
                // Validate file data
                if (empty($file['name']) || empty($file['path']) || !isset($file['content'])) {
                    continue;
                }

                // Sanitize paths
                $relativePath = $this->sanitizePath($file['path']) . '/' . $this->sanitizeFilename($file['name']);
                
                // Add file to ZIP
                $zip->addFromString($relativePath, $file['content']);
            }

            $zip->close();

            // Log successful export
            Log::info('ZIP export created', [
                'filename' => $zipFilename,
                'file_count' => count($files)
            ]);

            // Return ZIP file for download
            return response()->download($zipPath)
                ->deleteFileAfterSend(true)
                ->setContentDisposition('attachment', $zipFilename);

        } catch (\Exception $e) {
            Log::error('Error creating ZIP export: ' . $e->getMessage());
            
            // Clean up ZIP file if it exists
            if (isset($zipPath) && file_exists($zipPath)) {
                unlink($zipPath);
            }

            return response()->json([
                'error' => 'Failed to create ZIP file',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Save a single file to the Laravel project structure
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveFile(Request $request)
    {
        try {
            // Validate input
            $validator = Validator::make($request->all(), [
                'file_name' => 'required|string|max:255',
                'path' => 'required|string|max:255',
                'content' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'messages' => $validator->errors()
                ], 422);
            }

            // Sanitize inputs
            $fileName = $this->sanitizeFilename($request->input('file_name'));
            $path = $this->sanitizePath($request->input('path'));
            $content = $request->input('content');

            // Determine full path based on file type
            $fullPath = $this->getFullPath($path, $fileName);

            // Create directory if it doesn't exist
            $directory = dirname($fullPath);
            if (!file_exists($directory)) {
                if (!mkdir($directory, 0755, true)) {
                    throw new \Exception("Failed to create directory: $directory");
                }
            }

            // Check if file is writable or can be created
            if (file_exists($fullPath) && !is_writable($fullPath)) {
                throw new \Exception("File is not writable: $fullPath");
            }

            // Save file
            if (file_put_contents($fullPath, $content) === false) {
                throw new \Exception("Failed to write file: $fullPath");
            }

            // Log successful save
            Log::info('File saved successfully', [
                'path' => $fullPath,
                'size' => strlen($content)
            ]);

            return response()->json([
                'status' => 'success',
                'message' => "File saved successfully at $path/$fileName",
                'path' => $path,
                'file_name' => $fileName
            ]);

        } catch (\Exception $e) {
            Log::error('Error saving file: ' . $e->getMessage(), [
                'file_name' => $request->input('file_name'),
                'path' => $request->input('path')
            ]);

            return response()->json([
                'error' => 'Failed to save file',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get the full path for a file based on its type
     *
     * @param string $path
     * @param string $fileName
     * @return string
     */
    private function getFullPath($path, $fileName)
    {
        // Map common paths to their full system paths
        $pathMap = [
            'resources/views' => resource_path('views'),
            'resources/views/pages' => resource_path('views/pages'),
            'resources/views/layouts' => resource_path('views/layouts'),
            'resources/views/includes' => resource_path('views/includes'),
            'app/Http/Controllers' => app_path('Http/Controllers'),
            'database/migrations' => database_path('migrations'),
            'routes' => base_path('routes')
        ];

        // Get the base path from the map or use the provided path
        $basePath = $pathMap[$path] ?? base_path($path);

        return $basePath . '/' . $fileName;
    }

    /**
     * Sanitize file path to prevent directory traversal
     *
     * @param string $path
     * @return string
     */
    private function sanitizePath($path)
    {
        // Remove any directory traversal attempts
        $path = str_replace(['../', '..\\'], '', $path);
        
        // Remove leading/trailing slashes
        $path = trim($path, '/\\');
        
        // Convert backslashes to forward slashes
        $path = str_replace('\\', '/', $path);
        
        return $path;
    }

    /**
     * Sanitize filename to prevent security issues
     *
     * @param string $filename
     * @return string
     */
    private function sanitizeFilename($filename)
    {
        // Remove any directory traversal attempts
        $filename = basename($filename);
        
        // Remove any null bytes
        $filename = str_replace(chr(0), '', $filename);
        
        return $filename;
    }

    /**
     * List all generated modules with pagination and filtering
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listModules(Request $request)
    {
        try {
            $query = GeneratedModule::query();

            // Apply filters
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            if ($request->has('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('author', 'like', "%{$search}%");
                });
            }

            // Apply sorting
            $sortBy = $request->get('sort', 'created_at');
            $sortOrder = $request->get('order', 'desc');
            $query->orderBy($sortBy, $sortOrder);

            // Paginate results
            $perPage = $request->get('per_page', 10);
            $modules = $query->paginate($perPage);

            return response()->json($modules);
        } catch (\Exception $e) {
            Log::error('Error listing modules: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to list modules'], 500);
        }
    }

    /**
     * View a specific module's details
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function viewModule($id)
    {
        try {
            $module = GeneratedModule::findOrFail($id);
            return response()->json($module);
        } catch (\Exception $e) {
            Log::error('Error viewing module: ' . $e->getMessage());
            return response()->json(['error' => 'Module not found'], 404);
        }
    }

    /**
     * Export a module as a ZIP file
     *
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportModule($id)
    {
        try {
            $module = GeneratedModule::findOrFail($id);
            
            // Generate unique filename
            $timestamp = now()->timestamp;
            $zipFilename = "module_{$module->name}_{$timestamp}.zip";
            $zipPath = storage_path("app/exports/{$zipFilename}");

            // Ensure export directory exists
            Storage::makeDirectory('exports');

            // Create ZIP archive
            $zip = new ZipArchive;
            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                throw new \Exception('Failed to create ZIP archive');
            }

            // Add files to ZIP
            foreach ($module->files as $file) {
                $fullPath = $this->getFullPath($file['path'], $file['name']);
                if (file_exists($fullPath)) {
                    $zip->addFile($fullPath, $file['path'] . '/' . $file['name']);
                }
            }

            $zip->close();

            // Log successful export
            Log::info('Module exported', [
                'module_id' => $id,
                'filename' => $zipFilename
            ]);

            // Return ZIP file for download
            return response()->download($zipPath)
                ->deleteFileAfterSend(true)
                ->setContentDisposition('attachment', $zipFilename);

        } catch (\Exception $e) {
            Log::error('Error exporting module: ' . $e->getMessage());
            
            // Clean up ZIP file if it exists
            if (isset($zipPath) && file_exists($zipPath)) {
                unlink($zipPath);
            }

            return response()->json([
                'error' => 'Failed to export module',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a module
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteModule($id)
    {
        try {
            $module = GeneratedModule::findOrFail($id);
            
            // Soft delete the module
            $module->delete();

            // Log deletion
            Log::info('Module deleted', ['module_id' => $id]);

            return response()->json([
                'message' => 'Module deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting module: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete module'], 500);
        }
    }

    /**
     * Update module status
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateModuleStatus(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'status' => 'required|in:draft,review,published'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'messages' => $validator->errors()
                ], 422);
            }

            $module = GeneratedModule::findOrFail($id);
            $module->status = $request->status;
            $module->save();

            return response()->json([
                'message' => 'Module status updated successfully',
                'module' => $module
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating module status: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update module status'], 500);
        }
    }
} 