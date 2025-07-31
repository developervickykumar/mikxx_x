<?php

namespace App\Console\Commands;

use App\Models\Business;
use Illuminate\Console\Command;

class ViewAuditLogs extends Command
{
    protected $signature = 'business:audit-logs
                            {business : The business slug}
                            {--user= : Filter by user email}
                            {--action= : Filter by action type}
                            {--start-date= : Filter by start date (Y-m-d)}
                            {--end-date= : Filter by end date (Y-m-d)}
                            {--limit=50 : Number of logs to show}';

    protected $description = 'View permission audit logs';

    public function handle(): int
    {
        $business = Business::where('slug', $this->argument('business'))->first();

        if (!$business) {
            $this->error("Business not found.");
            return 1;
        }

        $filters = [];
        
        if ($userEmail = $this->option('user')) {
            $user = $business->users()->where('email', $userEmail)->first();
            if (!$user) {
                $this->error("User not found.");
                return 1;
            }
            $filters['user_id'] = $user->id;
        }

        if ($action = $this->option('action')) {
            $filters['action'] = $action;
        }

        if ($startDate = $this->option('start-date')) {
            $filters['start_date'] = $startDate;
        }

        if ($endDate = $this->option('end-date')) {
            $filters['end_date'] = $endDate;
        }

        $limit = (int) $this->option('limit');
        $logs = $business->getAuditLogs($filters, $limit);

        if ($logs->isEmpty()) {
            $this->info("No audit logs found for {$business->name}.");
            return 0;
        }

        $this->info("\nAudit Logs for {$business->name}:");
        $this->newLine();

        foreach ($logs as $log) {
            $this->info("Action: {$log->action_label}");
            $this->line("User: {$log->user->name} ({$log->user->email})");
            $this->line("Date: {$log->created_at->format('Y-m-d H:i:s')}");
            
            $details = $log->formatted_details;
            if (!empty($details)) {
                $this->line("Details:");
                foreach ($details as $key => $value) {
                    if (is_array($value)) {
                        $this->line("  {$key}:");
                        foreach ($value as $subKey => $subValue) {
                            $this->line("    {$subKey}: {$subValue}");
                        }
                    } else {
                        $this->line("  {$key}: {$value}");
                    }
                }
            }
            
            $this->newLine();
        }

        if ($logs->hasPages()) {
            $this->info("Page {$logs->currentPage()} of {$logs->lastPage()}");
        }

        return 0;
    }
} 