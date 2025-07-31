<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Page Builder</title>
    
    <!-- CSS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/default.min.css" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 280px;
            --header-height: 60px;
            --primary-color: #4a90e2;
            --secondary-color: #f5f5f5;
            --text-color: #333;
            --border-color: #ddd;
        }

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Layout */
        .page-builder {
            display: flex;
            height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--secondary-color);
            border-right: 1px solid var(--border-color);
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        /* Main Content Area */
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            height: 100vh;
            overflow-y: auto;
            background: #fff;
        }

        /* Header */
        .header {
            height: var(--header-height);
            background: #fff;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            padding: 0 20px;
            position: sticky;
            top: 0;
            z-index: 900;
        }

        /* Component Panel */
        .component-panel {
            padding: 20px;
        }

        .component-item {
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 10px;
            cursor: move;
            transition: all 0.2s ease;
        }

        .component-item:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* Grid Layout System */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 20px;
            padding: 20px;
            min-height: 100vh;
        }

        .grid-item {
            grid-column: span 12;
            position: relative;
            min-height: 100px;
        }

        .grid-item[data-columns="2"] {
            grid-column: span 6;
        }

        .grid-item[data-columns="3"] {
            grid-column: span 4;
        }

        .grid-item[data-columns="4"] {
            grid-column: span 3;
        }

        .grid-controls {
            position: absolute;
            top: -30px;
            right: 0;
            display: none;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 5px;
            z-index: 1000;
        }

        .grid-item:hover .grid-controls {
            display: flex;
        }

        .grid-controls button {
            background: none;
            border: none;
            padding: 5px;
            margin: 0 2px;
            cursor: pointer;
            color: var(--text-color);
        }

        .grid-controls button:hover {
            color: var(--primary-color);
        }

        .drop-zone {
            min-height: 100px;
            border: 2px dashed var(--border-color);
            margin: 10px 0;
            padding: 20px;
            transition: all 0.2s ease;
            background-color: rgba(74, 144, 226, 0.05);
            position: relative;
            border-radius: 4px;
        }

        .drop-zone::before {
            content: 'Drop component here';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: var(--border-color);
            font-size: 1.2em;
            pointer-events: none;
        }

        .drop-zone.drag-over {
            border-color: var(--primary-color);
            background-color: rgba(74, 144, 226, 0.1);
        }

        .drop-zone.drag-over::before {
            color: var(--primary-color);
        }

        .drop-zone-content {
            min-height: 50px;
        }

        .drop-zone:empty {
            min-height: 100px;
        }

        .drop-zone:not(:empty)::before {
            display: none;
        }

        .layout-controls {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .layout-controls button {
            margin: 0 5px;
        }

        /* Toolbar */
        .toolbar {
            position: absolute;
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 5px;
            display: none;
            z-index: 1000;
        }

        .toolbar button {
            background: none;
            border: none;
            padding: 5px;
            cursor: pointer;
            color: var(--text-color);
        }

        .toolbar button:hover {
            color: var(--primary-color);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }

        /* Mode-specific styles */
        .edit-mode .component {
            border: 1px solid transparent;
        }

        .edit-mode .component:hover {
            border-color: var(--border-color);
        }

        .edit-mode .toolbar {
            display: none;
        }

        .edit-mode .component:hover .toolbar {
            display: flex;
        }

        .preview-mode .component {
            border: none;
        }

        .preview-mode .toolbar,
        .preview-mode .grid-controls,
        .preview-mode .component-item,
        .preview-mode .layout-controls {
            display: none !important;
        }

        .live-mode .component {
            border: none;
        }

        .live-mode .toolbar,
        .live-mode .grid-controls,
        .live-mode .component-item,
        .live-mode .layout-controls {
            display: none !important;
        }

        .live-mode .component {
            pointer-events: auto;
        }

        .mode-controls .btn {
            position: relative;
        }

        .mode-controls .btn.active {
            background-color: var(--primary-color);
            color: white;
        }

        .mode-controls .btn.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-bottom: 5px solid var(--primary-color);
        }
    </style>
</head>

@extends('layouts.app')

