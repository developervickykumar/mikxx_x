<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class MigrationController extends Controller
{
    /**
     * Run Laravel migrations with security checks
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function run(Request $request)
    {
        // Check if user is authenticated and is admin
        if (!auth()->check() || !auth()->user()->is_admin) {
            Log::warning('Unauthorized migration attempt', [
                'user_id' => auth()->id(),
                'ip' => $request->ip()
            ]);
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Validate PIN/password
        $validator = validator($request->all(), [
            'pin' => 'required|string|size:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors()
            ], 422);
        }

        // Verify PIN (stored in .env as MIGRATION_PIN)
        if (!Hash::check($request->pin, config('app.migration_pin'))) {
            Log::warning('Invalid migration PIN attempt', [
                'user_id' => auth()->id(),
                'ip' => $request->ip()
            ]);
            return response()->json(['error' => 'Invalid PIN'], 403);
        }

        try {
            // Log migration attempt
            Log::info('Starting migration execution', [
                'user_id' => auth()->id(),
                'ip' => $request->ip()
            ]);

            // Run migration in a queue
            Artisan::queue('migrate', [
                '--force' => true,
                '--no-interaction' => true
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Migration queued successfully. Check logs for details.'
            ]);

        } catch (\Exception $e) {
            Log::error('Migration failed', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'ip' => $request->ip()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Migration failed. Check logs for details.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get migration status
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function status()
    {
        try {
            $output = Artisan::call('migrate:status');
            $status = Artisan::output();

            return response()->json([
                'status' => 'success',
                'data' => $status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get migration status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Rollback the last migration
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function rollback(Request $request)
    {
        // Check if user is authenticated and is admin
        if (!auth()->check() || !auth()->user()->is_admin) {
            Log::warning('Unauthorized rollback attempt', [
                'user_id' => auth()->id(),
                'ip' => $request->ip()
            ]);
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Validate PIN/password
        $validator = validator($request->all(), [
            'pin' => 'required|string|size:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors()
            ], 422);
        }

        // Verify PIN
        if (!Hash::check($request->pin, config('app.migration_pin'))) {
            Log::warning('Invalid rollback PIN attempt', [
                'user_id' => auth()->id(),
                'ip' => $request->ip()
            ]);
            return response()->json(['error' => 'Invalid PIN'], 403);
        }

        try {
            // Log rollback attempt
            Log::info('Starting migration rollback', [
                'user_id' => auth()->id(),
                'ip' => $request->ip()
            ]);

            // Run rollback in a queue
            Artisan::queue('migrate:rollback', [
                '--force' => true,
                '--no-interaction' => true
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Rollback queued successfully. Check logs for details.'
            ]);

        } catch (\Exception $e) {
            Log::error('Rollback failed', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'ip' => $request->ip()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Rollback failed. Check logs for details.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Run database seeders
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function seed(Request $request)
    {
        // Check if user is authenticated and is admin
        if (!auth()->check() || !auth()->user()->is_admin) {
            Log::warning('Unauthorized seeder attempt', [
                'user_id' => auth()->id(),
                'ip' => $request->ip()
            ]);
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Validate PIN/password
        $validator = validator($request->all(), [
            'pin' => 'required|string|size:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $validator->errors()
            ], 422);
        }

        // Verify PIN
        if (!Hash::check($request->pin, config('app.migration_pin'))) {
            Log::warning('Invalid seeder PIN attempt', [
                'user_id' => auth()->id(),
                'ip' => $request->ip()
            ]);
            return response()->json(['error' => 'Invalid PIN'], 403);
        }

        try {
            // Log seeder attempt
            Log::info('Starting database seeding', [
                'user_id' => auth()->id(),
                'ip' => $request->ip()
            ]);

            // Run seeder in a queue
            Artisan::queue('db:seed', [
                '--force' => true,
                '--no-interaction' => true
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Seeding queued successfully. Check logs for details.'
            ]);

        } catch (\Exception $e) {
            Log::error('Seeding failed', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'ip' => $request->ip()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Seeding failed. Check logs for details.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 