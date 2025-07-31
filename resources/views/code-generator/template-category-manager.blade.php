<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template Category Manager</title>
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
            --danger-color: #dc2626;
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

        .nav-link:hover, .nav-link.active {
            background: var(--hover-color);
            color: var(--primary-color);
        }

        /* Main Content */
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        /* Toolbar */
        .toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .category-count {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        /* Search Bar */
        .search-bar {
            position: relative;
            max-width: 300px;
            margin-bottom: 1.5rem;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem;
            padding-left: 2.5rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            font-size: 0.875rem;
        }

        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
        }

        /* Category Table */
        .category-table {
            width: 100%;
            border-collapse: collapse;
            background: var(--background-color);
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .category-table th {
            background: var(--card-background);
            padding: 1rem;
            text-align: left;
            font-weight: 500;
            color: var(--text-secondary);
            border-bottom: 1px solid var(--border-color);
        }

        .category-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .category-table tr:last-child td {
            border-bottom: none;
        }

        .category-table tr:hover {
            background: var(--hover-color);
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-active {
            background: #dcfce7;
            color: var(--success-color);
        }

        .status-inactive {
            background: #fee2e2;
            color: var(--danger-color);
        }

        /* Add Category Form */
        .add-category {
            background: var(--card-background);
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            font-size: 1.125rem;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 1rem;
            align-items: end;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-label {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .form-input, .form-select {
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 0.375rem;
            font-size: 0.875rem;
            background: var(--background-color);
        }

        /* Buttons */
        .button {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .button-primary {
            background: var(--primary-color);
            color: white;
        }

        .button-primary:hover {
            background: #1d4ed8;
        }

        .button-secondary {
            background: var(--hover-color);
            color: var(--text-color);
        }

        .button-secondary:hover {
            background: #e2e8f0;
        }

        .button-danger {
            background: var(--danger-color);
            color: white;
        }

        .button-danger:hover {
            background: #b91c1c;
        }

        .button-icon {
            padding: 0.5rem;
            font-size: 0.875rem;
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

            .toolbar {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .category-table {
                display: block;
                overflow-x: auto;
            }

            .button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Top Navigation -->
    <nav class="top-nav">
        <div class="nav-content">
            <a href="html-builder-dashboard.html" class="brand">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
                HTML Builder
            </a>
            <div class="nav-links">
                <a href="html-builder-dashboard.html" class="nav-link">Dashboard</a>
                <a href="new-html-builder.html" class="nav-link">Builder</a>
                <a href="template-library.html" class="nav-link">Templates</a>
                <a href="template-category-manager.html" class="nav-link active">Categories</a>
                <a href="ai-html-generator.html" class="nav-link">AI Generator</a>
                <a href="export-html-output.html" class="nav-link">Export</a>
                <a href="#" class="nav-link">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <!-- Toolbar -->
        <div class="toolbar">
            <button class="button button-secondary" onclick="location.href='template-library.html'">Back to Template Library</button>
            <span class="category-count">Total Categories: 8</span>
        </div>

        <!-- Add New Category Form -->
        <div class="add-category">
            <h2 class="form-title">Add New Category</h2>
            <form class="form-grid">
                <div class="form-group">
                    <label class="form-label">Category Name</label>
                    <input type="text" class="form-input" placeholder="Enter category name">
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select class="form-select">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <button type="submit" class="button button-primary">Add Category</button>
            </form>
        </div>

        <!-- Search Bar -->
        <div class="search-bar">
            <span class="search-icon">🔍</span>
            <input type="text" class="search-input" placeholder="Search categories...">
        </div>

        <!-- Category Table Section -->
        <table class="category-table">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Total Templates</th>
                    <th>Status</th>
                    <th>Last Modified</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Hero Sections</td>
                    <td>12</td>
                    <td><span class="status-badge status-active">Active</span></td>
                    <td>2024-03-15</td>
                    <td>
                        <button class="button button-icon button-secondary">Edit</button>
                        <button class="button button-icon button-danger">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>Contact Forms</td>
                    <td>8</td>
                    <td><span class="status-badge status-active">Active</span></td>
                    <td>2024-03-14</td>
                    <td>
                        <button class="button button-icon button-secondary">Edit</button>
                        <button class="button button-icon button-danger">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>Pricing Tables</td>
                    <td>6</td>
                    <td><span class="status-badge status-active">Active</span></td>
                    <td>2024-03-13</td>
                    <td>
                        <button class="button button-icon button-secondary">Edit</button>
                        <button class="button button-icon button-danger">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>Email Layouts</td>
                    <td>10</td>
                    <td><span class="status-badge status-inactive">Inactive</span></td>
                    <td>2024-03-12</td>
                    <td>
                        <button class="button button-icon button-secondary">Edit</button>
                        <button class="button button-icon button-danger">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        // Placeholder functions for future implementation
        function editCategory(categoryId) {
            console.log('Edit category:', categoryId);
        }

        function deleteCategory(categoryId) {
            if (confirm('Are you sure you want to delete this category?')) {
                console.log('Delete category:', categoryId);
            }
        }

        // Add click handlers to buttons
        document.querySelectorAll('.button-secondary').forEach(button => {
            if (button.textContent === 'Edit') {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const categoryName = row.cells[0].textContent;
                    editCategory(categoryName);
                });
            }
        });

        document.querySelectorAll('.button-danger').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                const categoryName = row.cells[0].textContent;
                deleteCategory(categoryName);
            });
        });
    </script>
</body>
</html> 