@section('css')
    <!-- CSS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/default.min.css" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-width: 280px;
            --header-height: 60px;
            --primary-color: #4a90e2;
            --secondary-color: #f5f5f5;
            --text-color: #333;
            --border-color: #ddd;
        }

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Layout */
        .page-builder {
            display: flex;
            height: calc(100vh - 120px);
            margin-top: -1.5rem;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            height: 100%;
            background: var(--secondary-color);
            border-right: 1px solid var(--border-color);
            position: fixed;
            left: 0;
            top: 120px;
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        /* Main Content Area */
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            height: 100%;
            overflow-y: auto;
            background: #fff;
        }

        /* Header */
        .header {
            height: var(--header-height);
            background: #fff;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            padding: 0 20px;
            position: sticky;
            top: 0;
            z-index: 900;
        }

        /* Component Panel */
        .component-panel {
            padding: 20px;
        }

        .component-item {
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 10px;
            cursor: move;
            transition: all 0.2s ease;
        }

        .component-item:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* Grid Layout System */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 20px;
            padding: 20px;
            min-height: 100vh;
        }

        .grid-item {
            grid-column: span 12;
            position: relative;
            min-height: 100px;
        }

        .grid-item[data-columns="2"] {
            grid-column: span 6;
        }

        .grid-item[data-columns="3"] {
            grid-column: span 4;
        }

        .grid-item[data-columns="4"] {
            grid-column: span 3;
        }

        .grid-controls {
            position: absolute;
            top: -30px;
            right: 0;
            display: none;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 5px;
            z-index: 1000;
        }

        .grid-item:hover .grid-controls {
            display: flex;
        }

        .grid-controls button {
            background: none;
            border: none;
            padding: 5px;
            margin: 0 2px;
            cursor: pointer;
            color: var(--text-color);
        }

        .grid-controls button:hover {
            color: var(--primary-color);
        }

        .drop-zone {
            min-height: 100px;
            border: 2px dashed var(--border-color);
            margin: 10px 0;
            padding: 20px;
            transition: all 0.2s ease;
            background-color: rgba(74, 144, 226, 0.05);
            position: relative;
            border-radius: 4px;
        }

        .drop-zone::before {
            content: 'Drop component here';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: var(--border-color);
            font-size: 1.2em;
            pointer-events: none;
        }

        .drop-zone.drag-over {
            border-color: var(--primary-color);
            background-color: rgba(74, 144, 226, 0.1);
        }

        .drop-zone.drag-over::before {
            color: var(--primary-color);
        }

        .drop-zone-content {
            min-height: 50px;
        }

        .drop-zone:empty {
            min-height: 100px;
        }

        .drop-zone:not(:empty)::before {
            display: none;
        }

        /* Mode-specific styles */
        .edit-mode .component {
            border: 1px solid transparent;
        }

        .edit-mode .component:hover {
            border-color: var(--border-color);
        }

        .edit-mode .toolbar {
            display: none;
        }

        .edit-mode .component:hover .toolbar {
            display: flex;
        }

        .preview-mode .component {
            border: none;
        }

        .preview-mode .toolbar,
        .preview-mode .grid-controls,
        .preview-mode .component-item,
        .preview-mode .layout-controls {
            display: none !important;
        }

        .live-mode .component {
            border: none;
        }

        .live-mode .toolbar,
        .live-mode .grid-controls,
        .live-mode .component-item,
        .live-mode .layout-controls {
            display: none !important;
        }

        .live-mode .component {
            pointer-events: auto;
        }

        .mode-controls .btn {
            position: relative;
        }

        .mode-controls .btn.active {
            background-color: var(--primary-color);
            color: white;
        }

        .mode-controls .btn.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-bottom: 5px solid var(--primary-color);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
@endsection

@section('content')
<div class="page-builder">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="component-panel">
            <div class="component-search mb-3">
                <input type="text" class="form-control" placeholder="Search components..." id="componentSearch">
            </div>
            <div class="component-categories mb-3">
                <button class="btn btn-sm btn-outline-primary active" data-category="all">All</button>
                <button class="btn btn-sm btn-outline-primary" data-category="layout">Layout</button>
                <button class="btn btn-sm btn-outline-primary" data-category="content">Content</button>
                <button class="btn btn-sm btn-outline-primary" data-category="media">Media</button>
            </div>
            <h3>Components</h3>
            <div class="component-item" draggable="true" data-type="heading" data-category="content">
                <i class="fas fa-heading"></i> Heading
            </div>
            <div class="component-item" draggable="true" data-type="text" data-category="content">
                <i class="fas fa-paragraph"></i> Text
            </div>
            <div class="component-item" draggable="true" data-type="image" data-category="media">
                <i class="fas fa-image"></i> Image
            </div>
            <div class="component-item" draggable="true" data-type="video" data-category="media">
                <i class="fas fa-video"></i> Video
            </div>
            <div class="component-item" draggable="true" data-type="form" data-category="content">
                <i class="fas fa-wpforms"></i> Form
            </div>
            <div class="component-item" draggable="true" data-type="columns" data-category="layout">
                <i class="fas fa-columns"></i> Columns
            </div>
            <div class="component-item" draggable="true" data-type="left-menu" data-category="layout">
                <i class="fas fa-bars"></i> Left Menu
            </div>
            <div class="component-item" draggable="true" data-type="sidebar" data-category="layout">
                <i class="fas fa-columns"></i> Sidebar
            </div>
            <div class="component-item" draggable="true" data-type="card" data-category="content">
                <i class="fas fa-square"></i> Card
            </div>
            <div class="component-item" draggable="true" data-type="tabs" data-category="content">
                <i class="fas fa-folder"></i> Tabs
            </div>
            <div class="component-item" draggable="true" data-type="accordion" data-category="content">
                <i class="fas fa-list"></i> Accordion
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <div class="mode-controls me-3">
                <button class="btn btn-primary active" data-mode="edit">
                    <i class="fas fa-edit"></i> Edit Mode
                </button>
                <button class="btn btn-secondary" data-mode="preview">
                    <i class="fas fa-eye"></i> Preview Mode
                </button>
                <button class="btn btn-info" data-mode="live">
                    <i class="fas fa-broadcast-tower"></i> Live Mode
                </button>
            </div>
            <button class="btn btn-primary me-2" id="saveBtn">
                <i class="fas fa-save"></i> Save
            </button>
            <button class="btn btn-secondary me-2" id="previewBtn">
                <i class="fas fa-eye"></i> Preview
            </button>
            <button class="btn btn-info me-2" id="exportBtn">
                <i class="fas fa-file-export"></i> Export
            </button>
            <div class="ms-auto">
                <button class="btn btn-outline-secondary" id="themeToggle">
                    <i class="fas fa-moon"></i>
                </button>
            </div>
        </div>

        <div id="canvas" class="p-4">
            <!-- Drop zones will be added here dynamically -->
        </div>
    </div>
