<?php

namespace App\Http\Controllers;

use App\Models\TableData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TableDataController extends Controller
{
    /**
     * Save table data
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'data' => 'required|array',
            'data.*' => 'required|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $tableData = TableData::updateOrCreate(
                [
                    'name' => $request->name,
                    'user_id' => Auth::id()
                ],
                [
                    'data' => $request->data
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Table saved successfully',
                'data' => $tableData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save table',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Load table data
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function load(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required_without:name|exists:table_data,id',
            'name' => 'required_without:id|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $query = TableData::where('user_id', Auth::id());
            
            if ($request->has('id')) {
                $query->where('id', $request->id);
            } else {
                $query->where('name', $request->name);
            }

            $tableData = $query->first();

            if (!$tableData) {
                return response()->json([
                    'success' => false,
                    'message' => 'Table not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $tableData->data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load table',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * List all tables for the authenticated user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list()
    {
        try {
            $tables = TableData::where('user_id', Auth::id())
                ->select('id', 'name', 'created_at')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $tables
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to list tables',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a table
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:table_data,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $tableData = TableData::where('id', $request->id)
                ->where('user_id', Auth::id())
                ->first();

            if (!$tableData) {
                return response()->json([
                    'success' => false,
                    'message' => 'Table not found'
                ], 404);
            }

            $tableData->delete();

            return response()->json([
                'success' => true,
                'message' => 'Table deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete table',
                'error' => $e->getMessage()
            ], 500);
        }
    }
} 