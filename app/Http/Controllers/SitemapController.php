<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SitemapController extends Controller
{
    protected $excludedMethods = ['POST', 'PUT', 'PATCH', 'DELETE'];
    protected $excludedPatterns = [
        // Data operations
        'edit', 'update', 'destroy', 'delete', 'store', 'create', 'toggle',
        'verify', 'reorder', 'bulk', 'import', 'export', 'generate', 'duplicate',
        'save-template', 'updateOrder', 'updateStatus', 'updateImage', 'updateIcon',
        'toggleProtection', 'mediaUpload', 'categoryMediaDestroy', 'storeHierarchy',
        'getHierarchyChildren', 'getChildren', 'getChildrenByName', 'filterByLabel',
        'search', 'batch', 'documentation', 'evaluate', 'saveFieldSettings',
        'saveSettings', 'submit', 'render',
        
        // API and data endpoints
        'api/', 'ajax/', 'fetch', 'get-', 'load-', 'search-', 'filter-',
        'sort-', 'paginate', 'export-', 'import-', 'download', 'upload',
        
        // Form submissions
        'submit-', 'process-', 'handle-', 'action-', 'do-',
        
        // State changes
        'toggle-', 'change-', 'switch-', 'activate-', 'deactivate-',
        
        // Data manipulation
        'add-', 'remove-', 'insert-', 'delete-', 'trash-', 'restore-',
        
        // System operations
        'clear-', 'flush-', 'reset-', 'refresh-', 'reload-', 'sync-',
        
        // Media operations
        'upload-', 'download-', 'delete-', 'crop-', 'resize-', 'optimize-',
        
        // Authentication operations
        'login', 'register', 'logout', 'password', 'reset', 'verify-',
        
        // Internal routes
        '_', 'livewire/', 'sanctum/', 'horizon/', 'telescope/', 'debugbar/'
    ];

    protected $adminCategories = [
        'dashboard' => [
            'title' => 'Dashboard',
            'description' => 'Main admin dashboard and overview',
            'patterns' => ['dashboard']
        ],
        'user_management' => [
            'title' => 'User Management',
            'description' => 'User accounts and permissions',
            'patterns' => ['users', 'roles', 'permissions']
        ],
        'content_management' => [
            'title' => 'Content Management',
            'description' => 'Content and media management',
            'patterns' => ['posts', 'categories', 'media']
        ],
        'form_management' => [
            'title' => 'Form Management',
            'description' => 'Form builder and management',
            'patterns' => ['forms', 'form-', 'field-types', 'field-categories']
        ],
        'table_management' => [
            'title' => 'Table Management',
            'description' => 'Table builder and management',
            'patterns' => ['table-builder']
        ],
        'business_management' => [
            'title' => 'Business Management',
            'description' => 'Business accounts and settings',
            'patterns' => ['business']
        ],
        'system_settings' => [
            'title' => 'System Settings',
            'description' => 'System configuration and settings',
            'patterns' => ['settings', 'configuration']
        ]
    ];

    public function index()
    {
        $routes = $this->getFilteredRoutes();
        $categorizedRoutes = $this->categorizeRoutes($routes);
        return view('sitemap', compact('categorizedRoutes'));
    }

    public function businessSitemap()
    {
        $routes = $this->getFilteredRoutes('business');
        $categorizedRoutes = $this->categorizeRoutes($routes);
        return view('sitemap', compact('categorizedRoutes'));
    }

    public function userSitemap()
    {
        $routes = $this->getFilteredRoutes('user');
        $categorizedRoutes = $this->categorizeRoutes($routes);
        return view('sitemap', compact('categorizedRoutes'));
    }

    public function publicSitemap()
    {
        $routes = $this->getFilteredRoutes('public');
        $categorizedRoutes = $this->categorizeRoutes($routes);
        return view('sitemap', compact('categorizedRoutes'));
    }

    protected function getFilteredRoutes($type = 'all')
    {
        $routes = collect(Route::getRoutes())->filter(function ($route) {
            $uri = $route->uri();
            $methods = $route->methods();

            // Skip if it's not a GET route
            if (!in_array('GET', $methods)) {
                return false;
            }

            // Skip internal and system routes
            if (str_starts_with($uri, '_') || 
                str_starts_with($uri, 'api/') || 
                str_starts_with($uri, 'sanctum/') || 
                str_starts_with($uri, 'livewire/') ||
                str_starts_with($uri, 'horizon/') ||
                str_starts_with($uri, 'telescope/') ||
                str_starts_with($uri, 'debugbar/')) {
                return false;
            }

            // Skip routes with excluded patterns
            foreach ($this->excludedPatterns as $pattern) {
                if (str_contains($uri, $pattern)) {
                    return false;
                }
            }

            // Skip routes that are likely data operations
            $segments = explode('/', $uri);
            $lastSegment = end($segments);
            
            // Skip if the last segment is numeric (likely an ID)
            if (is_numeric($lastSegment)) {
                return false;
            }

            // Skip if the route contains common data operation patterns
            $dataOperationPatterns = ['edit', 'create', 'update', 'delete', 'destroy', 'store'];
            foreach ($dataOperationPatterns as $pattern) {
                if (str_contains($uri, $pattern)) {
                    return false;
                }
            }

            return true;
        })->map(function ($route) {
            return [
                'uri' => $route->uri(),
                'name' => $route->getName(),
                'methods' => $route->methods(),
                'middleware' => $route->middleware(),
            ];
        });

        // Filter based on type
        if ($type !== 'all') {
            $routes = $routes->filter(function ($route) use ($type) {
                switch ($type) {
                    case 'business':
                        return str_starts_with($route['uri'], 'business/');
                    case 'user':
                        return !str_starts_with($route['uri'], 'admin/') && 
                               !str_starts_with($route['uri'], 'business/');
                    case 'public':
                        return !str_starts_with($route['uri'], 'admin/') && 
                               !str_starts_with($route['uri'], 'business/') &&
                               !in_array('auth', $route['middleware']);
                    default:
                        return true;
                }
            });
        }

        return $routes->values();
    }

    protected function categorizeRoutes($routes)
    {
        $categories = [
            'admin' => [
                'title' => 'Admin Pages',
                'description' => 'Administrative pages and controls',
                'routes' => []
            ],
            'business' => [
                'title' => 'Business Pages',
                'description' => 'Business management and operations',
                'routes' => []
            ],
            'forms' => [
                'title' => 'Form Management',
                'description' => 'Form creation and management',
                'routes' => []
            ],
            'categories' => [
                'title' => 'Category Management',
                'description' => 'Category organization and structure',
                'routes' => []
            ],
            'table_builder' => [
                'title' => 'Table Builder',
                'description' => 'Table creation and management',
                'routes' => []
            ],
            'auth' => [
                'title' => 'Authentication',
                'description' => 'User authentication and authorization',
                'routes' => []
            ],
            'user' => [
                'title' => 'User Pages',
                'description' => 'User-specific pages and features',
                'routes' => []
            ]
        ];

        // Initialize admin subcategories
        foreach ($this->adminCategories as $key => $category) {
            $categories['admin']['subcategories'][$key] = [
                'title' => $category['title'],
                'description' => $category['description'],
                'routes' => []
            ];
        }

        foreach ($routes as $route) {
            $uri = $route['uri'];
            $middleware = $route['middleware'];

            if (str_starts_with($uri, 'admin/')) {
                // Categorize admin routes into subcategories
                $categorized = false;
                foreach ($this->adminCategories as $key => $category) {
                    foreach ($category['patterns'] as $pattern) {
                        if (str_contains($uri, $pattern)) {
                            $categories['admin']['subcategories'][$key]['routes'][] = $route;
                            $categorized = true;
                            break 2;
                        }
                    }
                }
                if (!$categorized) {
                    $categories['admin']['routes'][] = $route;
                }
            } elseif (str_starts_with($uri, 'business/')) {
                $categories['business']['routes'][] = $route;
            } elseif (str_contains($uri, 'forms') || str_contains($uri, 'form-')) {
                $categories['forms']['routes'][] = $route;
            } elseif (str_contains($uri, 'categories')) {
                $categories['categories']['routes'][] = $route;
            } elseif (str_contains($uri, 'table-builder')) {
                $categories['table_builder']['routes'][] = $route;
            } elseif (in_array('auth', $middleware) || str_contains($uri, 'login') || str_contains($uri, 'register')) {
                $categories['auth']['routes'][] = $route;
            } else {
                $categories['user']['routes'][] = $route;
            }
        }

        // Remove empty categories and subcategories
        foreach ($categories as $key => $category) {
            if (isset($category['subcategories'])) {
                $categories[$key]['subcategories'] = array_filter($category['subcategories'], function($subcategory) {
                    return !empty($subcategory['routes']);
                });
            }
        }

        return array_filter($categories, function($category) {
            return !empty($category['routes']) || (isset($category['subcategories']) && !empty($category['subcategories']));
        });
    }
} 