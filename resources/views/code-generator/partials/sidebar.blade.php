<aside class="sidebar">
    <!-- Dashboard -->
    <div class="category">
        <h3 class="category-title">Dashboard</h3>
        <ul class="nav-links">
            <li><a href="{{ route('code-generator.dashboard') }}" class="nav-link {{ request()->routeIs('code-generator.dashboard') ? 'active' : '' }}">Dashboard</a></li>
            <li><a href="{{ route('code-generator.module-summary') }}" class="nav-link {{ request()->routeIs('code-generator.module-summary') ? 'active' : '' }}">Module Summary</a></li>
        </ul>
    </div>

    <!-- Phase 1: Review -->
    <div class="category">
        <h3 class="category-title">Phase 1: Review</h3>
        <ul class="nav-links">
            <li><a href="{{ route('code-generator.upload-files') }}" class="nav-link {{ request()->routeIs('code-generator.upload-files') ? 'active' : '' }}">Upload Files</a></li>
            <li><a href="{{ route('code-generator.prompt-review') }}" class="nav-link {{ request()->routeIs('code-generator.prompt-review') ? 'active' : '' }}">Prompt Review</a></li>
            <li><a href="{{ route('code-generator.html-analysis') }}" class="nav-link {{ request()->routeIs('code-generator.html-analysis') ? 'active' : '' }}">HTML Analysis</a></li>
            <li><a href="{{ route('code-generator.prompt-suggestion') }}" class="nav-link {{ request()->routeIs('code-generator.prompt-suggestion') ? 'active' : '' }}">Prompt Suggestion</a></li>
            <li><a href="{{ route('code-generator.report-view') }}" class="nav-link {{ request()->routeIs('code-generator.report-view') ? 'active' : '' }}">Report View</a></li>
            <li><a href="{{ route('code-generator.html-vs-prompt-score') }}" class="nav-link {{ request()->routeIs('code-generator.html-vs-prompt-score') ? 'active' : '' }}">HTML vs Prompt Score</a></li>
        </ul>
    </div>

    <!-- Phase 2: Build -->
    <div class="category">
        <h3 class="category-title">Phase 2: Build</h3>
        <ul class="nav-links">
            <li><a href="{{ route('code-generator.component-mapping') }}" class="nav-link {{ request()->routeIs('code-generator.component-mapping') ? 'active' : '' }}">Component Mapping</a></li>
            <li><a href="{{ route('code-generator.blade-preview') }}" class="nav-link {{ request()->routeIs('code-generator.blade-preview') ? 'active' : '' }}">Blade Preview</a></li>
            <li><a href="{{ route('code-generator.bug-fixer') }}" class="nav-link {{ request()->routeIs('code-generator.bug-fixer') ? 'active' : '' }}">Bug Fixer</a></li>
            <li><a href="{{ route('code-generator.role-mapper') }}" class="nav-link {{ request()->routeIs('code-generator.role-mapper') ? 'active' : '' }}">Role Mapper</a></li>
            <li><a href="{{ route('code-generator.notification-mapper') }}" class="nav-link {{ request()->routeIs('code-generator.notification-mapper') ? 'active' : '' }}">Notification Mapper</a></li>
        </ul>
    </div>

    <!-- Phase 3: Publish -->
    <div class="category">
        <h3 class="category-title">Phase 3: Publish</h3>
        <ul class="nav-links">
            <li><a href="{{ route('code-generator.final-checklist') }}" class="nav-link {{ request()->routeIs('code-generator.final-checklist') ? 'active' : '' }}">Final Checklist</a></li>
            <li><a href="{{ route('code-generator.publish-confirmation') }}" class="nav-link {{ request()->routeIs('code-generator.publish-confirmation') ? 'active' : '' }}">Publish Confirmation</a></li>
            <li><a href="{{ route('code-generator.publish-status') }}" class="nav-link {{ request()->routeIs('code-generator.publish-status') ? 'active' : '' }}">Publish Status</a></li>
            <li><a href="{{ route('code-generator.publish-report') }}" class="nav-link {{ request()->routeIs('code-generator.publish-report') ? 'active' : '' }}">Publish Report</a></li>
        </ul>
    </div>

    <!-- Shared -->
    <div class="category">
        <h3 class="category-title">Shared</h3>
        <ul class="nav-links">
            <li><a href="{{ route('code-generator.file-viewer') }}" class="nav-link {{ request()->routeIs('code-generator.file-viewer') ? 'active' : '' }}">File Viewer</a></li>
            <li><a href="{{ route('code-generator.code-diff') }}" class="nav-link {{ request()->routeIs('code-generator.code-diff') ? 'active' : '' }}">Code Diff</a></li>
            <li><a href="{{ route('code-generator.progress-tracker') }}" class="nav-link {{ request()->routeIs('code-generator.progress-tracker') ? 'active' : '' }}">Progress Tracker</a></li>
            <li><a href="{{ route('code-generator.ai-suggestion-popup') }}" class="nav-link {{ request()->routeIs('code-generator.ai-suggestion-popup') ? 'active' : '' }}">AI Suggestion Popup</a></li>
            <li><a href="{{ route('code-generator.audit-logs') }}" class="nav-link {{ request()->routeIs('code-generator.audit-logs') ? 'active' : '' }}">Audit Logs</a></li>
        </ul>
    </div>

    <!-- Optional -->
    <div class="category">
        <h3 class="category-title">Optional</h3>
        <ul class="nav-links">
            <li><a href="{{ route('code-generator.user-activity-log') }}" class="nav-link {{ request()->routeIs('code-generator.user-activity-log') ? 'active' : '' }}">User Activity Log</a></li>
            <li><a href="{{ route('code-generator.multi-user-collaboration') }}" class="nav-link {{ request()->routeIs('code-generator.multi-user-collaboration') ? 'active' : '' }}">Multi-user Collaboration</a></li>
            <li><a href="{{ route('code-generator.notification-center') }}" class="nav-link {{ request()->routeIs('code-generator.notification-center') ? 'active' : '' }}">Notification Center</a></li>
        </ul>
    </div>
</aside> 