</div>
@endsection

@section('js')
    <!-- JavaScript Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    
    <script>
        // Initialize the page builder
        document.addEventListener('DOMContentLoaded', function() {
            // Component templates
            const componentTemplates = {
                heading: `<div class="component" data-type="heading">
                    <h2 contenteditable="true">Heading</h2>
                    <div class="toolbar">
                        <button class="delete-btn"><i class="fas fa-trash"></i></button>
                        <button class="duplicate-btn"><i class="fas fa-copy"></i></button>
                        <button class="style-btn"><i class="fas fa-paint-brush"></i></button>
                    </div>
                </div>`,
                text: `<div class="component" data-type="text">
                    <p contenteditable="true">Enter your text here...</p>
                    <div class="toolbar">
                        <button class="delete-btn"><i class="fas fa-trash"></i></button>
                        <button class="duplicate-btn"><i class="fas fa-copy"></i></button>
                        <button class="style-btn"><i class="fas fa-paint-brush"></i></button>
                    </div>
                </div>`,
                image: `<div class="component" data-type="image">
                    <div class="image-container">
                        <img src="https://via.placeholder.com/400x300" alt="Placeholder image" style="max-width: 100%;">
                        <input type="file" class="image-upload" accept="image/*" style="display: none;">
                        <div class="image-upload-overlay">
                            <button class="btn btn-primary upload-btn">
                                <i class="fas fa-upload"></i> Upload Image
                            </button>
                        </div>
                    </div>
                    <div class="toolbar">
                        <button class="delete-btn"><i class="fas fa-trash"></i></button>
                        <button class="duplicate-btn"><i class="fas fa-copy"></i></button>
                        <button class="upload-btn"><i class="fas fa-upload"></i></button>
                        <button class="style-btn"><i class="fas fa-paint-brush"></i></button>
                        <button class="resize-btn"><i class="fas fa-expand"></i></button>
                    </div>
                </div>`,
                video: `<div class="component" data-type="video">
                    <div class="video-container">
                        <input type="text" class="video-url" placeholder="Enter YouTube URL" style="width: 100%; margin-bottom: 10px;">
                        <div class="video-preview"></div>
                    </div>
                    <div class="toolbar">
                        <button class="delete-btn"><i class="fas fa-trash"></i></button>
                        <button class="duplicate-btn"><i class="fas fa-copy"></i></button>
                        <button class="style-btn"><i class="fas fa-paint-brush"></i></button>
                    </div>
                </div>`,
                form: `<div class="component" data-type="form">
                    <form class="dynamic-form">
                        <div class="form-group mb-3">
                            <input type="text" class="form-control" placeholder="Name">
                        </div>
                        <div class="form-group mb-3">
                            <input type="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group mb-3">
                            <textarea class="form-control" placeholder="Message"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <div class="toolbar">
                        <button class="delete-btn"><i class="fas fa-trash"></i></button>
                        <button class="duplicate-btn"><i class="fas fa-copy"></i></button>
                        <button class="add-field-btn"><i class="fas fa-plus"></i></button>
                        <button class="style-btn"><i class="fas fa-paint-brush"></i></button>
                    </div>
                </div>`,
                columns: `<div class="component" data-type="columns">
                    <div class="row">
                        <div class="col-md-4 drop-zone">
                            <div class="column-content"></div>
                        </div>
                        <div class="col-md-4 drop-zone">
                            <div class="column-content"></div>
                        </div>
                        <div class="col-md-4 drop-zone">
                            <div class="column-content"></div>
                        </div>
                    </div>
                    <div class="toolbar">
                        <button class="delete-btn"><i class="fas fa-trash"></i></button>
                        <button class="duplicate-btn"><i class="fas fa-copy"></i></button>
                        <button class="style-btn"><i class="fas fa-paint-brush"></i></button>
                    </div>
                </div>`,
                'left-menu': `<div class="component" data-type="left-menu">
                    <div class="left-menu-container">
                        <div class="menu-header">
                            <h3 contenteditable="true">Menu Title</h3>
                        </div>
                        <ul class="menu-items">
                            <li class="menu-item">
                                <i class="fas fa-home"></i>
                                <span contenteditable="true">Home</span>
                            </li>
                            <li class="menu-item">
                                <i class="fas fa-user"></i>
                                <span contenteditable="true">Profile</span>
                            </li>
                            <li class="menu-item">
                                <i class="fas fa-cog"></i>
                                <span contenteditable="true">Settings</span>
                            </li>
                        </ul>
                    </div>
                    <div class="toolbar">
                        <button class="delete-btn"><i class="fas fa-trash"></i></button>
                        <button class="duplicate-btn"><i class="fas fa-copy"></i></button>
                        <button class="add-item-btn"><i class="fas fa-plus"></i></button>
                        <button class="style-btn"><i class="fas fa-paint-brush"></i></button>
                    </div>
                </div>`,
                'sidebar': `<div class="component" data-type="sidebar">
                    <div class="sidebar-container">
                        <div class="sidebar-header">
                            <h3 contenteditable="true">Sidebar Title</h3>
                        </div>
                        <div class="sidebar-content">
                            <div class="sidebar-section">
                                <h4 contenteditable="true">Section 1</h4>
                                <p contenteditable="true">Add your content here...</p>
                            </div>
                            <div class="sidebar-section">
                                <h4 contenteditable="true">Section 2</h4>
                                <p contenteditable="true">Add your content here...</p>
                            </div>
                        </div>
                    </div>
                    <div class="toolbar">
                        <button class="delete-btn"><i class="fas fa-trash"></i></button>
                        <button class="duplicate-btn"><i class="fas fa-copy"></i></button>
                        <button class="add-section-btn"><i class="fas fa-plus"></i></button>
                        <button class="style-btn"><i class="fas fa-paint-brush"></i></button>
                    </div>
                </div>`,
                'card': `<div class="component" data-type="card">
                    <div class="card">
                        <div class="card-header">
                            <h3 contenteditable="true">Card Title</h3>
                        </div>
                        <div class="card-body">
                            <p contenteditable="true">Card content goes here...</p>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary">Action</button>
                        </div>
                    </div>
                    <div class="toolbar">
                        <button class="delete-btn"><i class="fas fa-trash"></i></button>
                        <button class="duplicate-btn"><i class="fas fa-copy"></i></button>
                        <button class="style-btn"><i class="fas fa-paint-brush"></i></button>
                        <button class="resize-btn"><i class="fas fa-expand"></i></button>
                    </div>
                </div>`,
                'tabs': `<div class="component" data-type="tabs">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#tab1" data-bs-toggle="tab">Tab 1</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tab2" data-bs-toggle="tab">Tab 2</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab1">
                                <p contenteditable="true">Tab 1 content...</p>
                            </div>
                            <div class="tab-pane fade" id="tab2">
                                <p contenteditable="true">Tab 2 content...</p>
                            </div>
                        </div>
                    </div>
                    <div class="toolbar">
                        <button class="delete-btn"><i class="fas fa-trash"></i></button>
                        <button class="duplicate-btn"><i class="fas fa-copy"></i></button>
                        <button class="add-tab-btn"><i class="fas fa-plus"></i></button>
                        <button class="style-btn"><i class="fas fa-paint-brush"></i></button>
                    </div>
                </div>`,
                'accordion': `<div class="component" data-type="accordion">
                    <div class="accordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                                    <span contenteditable="true">Accordion Item 1</span>
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse show">
                                <div class="accordion-body">
                                    <p contenteditable="true">Accordion content 1...</p>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                    <span contenteditable="true">Accordion Item 2</span>
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <p contenteditable="true">Accordion content 2...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="toolbar">
                        <button class="delete-btn"><i class="fas fa-trash"></i></button>
                        <button class="duplicate-btn"><i class="fas fa-copy"></i></button>
                        <button class="add-item-btn"><i class="fas fa-plus"></i></button>
                        <button class="style-btn"><i class="fas fa-paint-brush"></i></button>
                    </div>
                </div>`
            };

            // Initialize the page builder with grid system
            const canvas = document.getElementById('canvas');
            canvas.innerHTML = `
                <div class="grid-container">
                    <div class="grid-item" data-columns="12">
                        <div class="grid-controls">
                            <button class="split-btn" title="Split into columns"><i class="fas fa-columns"></i></button>
                            <button class="merge-btn" title="Merge with adjacent"><i class="fas fa-compress-alt"></i></button>
                            <button class="delete-btn" title="Delete section"><i class="fas fa-trash"></i></button>
                            <button class="move-up-btn" title="Move up"><i class="fas fa-arrow-up"></i></button>
                            <button class="move-down-btn" title="Move down"><i class="fas fa-arrow-down"></i></button>
                        </div>
                        <div class="drop-zone">
                            <div class="drop-zone-content"></div>
                        </div>
                    </div>
                </div>
            `;

            // Add layout controls
            const layoutControls = document.createElement('div');
            layoutControls.className = 'layout-controls';
            layoutControls.innerHTML = `
                <button class="btn btn-primary" id="addRowBtn">
                    <i class="fas fa-plus"></i> Add Row
                </button>
                <button class="btn btn-secondary" id="clearLayoutBtn">
                    <i class="fas fa-trash"></i> Clear Layout
                </button>
            `;
            document.body.appendChild(layoutControls);

            // Make components draggable
            const componentItems = document.querySelectorAll('.component-item');
            componentItems.forEach(item => {
                item.addEventListener('dragstart', (e) => {
                    e.dataTransfer.setData('text/plain', item.dataset.type);
                    e.dataTransfer.effectAllowed = 'copy';
                    document.body.classList.add('dragging');
                });

                item.addEventListener('dragend', () => {
                    document.body.classList.remove('dragging');
                });
            });

            // Handle grid controls
            document.addEventListener('click', (e) => {
                const gridItem = e.target.closest('.grid-item');
                if (!gridItem) return;

                if (e.target.closest('.split-btn')) {
                    const columns = parseInt(gridItem.dataset.columns);
                    if (columns > 1) {
                        const newColumns = columns / 2;
                        const content = gridItem.querySelector('.drop-zone-content').innerHTML;
                        
                        // Create new grid item
                        const newGridItem = gridItem.cloneNode(true);
                        newGridItem.dataset.columns = newColumns;
                        
                        // Clear content of new item
                        newGridItem.querySelector('.drop-zone-content').innerHTML = '';
                        
                        // Insert new grid item
                        gridItem.parentNode.insertBefore(newGridItem, gridItem.nextSibling);
                        
                        // Update original item
                        gridItem.dataset.columns = newColumns;
                        
                        // Preserve content in original item
                        gridItem.querySelector('.drop-zone-content').innerHTML = content;
                        
                        // Initialize components in both items
                        initializeExistingComponents(gridItem);
                        initializeExistingComponents(newGridItem);
                        
                        saveState();
                    }
                }

                if (e.target.closest('.merge-btn')) {
                    const nextItem = gridItem.nextElementSibling;
                    if (nextItem && nextItem.classList.contains('grid-item')) {
                        const totalColumns = parseInt(gridItem.dataset.columns) + parseInt(nextItem.dataset.columns);
                        gridItem.dataset.columns = totalColumns;
                        nextItem.remove();
                        saveState();
                    }
                }

                if (e.target.closest('.delete-btn')) {
                    if (document.querySelectorAll('.grid-item').length > 1) {
                        gridItem.remove();
                        saveState();
                    }
                }

                if (e.target.closest('.move-up-btn')) {
                    const prevItem = gridItem.previousElementSibling;
                    if (prevItem) {
                        prevItem.parentNode.insertBefore(gridItem, prevItem);
                        saveState();
                    }
                }

                if (e.target.closest('.move-down-btn')) {
                    const nextItem = gridItem.nextElementSibling;
                    if (nextItem) {
                        nextItem.parentNode.insertBefore(gridItem, nextItem.nextSibling);
                        saveState();
                    }
                }
            });

            // Add row button
            document.getElementById('addRowBtn').addEventListener('click', () => {
                const gridContainer = document.querySelector('.grid-container');
                const newGridItem = document.createElement('div');
                newGridItem.className = 'grid-item';
                newGridItem.dataset.columns = '12';
                newGridItem.innerHTML = `
                    <div class="grid-controls">
                        <button class="split-btn" title="Split into columns"><i class="fas fa-columns"></i></button>
                        <button class="merge-btn" title="Merge with adjacent"><i class="fas fa-compress-alt"></i></button>
                        <button class="delete-btn" title="Delete section"><i class="fas fa-trash"></i></button>
                        <button class="move-up-btn" title="Move up"><i class="fas fa-arrow-up"></i></button>
                        <button class="move-down-btn" title="Move down"><i class="fas fa-arrow-down"></i></button>
                    </div>
                    <div class="drop-zone">
                        <div class="drop-zone-content"></div>
                    </div>
                `;
                gridContainer.appendChild(newGridItem);
                saveState();
            });

            // Clear layout button
            document.getElementById('clearLayoutBtn').addEventListener('click', () => {
                if (confirm('Are you sure you want to clear the entire layout?')) {
                    const gridContainer = document.querySelector('.grid-container');
                    gridContainer.innerHTML = `
                        <div class="grid-item" data-columns="12">
                            <div class="grid-controls">
                                <button class="split-btn" title="Split into columns"><i class="fas fa-columns"></i></button>
                                <button class="merge-btn" title="Merge with adjacent"><i class="fas fa-compress-alt"></i></button>
                                <button class="delete-btn" title="Delete section"><i class="fas fa-trash"></i></button>
                                <button class="move-up-btn" title="Move up"><i class="fas fa-arrow-up"></i></button>
                                <button class="move-down-btn" title="Move down"><i class="fas fa-arrow-down"></i></button>
                            </div>
                            <div class="drop-zone">
                                <div class="drop-zone-content"></div>
                            </div>
                        </div>
                    `;
                    saveState();
                }
            });

            // Handle drop zones
            canvas.addEventListener('dragover', (e) => {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'copy';
                
                const dropZone = e.target.closest('.drop-zone');
                if (dropZone) {
                    dropZone.classList.add('drag-over');
                }
            });

            canvas.addEventListener('dragleave', (e) => {
                const dropZone = e.target.closest('.drop-zone');
                if (dropZone && !dropZone.contains(e.relatedTarget)) {
                    dropZone.classList.remove('drag-over');
                }
            });

            canvas.addEventListener('drop', (e) => {
                e.preventDefault();
                const dropZone = e.target.closest('.drop-zone');
                if (dropZone) {
                    dropZone.classList.remove('drag-over');
                    const componentType = e.dataTransfer.getData('text/plain');
                    const template = componentTemplates[componentType];
                    if (template) {
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = template;
                        const component = tempDiv.firstElementChild;
                        component.id = `component-${Date.now()}`;
                        dropZone.querySelector('.drop-zone-content').appendChild(component);
                        initializeComponent(component);
                        saveState();
                    }
                }
            });

            // Initialize with empty state
            history.push(canvas.innerHTML);
            updateUndoRedoButtons();

            // Theme toggle
            document.getElementById('themeToggle').addEventListener('click', () => {
                document.body.classList.toggle('dark-theme');
            });

            // Preview mode
            document.getElementById('previewBtn').addEventListener('click', () => {
                const previewWindow = window.open('', '_blank');
                previewWindow.document.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Preview</title>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                    </head>
                    <body>
                        ${canvas.innerHTML}
                    </body>
                    </html>
                `);
            });

            // Export functionality
            document.getElementById('exportBtn').addEventListener('click', () => {
                const html = `
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Exported Page</title>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                    </head>
                    <body>
                        ${canvas.innerHTML}
                    </body>
                    </html>
                `;
                
                const blob = new Blob([html], { type: 'text/html' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'exported-page.html';
                a.click();
                URL.revokeObjectURL(url);
            });

            // Add style panel functionality
            const stylePanel = document.createElement('div');
            stylePanel.className = 'style-panel';
            stylePanel.style.display = 'none';
            stylePanel.innerHTML = `
                <div class="style-panel-content">
                    <h4>Style Options</h4>
                    <div class="mb-3">
                        <label>Background Color</label>
                        <input type="color" class="form-control bg-color">
                    </div>
                    <div class="mb-3">
                        <label>Text Color</label>
                        <input type="color" class="form-control text-color">
                    </div>
                    <div class="mb-3">
                        <label>Font Size</label>
                        <input type="range" class="form-range font-size" min="12" max="48" value="16">
                    </div>
                    <div class="mb-3">
                        <label>Padding</label>
                        <input type="range" class="form-range padding" min="0" max="50" value="20">
                    </div>
                    <button class="btn btn-primary apply-style">Apply</button>
                    <button class="btn btn-secondary close-style">Close</button>
                </div>
            `;
            document.body.appendChild(stylePanel);

            // Handle style button clicks
            document.addEventListener('click', (e) => {
                if (e.target.closest('.style-btn')) {
                    const component = e.target.closest('.component');
                    stylePanel.style.display = 'block';
                    stylePanel.dataset.target = component.id;
                }
            });

            // Apply styles
            document.querySelector('.apply-style').addEventListener('click', () => {
                const component = document.getElementById(stylePanel.dataset.target);
                if (component) {
                    const bgColor = stylePanel.querySelector('.bg-color').value;
                    const textColor = stylePanel.querySelector('.text-color').value;
                    const fontSize = stylePanel.querySelector('.font-size').value;
                    const padding = stylePanel.querySelector('.padding').value;

                    component.style.backgroundColor = bgColor;
                    component.style.color = textColor;
                    component.style.fontSize = `${fontSize}px`;
                    component.style.padding = `${padding}px`;
                }
            });

            // Close style panel
            document.querySelector('.close-style').addEventListener('click', () => {
                stylePanel.style.display = 'none';
            });

            // Handle image uploads
            document.addEventListener('change', (e) => {
                if (e.target.classList.contains('image-upload')) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            const img = e.target.closest('.image-container').querySelector('img');
                            img.src = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });

            // Handle video URLs
            document.addEventListener('input', (e) => {
                if (e.target.classList.contains('video-url')) {
                    const url = e.target.value;
                    const videoId = extractYouTubeId(url);
                    if (videoId) {
                        const preview = e.target.closest('.video-container').querySelector('.video-preview');
                        preview.innerHTML = `
                            <iframe width="100%" height="315" 
                                src="https://www.youtube.com/embed/${videoId}" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                            </iframe>
                        `;
                    }
                }
            });

            // Helper function to extract YouTube video ID
            function extractYouTubeId(url) {
                const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
                const match = url.match(regExp);
                return (match && match[2].length === 11) ? match[2] : null;
            }

            // Initialize syntax highlighting
            document.addEventListener('input', (e) => {
                if (e.target.classList.contains('language-javascript')) {
                    hljs.highlightElement(e.target);
                }
            });

            // Add undo/redo functionality
            const history = {
                states: [],
                currentIndex: -1,
                maxStates: 50,

                push(state) {
                    // Remove any future states if we're not at the end
                    this.states = this.states.slice(0, this.currentIndex + 1);
                    
                    // Add new state
                    this.states.push(state);
                    this.currentIndex++;
                    
                    // Limit history size
                    if (this.states.length > this.maxStates) {
                        this.states.shift();
                        this.currentIndex--;
                    }
                },

                undo() {
                    if (this.currentIndex > 0) {
                        this.currentIndex--;
                        return this.states[this.currentIndex];
                    }
                    return null;
                },

                redo() {
                    if (this.currentIndex < this.states.length - 1) {
                        this.currentIndex++;
                        return this.states[this.currentIndex];
                    }
                    return null;
                }
            };

            // Add undo/redo buttons to header
            const header = document.querySelector('.header');
            const undoRedoButtons = document.createElement('div');
            undoRedoButtons.className = 'ms-2';
            undoRedoButtons.innerHTML = `
                <button class="btn btn-outline-secondary me-2" id="undoBtn" disabled>
                    <i class="fas fa-undo"></i> Undo
                </button>
                <button class="btn btn-outline-secondary" id="redoBtn" disabled>
                    <i class="fas fa-redo"></i> Redo
                </button>
            `;
            header.insertBefore(undoRedoButtons, header.querySelector('.ms-auto'));

            // Handle undo/redo
            document.getElementById('undoBtn').addEventListener('click', () => {
                const state = history.undo();
                if (state) {
                    canvas.innerHTML = state;
                    updateUndoRedoButtons();
                }
            });

            document.getElementById('redoBtn').addEventListener('click', () => {
                const state = history.redo();
                if (state) {
                    canvas.innerHTML = state;
                    updateUndoRedoButtons();
                }
            });

            function updateUndoRedoButtons() {
                document.getElementById('undoBtn').disabled = history.currentIndex <= 0;
                document.getElementById('redoBtn').disabled = history.currentIndex >= history.states.length - 1;
            }

            // Save state after each change
            function saveState() {
                history.push(canvas.innerHTML);
                updateUndoRedoButtons();
            }

            // Handle component search functionality
            document.getElementById('componentSearch').addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase();
                const componentItems = document.querySelectorAll('.component-item');
                
                componentItems.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(searchTerm) ? 'block' : 'none';
                });
            });

            // Add component category filtering
            document.querySelectorAll('.component-categories button').forEach(button => {
                button.addEventListener('click', () => {
                    const category = button.dataset.category;
                    document.querySelectorAll('.component-categories button').forEach(btn => {
                        btn.classList.remove('active');
                    });
                    button.classList.add('active');

                    const componentItems = document.querySelectorAll('.component-item');
                    componentItems.forEach(item => {
                        if (category === 'all' || item.dataset.category === category) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });

            // Initialize component functionality
            function initializeComponent(component) {
                // Make content editable
                const editableElements = component.querySelectorAll('[contenteditable="true"]');
                editableElements.forEach(element => {
                    element.addEventListener('input', saveState);
                });

                // Handle delete button
                const deleteBtn = component.querySelector('.delete-btn');
                if (deleteBtn) {
                    deleteBtn.addEventListener('click', () => {
                        component.remove();
                        saveState();
                    });
                }

                // Handle duplicate button
                const duplicateBtn = component.querySelector('.duplicate-btn');
                if (duplicateBtn) {
                    duplicateBtn.addEventListener('click', () => {
                        const clone = component.cloneNode(true);
                        clone.id = `component-${Date.now()}`;
                        component.parentNode.insertBefore(clone, component.nextSibling);
                        initializeComponent(clone);
                        saveState();
                    });
                }

                // Handle style button
                const styleBtn = component.querySelector('.style-btn');
                if (styleBtn) {
                    styleBtn.addEventListener('click', () => {
                        stylePanel.style.display = 'block';
                        stylePanel.dataset.target = component.id;
                    });
                }

                // Handle add menu item button
                const addItemBtn = component.querySelector('.add-item-btn');
                if (addItemBtn) {
                    addItemBtn.addEventListener('click', () => {
                        const menuItems = component.querySelector('.menu-items');
                        const newItem = document.createElement('li');
                        newItem.className = 'menu-item';
                        newItem.innerHTML = `
                            <i class="fas fa-circle"></i>
                            <span contenteditable="true">New Item</span>
                        `;
                        menuItems.appendChild(newItem);
                        initializeComponent(newItem);
                        saveState();
                    });
                }

                // Handle add sidebar section button
                const addSectionBtn = component.querySelector('.add-section-btn');
                if (addSectionBtn) {
                    addSectionBtn.addEventListener('click', () => {
                        const sidebarContent = component.querySelector('.sidebar-content');
                        const newSection = document.createElement('div');
                        newSection.className = 'sidebar-section';
                        newSection.innerHTML = `
                            <h4 contenteditable="true">New Section</h4>
                            <p contenteditable="true">Add your content here...</p>
                        `;
                        sidebarContent.appendChild(newSection);
                        initializeComponent(newSection);
                        saveState();
                    });
                }

                // Handle image upload
                const uploadBtn = component.querySelector('.upload-btn');
                if (uploadBtn) {
                    uploadBtn.addEventListener('click', () => {
                        const fileInput = component.querySelector('.image-upload');
                        fileInput.click();
                    });
                }

                // Handle form field addition
                const addFieldBtn = component.querySelector('.add-field-btn');
                if (addFieldBtn) {
                    addFieldBtn.addEventListener('click', () => {
                        const form = component.querySelector('form');
                        const newField = document.createElement('div');
                        newField.className = 'form-group mb-3';
                        newField.innerHTML = `
                            <input type="text" class="form-control" placeholder="New Field">
                        `;
                        form.insertBefore(newField, form.lastElementChild);
                        saveState();
                    });
                }

                // Handle add tab button
                const addTabBtn = component.querySelector('.add-tab-btn');
                if (addTabBtn) {
                    addTabBtn.addEventListener('click', () => {
                        const tabsContainer = component.querySelector('.tabs-container');
                        const tabCount = tabsContainer.querySelectorAll('.nav-item').length + 1;
                        
                        // Add new tab
                        const newTab = document.createElement('li');
                        newTab.className = 'nav-item';
                        newTab.innerHTML = `
                            <a class="nav-link" href="#tab${tabCount}" data-bs-toggle="tab">Tab ${tabCount}</a>
                        `;
                        tabsContainer.querySelector('.nav-tabs').appendChild(newTab);

                        // Add new tab content
                        const newContent = document.createElement('div');
                        newContent.className = 'tab-pane fade';
                        newContent.id = `tab${tabCount}`;
                        newContent.innerHTML = `
                            <p contenteditable="true">Tab ${tabCount} content...</p>
                        `;
                        tabsContainer.querySelector('.tab-content').appendChild(newContent);

                        initializeComponent(newContent);
                        saveState();
                    });
                }

                // Handle add accordion item button
                const addAccordionItemBtn = component.querySelector('.add-item-btn');
                if (addAccordionItemBtn && component.dataset.type === 'accordion') {
                    addAccordionItemBtn.addEventListener('click', () => {
                        const accordion = component.querySelector('.accordion');
                        const itemCount = accordion.querySelectorAll('.accordion-item').length + 1;
                        
                        const newItem = document.createElement('div');
                        newItem.className = 'accordion-item';
                        newItem.innerHTML = `
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${itemCount}">
                                    <span contenteditable="true">Accordion Item ${itemCount}</span>
                                </button>
                            </h2>
                            <div id="collapse${itemCount}" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <p contenteditable="true">Accordion content ${itemCount}...</p>
                                </div>
                            </div>
                        `;
                        accordion.appendChild(newItem);
                        initializeComponent(newItem);
                        saveState();
                    });
                }
            }

            // Add function to initialize existing components
            function initializeExistingComponents(container) {
                const components = container.querySelectorAll('.component');
                components.forEach(component => {
                    if (!component.id) {
                        component.id = `component-${Date.now()}`;
                    }
                    initializeComponent(component);
                });
            }

            // Update grid container styles
            const gridContainer = document.querySelector('.grid-container');
            if (gridContainer) {
                gridContainer.style.display = 'grid';
                gridContainer.style.gridTemplateColumns = 'repeat(12, 1fr)';
                gridContainer.style.gap = '20px';
                gridContainer.style.padding = '20px';
            }

            // Mode controls
            const modeControls = document.querySelector('.mode-controls');
            let currentMode = 'edit';

            modeControls.addEventListener('click', (e) => {
                const button = e.target.closest('button');
                if (!button) return;

                const mode = button.dataset.mode;
                if (mode === currentMode) return;

                // Update active button
                modeControls.querySelectorAll('button').forEach(btn => {
                    btn.classList.remove('active');
                });
                button.classList.add('active');

                // Update mode
                currentMode = mode;
                document.body.className = `${mode}-mode`;

                // Handle mode-specific behaviors
                switch (mode) {
                    case 'edit':
                        enableEditing();
                        break;
                    case 'preview':
                        disableEditing();
                        break;
                    case 'live':
                        enableLiveMode();
                        break;
                }
            });

            function enableEditing() {
                // Enable all editing features
                document.querySelectorAll('.component').forEach(component => {
                    component.setAttribute('contenteditable', 'true');
                    component.style.pointerEvents = 'auto';
                });

                // Show all controls
                document.querySelectorAll('.toolbar, .grid-controls, .layout-controls').forEach(control => {
                    control.style.display = '';
                });

                // Enable drag and drop
                document.querySelectorAll('.component-item').forEach(item => {
                    item.draggable = true;
                });
            }

            function disableEditing() {
                // Disable editing features
                document.querySelectorAll('.component').forEach(component => {
                    component.removeAttribute('contenteditable');
                    component.style.pointerEvents = 'auto';
                });

                // Hide all controls
                document.querySelectorAll('.toolbar, .grid-controls, .layout-controls').forEach(control => {
                    control.style.display = 'none';
                });

                // Disable drag and drop
                document.querySelectorAll('.component-item').forEach(item => {
                    item.draggable = false;
                });
            }

            function enableLiveMode() {
                disableEditing();

                // Add live mode specific behaviors
                document.querySelectorAll('form').forEach(form => {
                    form.addEventListener('submit', handleFormSubmit);
                });

                document.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', handleLinkClick);
                });

                // Initialize any interactive components
                initializeInteractiveComponents();
            }

            function handleFormSubmit(e) {
                e.preventDefault();
                // Handle form submission in live mode
                const formData = new FormData(e.target);
                // Add your form submission logic here
                console.log('Form submitted:', Object.fromEntries(formData));
            }

            function handleLinkClick(e) {
                // Handle link clicks in live mode
                const href = e.target.getAttribute('href');
                if (href && href.startsWith('#')) {
                    e.preventDefault();
                    // Handle internal navigation
                    const targetElement = document.querySelector(href);
                    if (targetElement) {
                        targetElement.scrollIntoView({ behavior: 'smooth' });
                    }
                }
            }

            function initializeInteractiveComponents() {
                // Initialize tabs
                document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
                    tab.addEventListener('click', (e) => {
                        e.preventDefault();
                        const target = document.querySelector(tab.getAttribute('href'));
                        if (target) {
                            // Hide all tab panes
                            target.parentElement.querySelectorAll('.tab-pane').forEach(pane => {
                                pane.classList.remove('show', 'active');
                            });
                            // Show target tab pane
                            target.classList.add('show', 'active');
                            // Update active tab
                            tab.parentElement.querySelectorAll('.nav-link').forEach(link => {
                                link.classList.remove('active');
                            });
                            tab.classList.add('active');
                        }
                    });
                });

                // Initialize accordions
                document.querySelectorAll('.accordion-button').forEach(button => {
                    button.addEventListener('click', () => {
                        const target = document.querySelector(button.getAttribute('data-bs-target'));
                        if (target) {
                            const isExpanded = button.classList.contains('collapsed');
                            // Toggle all accordion items
                            button.parentElement.parentElement.querySelectorAll('.accordion-button').forEach(btn => {
                                btn.classList.add('collapsed');
                                document.querySelector(btn.getAttribute('data-bs-target')).classList.remove('show');
                            });
                            // Toggle clicked item
                            if (isExpanded) {
                                button.classList.remove('collapsed');
                                target.classList.add('show');
                            }
                        }
                    });
                });
            }
        });
    </script>
@endsection 