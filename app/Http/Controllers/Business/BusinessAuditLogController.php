<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessAuditLog;
use Illuminate\Http\Request;

class BusinessAuditLogController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(BusinessAuditLog::class, 'audit-log');
    }

    /**
     * Display a listing of the audit logs.
     */
    public function index(Business $business)
    {
        $logs = $business->auditLogs()
            ->with(['user', 'subject'])
            ->latest()
            ->paginate(20);

        return view('business.audit-logs.index', compact('business', 'logs'));
    }

    /**
     * Display the specified audit log.
     */
    public function show(Business $business, BusinessAuditLog $auditLog)
    {
        $auditLog->load(['user', 'subject']);

        return view('business.audit-logs.show', compact('business', 'auditLog'));
    }
} 