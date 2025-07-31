@extends('layouts.master')

 

@section('content')
<link rel="preload" href="styles.css" as="style">
<link rel="preload" href="fonts/main-font.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="i18n.js" as="script">
<link rel="preload" href="analytics.js" as="script">
<link rel="preload" href="security.js" as="script">
<!-- Add security.js -->
<script src="security.js"></script>
<!-- Add security headers -->
<meta http-equiv="X-Content-Type-Options" content="nosniff">
<meta http-equiv="X-Frame-Options" content="DENY">
<meta http-equiv="X-XSS-Protection" content="1; mode=block">
<meta http-equiv="Referrer-Policy" content="strict-origin-when-cross-origin">

<style>
        :root {
            --primary-color: #2563eb;
            --text-color: #1f2937;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
            --background-color: #ffffff;
            --card-background: #f8fafc;
            --hover-color: #f1f5f9;
            --success-color: #059669;
            --warning-color: #d97706;
            --error-color: #dc2626;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --transition: all 0.2s ease-in-out;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            line-height: 1.5;
            color: var(--text-color);
            background: var(--background-color);
        }

        /* Navigation */
        .top-nav {
            background: var(--background-color);
            padding: 1rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-color);
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
        }

        .nav-link {
            color: var(--text-color);
            text-decoration: none;
            font-size: 0.875rem;
            padding: 0.5rem;
            border-radius: 0.375rem;
            transition: all 0.2s;
        }

        .nav-link:hover {
            background: var(--hover-color);
            color: var(--primary-color);
        }

        /* Main Content */
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .section-card {
            background: var(--card-background);
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: relative;
            transition: var(--transition);
        }

        .section-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            font-size: 1.25rem;
            font-weight: 600;
            position: relative;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .section-count {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            background: var(--hover-color);
            color: var(--text-secondary);
            padding: 0.25rem 0.5rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .section-items {
            display: grid;
            gap: 1rem;
        }

        .item-card {
            background: var(--background-color);
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            padding: 1rem;
            text-decoration: none;
            color: var(--text-color);
            transition: all 0.2s;
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .item-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        .item-card::after {
            content: "→";
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0;
            transition: var(--transition);
        }

        .item-card:hover::after {
            opacity: 1;
            right: 0.75rem;
        }

        .item-badge {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            padding: 0.25rem 0.5rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-new {
            background: var(--success-color);
            color: white;
        }

        .badge-updated {
            background: var(--warning-color);
            color: white;
        }

        .item-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .item-title {
            font-weight: 500;
        }

        .item-description {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 2rem;
            color: var(--text-secondary);
            font-size: 0.875rem;
            border-top: 1px solid var(--border-color);
            margin-top: 3rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-content {
                flex-direction: column;
                gap: 1rem;
            }

            .nav-links {
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .quick-actions {
                flex-direction: column;
            }

            .quick-action-btn {
                width: 100%;
                justify-content: center;
            }

            .activity-item {
                flex-direction: column;
                align-items: flex-start;
                text-align: left;
            }

            .activity-time {
                margin-top: 0.25rem;
            }
        }

        /* Active State */
        .item-card.active {
            border-color: var(--primary-color);
            background: var(--hover-color);
        }

        /* Search Bar */
        .search-container {
            margin-bottom: 2rem;
            position: relative;
        }

        .search-bar {
            width: 100%;
            padding: 0.75rem 1rem;
            padding-left: 2.5rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            font-size: 0.875rem;
            background: var(--background-color);
            transition: var(--transition);
        }

        .search-bar:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
        }

        /* Quick Actions */
        .quick-actions {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .quick-action-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
        }

        .quick-action-btn:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }

        /* User Profile */
        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .user-profile:hover {
            background: var(--hover-color);
        }

        .user-avatar {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 0.875rem;
            font-weight: 500;
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        /* Recent Activity */
        .recent-activity {
            margin-top: 2rem;
            padding: 1.5rem;
            background: var(--card-background);
            border-radius: 0.5rem;
            box-shadow: var(--shadow-sm);
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem;
            background: var(--background-color);
            border-radius: 0.375rem;
            font-size: 0.875rem;
        }

        .activity-icon {
            width: 2rem;
            height: 2rem;
            border-radius: 0.375rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--hover-color);
        }

        .activity-content {
            flex: 1;
        }

        .activity-time {
            color: var(--text-secondary);
            font-size: 0.75rem;
        }

        /* Loading State */
        .loading {
            position: relative;
            pointer-events: none;
            opacity: 0.7;
        }

        .loading::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 24px;
            height: 24px;
            margin: -12px 0 0 -12px;
            border: 2px solid var(--primary-color);
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>

@include('backend.category.partials.create-category')

<!-- Main Content -->
<main class="">
    <!-- Search and Quick Actions -->
    <div class="search-container">
        <svg class="search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2">
            <circle cx="11" cy="11" r="8" />
            <path d="M21 21l-4.35-4.35" />
        </svg>
        <input type="text" class="search-bar" placeholder="Search templates, components, or tools..." id="searchInput">
    </div>

    <div class="quick-actions">
        <button class="quick-action-btn" onclick="location.href='new-html-builder.html'">
            <span>🆕</span>
            New Template
        </button>

        <button type="button" class="btn btn-soft-light mb-2" data-bs-toggle="modal"
                            data-bs-target="#createCategoryModal">
                            Add Categories
                        </button>
        <button class="quick-action-btn" onclick="location.href='ai-html-generator.html'">
            <span>🤖</span>
            AI Generator
        </button>
        <button class="quick-action-btn" onclick="location.href='template-library.html'">
            <span>📚</span>
            Template Library
        </button>
        <button class="quick-action-btn" onclick="location.href='export-html-output.html'">
            <span>📤</span>
            Export
        </button>
    </div>

 
 
 
    <!-- Recent Activity -->
    <div class="recent-activity">
        <div class="section-header">
            <span>📊</span>
            <h2>Recent Activity</h2>
        </div>
        <div class="activity-list">
            <div class="activity-item">
                <div class="activity-icon">📝</div>
                <div class="activity-content">
                    <div>Created new template "Hero Section - Modern"</div>
                    <div class="activity-time">2 hours ago</div>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-icon">🤖</div>
                <div class="activity-content">
                    <div>Generated HTML using AI Assistant</div>
                    <div class="activity-time">5 hours ago</div>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-icon">📤</div>
                <div class="activity-content">
                    <div>Exported template "Contact Form"</div>
                    <div class="activity-time">1 day ago</div>
                </div>
            </div>
        </div>
    </div>
</main>



<script>
// Search functionality
const searchInput = document.getElementById('searchInput');
const itemCards = document.querySelectorAll('.item-card');
const sections = document.querySelectorAll('.section-card');

searchInput.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();

    itemCards.forEach(card => {
        const title = card.querySelector('.item-title').textContent.toLowerCase();
        const description = card.querySelector('.item-description').textContent.toLowerCase();
        const isVisible = title.includes(searchTerm) || description.includes(searchTerm);

        card.style.display = isVisible ? 'flex' : 'none';
    });

    // Hide empty sections
    sections.forEach(section => {
        const visibleItems = section.querySelectorAll('.item-card[style="display: flex"]');
        section.style.display = visibleItems.length > 0 ? 'block' : 'none';
    });
});

// Add loading state to buttons
document.querySelectorAll('.quick-action-btn').forEach(button => {
    button.addEventListener('click', function() {
        this.classList.add('loading');
        setTimeout(() => {
            this.classList.remove('loading');
        }, 1000);
    });
});

// Mock recent activity updates
function updateRecentActivity() {
    const activities = [{
            icon: '📝',
            text: 'Created new template "Hero Section - Modern"',
            time: '2 hours ago'
        },
        {
            icon: '🤖',
            text: 'Generated HTML using AI Assistant',
            time: '5 hours ago'
        },
        {
            icon: '📤',
            text: 'Exported template "Contact Form"',
            time: '1 day ago'
        }
    ];

    const activityList = document.querySelector('.activity-list');
    activityList.innerHTML = activities.map(activity => `
                <div class="activity-item">
                    <div class="activity-icon">${activity.icon}</div>
                    <div class="activity-content">
                        <div>${activity.text}</div>
                        <div class="activity-time">${activity.time}</div>
                    </div>
                </div>
            `).join('');
}

// Initialize
updateRecentActivity();
</script>

@endsection