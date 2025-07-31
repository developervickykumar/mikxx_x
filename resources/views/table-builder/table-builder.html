<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Builder</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-color: #4a6da7;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --border-color: #e0e0e0;
            --bg-color: #f8f9fa;
            --text-color: #333;
            --sidebar-width: 25vw;
            --main-width: 75vw;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            display: flex;
            min-height: 100vh;
            overflow: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: white;
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .sidebar-header {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            background: var(--primary-color);
            color: white;
        }

        .sidebar-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .tab-buttons {
            display: flex;
            border-bottom: 1px solid var(--border-color);
        }

        .tab-button {
            flex: 1;
            padding: 12px;
            text-align: center;
            border: none;
            background: none;
            cursor: pointer;
            border-bottom: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .tab-button.active {
            border-bottom: 2px solid var(--primary-color);
            color: var(--primary-color);
        }

        .tab-button i {
            width: 20px;
            text-align: center;
        }

        /* Tab Content Styles */
        .tab-content {
            display: none;
            padding: 15px;
            overflow-y: auto;
            height: calc(100vh - 120px);
        }

        .tab-content.active {
            display: block;
        }

        /* Form Builder Styles */
        .form-builder {
            background: white;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .form-file-name {
            margin-bottom: 15px;
        }

        .form-file-name input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 1rem;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: var(--text-color);
        }

        .form-input {
            width: 100%;
            padding: 8px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            color: white;
        }

        /* Graph Styles */
        .graph-container {
            background: white;
            border-radius: 4px;
            padding: 12px;
            margin-bottom: 10px;
        }

        .graph-selector {
            margin-bottom: 15px;
        }

        .graph-type {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }

        .graph-type-btn {
            padding: 6px 12px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            background: white;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .graph-type-btn.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .graph-canvas {
            width: 100%;
            height: 200px;
            margin-top: 10px;
        }

        /* Main Content Styles */
        .main-content {
            width: var(--main-width);
            height: 100vh;
            display: flex;
            flex-direction: column;
            margin-bottom: 40px;
        }

        /* Excel-like Toolbar */
        .toolbar {
            background: white;
            padding: 8px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .toolbar-group {
            display: flex;
            gap: 5px;
            padding: 0 10px;
            border-right: 1px solid var(--border-color);
        }

        .toolbar-btn {
            padding: 6px 10px;
            border: none;
            background: none;
            cursor: pointer;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9rem;
        }

        .toolbar-btn:hover {
            background-color: var(--bg-color);
        }

        /* Excel-like Grid */
        .grid-container {
            flex: 1;
            overflow: auto;
            background: white;
            position: relative;
        }

        .grid {
            border-collapse: collapse;
            width: 100%;
        }

        .grid th,
        .grid td {
            border: 1px solid var(--border-color);
            padding: 8px;
            min-width: 100px;
            height: 30px;
            position: relative;
        }

        .grid th {
            background-color: var(--bg-color);
            font-weight: 600;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .grid td {
            background: white;
            position: relative;
            user-select: none;
        }

        .grid td.selected {
            background-color: #e6f3ff;
            border: 2px solid #4a6da7;
        }

        .grid td.dragging {
            background-color: #f0f7ff;
            border: 2px dashed #4a6da7;
        }

        .grid td.highlighted {
            background-color: #e6f3ff;
        }

        .grid td.hidden {
            display: none;
        }

        .grid input {
            width: 100%;
            height: 100%;
            border: none;
            padding: 8px;
            font-size: inherit;
            font-family: inherit;
        }

        .grid input:focus {
            outline: 2px solid var(--primary-color);
        }

        /* Formula Bar */
        .formula-bar {
            background: white;
            padding: 8px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .formula-label {
            font-weight: 600;
            color: var(--secondary-color);
        }

        .formula-input {
            flex: 1;
            padding: 6px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-family: monospace;
        }

        /* Template Styles */
        .templates {
            padding: 15px;
        }

        .template-card {
            background: white;
            border-radius: 4px;
            padding: 12px;
            margin-bottom: 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .template-card:hover {
            transform: translateX(5px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        }

        .template-title {
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--primary-color);
        }

        .template-description {
            font-size: 0.85rem;
            color: var(--secondary-color);
        }

        /* Rich Text Editor Toolbar Styles */
        .rich-text-toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
            padding: 8px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
        
        .toolbar-group {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 4px;
            border-right: 1px solid #dee2e6;
        }
        
        .toolbar-group:last-child {
            border-right: none;
        }
        
        .rich-text-btn {
            position: relative;
            padding: 6px 8px;
            border: none;
            background: none;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 32px;
            height: 32px;
        }
        
        .rich-text-btn:hover {
            background-color: #e9ecef;
        }
        
        .rich-text-btn[data-tooltip]::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            padding: 4px 8px;
            background-color: #333;
            color: white;
            font-size: 12px;
            border-radius: 4px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s, visibility 0.2s;
        }
        
        .rich-text-btn[data-tooltip]:hover::after {
            opacity: 1;
            visibility: visible;
        }
        
        .toolbar-separator {
            width: 1px;
            height: 24px;
            background-color: #dee2e6;
            margin: 0 4px;
        }
        
        .dropdown-btn {
            position: relative;
            display: inline-block;
        }
        
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 200px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            z-index: 1000;
            border-radius: 4px;
        }
        
        .dropdown-content.show {
            display: block;
        }
        
        .dropdown-item {
            padding: 8px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }
        
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        
        .dropdown-item .shortcut {
            color: #6c757d;
            font-size: 0.9em;
        }
        
        .color-picker {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 4px;
            padding: 8px;
        }
        
        .color-option {
            width: 24px;
            height: 24px;
            border-radius: 4px;
            cursor: pointer;
            border: 1px solid #dee2e6;
        }
        
        .color-option:hover {
            transform: scale(1.1);
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
            }

            .main-content {
                width: 100%;
            }
        }

        /* Add new styles for enhanced features */
        .sheet-tabs {
            display: flex;
            gap: 5px;
            padding: 5px;
            background: var(--bg-color);
            border-top: 1px solid var(--border-color);
            overflow-x: auto;
            white-space: nowrap;
        }

        .sheet-tab {
            padding: 5px 10px;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 3px;
            cursor: pointer;
            position: relative;
            min-width: 100px;
            text-align: center;
            user-select: none;
        }

        .sheet-tab.dragging {
            opacity: 0.5;
            background: var(--bg-color);
        }

        .sheet-tab.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .sheet-context-menu {
            position: fixed;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            z-index: 1001;
            display: none;
        }

        .sheet-context-menu.show {
            display: block;
        }

        .context-menu-item {
            padding: 8px 15px;
            cursor: pointer;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .context-menu-item:hover {
            background: var(--bg-color);
        }

        .context-menu-item i {
            width: 16px;
            text-align: center;
        }

        .add-sheet-btn {
            padding: 5px 10px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            margin-left: 5px;
        }

        /* Add styles for Excel-like header menu */
        .excel-header {
            background: white;
            border-bottom: 1px solid var(--border-color);
            padding: 0 10px;
        }

        .menu-bar {
            display: flex;
            align-items: center;
            height: 40px;
            justify-content: space-between;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .close-sheet-btn {
            padding: 8px;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-color);
        }

        .close-sheet-btn:hover {
            color: var(--primary-color);
        }

        .menu-item {
            padding: 8px 12px;
            cursor: pointer;
            position: relative;
        }

        .menu-item:hover {
            background: var(--bg-color);
        }

        .menu-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: none;
            min-width: 250px;
            z-index: 1000;
        }

        .menu-item:hover .menu-dropdown {
            display: block;
        }

        .menu-dropdown-item {
            padding: 8px 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .menu-dropdown-item:hover {
            background: var(--bg-color);
        }

        .menu-dropdown-item i {
            width: 20px;
            text-align: center;
        }

        .menu-separator {
            height: 1px;
            background: var(--border-color);
            margin: 5px 0;
        }

        /* Update sheet tabs styles */
        .sheet-tabs-container {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-top: 1px solid var(--border-color);
            padding: 5px;
            z-index: 1000;
            display: flex;
            align-items: center;
        }

        .sheet-tabs {
            display: flex;
            gap: 5px;
            overflow-x: auto;
            white-space: nowrap;
            flex: 1;
        }

        .sheet-tab {
            min-width: 120px;
            max-width: 200px;
            padding: 5px 10px;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 3px;
            cursor: pointer;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            user-select: none;
        }

        .sheet-tab span {
            flex: 1;
            text-align: center;
        }

        .sheet-tab.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .sheet-menu-icon {
            padding: 2px 5px;
            border-radius: 3px;
        }

        .sheet-menu-icon:hover {
            background: rgba(0,0,0,0.1);
        }

        .add-sheet-btn {
            padding: 5px 10px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            margin-left: 5px;
        }

        /* Add styles for keyboard shortcuts */
        .shortcut-hint {
            position: absolute;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            right: 5px;
            top: 5px;
            display: none;
        }

        .menu-dropdown-item:hover .shortcut-hint {
            display: block;
        }

        /* Add styles for rich text editor state */
        .rich-text-btn.active {
            background: var(--primary-color);
            color: white;
        }

        /* Remove styles for sheet numbering and save button */
        .sheet-number {
            display: none;
        }

        .save-button {
            display: none;
        }

        .rename-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 1002;
            display: none;
        }

        .rename-popup.show {
            display: block;
        }

        /* Add accordion styles */
        .accordion {
            margin-bottom: 10px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            overflow: hidden;
        }

        .accordion-header {
            padding: 12px 15px;
            background: var(--bg-color);
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            border-bottom: 1px solid var(--border-color);
        }

        .accordion-header.active {
            background: var(--primary-color);
            color: white;
        }

        .accordion-header i {
            transition: transform 0.3s ease;
        }

        .accordion-header.active i {
            transform: rotate(180deg);
        }

        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .accordion-content.active {
            max-height: 500px;
            overflow: visible;
        }

        /* Add styles for shortcuts bar */
        .shortcuts-bar {
            background: white;
            border-bottom: 1px solid var(--border-color);
            padding: 5px 10px;
            display: flex;
            gap: 10px;
            align-items: center;
            font-size: 0.85rem;
            color: var(--secondary-color);
        }

        .shortcut-item {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 3px 8px;
            border-radius: 3px;
            cursor: pointer;
        }

        .shortcut-item:hover {
            background: var(--bg-color);
        }

        .shortcut-key {
            background: var(--bg-color);
            padding: 2px 5px;
            border-radius: 3px;
            font-family: monospace;
            font-size: 0.8rem;
        }

        .shortcut-separator {
            width: 1px;
            height: 20px;
            background: var(--border-color);
            margin: 0 5px;
        }

        .cell-context-menu {
            position: fixed;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            z-index: 1000;
            display: none;
            min-width: 200px;
        }

        .cell-context-menu.show {
            display: block;
        }

        .cell-context-menu-item {
            padding: 8px 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cell-context-menu-item:hover {
            background: var(--bg-color);
        }

        .cell-context-menu-item i {
            width: 16px;
            text-align: center;
        }

        .cell-context-menu-separator {
            height: 1px;
            background: var(--border-color);
            margin: 5px 0;
        }

        .cell-comment {
            position: absolute;
            top: 100%;
            left: 0;
            background: #fff3cd;
            border: 1px solid #ffeeba;
            padding: 5px;
            font-size: 0.8rem;
            z-index: 1000;
            display: none;
        }

        .cell-comment.show {
            display: block;
        }

        .cell-note {
            position: absolute;
            top: 0;
            right: 0;
            width: 8px;
            height: 8px;
            background: #ffc107;
            border-radius: 50%;
        }

        .cell-link {
            color: #4a6da7;
            text-decoration: underline;
        }

        .cell-dropdown {
            position: absolute;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            z-index: 1000;
            display: none;
        }

        .cell-dropdown.show {
            display: block;
        }

        .dropdown-option {
            padding: 8px 15px;
            cursor: pointer;
        }

        .dropdown-option:hover {
            background: var(--bg-color);
        }

        .cell-validation {
            position: absolute;
            top: 0;
            right: 0;
            width: 8px;
            height: 8px;
            background: #28a745;
            border-radius: 50%;
        }

        .cell-conditional-format {
            position: absolute;
            top: 0;
            right: 0;
            width: 8px;
            height: 8px;
            background: #17a2b8;
            border-radius: 50%;
        }

        /* Remove shortcuts bar styles */
        .shortcuts-bar {
            display: none;
        }
        
        /* Add new header menu styles */
        .header-menu {
            display: flex;
            align-items: center;
            background-color: #f8f9fa;
            padding: 8px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .menu-item {
            position: relative;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.2s;
        }
        
        .menu-item:hover {
            background-color: #e9ecef;
        }
        
        .menu-item .shortcut {
            font-size: 0.8em;
            color: #6c757d;
            margin-left: 8px;
        }
        
        .menu-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            min-width: 200px;
            z-index: 1000;
            display: none;
        }
        
        .menu-item:hover .menu-dropdown {
            display: block;
        }
        
        .menu-dropdown-item {
            padding: 8px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
        }
        
        .menu-dropdown-item:hover {
            background-color: #f8f9fa;
        }
        
        .menu-dropdown-item .shortcut {
            color: #6c757d;
            font-size: 0.9em;
        }
        
        .menu-separator {
            height: 1px;
            background-color: #dee2e6;
            margin: 4px 0;
        }

        /* Add new styles for color picker and other new elements */
        .color-picker {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 4px;
            padding: 8px;
        }
        
        .color-option {
            width: 24px;
            height: 24px;
            border-radius: 4px;
            cursor: pointer;
            border: 1px solid #dee2e6;
        }
        
        .color-option:hover {
            transform: scale(1.1);
        }
        
        .custom-color {
            grid-column: span 4;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 4px;
        }
        
        .custom-color input[type="color"] {
            width: 24px;
            height: 24px;
            padding: 0;
            border: none;
        }
        
        .custom-color label {
            font-size: 0.9em;
            color: #6c757d;
        }

        /* Add new styles for alignment menu */
        .toolbar-group {
            display: flex;
            gap: 5px;
            padding: 0 10px;
            border-right: 1px solid var(--border-color);
        }

        /* Add new styles for alignment menu items */
        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            cursor: pointer;
        }

        .dropdown-item i {
            width: 16px;
            text-align: center;
        }

        .dropdown-item .shortcut {
            margin-left: auto;
            color: #6c757d;
            font-size: 0.9em;
        }

        .menu-separator {
            height: 1px;
            background-color: #dee2e6;
            margin: 4px 0;
        }

        /* Add Handsontable container styles */
        .handsontable-container {
            width: 100%;
            height: calc(100vh - 200px);
            overflow: hidden;
        }

        /* Update grid container styles */
        .grid-container {
            flex: 1;
            overflow: hidden;
            position: relative;
        }

        /* Ensure proper z-index for context menus */
        .cell-context-menu {
            z-index: 1001;
        }

        /* Toolbar Styles */
        .toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 8px;
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            align-items: center;
        }

        .toolbar-group {
            display: flex;
            gap: 4px;
            align-items: center;
            padding: 0 8px;
            border-right: 1px solid #dee2e6;
        }

        .toolbar-group:last-child {
            border-right: none;
        }

        .toolbar-button {
            padding: 6px 8px;
            border: 1px solid transparent;
            background: none;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 4px;
            color: #495057;
            font-size: 14px;
        }

        .toolbar-button:hover {
            background: #e9ecef;
            border-color: #dee2e6;
        }

        .toolbar-button.active {
            background: #e7f5ff;
            border-color: #74c0fc;
            color: #1971c2;
        }

        .toolbar-dropdown {
            padding: 6px 8px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            background: white;
            cursor: pointer;
            min-width: 120px;
        }

        .toolbar-separator {
            width: 1px;
            height: 24px;
            background: #dee2e6;
            margin: 0 4px;
        }

        .toolbar-color-picker {
            width: 24px;
            height: 24px;
            padding: 0;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            cursor: pointer;
        }

        /* Update Handsontable container styles */
        .handsontable-container {
            width: 100%;
            height: calc(100vh - 120px);
            overflow: hidden;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-title">Table Builder</div>
        </div>
        <div class="tab-buttons">
            <button class="tab-button active" data-tab="form">
                <i class="fas fa-edit"></i>
                Form Builder
            </button>
            <button class="tab-button" data-tab="graphs">
                <i class="fas fa-chart-bar"></i>
                Graphs
            </button>
            <button class="tab-button" data-tab="templates">
                <i class="fas fa-file-alt"></i>
                Templates
            </button>
            <button class="tab-button" data-tab="files">
                <i class="fas fa-folder"></i>
                Files
            </button>
        </div>
        <div class="sidebar-tabs">
            <!-- Form Builder Tab -->
            <div class="tab-content active" id="form">
                <div class="form-builder">
                    <div class="form-file-name">
                        <input type="text" id="fileName" placeholder="Enter File Name" onchange="autoSave()">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Select Template</label>
                        <select class="form-input" id="templateSelect" onchange="loadTemplate(this.value)">
                            <option value="">Select a template</option>
                            <option value="salary">Salary Calculator</option>
                            <option value="sales">Sales Report</option>
                            <option value="inventory">Inventory Tracker</option>
                            <option value="expenses">Expense Tracker</option>
                            <option value="project">Project Tracker</option>
                        </select>
                    </div>
                    <div id="formFields">
                        <!-- Dynamic form fields will be added here -->
                    </div>
                </div>
            </div>
            <!-- Graphs Tab -->
            <div class="tab-content" id="graphs">
                <div class="graph-container">
                    <div class="graph-selector">
                        <label class="form-label">Select Graph Type</label>
                        <div class="graph-type">
                            <button class="graph-type-btn active" data-type="bar">Bar Chart</button>
                            <button class="graph-type-btn" data-type="line">Line Chart</button>
                            <button class="graph-type-btn" data-type="pie">Pie Chart</button>
                        </div>
                    </div>
                    <div class="graph-preview">
                        <canvas id="dataGraph"></canvas>
                    </div>
                </div>
            </div>
            <!-- Templates Tab -->
            <div class="tab-content" id="templates">
                <div class="accordion">
                    <div class="accordion-header" onclick="toggleAccordion(this)">
                        <span>Financial Templates</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="accordion-content">
                        <div class="template-card" onclick="loadTemplateInNewSheet('salary')">
                            <div class="template-title">Salary Calculator</div>
                            <div class="template-description">
                                Basic Salary + Allowances - Deductions - Tax
                            </div>
                        </div>
                        <div class="template-card" onclick="loadTemplateInNewSheet('sales')">
                            <div class="template-title">Sales Report</div>
                            <div class="template-description">
                                Quantity × Price × (1 - Discount%)
                            </div>
                        </div>
                        <div class="template-card" onclick="loadTemplateInNewSheet('expenses')">
                            <div class="template-title">Expense Tracker</div>
                            <div class="template-description">
                                Track and categorize monthly expenses
                            </div>
                        </div>
                        <div class="template-card" onclick="loadTemplateInNewSheet('budget')">
                            <div class="template-title">Budget Planner</div>
                            <div class="template-description">
                                Monthly income and expense planning
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion">
                    <div class="accordion-header" onclick="toggleAccordion(this)">
                        <span>Business Templates</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="accordion-content">
                        <div class="template-card" onclick="loadTemplateInNewSheet('inventory')">
                            <div class="template-title">Inventory Tracker</div>
                            <div class="template-description">
                                Stock Level Monitoring and Reorder Points
                            </div>
                        </div>
                        <div class="template-card" onclick="loadTemplateInNewSheet('project')">
                            <div class="template-title">Project Tracker</div>
                            <div class="template-description">
                                Project tasks, deadlines, and progress
                            </div>
                        </div>
                        <div class="template-card" onclick="loadTemplateInNewSheet('employee')">
                            <div class="template-title">Employee Management</div>
                            <div class="template-description">
                                Employee records and performance tracking
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion">
                    <div class="accordion-header" onclick="toggleAccordion(this)">
                        <span>Education Templates</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="accordion-content">
                        <div class="template-card" onclick="loadTemplateInNewSheet('attendance')">
                            <div class="template-title">Attendance Sheet</div>
                            <div class="template-description">
                                Student attendance and class records
                            </div>
                        </div>
                        <div class="template-card" onclick="loadTemplateInNewSheet('grades')">
                            <div class="template-title">Grade Tracker</div>
                            <div class="template-description">
                                Student grades and performance analysis
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Files Tab -->
            <div class="tab-content" id="files">
                <div class="form-actions">
                    <button class="btn btn-primary" onclick="createNewFolder()">
                        <i class="fas fa-folder-plus"></i>
                        New Folder
                    </button>
                    <button class="btn btn-primary" onclick="uploadFile()">
                        <i class="fas fa-upload"></i>
                        Upload File
                    </button>
                </div>
                <div class="files-container" id="filesList">
                    <!-- Files will be listed here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" style="margin-top: 40px;">
        <!-- Excel-like header menu -->
        <div class="excel-header">
            <div class="menu-bar">
                <div class="header-left">
                    <div class="menu-item">
                        File
                        <div class="menu-dropdown">
                            <div class="menu-dropdown-item" onclick="newFile()">
                                <i class="fas fa-file"></i>
                                New
                                <span class="shortcut-hint">Ctrl+N</span>
                            </div>
                            <div class="menu-dropdown-item" onclick="openFile()">
                                <i class="fas fa-folder-open"></i>
                                Open
                                <span class="shortcut-hint">Ctrl+O</span>
                            </div>
                            <div class="menu-dropdown-item" onclick="importFile()">
                                <i class="fas fa-file-import"></i>
                                Import
                            </div>
                            <div class="menu-dropdown-item" onclick="makeCopy()">
                                <i class="fas fa-copy"></i>
                                Make a Copy
                                <span class="shortcut-hint">Ctrl+Shift+C</span>
                            </div>
                            <div class="menu-separator"></div>
                            <div class="menu-dropdown-item" onclick="downloadAs()">
                                <i class="fas fa-download"></i>
                                Download as
                                <div class="submenu">
                                    <div class="menu-dropdown-item" onclick="downloadAsExcel()">Excel (.xlsx)</div>
                                    <div class="menu-dropdown-item" onclick="downloadAsCSV()">CSV (.csv)</div>
                                    <div class="menu-dropdown-item" onclick="downloadAsPDF()">PDF (.pdf)</div>
                                </div>
                            </div>
                            <div class="menu-dropdown-item" onclick="emailAsAttachment()">
                                <i class="fas fa-paper-plane"></i>
                                Email as Attachment
                            </div>
                            <div class="menu-dropdown-item" onclick="showVersionHistory()">
                                <i class="fas fa-history"></i>
                                Version History
                                <span class="shortcut-hint">Ctrl+Alt+Shift+H</span>
                            </div>
                            <div class="menu-separator"></div>
                            <div class="menu-dropdown-item" onclick="renameFile()">
                                <i class="fas fa-edit"></i>
                                Rename
                            </div>
                            <div class="menu-dropdown-item" onclick="moveFile()">
                                <i class="fas fa-folder"></i>
                                Move
                            </div>
                            <div class="menu-dropdown-item" onclick="addShortcutToDrive()">
                                <i class="fas fa-link"></i>
                                Add Shortcut to Drive
                            </div>
                            <div class="menu-dropdown-item" onclick="moveToTrash()">
                                <i class="fas fa-trash"></i>
                                Move to Trash
                            </div>
                            <div class="menu-separator"></div>
                            <div class="menu-dropdown-item" onclick="publishToWeb()">
                                <i class="fas fa-globe"></i>
                                Publish to Web
                            </div>
                            <div class="menu-dropdown-item" onclick="printTable()">
                                <i class="fas fa-print"></i>
                                Print
                                <span class="shortcut-hint">Ctrl+P</span>
                            </div>
                            <div class="menu-dropdown-item" onclick="shareFile()">
                                <i class="fas fa-share-alt"></i>
                                Share
                                <span class="shortcut-hint">Ctrl+Alt+S</span>
                            </div>
                        </div>
                    </div>
                    <div class="menu-item">
                        Edit
                        <div class="menu-dropdown">
                            <div class="menu-dropdown-item" onclick="undo()">
                                <i class="fas fa-undo"></i>
                                Undo
                                <span class="shortcut-hint">Ctrl+Z</span>
                            </div>
                            <div class="menu-dropdown-item" onclick="redo()">
                                <i class="fas fa-redo"></i>
                                Redo
                                <span class="shortcut-hint">Ctrl+Y</span>
                            </div>
                            <div class="menu-separator"></div>
                            <div class="menu-dropdown-item" onclick="cutContent()">
                                <i class="fas fa-cut"></i>
                                Cut
                                <span class="shortcut-hint">Ctrl+X</span>
                            </div>
                            <div class="menu-dropdown-item" onclick="copyContent()">
                                <i class="fas fa-copy"></i>
                                Copy
                                <span class="shortcut-hint">Ctrl+C</span>
                            </div>
                            <div class="menu-dropdown-item" onclick="pasteContent()">
                                <i class="fas fa-paste"></i>
                                Paste
                                <span class="shortcut-hint">Ctrl+V</span>
                            </div>
                            <div class="menu-dropdown-item" onclick="pasteSpecial()">
                                <i class="fas fa-paste"></i>
                                Paste Special
                                <span class="shortcut-hint">Ctrl+Shift+V</span>
                            </div>
                            <div class="menu-dropdown-item" onclick="deleteContent()">
                                <i class="fas fa-trash"></i>
                                Delete
                                <span class="shortcut-hint">Delete</span>
                            </div>
                            <div class="menu-dropdown-item" onclick="selectAll()">
                                <i class="fas fa-object-group"></i>
                                Select All
                                <span class="shortcut-hint">Ctrl+A</span>
                            </div>
                            <div class="menu-dropdown-item" onclick="findAndReplace()">
                                <i class="fas fa-search"></i>
                                Find and Replace
                                <span class="shortcut-hint">Ctrl+H</span>
                            </div>
                        </div>
                    </div>
                    <div class="menu-item">
                        View
                        <div class="menu-dropdown">
                            <div class="menu-dropdown-item" onclick="toggleGridlines()">
                                <i class="fas fa-th"></i>
                                Gridlines
                            </div>
                            <div class="menu-dropdown-item" onclick="showProtectedRanges()">
                                <i class="fas fa-lock"></i>
                                Protected Ranges
                            </div>
                            <div class="menu-dropdown-item" onclick="toggleFormulaBar()">
                                <i class="fas fa-calculator"></i>
                                Formula Bar
                            </div>
                            <div class="menu-dropdown-item" onclick="showFormulas()">
                                <i class="fas fa-code"></i>
                                Show Formulas
                                <span class="shortcut-hint">Ctrl+`</span>
                            </div>
                            <div class="menu-separator"></div>
                            <div class="menu-dropdown-item" onclick="zoomIn()">
                                <i class="fas fa-search-plus"></i>
                                Zoom In
                                <span class="shortcut-hint">Ctrl++</span>
                            </div>
                            <div class="menu-dropdown-item" onclick="zoomOut()">
                                <i class="fas fa-search-minus"></i>
                                Zoom Out
                                <span class="shortcut-hint">Ctrl+-</span>
                            </div>
                            <div class="menu-dropdown-item" onclick="freezePanes()">
                                <i class="fas fa-snowflake"></i>
                                Freeze
                                <div class="submenu">
                                    <div class="menu-dropdown-item" onclick="freezeRow()">Freeze Row</div>
                                    <div class="menu-dropdown-item" onclick="freezeColumn()">Freeze Column</div>
                                    <div class="menu-dropdown-item" onclick="freezeBoth()">Freeze Both</div>
                                </div>
                            </div>
                            <div class="menu-dropdown-item" onclick="toggleFullScreen()">
                                <i class="fas fa-expand"></i>
                                Full Screen
                                <span class="shortcut-hint">F11</span>
                            </div>
                            <div class="menu-dropdown-item" onclick="toggleCompactControls()">
                                <i class="fas fa-compress"></i>
                                Compact Controls
                            </div>
                            <div class="menu-dropdown-item" onclick="showComments()">
                                <i class="fas fa-comment"></i>
                                Show Comments
                            </div>
                            <div class="menu-dropdown-item" onclick="showNamedRanges()">
                                <i class="fas fa-tag"></i>
                                Show Named Ranges
                            </div>
                            <div class="menu-dropdown-item" onclick="showFormulaHelp()">
                                <i class="fas fa-question-circle"></i>
                                Show Formula Help
                            </div>
                        </div>
                    </div>
                    <div class="menu-item">
                        Insert
                        <div class="menu-dropdown">
                            <div class="menu-dropdown-item" onclick="insertRowAbove()">
                                <i class="fas fa-plus"></i>
                                Row Above
                                <span class="shortcut-hint">Ctrl+Shift++</span>
                            </div>
                            <div class="menu-dropdown-item" onclick="insertRowBelow()">
                                <i class="fas fa-plus"></i>
                                Row Below
                            </div>
                            <div class="menu-dropdown-item" onclick="insertColumnLeft()">
                                <i class="fas fa-plus"></i>
                                Column Left
                            </div>
                            <div class="menu-dropdown-item" onclick="insertColumnRight()">
                                <i class="fas fa-plus"></i>
                                Column Right
                                <span class="shortcut-hint">Ctrl+Shift++</span>
                            </div>
                            <div class="menu-dropdown-item" onclick="insertCells()">
                                <i class="fas fa-plus"></i>
                                Cells
                            </div>
                            <div class="menu-separator"></div>
                            <div class="menu-dropdown-item" onclick="insertChart()">
                                <i class="fas fa-chart-bar"></i>
                                Chart
                            </div>
                            <div class="menu-dropdown-item" onclick="insertPivotTable()">
                                <i class="fas fa-table"></i>
                                Pivot Table
                            </div>
                            <div class="menu-dropdown-item" onclick="insertImage()">
                                <i class="fas fa-image"></i>
                                Image
                            </div>
                            <div class="menu-dropdown-item" onclick="insertDrawing()">
                                <i class="fas fa-pencil-alt"></i>
                                Drawing
                            </div>
                            <div class="menu-dropdown-item" onclick="insertFunction()">
                                <i class="fas fa-function"></i>
                                Function
                            </div>
                            <div class="menu-dropdown-item" onclick="insertLink()">
                                <i class="fas fa-link"></i>
                                Link
                            </div>
                            <div class="menu-dropdown-item" onclick="insertCheckbox()">
                                <i class="fas fa-check-square"></i>
                                Checkbox
                            </div>
                            <div class="menu-dropdown-item" onclick="insertComment()">
                                <i class="fas fa-comment"></i>
                                Comment
                            </div>
                            <div class="menu-dropdown-item" onclick="insertNote()">
                                <i class="fas fa-sticky-note"></i>
                                Note
                            </div>
                            <div class="menu-dropdown-item" onclick="insertDate()">
                                <i class="fas fa-calendar"></i>
                                Date
                            </div>
                            <div class="menu-dropdown-item" onclick="insertTime()">
                                <i class="fas fa-clock"></i>
                                Time
                            </div>
                            <div class="menu-dropdown-item" onclick="insertDropdown()">
                                <i class="fas fa-caret-down"></i>
                                Dropdown
                            </div>
                            <div class="menu-dropdown-item" onclick="insertTableOfContents()">
                                <i class="fas fa-list"></i>
                                Table of Contents
                            </div>
                            <div class="menu-dropdown-item" onclick="insertPageBreak()">
                                <i class="fas fa-file-alt"></i>
                                Page Break
                            </div>
                        </div>
                    </div>
                    <div class="menu-item">
                        Format
                        <div class="menu-dropdown">
                            <div class="menu-dropdown-item" onclick="formatNumber()">
                                <i class="fas fa-hashtag"></i>
                                Number
                            </div>
                            <div class="menu-separator"></div>
                            <div class="menu-dropdown-item" onclick="formatText('bold')">
                                <i class="fas fa-bold"></i>
                                Bold
                                <span class="shortcut-hint">Ctrl+B</span>
                            </div>
                            <div class="menu-dropdown-item" onclick="formatText('italic')">
                                <i class="fas fa-italic"></i>
                                Italic
                                <span class="shortcut-hint">Ctrl+I</span>
                            </div>
                            <div class="menu-dropdown-item" onclick="formatText('underline')">
                                <i class="fas fa-underline"></i>
                                Underline
                                <span class="shortcut-hint">Ctrl+U</span>
                            </div>
                            <div class="menu-dropdown-item" onclick="formatText('strikethrough')">
                                <i class="fas fa-strikethrough"></i>
                                Strikethrough
                            </div>
                            <div class="menu-separator"></div>
                            <div class="menu-dropdown-item" onclick="formatFont()">
                                <i class="fas fa-font"></i>
                                Font
                            </div>
                            <div class="menu-dropdown-item" onclick="formatFontSize()">
                                <i class="fas fa-text-height"></i>
                                Font Size
                            </div>
                            <div class="menu-dropdown-item" onclick="formatTextColor()">
                                <i class="fas fa-palette"></i>
                                Text Color
                            </div>
                            <div class="menu-dropdown-item" onclick="formatFillColor()">
                                <i class="fas fa-fill-drip"></i>
                                Fill Color
                            </div>
                            <div class="menu-dropdown-item" onclick="formatBorders()">
                                <i class="fas fa-border-all"></i>
                                Borders
                            </div>
                            <div class="menu-dropdown-item" onclick="mergeCells()">
                                <i class="fas fa-object-group"></i>
                                Merge Cells
                            </div>
                            <div class="menu-dropdown-item" onclick="wrapText()">
                                <i class="fas fa-text-width"></i>
                                Wrap Text
                            </div>
                            <div class="menu-dropdown-item" onclick="textRotation()">
                                <i class="fas fa-rotate-right"></i>
                                Text Rotation
                            </div>
                            <div class="menu-dropdown-item" onclick="conditionalFormatting()">
                                <i class="fas fa-paint-brush"></i>
                                Conditional Formatting
                            </div>
                            <div class="menu-dropdown-item" onclick="clearFormatting()">
                                <i class="fas fa-eraser"></i>
                                Clear Formatting
                            </div>
                            <div class="menu-dropdown-item" onclick="alternatingColors()">
                                <i class="fas fa-palette"></i>
                                Alternating Colors
                            </div>
                            <div class="menu-dropdown-item" onclick="formatAlignment()">
                                <i class="fas fa-align-left"></i>
                                Alignment
                            </div>
                            <div class="menu-dropdown-item" onclick="textDirection()">
                                <i class="fas fa-text-height"></i>
                                Text Direction
                            </div>
                        </div>
                    </div>
                    <div class="menu-item">
                        Data
                        <div class="menu-dropdown">
                            <div class="menu-dropdown-item" onclick="sortSheetAZ()">
                                <i class="fas fa-sort-alpha-down"></i>
                                Sort Sheet A–Z
                            </div>
                            <div class="menu-dropdown-item" onclick="sortSheetZA()">
                                <i class="fas fa-sort-alpha-down-alt"></i>
                                Sort Sheet Z–A
                            </div>
                            <div class="menu-dropdown-item" onclick="sortRange()">
                                <i class="fas fa-sort"></i>
                                Sort Range
                            </div>
                            <div class="menu-dropdown-item" onclick="createFilter()">
                                <i class="fas fa-filter"></i>
                                Create a Filter
                                <span class="shortcut-hint">Ctrl+Shift+F</span>
                            </div>
                            <div class="menu-dropdown-item" onclick="filterViews()">
                                <i class="fas fa-filter"></i>
                                Filter Views
                            </div>
                            <div class="menu-dropdown-item" onclick="dataValidation()">
                                <i class="fas fa-check-circle"></i>
                                Data Validation
                            </div>
                            <div class="menu-dropdown-item" onclick="removeDuplicates()">
                                <i class="fas fa-backspace"></i>
                                Remove Duplicates
                            </div>
                            <div class="menu-dropdown-item" onclick="splitTextToColumns()">
                                <i class="fas fa-columns"></i>
                                Split Text to Columns
                            </div>
                            <div class="menu-dropdown-item" onclick="trimWhitespace()">
                                <i class="fas fa-cut"></i>
                                Trim Whitespace
                            </div>
                            <div class="menu-dropdown-item" onclick="randomizeRange()">
                                <i class="fas fa-random"></i>
                                Randomize Range
                            </div>
                            <div class="menu-dropdown-item" onclick="namedRanges()">
                                <i class="fas fa-tag"></i>
                                Named Ranges
                            </div>
                            <div class="menu-dropdown-item" onclick="protectedSheetsAndRanges()">
                                <i class="fas fa-lock"></i>
                                Protected Sheets and Ranges
                            </div>
                            <div class="menu-dropdown-item" onclick="pivotTableEditor()">
                                <i class="fas fa-table"></i>
                                Pivot Table Editor
                            </div>
                            <div class="menu-dropdown-item" onclick="slicer()">
                                <i class="fas fa-sliders-h"></i>
                                Slicer
                            </div>
                            <div class="menu-dropdown-item" onclick="columnStats()">
                                <i class="fas fa-chart-bar"></i>
                                Column Stats
                            </div>
                            <div class="menu-dropdown-item" onclick="cleanupSuggestions()">
                                <i class="fas fa-broom"></i>
                                Cleanup Suggestions
                            </div>
                        </div>
                    </div>
                    <div class="menu-item">
                        Tools
                        <div class="menu-dropdown">
                            <div class="menu-dropdown-item" onclick="checkSpelling()">
                                <i class="fas fa-spell-check"></i>
                                Spelling
                                <span class="shortcut-hint">F7</span>
                            </div>
                            <div class="menu-dropdown-item" onclick="toggleAutocomplete()">
                                <i class="fas fa-magic"></i>
                                Autocomplete
                            </div>
                            <div class="menu-dropdown-item" onclick="notificationRules()">
                                <i class="fas fa-bell"></i>
                                Notification Rules
                            </div>
                            <div class="menu-dropdown-item" onclick="enableAutocomplete()">
                                <i class="fas fa-magic"></i>
                                Enable Autocomplete
                            </div>
                            <div class="menu-dropdown-item" onclick="protectSheet()">
                                <i class="fas fa-lock"></i>
                                Protect Sheet
                            </div>
                            <div class="menu-dropdown-item" onclick="createForm()">
                                <i class="fas fa-file-alt"></i>
                                Create a Form
                            </div>
                            <div class="menu-dropdown-item" onclick="scriptEditor()">
                                <i class="fas fa-code"></i>
                                Script Editor (Apps Script)
                            </div>
                            <div class="menu-dropdown-item" onclick="macros()">
                                <i class="fas fa-cogs"></i>
                                Macros
                            </div>
                            <div class="menu-dropdown-item" onclick="activityDashboard()">
                                <i class="fas fa-chart-line"></i>
                                Activity Dashboard
                            </div>
                            <div class="menu-dropdown-item" onclick="goalSeek()">
                                <i class="fas fa-bullseye"></i>
                                Goal Seek
                            </div>
                            <div class="menu-dropdown-item" onclick="solver()">
                                <i class="fas fa-calculator"></i>
                                Solver
                            </div>
                            <div class="menu-dropdown-item" onclick="enableSmartFill()">
                                <i class="fas fa-magic"></i>
                                Enable Smart Fill
                            </div>
                        </div>
                    </div>
                    <div class="menu-item">
                        Extensions
                        <div class="menu-dropdown">
                            <div class="menu-dropdown-item" onclick="addons()">
                                <i class="fas fa-puzzle-piece"></i>
                                Add-ons
                            </div>
                            <div class="menu-dropdown-item" onclick="appScriptEditor()">
                                <i class="fas fa-code"></i>
                                App Script Editor
                            </div>
                            <div class="menu-dropdown-item" onclick="macros()">
                                <i class="fas fa-cogs"></i>
                                Macros
                            </div>
                            <div class="menu-dropdown-item" onclick="appsMarketplace()">
                                <i class="fas fa-store"></i>
                                Apps Marketplace
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header-right">
                    <button class="close-sheet-btn" onclick="closeCurrentSheet()" title="Close Sheet">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- Add shortcuts bar -->
            <div class="shortcuts-bar">
                <div class="shortcut-item">
                    <span class="shortcut-key">Ctrl+N</span>
                    <span>New</span>
                </div>
                <div class="shortcut-item">
                    <span class="shortcut-key">Ctrl+O</span>
                    <span>Open</span>
                </div>
                <div class="shortcut-item">
                    <span class="shortcut-key">Ctrl+S</span>
                    <span>Save</span>
                </div>
                <div class="shortcut-separator"></div>
                <div class="shortcut-item">
                    <span class="shortcut-key">Ctrl+C</span>
                    <span>Copy</span>
                </div>
                <div class="shortcut-item">
                    <span class="shortcut-key">Ctrl+V</span>
                    <span>Paste</span>
                </div>
                <div class="shortcut-item">
                    <span class="shortcut-key">Ctrl+X</span>
                    <span>Cut</span>
                </div>
                <div class="shortcut-separator"></div>
                <div class="shortcut-item">
                    <span class="shortcut-key">Ctrl+B</span>
                    <span>Bold</span>
                </div>
                <div class="shortcut-item">
                    <span class="shortcut-key">Ctrl+I</span>
                    <span>Italic</span>
                </div>
                <div class="shortcut-item">
                    <span class="shortcut-key">Ctrl+U</span>
                    <span>Underline</span>
                </div>
                <div class="shortcut-separator"></div>
                <div class="shortcut-item">
                    <span class="shortcut-key">Ctrl+P</span>
                    <span>Print</span>
                </div>
                <div class="shortcut-item">
                    <span class="shortcut-key">Ctrl+F</span>
                    <span>Find</span>
                </div>
                <div class="shortcut-item">
                    <span class="shortcut-key">Ctrl+H</span>
                    <span>Replace</span>
                </div>
            </div>
        </div>

        <!-- Rich Text Editor Toolbar -->
        <div class="rich-text-toolbar">
            <!-- File Operations -->
            <div class="toolbar-group">
                <button class="rich-text-btn" data-tooltip="Undo (Ctrl+Z)">
                    <i class="fas fa-undo"></i>
                </button>
                <button class="rich-text-btn" data-tooltip="Redo (Ctrl+Y)">
                    <i class="fas fa-redo"></i>
                </button>
                <div class="toolbar-separator"></div>
                <button class="rich-text-btn" data-tooltip="Print (Ctrl+P)">
                    <i class="fas fa-print"></i>
                </button>
                <button class="rich-text-btn" data-tooltip="Paint Format">
                    <i class="fas fa-paint-brush"></i>
                </button>
            </div>

            <!-- View Operations -->
            <div class="toolbar-group">
                <button class="rich-text-btn" data-tooltip="Zoom In">
                    <i class="fas fa-search-plus"></i>
                </button>
                <button class="rich-text-btn" data-tooltip="Zoom Out">
                    <i class="fas fa-search-minus"></i>
                </button>
            </div>

            <!-- Number Format -->
            <div class="toolbar-group">
                <button class="rich-text-btn" data-tooltip="Format as Currency">
                    <i class="fas fa-dollar-sign"></i>
                </button>
                <button class="rich-text-btn" data-tooltip="Format as Percent">
                    <i class="fas fa-percent"></i>
                </button>
                <button class="rich-text-btn" data-tooltip="Decrease Decimal Places">
                    <i class="fas fa-minus-circle"></i>
                </button>
                <button class="rich-text-btn" data-tooltip="Increase Decimal Places">
                    <i class="fas fa-plus-circle"></i>
                </button>
            </div>

            <!-- Insert Operations -->
            <div class="toolbar-group">
                <button class="rich-text-btn" data-tooltip="Insert Link">
                    <i class="fas fa-link"></i>
                </button>
                <button class="rich-text-btn" data-tooltip="Insert Comment">
                    <i class="fas fa-comment"></i>
                </button>
                <button class="rich-text-btn" data-tooltip="Insert Chart">
                    <i class="fas fa-chart-bar"></i>
                </button>
                <button class="rich-text-btn" data-tooltip="Filter">
                    <i class="fas fa-filter"></i>
                </button>
                <button class="rich-text-btn" data-tooltip="Functions (Σ)">
                    <i class="fas fa-sigma"></i>
                </button>
            </div>

            <!-- Text Format -->
            <div class="toolbar-group">
                <div class="dropdown-btn">
                    <button class="rich-text-btn" data-tooltip="Font Family">
                        <i class="fas fa-font"></i>
                    </button>
                    <div class="dropdown-content">
                        <div class="dropdown-item">Arial</div>
                        <div class="dropdown-item">Times New Roman</div>
                        <div class="dropdown-item">Courier New</div>
                        <div class="dropdown-item">Verdana</div>
                    </div>
                </div>
                <div class="dropdown-btn">
                    <button class="rich-text-btn" data-tooltip="Font Size">
                        <i class="fas fa-text-height"></i>
                    </button>
                    <div class="dropdown-content">
                        <div class="dropdown-item">8</div>
                        <div class="dropdown-item">10</div>
                        <div class="dropdown-item">12</div>
                        <div class="dropdown-item">14</div>
                        <div class="dropdown-item">16</div>
                        <div class="dropdown-item">18</div>
                        <div class="dropdown-item">20</div>
                    </div>
                </div>
                <div class="toolbar-separator"></div>
                <button class="rich-text-btn" data-tooltip="Bold (Ctrl+B)">
                    <i class="fas fa-bold"></i>
                </button>
                <button class="rich-text-btn" data-tooltip="Italic (Ctrl+I)">
                    <i class="fas fa-italic"></i>
                </button>
                <button class="rich-text-btn" data-tooltip="Underline (Ctrl+U)">
                    <i class="fas fa-underline"></i>
                </button>
            </div>

            <!-- Colors -->
            <div class="toolbar-group">
                <div class="dropdown-btn">
                    <button class="rich-text-btn" data-tooltip="Text Color">
                        <i class="fas fa-font"></i>
                    </button>
                    <div class="dropdown-content color-picker">
                        <div class="color-option" style="background-color: #000000" data-color="#000000"></div>
                        <div class="color-option" style="background-color: #FF0000" data-color="#FF0000"></div>
                        <div class="color-option" style="background-color: #00FF00" data-color="#00FF00"></div>
                        <div class="color-option" style="background-color: #0000FF" data-color="#0000FF"></div>
                        <div class="color-option" style="background-color: #FFFF00" data-color="#FFFF00"></div>
                        <div class="color-option" style="background-color: #FF00FF" data-color="#FF00FF"></div>
                        <div class="color-option" style="background-color: #00FFFF" data-color="#00FFFF"></div>
                        <div class="color-option" style="background-color: #FFFFFF" data-color="#FFFFFF"></div>
                    </div>
                </div>
                <div class="dropdown-btn">
                    <button class="rich-text-btn" data-tooltip="Fill Color">
                        <i class="fas fa-fill-drip"></i>
                    </button>
                    <div class="dropdown-content color-picker">
                        <div class="color-option" style="background-color: #FFFFFF" data-color="#FFFFFF"></div>
                        <div class="color-option" style="background-color: #FFE4E1" data-color="#FFE4E1"></div>
                        <div class="color-option" style="background-color: #E6E6FA" data-color="#E6E6FA"></div>
                        <div class="color-option" style="background-color: #F0FFF0" data-color="#F0FFF0"></div>
                        <div class="color-option" style="background-color: #FFF0F5" data-color="#FFF0F5"></div>
                        <div class="color-option" style="background-color: #F0F8FF" data-color="#F0F8FF"></div>
                        <div class="color-option" style="background-color: #F5F5F5" data-color="#F5F5F5"></div>
                        <div class="color-option" style="background-color: #FDF5E6" data-color="#FDF5E6"></div>
                    </div>
                </div>
            </div>

            <!-- Cell Operations -->
            <div class="toolbar-group">
                <div class="dropdown-btn">
                    <button class="rich-text-btn" data-tooltip="Borders">
                        <i class="fas fa-border-all"></i>
                    </button>
                    <div class="dropdown-content">
                        <div class="dropdown-item">No Border</div>
                        <div class="dropdown-item">All Borders</div>
                        <div class="dropdown-item">Outside Borders</div>
                        <div class="dropdown-item">Thick Box Border</div>
                        <div class="dropdown-item">Bottom Border</div>
                        <div class="dropdown-item">Top Border</div>
                        <div class="dropdown-item">Left Border</div>
                        <div class="dropdown-item">Right Border</div>
                    </div>
                </div>
                <button class="rich-text-btn" data-tooltip="Merge Cells">
                    <i class="fas fa-object-group"></i>
                </button>
            </div>

            <!-- Alignment -->
            <div class="toolbar-group">
                <div class="dropdown-btn">
                    <button class="rich-text-btn" data-tooltip="Horizontal Align">
                        <i class="fas fa-align-left"></i>
                    </button>
                    <div class="dropdown-content">
                        <div class="dropdown-item">
                            <i class="fas fa-align-left"></i>
                            <span>Left</span>
                            <span class="shortcut">Ctrl+L</span>
                        </div>
                        <div class="dropdown-item">
                            <i class="fas fa-align-center"></i>
                            <span>Center</span>
                            <span class="shortcut">Ctrl+E</span>
                        </div>
                        <div class="dropdown-item">
                            <i class="fas fa-align-right"></i>
                            <span>Right</span>
                            <span class="shortcut">Ctrl+R</span>
                        </div>
                    </div>
                </div>
                <div class="dropdown-btn">
                    <button class="rich-text-btn" data-tooltip="Vertical Align">
                        <i class="fas fa-align-top"></i>
                    </button>
                    <div class="dropdown-content">
                        <div class="dropdown-item">
                            <i class="fas fa-align-top"></i>
                            <span>Top</span>
                            <span class="shortcut">Alt+T</span>
                        </div>
                        <div class="dropdown-item">
                            <i class="fas fa-align-middle"></i>
                            <span>Middle</span>
                            <span class="shortcut">Alt+M</span>
                        </div>
                        <div class="dropdown-item">
                            <i class="fas fa-align-bottom"></i>
                            <span>Bottom</span>
                            <span class="shortcut">Alt+B</span>
                        </div>
                    </div>
                </div>
                <button class="rich-text-btn" data-tooltip="Text Wrap">
                    <i class="fas fa-text-width"></i>
                </button>
                <div class="dropdown-btn">
                    <button class="rich-text-btn" data-tooltip="Text Rotation">
                        <i class="fas fa-rotate-right"></i>
                    </button>
                    <div class="dropdown-content">
                        <div class="dropdown-item">0°</div>
                        <div class="dropdown-item">45°</div>
                        <div class="dropdown-item">90°</div>
                        <div class="dropdown-item">180°</div>
                        <div class="dropdown-item">270°</div>
                    </div>
                </div>
            </div>

            <!-- Insert Controls -->
            <div class="toolbar-group">
                <div class="dropdown-btn">
                    <button class="rich-text-btn" data-tooltip="Insert Dropdown">
                        <i class="fas fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content">
                        <div class="dropdown-item">List</div>
                        <div class="dropdown-item">Checkbox</div>
                        <div class="dropdown-item">Date</div>
                        <div class="dropdown-item">Time</div>
                    </div>
                </div>
                <button class="rich-text-btn" data-tooltip="Insert Checkbox">
                    <i class="fas fa-check-square"></i>
                </button>
            </div>
        </div>

        <style>
            /* Update dropdown item styles for alignment menu */
            .dropdown-item {
                display: flex;
                align-items: center;
                gap: 8px;
                padding: 8px 16px;
                cursor: pointer;
            }
            
            .dropdown-item i {
                width: 16px;
                text-align: center;
            }
            
            .dropdown-item .shortcut {
                margin-left: auto;
                color: #6c757d;
                font-size: 0.9em;
            }
            
            .menu-separator {
                height: 1px;
                background-color: #dee2e6;
                margin: 4px 0;
            }
        </style>

        <script>
            // Add alignment functionality
            document.querySelectorAll('.dropdown-item').forEach(item => {
                item.addEventListener('click', (e) => {
                    const icon = e.currentTarget.querySelector('i');
                    if (icon.classList.contains('fa-align-left')) {
                        selectedCells.forEach(cell => {
                            cell.style.textAlign = 'left';
                        });
                    } else if (icon.classList.contains('fa-align-center')) {
                        selectedCells.forEach(cell => {
                            cell.style.textAlign = 'center';
                        });
                    } else if (icon.classList.contains('fa-align-right')) {
                        selectedCells.forEach(cell => {
                            cell.style.textAlign = 'right';
                        });
                    } else if (icon.classList.contains('fa-align-justify')) {
                        selectedCells.forEach(cell => {
                            cell.style.textAlign = 'justify';
                        });
                    } else if (icon.classList.contains('fa-align-top')) {
                        selectedCells.forEach(cell => {
                            cell.style.verticalAlign = 'top';
                        });
                    } else if (icon.classList.contains('fa-align-middle')) {
                        selectedCells.forEach(cell => {
                            cell.style.verticalAlign = 'middle';
                        });
                    } else if (icon.classList.contains('fa-align-bottom')) {
                        selectedCells.forEach(cell => {
                            cell.style.verticalAlign = 'bottom';
                        });
                    }
                });
            });
        </script>

        <script>
            // Add new functionality for the new buttons
            document.querySelectorAll('.color-option').forEach(option => {
                option.addEventListener('click', (e) => {
                    const color = e.target.dataset.color;
                    if (e.target.closest('.dropdown-btn').querySelector('.fa-font')) {
                        // Text color
                        selectedCells.forEach(cell => {
                            cell.style.color = color;
                        });
                    } else {
                        // Cell color
                        selectedCells.forEach(cell => {
                            cell.style.backgroundColor = color;
                        });
                    }
                });
            });

            // Handle custom color inputs
            document.getElementById('customTextColor').addEventListener('change', (e) => {
                selectedCells.forEach(cell => {
                    cell.style.color = e.target.value;
                });
            });

            document.getElementById('customCellColor').addEventListener('change', (e) => {
                selectedCells.forEach(cell => {
                    cell.style.backgroundColor = e.target.value;
                });
            });

            // Handle heading styles
            document.querySelectorAll('[data-style]').forEach(item => {
                item.addEventListener('click', (e) => {
                    const style = e.target.dataset.style;
                    selectedCells.forEach(cell => {
                        cell.className = style;
                    });
                });
            });

            // Handle decimal controls
            document.querySelector('[data-tooltip="Increase Decimal"]').addEventListener('click', () => {
                selectedCells.forEach(cell => {
                    const value = parseFloat(cell.textContent);
                    if (!isNaN(value)) {
                        cell.textContent = value.toFixed((cell.dataset.decimals || 0) + 1);
                        cell.dataset.decimals = (cell.dataset.decimals || 0) + 1;
                    }
                });
            });

            document.querySelector('[data-tooltip="Decrease Decimal"]').addEventListener('click', () => {
                selectedCells.forEach(cell => {
                    const value = parseFloat(cell.textContent);
                    if (!isNaN(value)) {
                        const decimals = Math.max(0, (cell.dataset.decimals || 0) - 1);
                        cell.textContent = value.toFixed(decimals);
                        cell.dataset.decimals = decimals;
                    }
                });
            });

            // Handle link insertion
            document.querySelector('[data-tooltip="Insert Link"]').addEventListener('click', () => {
                const url = prompt('Enter URL:');
                if (url) {
                    selectedCells.forEach(cell => {
                        const text = cell.textContent;
                        cell.innerHTML = `<a href="${url}" target="_blank">${text}</a>`;
                    });
                }
            });

            document.querySelector('[data-tooltip="Remove Link"]').addEventListener('click', () => {
                selectedCells.forEach(cell => {
                    if (cell.querySelector('a')) {
                        cell.textContent = cell.querySelector('a').textContent;
                    }
                });
            });
        </script>

        <!-- Excel-like Toolbar -->
        <div class="toolbar">
            <div class="toolbar-group">
                <button class="toolbar-btn" onclick="addColumn()" title="Add Column">
                    <i class="fas fa-plus"></i>
                </button>
                <button class="toolbar-btn" onclick="addRow()" title="Add Row">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
            <div class="toolbar-group">
                <button class="toolbar-btn" onclick="deleteColumn()" title="Delete Column">
                    <i class="fas fa-minus"></i>
                </button>
                <button class="toolbar-btn" onclick="deleteRow()" title="Delete Row">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
            <div class="toolbar-group">
                <button class="toolbar-btn" onclick="formatAsCurrency()" title="Currency">
                    <i class="fas fa-dollar-sign"></i>
                </button>
                <button class="toolbar-btn" onclick="formatAsPercentage()" title="Percentage">
                    <i class="fas fa-percent"></i>
                </button>
            </div>
        </div>

        <!-- Formula Bar -->
        <div class="formula-bar">
            <span class="formula-label">Formula:</span>
            <input type="text" class="formula-input" id="formulaInput" placeholder="Enter formula (e.g., =A1+B1)">
        </div>

        <!-- Add Handsontable CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.css">
        
        <!-- Add Handsontable JS -->
        <script src="https://cdn.jsdelivr.net/npm/handsontable/dist/handsontable.full.min.js"></script>

        <style>
            /* Add Handsontable container styles */
            .handsontable-container {
                width: 100%;
                height: calc(100vh - 200px);
                overflow: hidden;
            }

            /* Update grid container styles */
            .grid-container {
                flex: 1;
                overflow: hidden;
                position: relative;
            }

            /* Ensure proper z-index for context menus */
            .cell-context-menu {
                z-index: 1001;
            }
        </style>

        <!-- Replace the existing grid with Handsontable container -->
        <div class="grid-container">
            <div id="hot" class="handsontable-container"></div>
        </div>

        <script>
            // Initialize Handsontable
            const hot = new Handsontable(document.getElementById('hot'), {
                data: [[]],
                colHeaders: true,
                rowHeaders: true,
                height: '100%',
                width: '100%',
                licenseKey: 'non-commercial-and-evaluation', // For development only
                contextMenu: true,
                dropdownMenu: true,
                filters: true,
                manualColumnResize: true,
                manualRowResize: true,
                mergeCells: true,
                comments: true,
                formulas: true,
                stretchH: 'all',
                columns: Array(26).fill({ type: 'text' }),
                colHeaders: Array.from({length: 26}, (_, i) => String.fromCharCode(65 + i)),
                afterChange: function(changes, source) {
                    if (source === 'loadData') {
                        return;
                    }
                    // Handle cell changes
                },
                afterSelection: function(r, c, r2, c2) {
                    // Handle cell selection
                }
            });

            // Update our existing functions to work with Handsontable
            function formatText(command) {
                const selected = hot.getSelected();
                if (selected) {
                    const cellMeta = hot.getCellMeta(selected[0], selected[1]);
                    switch(command) {
                        case 'bold':
                            cellMeta.renderer = function(instance, td, row, col, prop, value, cellProperties) {
                                Handsontable.renderers.TextRenderer.apply(this, arguments);
                                td.style.fontWeight = td.style.fontWeight === 'bold' ? 'normal' : 'bold';
                            };
                            break;
                        case 'italic':
                            cellMeta.renderer = function(instance, td, row, col, prop, value, cellProperties) {
                                Handsontable.renderers.TextRenderer.apply(this, arguments);
                                td.style.fontStyle = td.style.fontStyle === 'italic' ? 'normal' : 'italic';
                            };
                            break;
                        case 'underline':
                            cellMeta.renderer = function(instance, td, row, col, prop, value, cellProperties) {
                                Handsontable.renderers.TextRenderer.apply(this, arguments);
                                td.style.textDecoration = td.style.textDecoration === 'underline' ? 'none' : 'underline';
                            };
                            break;
                    }
                    hot.render();
                }
            }

            function formatFont(font) {
                const selected = hot.getSelected();
                if (selected) {
                    const cellMeta = hot.getCellMeta(selected[0], selected[1]);
                    cellMeta.renderer = function(instance, td, row, col, prop, value, cellProperties) {
                        Handsontable.renderers.TextRenderer.apply(this, arguments);
                        td.style.fontFamily = font;
                    };
                    hot.render();
                }
            }

            function formatFontSize(size) {
                const selected = hot.getSelected();
                if (selected) {
                    const cellMeta = hot.getCellMeta(selected[0], selected[1]);
                    cellMeta.renderer = function(instance, td, row, col, prop, value, cellProperties) {
                        Handsontable.renderers.TextRenderer.apply(this, arguments);
                        td.style.fontSize = size + 'px';
                    };
                    hot.render();
                }
            }

            // Update other formatting functions similarly...

            // Handle keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey || e.metaKey) {
                    switch(e.key.toLowerCase()) {
                        case 'b':
                            e.preventDefault();
                            formatText('bold');
                            break;
                        case 'i':
                            e.preventDefault();
                            formatText('italic');
                            break;
                        case 'u':
                            e.preventDefault();
                            formatText('underline');
                            break;
                        // Add other shortcuts...
                    }
                }
            });

            // Update cell context menu to work with Handsontable
            function showCellContextMenu(e) {
                e.preventDefault();
                const selected = hot.getSelected();
                if (selected) {
                    const menu = document.querySelector('.cell-context-menu');
                    menu.style.display = 'block';
                    menu.style.left = e.clientX + 'px';
                    menu.style.top = e.clientY + 'px';
                }
            }

            // Initialize Handsontable with our data
            function initializeTable() {
                const data = [];
                for (let i = 0; i < 50; i++) {
                    data[i] = [];
                    for (let j = 0; j < 26; j++) {
                        data[i][j] = '';
                    }
                }
                hot.loadData(data);
            }

            // Call initialization
            initializeTable();
        </script>
    </div>

    <!-- Add Sheet Context Menu -->
    <div class="sheet-context-menu" id="sheetContextMenu">
        <div class="context-menu-item" onclick="renameSheet()">
            <i class="fas fa-edit"></i>
            Rename
        </div>
        <div class="context-menu-item" onclick="deleteSheet()">
            <i class="fas fa-trash"></i>
            Delete
        </div>
        <div class="context-menu-item" onclick="moveSheetLeft()">
            <i class="fas fa-arrow-left"></i>
            Move Left
        </div>
        <div class="context-menu-item" onclick="moveSheetRight()">
            <i class="fas fa-arrow-right"></i>
            Move Right
        </div>
    </div>

    <!-- Add Rename Popup -->
    <div class="rename-popup" id="renamePopup">
        <div class="form-group">
            <label class="form-label">Enter new sheet name:</label>
            <input type="text" class="form-input" id="newSheetName">
            <div class="form-actions" style="margin-top: 15px;">
                <button class="btn btn-primary" onclick="confirmRename()">Save</button>
                <button class="btn btn-secondary" onclick="closeRenamePopup()">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Update sheet tabs container -->
    <div class="sheet-tabs-container">
        <div class="sheet-tabs" id="sheetTabs">
            <div class="sheet-tab active" data-sheet="Sheet1">
                <span>Sheet1</span>
                <i class="fas fa-ellipsis-v sheet-menu-icon" onclick="showSheetMenu(event)"></i>
            </div>
            <div class="sheet-tab" data-sheet="Sheet2">
                <span>Sheet2</span>
                <i class="fas fa-ellipsis-v sheet-menu-icon" onclick="showSheetMenu(event)"></i>
            </div>
            <div class="sheet-tab" data-sheet="Sheet3">
                <span>Sheet3</span>
                <i class="fas fa-ellipsis-v sheet-menu-icon" onclick="showSheetMenu(event)"></i>
            </div>
            <button class="add-sheet-btn" onclick="addSheet()">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>

    <!-- Add Cell Context Menu -->
    <div class="cell-context-menu" id="cellContextMenu">
        <div class="cell-context-menu-item" onclick="cutCellContent()">
            <i class="fas fa-cut"></i>
            Cut
            <span class="shortcut-hint">Ctrl+X</span>
        </div>
        <div class="cell-context-menu-item" onclick="copyCellContent()">
            <i class="fas fa-copy"></i>
            Copy
            <span class="shortcut-hint">Ctrl+C</span>
        </div>
        <div class="cell-context-menu-item" onclick="pasteCellContent()">
            <i class="fas fa-paste"></i>
            Paste
            <span class="shortcut-hint">Ctrl+V</span>
        </div>
        <div class="cell-context-menu-separator"></div>
        <div class="cell-context-menu-item" onclick="insertRowAbove()">
            <i class="fas fa-plus"></i>
            Insert Row Above
        </div>
        <div class="cell-context-menu-item" onclick="insertRowBelow()">
            <i class="fas fa-plus"></i>
            Insert Row Below
        </div>
        <div class="cell-context-menu-item" onclick="insertColumnLeft()">
            <i class="fas fa-plus"></i>
            Insert Column Left
        </div>
        <div class="cell-context-menu-item" onclick="insertColumnRight()">
            <i class="fas fa-plus"></i>
            Insert Column Right
        </div>
        <div class="cell-context-menu-separator"></div>
        <div class="cell-context-menu-item" onclick="deleteRow()">
            <i class="fas fa-trash"></i>
            Delete Row
        </div>
        <div class="cell-context-menu-item" onclick="deleteColumn()">
            <i class="fas fa-trash"></i>
            Delete Column
        </div>
        <div class="cell-context-menu-item" onclick="deleteCells()">
            <i class="fas fa-trash"></i>
            Delete Cells
        </div>
        <div class="cell-context-menu-item" onclick="clearCellValues()">
            <i class="fas fa-eraser"></i>
            Clear Values
        </div>
        <div class="cell-context-menu-separator"></div>
        <div class="cell-context-menu-item" onclick="hideRow()">
            <i class="fas fa-eye-slash"></i>
            Hide Row
        </div>
        <div class="cell-context-menu-item" onclick="hideColumn()">
            <i class="fas fa-eye-slash"></i>
            Hide Column
        </div>
        <div class="cell-context-menu-item" onclick="unhideRows()">
            <i class="fas fa-eye"></i>
            Unhide Rows
        </div>
        <div class="cell-context-menu-item" onclick="unhideColumns()">
            <i class="fas fa-eye"></i>
            Unhide Columns
        </div>
        <div class="cell-context-menu-separator"></div>
        <div class="cell-context-menu-item" onclick="insertLink()">
            <i class="fas fa-link"></i>
            Insert Link
        </div>
        <div class="cell-context-menu-item" onclick="addComment()">
            <i class="fas fa-comment"></i>
            Comment
        </div>
        <div class="cell-context-menu-item" onclick="addNote()">
            <i class="fas fa-sticky-note"></i>
            Note
        </div>
        <div class="cell-context-menu-item" onclick="showEditHistory()">
            <i class="fas fa-history"></i>
            Show Edit History
        </div>
        <div class="cell-context-menu-item" onclick="showConditionalFormatting()">
            <i class="fas fa-paint-brush"></i>
            Conditional Formatting
        </div>
        <div class="cell-context-menu-item" onclick="showDataValidation()">
            <i class="fas fa-check-circle"></i>
            Data Validation
        </div>
        <div class="cell-context-menu-item" onclick="protectRange()">
            <i class="fas fa-lock"></i>
            Protect Range
        </div>
        <div class="cell-context-menu-item" onclick="showMoreCellActions()">
            <i class="fas fa-ellipsis-h"></i>
            View More Cell Actions
        </div>
    </div>

    <script>
        // Initialize variables
        let selectedCell = null;
        let grid = document.getElementById('dataGrid');
        let formulaInput = document.getElementById('formulaInput');

        // Cell selection
        document.querySelectorAll('.grid td').forEach(cell => {
            cell.addEventListener('click', () => {
                // Remove selection from previous cell
                if (selectedCell) {
                    selectedCell.classList.remove('selected');
                }
                
                // Select new cell
                cell.classList.add('selected');
                selectedCell = cell;
                
                // Update formula bar
                formulaInput.value = cell.getAttribute('data-formula') || '';
            });
        });

        // Cell editing
        document.querySelectorAll('.grid td').forEach(cell => {
            cell.addEventListener('dblclick', () => {
                if (cell === selectedCell) {
                    const input = document.createElement('input');
                    input.value = cell.textContent;
                    cell.textContent = '';
                    cell.appendChild(input);
                    input.focus();
                    
                    input.addEventListener('blur', () => {
                        cell.textContent = input.value;
                        updateFormulas();
                    });
                    
                    input.addEventListener('keypress', (e) => {
                        if (e.key === 'Enter') {
                            cell.textContent = input.value;
                            updateFormulas();
                        }
                    });
                }
            });
        });

        // Formula handling
        formulaInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && selectedCell) {
                selectedCell.setAttribute('data-formula', formulaInput.value);
                updateFormulas();
            }
        });

        // Update formulas
        function updateFormulas() {
            document.querySelectorAll('.grid td[data-formula]').forEach(cell => {
                const formula = cell.getAttribute('data-formula');
                if (formula.startsWith('=')) {
                    try {
                        // Simple formula evaluation (you can enhance this)
                        const result = eval(formula.substring(1));
                        cell.textContent = result;
                    } catch (e) {
                        cell.textContent = '#ERROR';
                    }
                }
            });
        }

        // Add/Delete Rows and Columns
        function addRow() {
            const tbody = grid.querySelector('tbody');
            const newRow = document.createElement('tr');
            const colCount = grid.querySelector('th').length;
            
            for (let i = 0; i < colCount; i++) {
                const cell = document.createElement('td');
                cell.contentEditable = true;
                newRow.appendChild(cell);
            }
            
            tbody.appendChild(newRow);
        }

        function addColumn() {
            const headerRow = grid.querySelector('thead tr');
            const bodyRows = grid.querySelectorAll('tbody tr');
            
            // Add header
            const th = document.createElement('th');
            th.textContent = String.fromCharCode(65 + headerRow.children.length);
            headerRow.appendChild(th);
            
            // Add cells to all existing rows
            bodyRows.forEach(row => {
                const cell = document.createElement('td');
                cell.contentEditable = true;
                row.appendChild(cell);
            });
        }

        function deleteRow() {
            if (selectedCell) {
                const row = selectedCell.parentElement;
                if (row.parentElement.children.length > 1) {
                    row.remove();
                }
            }
        }

        function deleteColumn() {
            if (selectedCell) {
                const colIndex = Array.from(selectedCell.parentElement.children).indexOf(selectedCell);
                if (colIndex >= 0) {
                    // Remove header
                    grid.querySelector('thead tr').children[colIndex].remove();
                    
                    // Remove cells
                    grid.querySelectorAll('tbody tr').forEach(row => {
                        row.children[colIndex].remove();
                    });
                }
            }
        }

        // Formatting functions
        function formatAsCurrency() {
            if (selectedCell) {
                const value = parseFloat(selectedCell.textContent);
                if (!isNaN(value)) {
                    selectedCell.textContent = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'USD'
                    }).format(value);
                }
            }
        }

        function formatAsPercentage() {
            if (selectedCell) {
                const value = parseFloat(selectedCell.textContent);
                if (!isNaN(value)) {
                    selectedCell.textContent = (value * 100).toFixed(2) + '%';
                }
            }
        }

        // Tab switching
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', () => {
                // Update active tab button
                document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                
                // Update active tab content
                document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
                document.getElementById(button.dataset.tab).classList.add('active');
                
                // Initialize graphs when graphs tab is active
                if (button.dataset.tab === 'graphs') {
                    updateGraph();
                }
            });
        });

        // Graph type switching
        document.querySelectorAll('.graph-type-btn').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('.graph-type-btn').forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                updateGraph(button.dataset.type);
            });
        });

        // Update graph
        function updateGraph(type = 'bar') {
            const ctx = document.getElementById('dataGraph').getContext('2d');
            const data = getTableData();
            
            if (data.labels.length === 0) {
                // Add sample data if no data exists
                data.labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May'];
                data.values = [100, 200, 150, 300, 250];
            }
            
            new Chart(ctx, {
                type: type,
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Sample Data',
                        data: data.values,
                        backgroundColor: type === 'pie' ? 
                            ['#4a6da7', '#6c757d', '#28a745', '#dc3545', '#ffc107'] :
                            '#4a6da7',
                        borderColor: '#4a6da7',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            enabled: true
                        }
                    }
                }
            });
        }

        // Get table data for graph
        function getTableData() {
            const headers = Array.from(grid.querySelectorAll('th')).map(th => th.textContent);
            const rows = Array.from(grid.querySelectorAll('tbody tr'));
            
            return {
                labels: headers,
                values: headers.map((_, colIndex) => {
                    return rows.reduce((sum, row) => {
                        const value = parseFloat(row.children[colIndex].textContent);
                        return sum + (isNaN(value) ? 0 : value);
                    }, 0);
                })
            };
        }

        // Create new table
        function createNewTable() {
            const tableName = document.getElementById('tableName').value;
            const description = document.getElementById('tableDescription').value;
            
            if (!tableName) {
                alert('Please enter a table name');
                return;
            }
            
            // Clear existing table
            const tbody = grid.querySelector('tbody');
            tbody.innerHTML = '';
            
            // Add new row
            addRow();
            
            // Update headers
            const headerRow = grid.querySelector('thead tr');
            headerRow.innerHTML = '';
            ['A', 'B', 'C', 'D', 'E'].forEach(header => {
                const th = document.createElement('th');
                th.textContent = header;
                headerRow.appendChild(th);
            });
        }

        // Clear form
        function clearForm() {
            document.getElementById('tableName').value = '';
            document.getElementById('tableDescription').value = '';
        }

        // Add new functions for form builder
        function addFormField() {
            const formFields = document.getElementById('formFields');
            const fieldId = Date.now();
            
            const field = document.createElement('div');
            field.className = 'form-field';
            field.innerHTML = `
                <div class="form-field-header">
                    <input type="text" class="form-input" placeholder="Field Name" id="fieldName_${fieldId}">
                    <div class="form-field-actions">
                        <select class="form-input" id="fieldType_${fieldId}">
                            <option value="text">Text</option>
                            <option value="number">Number</option>
                            <option value="date">Date</option>
                            <option value="select">Select</option>
                            <option value="checkbox">Checkbox</option>
                        </select>
                        <button onclick="addCondition(${fieldId})">
                            <i class="fas fa-plus-circle"></i>
                        </button>
                        <button onclick="removeField(${fieldId})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div id="conditions_${fieldId}"></div>
            `;
            
            formFields.appendChild(field);
        }

        function addCondition(fieldId) {
            const conditions = document.getElementById(`conditions_${fieldId}`);
            const conditionId = Date.now();
            
            const condition = document.createElement('div');
            condition.className = 'condition-selector';
            condition.innerHTML = `
                <select class="form-input">
                    <option value="required">Required</option>
                    <option value="min">Minimum Value</option>
                    <option value="max">Maximum Value</option>
                    <option value="pattern">Pattern</option>
                </select>
                <input type="text" class="form-input" placeholder="Condition Value">
                <button onclick="removeCondition(${conditionId})">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            conditions.appendChild(condition);
        }

        function removeField(fieldId) {
            document.getElementById(`field_${fieldId}`).remove();
        }

        function removeCondition(conditionId) {
            document.getElementById(`condition_${conditionId}`).remove();
        }

        // Rich Text Editor Functions
        function formatText(command, value = null) {
            document.execCommand(command, false, value);
            
            // Update button active states
            const buttons = document.querySelectorAll('.rich-text-btn');
            buttons.forEach(button => {
                if (button.dataset.tooltip === command) {
                    button.classList.toggle('active');
                }
            });
        }

        // Update addColumn function to maintain row count
        function addColumn() {
            const headerRow = grid.querySelector('thead tr');
            const bodyRows = grid.querySelectorAll('tbody tr');
            
            // Add header
            const th = document.createElement('th');
            th.textContent = String.fromCharCode(65 + headerRow.children.length);
            headerRow.appendChild(th);
            
            // Add cells to all existing rows
            bodyRows.forEach(row => {
                const cell = document.createElement('td');
                cell.contentEditable = true;
                row.appendChild(cell);
            });
        }

        // Add more predefined forms
        function loadTemplate(templateName) {
            if (!templateName) return;
            
            const formFields = document.getElementById('formFields');
            formFields.innerHTML = '';
            
            const template = getTemplateData(templateName);
            template.fields.forEach((field, index) => {
                const fieldDiv = document.createElement('div');
                fieldDiv.className = 'form-field';
                fieldDiv.style.position = 'relative';
                
                const rowNumber = document.createElement('div');
                rowNumber.className = 'form-row-number';
                rowNumber.textContent = index + 1;
                
                const input = document.createElement('input');
                input.type = field.type;
                input.className = 'form-input';
                input.placeholder = field.label;
                
                fieldDiv.appendChild(rowNumber);
                fieldDiv.appendChild(input);
                formFields.appendChild(fieldDiv);
            });
        }

        function getTemplateData(templateName) {
            const templates = {
                salary: {
                    fields: [
                        { type: 'text', label: 'Employee Name' },
                        { type: 'number', label: 'Basic Salary' },
                        { type: 'number', label: 'Allowances' },
                        { type: 'number', label: 'Deductions' },
                        { type: 'number', label: 'Tax' },
                        { type: 'number', label: 'Net Salary' }
                    ]
                },
                sales: {
                    fields: [
                        { type: 'text', label: 'Product Name' },
                        { type: 'number', label: 'Quantity' },
                        { type: 'number', label: 'Unit Price' },
                        { type: 'number', label: 'Discount %' },
                        { type: 'number', label: 'Total' }
                    ]
                },
                inventory: {
                    fields: [
                        { type: 'text', label: 'Item Name' },
                        { type: 'number', label: 'Current Stock' },
                        { type: 'number', label: 'Minimum Level' },
                        { type: 'number', label: 'Reorder Point' },
                        { type: 'select', label: 'Status' }
                    ]
                },
                expenses: {
                    fields: [
                        { type: 'date', label: 'Date' },
                        { type: 'select', label: 'Category' },
                        { type: 'text', label: 'Description' },
                        { type: 'number', label: 'Amount' },
                        { type: 'select', label: 'Payment Method' }
                    ]
                },
                project: {
                    fields: [
                        { type: 'text', label: 'Task Name' },
                        { type: 'text', label: 'Assigned To' },
                        { type: 'date', label: 'Start Date' },
                        { type: 'date', label: 'End Date' },
                        { type: 'select', label: 'Status' }
                    ]
                },
                budget: {
                    fields: [
                        { type: 'text', label: 'Category' },
                        { type: 'number', label: 'Planned Amount' },
                        { type: 'number', label: 'Actual Amount' },
                        { type: 'number', label: 'Difference' },
                        { type: 'select', label: 'Status' }
                    ]
                },
                employee: {
                    fields: [
                        { type: 'text', label: 'Employee ID' },
                        { type: 'text', label: 'Name' },
                        { type: 'select', label: 'Department' },
                        { type: 'text', label: 'Position' },
                        { type: 'date', label: 'Hire Date' }
                    ]
                },
                attendance: {
                    fields: [
                        { type: 'text', label: 'Student Name' },
                        { type: 'date', label: 'Date' },
                        { type: 'select', label: 'Status' },
                        { type: 'text', label: 'Remarks' }
                    ]
                },
                grades: {
                    fields: [
                        { type: 'text', label: 'Student Name' },
                        { type: 'text', label: 'Subject' },
                        { type: 'number', label: 'Score' },
                        { type: 'select', label: 'Grade' },
                        { type: 'text', label: 'Comments' }
                    ]
                }
            };

            return templates[templateName] || {
                fields: [
                    { type: 'text', label: 'Name' },
                    { type: 'number', label: 'Quantity' },
                    { type: 'date', label: 'Date' },
                    { type: 'select', label: 'Status' },
                    { type: 'text', label: 'Description' }
                ]
            };
        }

        // Add new functions for enhanced features
        function showLineSpacingOptions() {
            const options = ['1.0', '1.15', '1.5', '2.0', '2.5', '3.0'];
            const dropdown = document.createElement('div');
            dropdown.className = 'cell-dropdown';
            options.forEach(option => {
                const div = document.createElement('div');
                div.className = 'dropdown-option';
                div.textContent = option;
                div.onclick = () => {
                    formatText('lineHeight', option);
                    dropdown.remove();
                };
                dropdown.appendChild(div);
            });
            document.body.appendChild(dropdown);
            dropdown.style.top = event.target.offsetTop + 'px';
            dropdown.style.left = event.target.offsetLeft + 'px';
            dropdown.classList.add('show');
        }

        function showLetterSpacingOptions() {
            const options = ['normal', '1px', '2px', '3px', '4px', '5px'];
            const dropdown = document.createElement('div');
            dropdown.className = 'cell-dropdown';
            options.forEach(option => {
                const div = document.createElement('div');
                div.className = 'dropdown-option';
                div.textContent = option;
                div.onclick = () => {
                    formatText('letterSpacing', option);
                    dropdown.remove();
                };
                dropdown.appendChild(div);
            });
            document.body.appendChild(dropdown);
            dropdown.style.top = event.target.offsetTop + 'px';
            dropdown.style.left = event.target.offsetLeft + 'px';
            dropdown.classList.add('show');
        }

        function insertLink() {
            const url = prompt('Enter URL:');
            if (url) {
                formatText('createLink', url);
            }
        }

        function removeLink() {
            formatText('unlink');
        }

        function copyContent() {
            if (selectedCell) {
                navigator.clipboard.writeText(selectedCell.textContent);
            }
        }

        function pasteContent() {
            if (selectedCell) {
                navigator.clipboard.readText().then(text => {
                    selectedCell.textContent = text;
                });
            }
        }

        function exportTable() {
            const table = document.getElementById('dataGrid');
            const html = table.outerHTML;
            const blob = new Blob([html], {type: 'application/vnd.ms-excel'});
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'table.xls';
            a.click();
        }

        function printTable() {
            window.print();
        }

        // Sheet Management Functions
        function addSheet() {
            const sheetTabs = document.getElementById('sheetTabs');
            const sheetCount = document.querySelectorAll('.sheet-tab:not(.add-sheet-btn)').length;
            const newSheet = document.createElement('div');
            newSheet.className = 'sheet-tab';
            newSheet.dataset.sheet = `Sheet${sheetCount + 1}`;
            
            const sheetName = document.createElement('span');
            sheetName.textContent = `Sheet${sheetCount + 1}`;
            
            const menuIcon = document.createElement('i');
            menuIcon.className = 'fas fa-ellipsis-v sheet-menu-icon';
            menuIcon.onclick = (e) => showSheetMenu(e);
            
            newSheet.appendChild(sheetName);
            newSheet.appendChild(menuIcon);
            
            sheetTabs.insertBefore(newSheet, document.querySelector('.add-sheet-btn'));
            
            document.querySelectorAll('.sheet-tab').forEach(tab => tab.classList.remove('active'));
            newSheet.classList.add('active');
            
            clearGrid();
            autoSave();
        }

        function clearGrid() {
            const tbody = grid.querySelector('tbody');
            tbody.innerHTML = '';
            addRow(); // Add one empty row
            
            // Reset headers
            const headerRow = grid.querySelector('thead tr');
            headerRow.innerHTML = '';
            ['A', 'B', 'C', 'D', 'E'].forEach(header => {
                const th = document.createElement('th');
                th.textContent = header;
                headerRow.appendChild(th);
            });
        }

        function loadTemplateInNewSheet(templateName) {
            // Add new sheet
            addSheet();
            
            // Load template in the new sheet
            loadTemplate(templateName);
            
            // Save template state
            const currentSheet = document.querySelector('.sheet-tab.active');
            currentSheet.dataset.template = templateName;
        }

        // Add drag and drop functionality
        document.querySelectorAll('.sheet-tab').forEach(tab => {
            tab.setAttribute('draggable', true);
            
            tab.addEventListener('dragstart', (e) => {
                tab.classList.add('dragging');
                e.dataTransfer.setData('text/plain', tab.dataset.sheet);
            });
            
            tab.addEventListener('dragend', () => {
                tab.classList.remove('dragging');
            });
        });

        document.getElementById('sheetTabs').addEventListener('dragover', (e) => {
            e.preventDefault();
            const draggingTab = document.querySelector('.sheet-tab.dragging');
            const otherTabs = [...document.querySelectorAll('.sheet-tab:not(.dragging)')];
            const addButton = document.querySelector('.add-sheet-btn');
            
            const closestTab = otherTabs.reduce((closest, tab) => {
                const box = tab.getBoundingClientRect();
                const offset = e.clientX - box.left - box.width / 2;
                
                if (offset < 0 && offset > closest.offset) {
                    return { offset, element: tab };
                } else {
                    return closest;
                }
            }, { offset: Number.NEGATIVE_INFINITY }).element;
            
            if (closestTab) {
                const tabs = document.getElementById('sheetTabs');
                tabs.insertBefore(draggingTab, closestTab);
            } else {
                const tabs = document.getElementById('sheetTabs');
                tabs.insertBefore(draggingTab, addButton);
            }
        });

        // Update sheet click handler
        document.querySelectorAll('.sheet-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.sheet-tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                autoSave();
            });
        });

        // Update context menu handler
        document.getElementById('sheetTabs').addEventListener('contextmenu', (e) => {
            const tab = e.target.closest('.sheet-tab');
            if (tab) {
                e.preventDefault();
                const menu = document.getElementById('sheetContextMenu');
                menu.style.top = e.clientY + 'px';
                menu.style.left = e.clientX + 'px';
                menu.classList.add('show');
                
                // Store the clicked tab
                menu.dataset.targetTab = tab.dataset.sheet;
            }
        });

        // Update sheet operations to work with the stored target tab
        function renameSheet() {
            const menu = document.getElementById('sheetContextMenu');
            const sheetName = menu.dataset.targetTab;
            const sheet = document.querySelector(`.sheet-tab[data-sheet="${sheetName}"]`);
            
            if (sheet) {
                const popup = document.getElementById('renamePopup');
                document.getElementById('newSheetName').value = sheet.textContent.trim();
                popup.style.display = 'block';
            }
        }

        function deleteSheet() {
            const menu = document.getElementById('sheetContextMenu');
            const sheetName = menu.dataset.targetTab;
            const sheet = document.querySelector(`.sheet-tab[data-sheet="${sheetName}"]`);
            
            if (sheet && document.querySelectorAll('.sheet-tab').length > 1) {
                if (confirm('Are you sure you want to delete this sheet?')) {
                    const nextSheet = sheet.nextElementSibling || sheet.previousElementSibling;
                    sheet.remove();
                    if (nextSheet && !nextSheet.classList.contains('add-sheet-btn')) {
                        nextSheet.classList.add('active');
                    }
                }
            }
        }

        function moveSheetLeft() {
            const menu = document.getElementById('sheetContextMenu');
            const sheetName = menu.dataset.targetTab;
            const sheet = document.querySelector(`.sheet-tab[data-sheet="${sheetName}"]`);
            
            if (sheet) {
                const prevSheet = sheet.previousElementSibling;
                if (prevSheet && !prevSheet.classList.contains('add-sheet-btn')) {
                    sheet.parentNode.insertBefore(sheet, prevSheet);
                }
            }
        }

        function moveSheetRight() {
            const menu = document.getElementById('sheetContextMenu');
            const sheetName = menu.dataset.targetTab;
            const sheet = document.querySelector(`.sheet-tab[data-sheet="${sheetName}"]`);
            
            if (sheet) {
                const nextSheet = sheet.nextElementSibling;
                if (nextSheet && !nextSheet.classList.contains('add-sheet-btn')) {
                    sheet.parentNode.insertBefore(nextSheet, sheet);
                }
            }
        }

        // Close context menu when clicking outside
        document.addEventListener('click', () => {
            document.getElementById('sheetContextMenu').classList.remove('show');
        });

        // Add new functions for enhanced features
        function toggleAccordion(header) {
            const content = header.nextElementSibling;
            const isActive = header.classList.contains('active');
            
            // Close all other accordions
            document.querySelectorAll('.accordion-header').forEach(h => {
                if (h !== header) {
                    h.classList.remove('active');
                    h.nextElementSibling.classList.remove('active');
                }
            });
            
            // Toggle clicked accordion
            if (!isActive) {
                header.classList.add('active');
                content.classList.add('active');
            } else {
                header.classList.remove('active');
                content.classList.remove('active');
            }
        }

        // Initialize accordions
        document.addEventListener('DOMContentLoaded', () => {
            // Open first accordion by default
            const firstAccordion = document.querySelector('.accordion-header');
            if (firstAccordion) {
                firstAccordion.classList.add('active');
                firstAccordion.nextElementSibling.classList.add('active');
            }
        });

        // Add new functions for enhanced features
        function saveCurrentTab() {
            const activeTab = document.querySelector('.tab-button.active').dataset.tab;
            const data = {
                form: getFormData(),
                graphs: getGraphData(),
                templates: getTemplateData(),
                files: getFileData()
            };
            
            localStorage.setItem(`tableBuilder_${activeTab}`, JSON.stringify(data));
            showNotification('Data saved successfully!');
        }

        function showNotification(message) {
            const notification = document.createElement('div');
            notification.className = 'notification';
            notification.textContent = message;
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 3000);
        }

        function confirmRename() {
            const newName = document.getElementById('newSheetName').value;
            const menu = document.getElementById('sheetContextMenu');
            const sheetName = menu.dataset.targetTab;
            const sheet = document.querySelector(`.sheet-tab[data-sheet="${sheetName}"]`);
            
            if (sheet && newName) {
                sheet.textContent = newName;
                sheet.dataset.sheet = newName;
                closeRenamePopup();
            }
        }

        function closeRenamePopup() {
            document.getElementById('renamePopup').style.display = 'none';
        }

        // Add auto-save functionality
        function autoSave() {
            const activeTab = document.querySelector('.tab-button.active').dataset.tab;
            const data = {
                form: getFormData(),
                graphs: getGraphData(),
                templates: getTemplateData(),
                files: getFileData()
            };
            
            localStorage.setItem(`tableBuilder_${activeTab}`, JSON.stringify(data));
        }

        // Update getFormData function
        function getFormData() {
            return {
                fileName: document.getElementById('fileName').value,
                template: document.getElementById('templateSelect').value,
                fields: Array.from(document.querySelectorAll('.form-field')).map(field => ({
                    name: field.querySelector('input').value,
                    type: field.querySelector('select').value
                }))
            };
        }

        // Add event listeners for auto-save
        document.getElementById('fileName').addEventListener('input', autoSave);
        document.getElementById('templateSelect').addEventListener('change', autoSave);

        // Add new functions for header menu
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.style.display = sidebar.style.display === 'none' ? 'block' : 'none';
        }

        function zoomIn() {
            const mainContent = document.querySelector('.main-content');
            const currentZoom = parseFloat(getComputedStyle(mainContent).zoom) || 1;
            mainContent.style.zoom = currentZoom + 0.1;
        }

        function zoomOut() {
            const mainContent = document.querySelector('.main-content');
            const currentZoom = parseFloat(getComputedStyle(mainContent).zoom) || 1;
            mainContent.style.zoom = Math.max(0.5, currentZoom - 0.1);
        }

        function showGraphs() {
            document.querySelector('.tab-button[data-tab="graphs"]').click();
        }

        function showTemplates() {
            document.querySelector('.tab-button[data-tab="templates"]').click();
        }

        function showFiles() {
            document.querySelector('.tab-button[data-tab="files"]').click();
        }

        function closeApp() {
            if (confirm('Are you sure you want to close the application?')) {
                window.close();
            }
        }

        // Add keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            // Check if Ctrl key is pressed
            if (e.ctrlKey) {
                switch(e.key.toLowerCase()) {
                    case 's':
                        e.preventDefault();
                        saveCurrentTab();
                        break;
                    case 'e':
                        e.preventDefault();
                        exportTable();
                        break;
                    case 'p':
                        e.preventDefault();
                        printTable();
                        break;
                    case 'c':
                        e.preventDefault();
                        copyContent();
                        break;
                    case 'v':
                        e.preventDefault();
                        pasteContent();
                        break;
                    case 'x':
                        e.preventDefault();
                        cutContent();
                        break;
                    case 'b':
                        e.preventDefault();
                        toggleSidebar();
                        break;
                    case 'g':
                        e.preventDefault();
                        showGraphs();
                        break;
                    case 't':
                        e.preventDefault();
                        showTemplates();
                        break;
                    case 'f':
                        e.preventDefault();
                        showFiles();
                        break;
                    case '+':
                        e.preventDefault();
                        zoomIn();
                        break;
                    case '-':
                        e.preventDefault();
                        zoomOut();
                        break;
                }
            }

            // Formatting shortcuts
            if (e.ctrlKey && selectedCell) {
                switch(e.key.toLowerCase()) {
                    case 'b':
                        e.preventDefault();
                        formatText('bold');
                        break;
                    case 'i':
                        e.preventDefault();
                        formatText('italic');
                        break;
                    case 'u':
                        e.preventDefault();
                        formatText('underline');
                        break;
                    case 'l':
                        e.preventDefault();
                        formatText('justifyLeft');
                        break;
                    case 'e':
                        e.preventDefault();
                        formatText('justifyCenter');
                        break;
                    case 'r':
                        e.preventDefault();
                        formatText('justifyRight');
                        break;
                }
            }

            // Delete key
            if (e.key === 'Delete' && selectedCell) {
                e.preventDefault();
                clearGrid();
            }
        });

        // Add new function for cut content
        function cutContent() {
            if (selectedCell) {
                copyContent();
                selectedCell.textContent = '';
            }
        }

        // Add new function for closing current sheet
        function closeCurrentSheet() {
            const activeSheet = document.querySelector('.sheet-tab.active');
            if (activeSheet && document.querySelectorAll('.sheet-tab').length > 1) {
                if (confirm('Are you sure you want to close this sheet?')) {
                    const nextSheet = activeSheet.nextElementSibling || activeSheet.previousElementSibling;
                    activeSheet.remove();
                    if (nextSheet && !nextSheet.classList.contains('add-sheet-btn')) {
                        nextSheet.classList.add('active');
                    }
                }
            }
        }

        // Update sheet management functions
        function showSheetMenu(event) {
            event.stopPropagation();
            const menu = document.getElementById('sheetContextMenu');
            menu.style.top = event.target.offsetTop + 'px';
            menu.style.left = event.target.offsetLeft + 'px';
            menu.classList.add('show');
            
            // Store the clicked tab
            const tab = event.target.closest('.sheet-tab');
            menu.dataset.targetTab = tab.dataset.sheet;
        }

        function closeSheetMenu() {
            document.getElementById('sheetContextMenu').classList.remove('show');
        }

        // Add new functions for all menu items
        function newFile() {
            clearGrid();
            showNotification('New file created');
        }

        function openFile() {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = '.xlsx,.csv,.ods';
            input.onchange = (e) => {
                const file = e.target.files[0];
                if (file) {
                    showNotification('File opened: ' + file.name);
                }
            };
            input.click();
        }

        function importFile() {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = '.xlsx,.csv,.ods';
            input.onchange = (e) => {
                const file = e.target.files[0];
                if (file) {
                    showNotification('File imported: ' + file.name);
                }
            };
            input.click();
        }

        function makeCopy() {
            const activeSheet = document.querySelector('.sheet-tab.active');
            if (activeSheet) {
                const newSheet = activeSheet.cloneNode(true);
                newSheet.textContent = activeSheet.textContent + ' (Copy)';
                document.getElementById('sheetTabs').insertBefore(newSheet, document.querySelector('.add-sheet-btn'));
                showNotification('Sheet copied');
            }
        }

        function downloadAsExcel() {
            exportTable();
        }

        function downloadAsCSV() {
            const table = document.getElementById('dataGrid');
            const rows = table.querySelectorAll('tr');
            let csv = '';
            rows.forEach(row => {
                const cells = row.querySelectorAll('th, td');
                const rowData = Array.from(cells).map(cell => cell.textContent);
                csv += rowData.join(',') + '\n';
            });
            const blob = new Blob([csv], {type: 'text/csv'});
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'table.csv';
            a.click();
        }

        function downloadAsPDF() {
            window.print();
        }

        function emailAsAttachment() {
            showNotification('Email attachment feature coming soon');
        }

        function showVersionHistory() {
            showNotification('Version history feature coming soon');
        }

        function renameFile() {
            const input = document.createElement('input');
            input.type = 'text';
            input.value = document.querySelector('.sheet-tab.active').textContent;
            input.onblur = () => {
                if (input.value) {
                    document.querySelector('.sheet-tab.active').textContent = input.value;
                }
            };
            document.querySelector('.sheet-tab.active').textContent = '';
            document.querySelector('.sheet-tab.active').appendChild(input);
            input.focus();
        }

        function moveFile() {
            showNotification('Move file feature coming soon');
        }

        function addShortcutToDrive() {
            showNotification('Add shortcut to drive feature coming soon');
        }

        function moveToTrash() {
            const activeSheet = document.querySelector('.sheet-tab.active');
            if (activeSheet && document.querySelectorAll('.sheet-tab').length > 1) {
                if (confirm('Are you sure you want to move this sheet to trash?')) {
                    activeSheet.remove();
                    showNotification('Sheet moved to trash');
                }
            }
        }

        function publishToWeb() {
            showNotification('Publish to web feature coming soon');
        }

        function shareFile() {
            showNotification('Share file feature coming soon');
        }

        function undo() {
            showNotification('Undo feature coming soon');
        }

        function redo() {
            showNotification('Redo feature coming soon');
        }

        function pasteSpecial() {
            showNotification('Paste special feature coming soon');
        }

        function deleteContent() {
            if (selectedCell) {
                selectedCell.textContent = '';
            }
        }

        function selectAll() {
            const cells = document.querySelectorAll('.grid td');
            cells.forEach(cell => cell.classList.add('selected'));
        }

        function findAndReplace() {
            showNotification('Find and replace feature coming soon');
        }

        function toggleGridlines() {
            const grid = document.getElementById('dataGrid');
            grid.classList.toggle('no-gridlines');
        }

        function showProtectedRanges() {
            showNotification('Protected ranges feature coming soon');
        }

        function toggleFormulaBar() {
            const formulaBar = document.querySelector('.formula-bar');
            formulaBar.style.display = formulaBar.style.display === 'none' ? 'flex' : 'none';
        }

        function showFormulas() {
            const cells = document.querySelectorAll('.grid td[data-formula]');
            cells.forEach(cell => {
                cell.textContent = cell.getAttribute('data-formula');
            });
        }

        function toggleFullScreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                document.exitFullscreen();
            }
        }

        function toggleCompactControls() {
            document.body.classList.toggle('compact-controls');
        }

        function showComments() {
            showNotification('Comments feature coming soon');
        }

        function showNamedRanges() {
            showNotification('Named ranges feature coming soon');
        }

        function showFormulaHelp() {
            showNotification('Formula help feature coming soon');
        }

        function insertRowAbove() {
            const row = selectedCell.parentElement;
            const newRow = row.cloneNode(true);
            row.parentElement.insertBefore(newRow, row);
        }

        function insertRowBelow() {
            const row = selectedCell.parentElement;
            const newRow = row.cloneNode(true);
            row.parentElement.insertAfter(newRow, row);
        }

        function insertColumnLeft() {
            const colIndex = Array.from(selectedCell.parentElement.children).indexOf(selectedCell);
            const rows = document.querySelectorAll('.grid tr');
            rows.forEach(row => {
                const cell = document.createElement(colIndex === 0 ? 'th' : 'td');
                cell.contentEditable = true;
                row.insertBefore(cell, row.children[colIndex]);
            });
        }

        function insertColumnRight() {
            const colIndex = Array.from(selectedCell.parentElement.children).indexOf(selectedCell);
            const rows = document.querySelectorAll('.grid tr');
            rows.forEach(row => {
                const cell = document.createElement(colIndex === 0 ? 'th' : 'td');
                cell.contentEditable = true;
                row.insertBefore(cell, row.children[colIndex + 1]);
            });
        }

        function insertCells() {
            showNotification('Insert cells feature coming soon');
        }

        function insertChart() {
            showNotification('Insert chart feature coming soon');
        }

        function insertPivotTable() {
            showNotification('Insert pivot table feature coming soon');
        }

        function insertImage() {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.onchange = (e) => {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        selectedCell.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            };
            input.click();
        }

        function insertDrawing() {
            showNotification('Insert drawing feature coming soon');
        }

        function insertFunction() {
            showNotification('Insert function feature coming soon');
        }

        function insertCheckbox() {
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            selectedCell.appendChild(checkbox);
        }

        function insertComment() {
            showNotification('Insert comment feature coming soon');
        }

        function insertNote() {
            showNotification('Insert note feature coming soon');
        }

        function insertDate() {
            selectedCell.textContent = new Date().toLocaleDateString();
        }

        function insertTime() {
            selectedCell.textContent = new Date().toLocaleTimeString();
        }

        function insertDropdown() {
            showNotification('Insert dropdown feature coming soon');
        }

        function insertTableOfContents() {
            showNotification('Insert table of contents feature coming soon');
        }

        function insertPageBreak() {
            showNotification('Insert page break feature coming soon');
        }

        function formatNumber() {
            showNotification('Format number feature coming soon');
        }

        function formatFont() {
            showNotification('Format font feature coming soon');
        }

        function formatFontSize() {
            showNotification('Format font size feature coming soon');
        }

        function formatTextColor() {
            showNotification('Format text color feature coming soon');
        }

        function formatFillColor() {
            showNotification('Format fill color feature coming soon');
        }

        function formatBorders() {
            showNotification('Format borders feature coming soon');
        }

        function mergeCells() {
            showNotification('Merge cells feature coming soon');
        }

        function wrapText() {
            showNotification('Wrap text feature coming soon');
        }

        function textRotation() {
            showNotification('Text rotation feature coming soon');
        }

        function conditionalFormatting() {
            showNotification('Conditional formatting feature coming soon');
        }

        function clearFormatting() {
            if (selectedCell) {
                selectedCell.style = '';
            }
        }

        function alternatingColors() {
            showNotification('Alternating colors feature coming soon');
        }

        function formatAlignment() {
            showNotification('Format alignment feature coming soon');
        }

        function textDirection() {
            showNotification('Text direction feature coming soon');
        }

        function sortSheetAZ() {
            showNotification('Sort sheet A-Z feature coming soon');
        }

        function sortSheetZA() {
            showNotification('Sort sheet Z-A feature coming soon');
        }

        function sortRange() {
            showNotification('Sort range feature coming soon');
        }

        function createFilter() {
            showNotification('Create filter feature coming soon');
        }

        function filterViews() {
            showNotification('Filter views feature coming soon');
        }

        function dataValidation() {
            showNotification('Data validation feature coming soon');
        }

        function removeDuplicates() {
            showNotification('Remove duplicates feature coming soon');
        }

        function splitTextToColumns() {
            showNotification('Split text to columns feature coming soon');
        }

        function trimWhitespace() {
            if (selectedCell) {
                selectedCell.textContent = selectedCell.textContent.trim();
            }
        }

        function randomizeRange() {
            showNotification('Randomize range feature coming soon');
        }

        function namedRanges() {
            showNotification('Named ranges feature coming soon');
        }

        function protectedSheetsAndRanges() {
            showNotification('Protected sheets and ranges feature coming soon');
        }

        function pivotTableEditor() {
            showNotification('Pivot table editor feature coming soon');
        }

        function slicer() {
            showNotification('Slicer feature coming soon');
        }

        function columnStats() {
            showNotification('Column stats feature coming soon');
        }

        function cleanupSuggestions() {
            showNotification('Cleanup suggestions feature coming soon');
        }

        function checkSpelling() {
            showNotification('Spelling check feature coming soon');
        }

        function toggleAutocomplete() {
            showNotification('Toggle autocomplete feature coming soon');
        }

        function notificationRules() {
            showNotification('Notification rules feature coming soon');
        }

        function enableAutocomplete() {
            showNotification('Enable autocomplete feature coming soon');
        }

        function protectSheet() {
            showNotification('Protect sheet feature coming soon');
        }

        function createForm() {
            showNotification('Create form feature coming soon');
        }

        function scriptEditor() {
            showNotification('Script editor feature coming soon');
        }

        function macros() {
            showNotification('Macros feature coming soon');
        }

        function activityDashboard() {
            showNotification('Activity dashboard feature coming soon');
        }

        function goalSeek() {
            showNotification('Goal seek feature coming soon');
        }

        function solver() {
            showNotification('Solver feature coming soon');
        }

        function enableSmartFill() {
            showNotification('Enable smart fill feature coming soon');
        }

        function addons() {
            showNotification('Add-ons feature coming soon');
        }

        function appScriptEditor() {
            showNotification('App script editor feature coming soon');
        }

        function appsMarketplace() {
            showNotification('Apps marketplace feature coming soon');
        }

        // Add new variables for cell operations
        let selectedCells = [];
        let isDragging = false;
        let dragStartCell = null;
        let dragEndCell = null;

        // Initialize cell event listeners
        function initializeCellEvents() {
            const cells = document.querySelectorAll('.grid td');
            
            cells.forEach(cell => {
                // Click to select
                cell.addEventListener('click', (e) => {
                    if (!e.ctrlKey && !e.shiftKey) {
                        clearSelection();
                    }
                    selectCell(cell, e.shiftKey);
                });

                // Double click to edit
                cell.addEventListener('dblclick', () => {
                    startEditing(cell);
                });

                // Right click for context menu
                cell.addEventListener('contextmenu', (e) => {
                    e.preventDefault();
                    showCellContextMenu(e, cell);
                });

                // Drag start
                cell.addEventListener('mousedown', (e) => {
                    if (e.button === 0) { // Left click
                        isDragging = true;
                        dragStartCell = cell;
                        cell.classList.add('dragging');
                    }
                });

                // Drag over
                cell.addEventListener('mouseover', () => {
                    if (isDragging && dragStartCell) {
                        highlightCells(dragStartCell, cell);
                    }
                });
            });

            // Drag end
            document.addEventListener('mouseup', () => {
                if (isDragging) {
                    isDragging = false;
                    document.querySelectorAll('.grid td.dragging').forEach(cell => {
                        cell.classList.remove('dragging');
                    });
                    document.querySelectorAll('.grid td.highlighted').forEach(cell => {
                        cell.classList.remove('highlighted');
                    });
                }
            });
        }

        // Cell selection functions
        function clearSelection() {
            document.querySelectorAll('.grid td.selected').forEach(cell => {
                cell.classList.remove('selected');
            });
            selectedCells = [];
        }

        function selectCell(cell, isShiftSelect) {
            if (isShiftSelect && selectedCells.length > 0) {
                const startCell = selectedCells[0];
                const endCell = cell;
                selectRange(startCell, endCell);
            } else {
                cell.classList.add('selected');
                selectedCells = [cell];
            }
        }

        function selectRange(startCell, endCell) {
            const startRow = startCell.parentElement.rowIndex;
            const startCol = startCell.cellIndex;
            const endRow = endCell.parentElement.rowIndex;
            const endCol = endCell.cellIndex;

            const minRow = Math.min(startRow, endRow);
            const maxRow = Math.max(startRow, endRow);
            const minCol = Math.min(startCol, endCol);
            const maxCol = Math.max(startCol, endCol);

            clearSelection();

            for (let row = minRow; row <= maxRow; row++) {
                for (let col = minCol; col <= maxCol; col++) {
                    const cell = document.querySelector(`.grid tr:nth-child(${row + 1}) td:nth-child(${col + 1})`);
                    if (cell) {
                        cell.classList.add('selected');
                        selectedCells.push(cell);
                    }
                }
            }
        }

        // Cell editing functions
        function startEditing(cell) {
            const input = document.createElement('input');
            input.value = cell.textContent;
            cell.textContent = '';
            cell.appendChild(input);
            input.focus();

            input.addEventListener('blur', () => {
                finishEditing(cell, input);
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    finishEditing(cell, input);
                } else if (e.key === 'Escape') {
                    cell.textContent = input.value;
                    input.remove();
                }
            });
        }

        function finishEditing(cell, input) {
            cell.textContent = input.value;
            input.remove();
            updateFormulas();
        }

        // Context menu functions
        function showCellContextMenu(e, cell) {
            const menu = document.getElementById('cellContextMenu');
            menu.style.top = e.clientY + 'px';
            menu.style.left = e.clientX + 'px';
            menu.classList.add('show');
            menu.dataset.targetCell = cell.id;
        }

        // Close context menu when clicking outside
        document.addEventListener('click', () => {
            document.getElementById('cellContextMenu').classList.remove('show');
        });

        // Cell operations
        function cutCellContent() {
            copyCellContent();
            clearCellValues();
        }

        function copyCellContent() {
            if (selectedCells.length > 0) {
                const text = selectedCells.map(cell => cell.textContent).join('\t');
                navigator.clipboard.writeText(text);
            }
        }

        function pasteCellContent() {
            navigator.clipboard.readText().then(text => {
                const values = text.split('\t');
                if (selectedCells.length > 0) {
                    const startCell = selectedCells[0];
                    const startRow = startCell.parentElement.rowIndex;
                    const startCol = startCell.cellIndex;
                    
                    values.forEach((value, index) => {
                        const row = Math.floor(index / values.length) + startRow;
                        const col = (index % values.length) + startCol;
                        const cell = document.querySelector(`.grid tr:nth-child(${row + 1}) td:nth-child(${col + 1})`);
                        if (cell) {
                            cell.textContent = value;
                        }
                    });
                }
            });
        }

        function clearCellValues() {
            selectedCells.forEach(cell => {
                cell.textContent = '';
            });
        }

        function deleteCells() {
            selectedCells.forEach(cell => {
                cell.textContent = '';
            });
        }

        // Initialize cell events when the page loads
        document.addEventListener('DOMContentLoaded', () => {
            initializeCellEvents();
        });
    </script>
</body>
</html> 