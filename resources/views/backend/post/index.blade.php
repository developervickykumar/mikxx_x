@extends('layouts.master')

@section('title') Posts @endsection

@section('css')
<!-- DataTables CSS -->
<link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ URL::asset('build/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
    type="text/css" />
<link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
    rel="stylesheet" type="text/css" />
    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">


<style>

.page-content{
    
   background:  #e9e9ef; 
}

.card {
    border: 1px dotted rgb(248, 240, 240);
    border-radius: 10px;
}

.font-size-card {
    font-size: 11px;
}

.nav-pills .nav-link {
    width: 6rem;
    text-align: start;
    padding: 5px;
}

/*.nav-link.active {*/
/*    background-color: #ffffff !important;*/
/*    color: rgb(0, 0, 0) !important;*/
/*}*/

.nav-link.active .icon-outer {
    background: #5156be;
    color: white;
}

.card-content {
    display: none;
}

.card-content.active {
    display: block;
}

.font-size-card {
    font-size: 11px;
}
</style>
@endsection

@section('content')

<style>
.nav-link {
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.nav-link.active {
    background-color: #e8f0ff;
    font-weight: 600;
}

.nav-pills .nav-link {
    border-radius: 0;
    color: rgb(63, 64, 68) !important;
}

.nav-pills .nav-link.active,
.nav-pills .show>.nav-link {
    background-color: #fff !important;
    font-weight: 600;
    color: #5156be !important;
    border: none;
}

.nav-link i {
    font-size: 20px !important;
    line-height: 1 !important;
    height: 28px;
}

.nav-link div {
    font-size: 12px;
    line-height: 1.2;
    max-height: 40px;
}

.nav-item.custom-nav-bg .nav-link .active {
    background: #5156be !important;
}

.nav-tabs-custom .nav-item .nav-link 
 {
    background: #e9e9ef;
    margin: 2px;
}

.nav-tabs-custom .nav-item .nav-link.active 
 {
    background: #5156be;
    color:#fff;
}
.nav-tabs-custom .nav-item .nav-link.active:after {
     transform: scale(0); 
}
</style>


<style>
/*:root {*/
/*    --primary-color: #3b82f6;*/
/*    --primary-hover: #2563eb;*/
/*    --text-primary: #1f2937;*/
/*    --text-secondary: #6b7280;*/
/*    --bg-primary: #ffffff;*/
/*    --bg-secondary: #f9fafb;*/
/*    --bg-blue-50: #eff6ff;*/
/*    --border-color: #e5e7eb;*/
/*    --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);*/
/*    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);*/
/*    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);*/
/*}*/

/** {*/
/*    margin: 0;*/
/*    padding: 0;*/
/*    box-sizing: border-box;*/
/*    font-family: 'Inter', sans-serif;*/
/*}*/

/*body {*/
/*    background: var(--bg-secondary);*/
/*    min-height: 100vh;*/
/*}*/

/*.create-post-container {*/
/*    max-width: 680px;*/
/*    margin: 0 auto;*/
/*    padding: 1rem;*/
/*}*/

.post-form {
    background: var(--bg-primary);
    border-radius: 0.75rem;
    box-shadow: var(--shadow-md);
    padding: 1.5rem;
}

/* Post Type Selection */
.post-type-selector {
    display: flex;
    /*gap: 1rem;*/
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-color);
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.post-type-button {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.375rem;
    padding: 0.75rem;
    background: transparent;
    border: none;
    border-radius: 0.5rem;
    color: var(--text-secondary);
    cursor: pointer;
    transition: all 0.2s;
    min-width: 80px;
}

.post-type-button:hover {
    background: var(--bg-blue-50);
    color: var(--primary-color);
}

.post-type-button.active {
    color: var(--primary-color);
}

.post-type-button .material-icons-outlined {
    font-size: 24px;
}

.post-type-button .type-label {
    font-size: 0.75rem;
    font-weight: 500;
}

/* Core Tools Section */
.core-tools {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.tool-row {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.scroll-y-custom {
    overflow-y: auto;
    max-height: 400px; /* adjust as needed */
}

/* Custom scrollbar for vertical (Y-axis) */
.scroll-y-custom::-webkit-scrollbar {
    width: 8px; /* scrollbar thickness */
}

.scroll-y-custom::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.scroll-y-custom::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.scroll-y-custom::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* For Firefox */
.scroll-y-custom {
    scrollbar-width: none;          /* "auto" or "thin" */
    scrollbar-color: #888 #f1f1f1;  /* thumb color track color */
}

.tool-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 0.75rem;
    background: var(--bg-primary);
    border-radius: 9999px;
    font-size: 0.75rem;
    color: var(--text-secondary);
    cursor: pointer;
    transition: all 0.2s;
}

.tool-chip:hover {
    background: var(--bg-blue-50);
    color: var(--primary-color);
}

.tool-chip .material-icons-outlined {
    font-size: 16px;
}

.tool-chip.active {
    background: var(--bg-blue-50);
    color: var(--primary-color);
}

/* More Tools Button */
.more-tools-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.375rem;
    padding: 0.5rem 0.75rem;
    background: var(--bg-primary);
    border: none;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    color: var(--text-secondary);
    cursor: pointer;
    transition: all 0.2s;
}

.more-tools-button:hover {
    background: var(--bg-blue-50);
    color: var(--primary-color);
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}

.modal.active {
    display: flex;
}

.modal-content {
    background: var(--bg-primary);
    border-radius: 0.75rem;
    width: 90%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
    position: relative;
}

.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border-color);
}

.modal-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
}

.close-button {
    background: none;
    border: none;
    color: var(--text-secondary);
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 0.375rem;
    transition: all 0.2s;
}

.close-button:hover {
    background: var(--bg-secondary);
    color: var(--text-primary);
}

.modal-body {
    padding: 1.5rem;
}

.tool-section {
    margin-bottom: 2rem;
}

.tool-section:last-child {
    margin-bottom: 0;
}

.section-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.tools-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 0.75rem;
}

.tool-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    background: var(--bg-secondary);
    border-radius: 0.5rem;
    cursor: pointer;
    transition: all 0.2s;
}

.tool-item:hover {
    background: var(--bg-blue-50);
}

.tool-item .material-icons-outlined {
    font-size: 20px;
    color: var(--text-secondary);
}

.tool-label {
    font-size: 0.75rem;
    color: var(--text-secondary);
}

.tool-item.active {
    background: var(--bg-blue-50);
}

.tool-item.active .material-icons-outlined,
.tool-item.active .tool-label {
    color: var(--primary-color);
}

.modal-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--border-color);
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
}

.modal-button {
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.modal-button.primary {
    background: var(--primary-color);
    color: white;
    border: none;
}

.modal-button.primary:hover {
    background: var(--primary-hover);
}

.modal-button.secondary {
    background: var(--bg-secondary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
}

.modal-button.secondary:hover {
    background: var(--bg-blue-50);
}

/* Form Controls */
.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    font-size: 0.875rem;
    color: var(--text-primary);
    background: var(--bg-primary);
    transition: all 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px var(--bg-blue-50);
}

.form-group {
    margin-bottom: 1rem;
}

.form-group:last-child {
    margin-bottom: 0;
}

.form-label {
    display: block;
    font-size: 0.75rem;
    font-weight: 500;
    color: var(--text-secondary);
    margin-bottom: 0.375rem;
}

select.form-control {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 1rem;
    padding-right: 2.5rem;
}

.form-row {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.form-row .form-group {
    flex: 1;
    margin-bottom: 0;
}

@media (max-width: 640px) {
    .form-row {
        flex-direction: column;
        gap: 0.75rem;
    }
}

/* Upload Area */
.upload-area {
    border: 2px dashed var(--border-color);
    border-radius: 0.5rem;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    background: var(--bg-secondary);
    margin-bottom: 1rem;
}

.upload-area:hover {
    border-color: var(--primary-color);
    background: var(--bg-blue-50);
}

.preview-box {
    width: 100%;
    height: 240px;
    background: var(--bg-secondary);
    border-radius: 0.5rem;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

.preview-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Tag Input */
.tag-input-container {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    transition: all 0.2s;
}

.tag-pill {
    display: inline-flex;
    align-items: center;
    padding: 0.375rem 0.75rem;
    background: var(--bg-blue-50);
    border-radius: 9999px;
    font-size: 0.75rem;
    color: var(--primary-color);
    gap: 0.375rem;
}

.tag-pill .material-icons-outlined {
    cursor: pointer;
    opacity: 0.7;
    transition: opacity 0.2s;
}

.tag-pill .material-icons-outlined:hover {
    opacity: 1;
}

.tag-input {
    flex: 1;
    min-width: 120px;
    border: none;
    outline: none;
    font-size: 0.875rem;
    color: var(--text-primary);
    background: transparent;
    padding: 0.375rem 0;
}

.tag-input::placeholder {
    color: var(--text-secondary);
}

/* Responsive Styles */
@media (max-width: 640px) {
    .create-post-container {
        padding: 0.5rem;
    }

    .post-form {
        padding: 1rem;
    }

    .modal-content {
        width: 100%;
        height: 100%;
        max-height: 100%;
        border-radius: 0;
    }

    .tool-row {
        flex-direction: column;
    }

    .tool-chip {
        width: 100%;
    }
}

.preview-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    background: transparent;
    color: var(--text-secondary);
    border: none;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.preview-button:hover {
    color: var(--text-primary);
}

.preview-button .material-icons-outlined {
    font-size: 18px;
}

.left-buttons {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.add-fields-button {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    background: transparent;
    color: var(--text-secondary);
    border: none;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    padding: 0;
}

.add-fields-button:hover {
    color: var(--text-primary);
}

.add-fields-button .material-icons-outlined {
    font-size: 18px;
}

.cta-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    background: #000000;
    color: white;
    border: none;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.cta-button:hover {
    background: #333333;
}

.cta-button .material-icons-outlined {
    font-size: 18px;
}

.submit-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.submit-button:hover {
    background: var(--primary-hover);
}

.submit-button .material-icons-outlined {
    font-size: 18px;
}

.action-buttons {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 0.75rem;
    margin-top: 1rem;
}

.right-buttons {
    display: flex;
    gap: 0.75rem;
}

@media (max-width: 640px) {
    .action-buttons {
        flex-direction: column;
        align-items: stretch;
    }

    .left-buttons {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .right-buttons {
        flex-direction: column;
    }

    .preview-button,
    .cta-button,
    .submit-button {
        width: 100%;
    }
}

.category-buttons {
    display: flex;
    gap: 0.75rem;
    overflow-x: auto;
    padding-bottom: 0.25rem;
}

.category-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: var(--bg-primary);
    border: none;
    border-radius: 0.375rem;
    color: var(--text-secondary);
    cursor: pointer;
    transition: all 0.2s;
    position: relative;
}

.category-button:hover {
    background: var(--bg-blue-50);
    color: var(--primary-color);
}

.category-button .material-icons-outlined {
    font-size: 20px;
}

.category-button::after {
    content: attr(data-tooltip);
    position: absolute;
    bottom: -25px;
    left: 50%;
    transform: translateX(-50%);
    padding: 4px 8px;
    background: rgba(0, 0, 0, 0.8);
    color: white;
    font-size: 0.75rem;
    border-radius: 4px;
    white-space: nowrap;
    opacity: 0;
    visibility: hidden;
    transition: all 0.2s;
}

.category-button:hover::after {
    opacity: 1;
    visibility: visible;
}

@media (max-width: 640px) {
    .category-buttons {
        gap: 0.5rem;
    }

    .category-button {
        width: 36px;
        height: 36px;
    }
}
</style>


<style>
:root {
    --primary-color: #6841b7;
    --primary-hover: #5a35a0;
    --text-primary: #1f2937;
    --text-secondary: #6b7280;
    --bg-primary: #ffffff;
    --bg-secondary: #f9fafb;
    --border-color: #e5e7eb;
    --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
    --radius-sm: 0.375rem;
    --radius-md: 0.5rem;
    --radius-full: 9999px;
}

/** {*/
/*    margin: 0;*/
/*    padding: 0;*/
/*    box-sizing: border-box;*/
/*    font-family: 'Inter', sans-serif;*/
/*}*/

/*body {*/
/*    background-color: var(--bg-secondary);*/
/*    color: var(--text-primary);*/
/*    line-height: 1.5;*/
/*}*/

/* Header Styles */
/*.header {*/
/*    position: sticky;*/
/*    top: 0;*/
/*    background: var(--bg-primary);*/
/*    padding: 0.75rem;*/
/*    box-shadow: var(--shadow-sm);*/
/*    z-index: 50;*/
/*}*/

.header-content {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/*.logo {*/
/*    font-size: 1.25rem;*/
/*    font-weight: 600;*/
/*    color: var(--primary-color);*/
/*    display: flex;*/
/*    align-items: center;*/
/*    gap: 0.5rem;*/
/*}*/

/*.logo .material-icons-outlined {*/
/*    font-size: 1.5rem;*/
/*}*/

.search-bar {
    flex: 1;
    max-width: 400px;
    margin: 0 2rem;
    position: relative;
}

.search-bar input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.75rem;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-full);
    background: var(--bg-secondary);
    font-size: 0.875rem;
    transition: all 0.2s;
}

.search-bar input::placeholder {
    color: var(--text-secondary);
    font-size: 0.75rem;
}

.search-bar input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(104, 65, 183, 0.1);
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--primary-color);
    font-size: 1.25rem;
}

.header-icons {
    display: flex;
    gap: 0.75rem;
}

.icon-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: var(--radius-full);
    background: var(--bg-secondary);
    cursor: pointer;
    border: none;
    transition: all 0.2s;
    color: var(--text-secondary);
}

.icon-btn:hover {
    background: var(--primary-color);
    color: white;
}

.icon-btn .material-icons-outlined {
    font-size: 1.25rem;
}

/* Main Layout */
.main-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1rem;
    display: grid;
    grid-template-columns: 240px 1fr 300px;
    gap: 1rem;
}

/* Sidebar Styles */
.sidebar {
    background: var(--bg-primary);
    border-radius: var(--radius-md);
    padding: 0.75rem;
    height: fit-content;
    box-shadow: var(--shadow-sm);
}

/*.nav-item {*/
/*    display: flex;*/
/*    align-items: center;*/
/*    gap: 0.75rem;*/
/*    padding: 0.75rem 1rem;*/
/*    border-radius: var(--radius-full);*/
/*    cursor: pointer;*/
/*    transition: all 0.2s;*/
/*    font-size: 0.875rem;*/
/*    text-decoration: none;*/
/*    color: var(--text-primary);*/
/*    margin-bottom: 0.5rem;*/
/*}*/

/*.nav-item:hover {*/
/*    background: var(--bg-secondary);*/
/*    color: var(--primary-color);*/
/*}*/

/*.nav-item.active {*/
/*    background: var(--primary-color);*/
/*    color: white;*/
/*}*/

.nav-item .material-icons-outlined {
    font-size: 1.25rem;
}

/* Posts Container */
.post-container {
    background: var(--bg-primary);
    border-radius: 15px;
    box-shadow: var(--shadow-sm);
    overflow: hidden;
    transition: all 0.2s;
    margin-bottom: 1rem; 
}

.post-container:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

.post-header {
    padding: 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between; 
}

.user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: var(--radius-full);
    object-fit: cover;
    border: 2px solid var(--primary-color);
}

.username {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--primary-color);
}

.timestamp {
    font-size: 0.75rem;
    color: var(--text-secondary);
}

.post-content {
    padding: 0.75rem;
}

.post-image {
    width: 100%;
    height: 300px;
    object-fit: cover;
    border-radius: var(--radius-sm);
    margin-bottom: 0.75rem;
}

.post-caption {
    font-size: 0.9rem;
    margin-bottom: 0.75rem;
    line-height: 1.6;
}

.post-actions {
    display: flex;
    gap: 1rem;
    padding: 0.75rem 1rem; 
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border: none;
    background: var(--bg-secondary);
    cursor: pointer;
    color: var(--text-secondary);
    font-size: 0.875rem;
    transition: all 0.2s;
    border-radius: var(--radius-full);
}

.action-btn:hover {
    background: var(--primary-color);
    color: white;
}

.action-btn .material-icons-outlined {
    font-size: 1.25rem;
}

.action-count {
    font-size: 0.688rem;
}

.gift-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    border-radius: var(--radius-full);
    background: var(--primary-color);
    color: white;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.gift-btn:hover {
    background: var(--primary-hover);
    transform: translateY(-1px);
}

.gift-btn .material-icons-outlined {
    font-size: 1.25rem;
}

/* Post Tools Bar */
.post-tools {
    padding: 0.75rem;
    overflow-x: auto;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
}

.post-tools::-webkit-scrollbar {
    display: none;
}

.tools-list {
    display: flex;
    gap: 0.75rem;
    padding: 0.5rem 0;
}

.tool-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--bg-secondary);
    border-radius: var(--radius-full);
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.tool-item:hover {
    background: var(--primary-color);
    color: white;
}

.tool-item .material-icons-outlined {
    font-size: 1.25rem;
}

/* Right Sidebar Styles */
.suggestions {
    background: var(--bg-primary);
    border-radius: var(--radius-md);
    padding: 0.75rem;
    box-shadow: var(--shadow-sm);
}

.suggestion-card {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem 0;
}

.suggestion-card:not(:last-child) {
    border-bottom: 1px solid var(--border-color);
}

.follow-btn {
    margin-left: auto;
    padding: 0.5rem 1rem;
    border-radius: var(--radius-full);
    background: var(--primary-color);
    color: white;
    border: none;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.2s;
}

.follow-btn:hover {
    background: var(--primary-hover);
    transform: translateY(-1px);
}

.hashtags {
    margin-top: 1rem;
}

.tag{
    font-size:0.80rem;
    cursor:pointer;
}

.hashtag {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    color: var(--primary-color);
    text-decoration: none;
    transition: all 0.2s;
    border-radius: var(--radius-full);
    font-size: 0.875rem;
    background: var(--bg-secondary);
    margin: 0.25rem;
}

.hashtag:hover {
    background: var(--primary-color);
    color: white;
}

.hashtag .material-icons-outlined {
    font-size: 1rem;
}

/* Mobile Styles */
@media (max-width: 1024px) {
    .main-container {
        grid-template-columns: 1fr;
    }

    .sidebar {
        display: none;
    }

    .create-post-btn {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        background: var(--primary-color);
        color: white;
        width: 48px;
        height: 48px;
        border-radius: var(--radius-full);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow-sm);
        cursor: pointer;
        border: none;
        z-index: 40;
        transition: all 0.2s;
    }

    .create-post-btn:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
    }

    .create-post-btn .material-icons-outlined {
        font-size: 1.5rem;
    }
}

@media (max-width: 640px) {
    .search-bar {
        display: none;
    }

    .header-content {
        justify-content: space-between;
    }

    .main-container {
        padding: 0.5rem;
    }

    .post-container {
        border-radius: 0;
    }

    .post-image {
        height: 300px;
    }
}

.nav-divider {
    height: 1px;
    background: var(--border-color);
    margin: 0.75rem 0;
}

.nav-section-title {
    font-size: 0.688rem;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    padding: 0.5rem;
}
</style>
  <script src="https://cdn.tailwindcss.com"></script>

<div class="row">
    <div class="col-md-9">
        <div class="card-body">
            <!-- Primary Tabs -->
            <ul class="nav nav-tabs nav-justified" role="tablist">
                
                    <li class="nav-item custom-nav-bg mx-1 align-content-center"  style="max-width: fit-content">
                            <i class="fas fa-filter"></i>
                        </li>
                
             
                @foreach ($primaryTabs as $primaryTab)
                    @php
                        $isRedirect = $primaryTab->id == '110852';
                        $tabUrl = $isRedirect ? route('shopping.index') : '#tab-' . $primaryTab->id;
                    @endphp
                    <li class="nav-item custom-nav-bg mx-1" style="max-width: fit-content">
                        <a class="nav-link {{ $loop->first ? 'active' : '' }} rounded-5"
                            {{ $isRedirect ? '' : 'data-bs-toggle=tab' }}
                            href="{{ $tabUrl }}" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block">{{ Str::limit($primaryTab->name, 8, '...') }}</span>
                        </a>
                    </li>
                @endforeach


            </ul>

            <!-- Primary Tab Content -->
            <div class="tab-content text-muted">
                @foreach ($primaryTabs as $index => $group)
                <div class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" id="tab-{{ $group->id }}"
                    role="tabpanel">

                    @php $children = $group->children ?? []; @endphp

                    @if(count($children))
                    <!-- Child Tabs as Styled Horizontal Pills -->
                    
                    
                    <section class="mt-6">
                          <div class="flex gap-4 overflow-x-auto pb-2 px-1">
                            <!-- Add Story -->
                            <div class="flex flex-col items-center"  data-bs-toggle="modal" data-bs-target="#createPostModal">
                              <button class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center border-2 border-blue-400 text-blue-500 hover:bg-blue-200 transition-all">
                                <span class="material-icons-outlined text-3xl">add</span>
                              </button>
                              <span class="text-xs text-gray-700 mt-1">Add Story</span>
                            </div>
                            <!-- Example Stories -->
                            <div class="flex flex-col items-center">
                              <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Story" class="w-16 h-16 rounded-full border-2 border-blue-400 object-cover"/>
                              <span class="text-xs text-gray-700 mt-1 truncate w-16 text-center">John</span>
                            </div>
                            <div class="flex flex-col items-center">
                              <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Story" class="w-16 h-16 rounded-full border-2 border-pink-400 object-cover"/>
                              <span class="text-xs text-gray-700 mt-1 truncate w-16 text-center">Emily</span>
                            </div>
                            <div class="flex flex-col items-center">
                              <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Story" class="w-16 h-16 rounded-full border-2 border-green-400 object-cover"/>
                              <span class="text-xs text-gray-700 mt-1 truncate w-16 text-center">Mike</span>
                            </div>
                            <div class="flex flex-col items-center">
                              <img src="https://randomuser.me/api/portraits/women/46.jpg" alt="Story" class="w-16 h-16 rounded-full border-2 border-yellow-400 object-cover"/>
                              <span class="text-xs text-gray-700 mt-1 truncate w-16 text-center">Sara</span>
                            </div>
                            <!-- Four more stories -->
                            <div class="flex flex-col items-center">
                              <img src="https://randomuser.me/api/portraits/men/50.jpg" alt="Story" class="w-16 h-16 rounded-full border-2 border-purple-400 object-cover"/>
                              <span class="text-xs text-gray-700 mt-1 truncate w-16 text-center">Alex</span>
                            </div>
                            <div class="flex flex-col items-center">
                              <img src="https://randomuser.me/api/portraits/women/51.jpg" alt="Story" class="w-16 h-16 rounded-full border-2 border-red-400 object-cover"/>
                              <span class="text-xs text-gray-700 mt-1 truncate w-16 text-center">Nina</span>
                            </div>
                            <div class="flex flex-col items-center">
                              <img src="https://randomuser.me/api/portraits/men/52.jpg" alt="Story" class="w-16 h-16 rounded-full border-2 border-teal-400 object-cover"/>
                              <span class="text-xs text-gray-700 mt-1 truncate w-16 text-center">Chris</span>
                            </div>
                            <div class="flex flex-col items-center">
                              <img src="https://randomuser.me/api/portraits/women/53.jpg" alt="Story" class="w-16 h-16 rounded-full border-2 border-orange-400 object-cover"/>
                              <span class="text-xs text-gray-700 mt-1 truncate w-16 text-center">Lily</span>
                            </div>
                          </div>
                        </section>

                    
                    @else
                    <!--<p class="text-muted mt-2">No child tabs found for this group.</p>-->
                    @endif
                </div>
                @endforeach
            </div>
            
            
        </div>
        
        <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createPostModalLabel">Create New Post</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="create-post-container">
                            <form class="post-form" method="POST" enctype="multipart/form-data" >
                                @csrf
                            
                                <!-- Post Type Selection -->
                                <div class="post-type-selector">
                                    <input type="hidden" name="post_type" id="post_type" value="text">
                            
                                    <button type="button" class="post-type-button active" data-type="text">
                                        <span class="material-icons-outlined">article</span>
                                        <span class="type-label">Text</span>
                                    </button>
                                    <button type="button" class="post-type-button" data-type="image">
                                        <span class="material-icons-outlined">image</span>
                                        <span class="type-label">Image</span>
                                    </button>
                                    <button type="button" class="post-type-button" data-type="video">
                                        <span class="material-icons-outlined">videocam</span>
                                        <span class="type-label">Video</span>
                                    </button>
                                    <button type="button" class="post-type-button" data-type="music">
                                        <span class="material-icons-outlined">music_note</span>
                                        <span class="type-label">Music</span>
                                    </button>
                                    <button type="button" class="post-type-button" data-type="link">
                                        <span class="material-icons-outlined">link</span>
                                        <span class="type-label">Link</span>
                                    </button>
                                    <button type="button" class="post-type-button" data-type="poll">
                                        <span class="material-icons-outlined">poll</span>
                                        <span class="type-label">Poll</span>
                                    </button>
                                </div>
                            
                                <!-- Post Details -->
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-control" name="category">
                                            <option value="">Select a category</option>
                                            <option value="education">Education</option>
                                            <option value="technology">Technology</option>
                                            <option value="lifestyle">Lifestyle</option>
                                            <option value="business">Business</option>
                                            <option value="entertainment">Entertainment</option>
                                            <option value="sports">Sports</option>
                                            <option value="health">Health & Wellness</option>
                                            <option value="travel">Travel</option>
                                            <option value="food">Food & Cooking</option>
                                            <option value="art">Art & Design</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="title" placeholder="Enter post title">
                                    </div>
                                </div>
                            
                                <!-- Post Content -->
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="content" placeholder="What's on your mind?" rows="4"></textarea>
                                </div>
                            
                                <!-- Media Upload -->
                                <div class="form-group media-upload-group d-none" id="mediaFields">
                                    <label>Media File</label>
                                    <input type="file" class="form-control" name="media_file">
                                    <input type="text" class="form-control mt-2" name="thumbnail_url" placeholder="Thumbnail URL (optional)">
                                    <input type="number" class="form-control mt-2" name="duration" placeholder="Duration (in seconds)">
                                </div>
                            
                                <!-- Poll Options (for poll type only) -->
                                <div class="form-group poll-group d-none" id="pollFields">
                                    <label>Poll Question</label>
                                    <input type="text" class="form-control" name="question" placeholder="Enter your question">
                                    <label class="mt-2">Options</label>
                                    <input type="text" class="form-control mb-2" name="options[]" placeholder="Option 1">
                                    <input type="text" class="form-control mb-2" name="options[]" placeholder="Option 2">
                                    <input type="text" class="form-control mb-2" name="options[]" placeholder="Option 3 (optional)">
                                    <input type="datetime-local" class="form-control" name="expires_at" placeholder="Poll expires at (optional)">
                                </div>
                            
                                <!-- Tags -->
                                <div class="form-group">
                                    <label>Tags</label>
                                    <input type="text" class="form-control" name="tags[]" placeholder="Enter tag #1">
                                    <input type="text" class="form-control mt-1" name="tags[]" placeholder="Enter tag #2">
                                </div>
                            
                                <!-- Action Buttons -->
                                <div class="form-group text-end mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="material-icons-outlined">arrow_forward</span>
                                        Submit Post
                                    </button>
                                </div>
                            </form>

                        </div>
        
                    </div>
                </div>
            </div>
        </div>
        
        

        
        @foreach($posts as $post)
        <div class="post-container">
            <div class="post-header">
                <div class="user-info">
                    <img  src="{{ asset('uploads/profile_pics/' . ($post->user->profile_picture ?? 'default-user.png')) }}" 
                        alt="{{ $post->user->first_name }}" 
                        class="profile-img w-16 h-16 rounded-circle">

                    <div>
                        <div class="username">{{ $post->user->first_name }}</div>
                        <div class="timestamp">{{ $post->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                <button class="icon-btn">
                    <span class="material-icons-outlined">more_horiz</span>
                </button>
            </div>
        
            <div class="post-content">
                @if($post->post_type === 'image' && $post->image)
                    <img src="{{ $post->image->image_url }}" alt="Post Image" class="post-image">
                @elseif($post->post_type === 'video' && $post->video)
                    <video class="post-image" controls>
                        <source src="{{ $post->video->video_url }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @elseif($post->post_type === 'poll' && $post->poll)
                    <p><strong>{{ $post->poll->question }}</strong></p>
                    @foreach($post->poll->options as $option)
                        <div>{{ $option->option_text }} ({{ $option->vote_count }} votes)</div>
                    @endforeach
                @endif
        
                <p class="post-caption">
                    {{ $post->content }}
                </p>
                @foreach($post->tags as $tag)
                        <span class="tag text-primary">#{{ $tag->tag }}</span>
                    @endforeach
            </div>
        
            <!-- Comment & Like Buttons -->
            <div class="post-actions flex space-x-2">
                <!-- Like Button -->
                <button class="action-btn like-btn {{ $post->isLikedBy(auth()->user()) ? 'text-bg-danger' : '' }}" data-post-id="{{ $post->id }}">
                    <span class="material-icons-outlined">
                        {{ $post->isLikedBy(auth()->user()) ? 'favorite' : 'favorite_border' }}
                    </span>
                    <span class="action-count">{{ $post->likes->count() }}</span>
                </button>

            
                    <!-- COMMENT BUTTON TRIGGER -->
                <button class="action-btn toggle-comment-btn" data-post-id="{{ $post->id }}">
                    <span class="material-icons-outlined">chat_bubble</span>
                    <span class="action-count">{{ $post->comments->count() }}</span>
                </button>


                <button class="action-btn">
                    <span class="material-icons-outlined">share</span>
                    Share
                </button>
                <button class="action-btn">
                    <span class="material-icons-outlined">bookmark</span>
                    Save
                </button>
        
                <button class="gift-btn action-btn" data-bs-toggle="modal" data-bs-target="#giftModal"onclick="openGiftModal({{ $post->user_id }}, {{ $post->id ?? 'null' }})">
                    <span class="material-icons-outlined">card_giftcard</span>  
                </button>
                
 
            </div>
            
            <script>
                function openGiftModal(receiverId, postId = null) {
                    document.getElementById('gift-receiver-id').value = receiverId;
                    document.getElementById('gift-post-id').value = postId || '';
                }

                function sendGift() {
                    const receiverId = document.getElementById('gift-receiver-id').value;
                    const postId = document.getElementById('gift-post-id').value;
                    const giftId = document.getElementById('gift-gift-id').value;
                
                    if (!giftId) {
                        alert("Please select a gift.");
                        return;
                    }
                
                    fetch('/send-gift', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            receiver_id: receiverId,
                            post_id: postId,
                            gift_category_id: giftId
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert("Gift sent!");
                            document.getElementById('giftModal').classList.remove('show'); // or use Bootstrap's modal hide
                        } else {
                            alert("Failed to send gift.");
                        }
                    })
                    .catch(() => alert("Error sending gift."));
                }
                

            </script>
            


            <!-- HIDDEN COMMENT SECTION -->
            <div id="comment-section-{{ $post->id }}" class="hidden bg-white text-sm text-gray-900 mt-2 rounded border border-gray-200 overflow-y-scroll" style="height:30vh">
                <div class="comment-list space-y-4 mx-auto px-4 py-3">
                    @foreach($post->comments as $comment)
                    <div class="space-y-1 border-b border-gray-200 pb-2 mb-2">
                        <div class="flex justify-between items-start">
                            <div class="flex space-x-2">
                                <img src="{{ asset('uploads/profile_pics/' . ($comment->user->profile_picture ?? 'default-user.png')) }}" class="w-9 h-9 rounded-full mt-1">
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <span class="font-semibold">{{ $comment->user->username }}</span>
                                        <span class="text-gray-400 text-xs">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="mt-1">
                                        {!! preg_replace('/@([\w\.]+)/', '<a href="/user/$1" class="text-blue-500">@\$1</a>', e($comment->comment)) !!}
                                    </p>
                                </div>
                            </div>
                            <!--<div class="text-gray-400 pr-2 pt-1">❤️</div>-->
                        </div>
            
                        <div class="pl-12 text-xs text-gray-500 flex space-x-4">
                            <button class="hover:underline reply-btn" data-username="{{ $comment->user->username }}" data-parent-id="{{ $comment->id }}" data-post-id="{{ $post->id }}">Reply</button>
                        </div>
             
                        <div class="pl-12 mt-2 space-y-2" id="replies-{{ $comment->id }}">
                            @foreach ($comment->replies->take(1) as $reply)
                                @include('backend.post.partials.reply', ['reply' => $reply])
                            @endforeach
                        
                            @if ($comment->replies->count() > 1)
                                <button class="text-xs text-blue-500 show-replies-btn" 
                                        data-comment-id="{{ $comment->id }}">
                                    View {{ $comment->replies->count() - 1 }} more repl{{ $comment->replies->count() - 1 > 1 ? 'ies' : 'y' }}
                                </button>
                            @endif
                        </div>
            
                         <div class="hidden extra-replies space-y-2 pl-12" id="extra-replies-{{ $comment->id }}">
                            @foreach ($comment->replies->skip(1) as $reply)
                                @include('backend.post.partials.reply', ['reply' => $reply])
                            @endforeach
                        </div>
            
            
                    </div>
                    @endforeach
            
                    <!-- ADD COMMENT FORM -->
                   
                       
            
                </div>
                <div class="position-sticky bottom-0 bg-white px-3">
                    <form method="POST" action="{{ route('post.comment', $post->id) }}" class="comment-form flex items-center rounded-full p-3 mt-2" data-post-id="{{ $post->id }}">
                        @csrf
                        <input type="hidden" name="parent_id" class="parent-id-input">
                        <input type="text" name="comment" class="comment-input flex-1 outline-none px-2 bg-transparent text-sm" placeholder="Add a comment..." required>
                        <button type="submit" class="text-blue-500 font-semibold text-sm px-3">Post</button>
                    </form>     
                </div>
                    
            </div>

            <!--<div class="post-tools">-->
                
                
            <!--    <div class="tools-list">-->
            <!--        <div class="tool-item"><span class="material-icons-outlined">schedule</span> Schedule Post</div>-->
            <!--        <div class="tool-item"><span class="material-icons-outlined">description</span> Add Form</div>-->
            <!--        <div class="tool-item"><span class="material-icons-outlined">add_circle</span> Add Button</div>-->
            <!--        <div class="tool-item"><span class="material-icons-outlined">star</span> Make Premium</div>-->
            <!--        <div class="tool-item"><span class="material-icons-outlined">campaign</span> Add Ads</div>-->
            <!--        <div class="tool-item"><span class="material-icons-outlined">payments</span> Commission</div>-->
            <!--        <div class="tool-item"><span class="material-icons-outlined">target</span> Call to Action</div>-->
            <!--        <div class="tool-item"><span class="material-icons-outlined">handshake</span> Referral</div>-->
            <!--    </div>-->
            <!--</div>-->
        </div>
        @endforeach



        @include('backend.post.partials.modals')

        @include('backend.post.partials.gift-modal')

        
        
        
        
    </div>
    <!-- end col -->
    
   <style>
    .accordion-button:focus {
        box-shadow: none;
    }

    .accordion-button::after {
        transition: transform 0.3s ease;
    }

    .accordion-button.collapsed::after {
        transform: rotate(0deg);
    }

    .accordion-button:not(.collapsed)::after {
        transform: rotate(180deg);
    }
    
    .accordion-button:not(.collapsed) {
        background-color:#fff; 
    }
</style>
    <style>
        .subcategory-check {
            transform: scale(1.2);
            cursor: pointer;
        }
        
        [data-icon]:before {
            font-family: dripicons-v2 !important;
            content: 
            '';
            font-style: normal !important;
            font-weight: 400 !important;
            font-variant: normal !important;
            text-transform: none !important;
            speak: none;
            line-height: 1;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        .collapse {
    visibility: visible;
}

    </style>

@php
use App\Models\Category;
$topTabs = Category::where('parent_id', 111735)->with('children.children')->orderBy('position')->get();
@endphp

<div class="col-md-3">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                
                <!-- Dynamic Tabs -->
                <ul class="nav nav-tabs mb-3" id="dynamicTabs" role="tablist">
                    @foreach($topTabs as $tab)
                        <li class="nav-item" role="presentation">
                            <button class="p-2 nav-link {{ $loop->first ? 'active' : '' }}"
                                    id="tab-{{ $tab->id }}"
                                    data-bs-toggle="tab"
                                    data-bs-target="#pane-{{ $tab->id }}"
                                    type="button"
                                    role="tab"
                                    aria-controls="pane-{{ $tab->id }}"
                                    aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ $tab->name }}
                            </button>
                        </li>
                    @endforeach
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="dynamicTabContent">
                    @foreach($topTabs as $tab)
                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                             id="pane-{{ $tab->id }}"
                             role="tabpanel"
                             aria-labelledby="tab-{{ $tab->id }}">
                             
                            <div class="accordion" id="accordion-{{ $tab->id }}">
                                @foreach($tab->children as $group)
                                    <div class="accordion-item border mb-1">
                                        <h2 class="accordion-header d-flex justify-content-between align-items-center px-3 py-0">
                                            <button class="accordion-button collapsed flex-grow-1" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#group-{{ $group->id }}"
                                                    aria-expanded="false"
                                                    aria-controls="group-{{ $group->id }}">
                                                {{ $group->name }}
                                            </button>
                                            <i class="mdi mdi-cog fs-5 text-muted ms-2"
                                               style="cursor:pointer"
                                               data-bs-toggle="offcanvas"
                                               data-bs-target="#settingsPanel-{{ $group->id }}"
                                               aria-controls="settingsPanel-{{ $group->id }}"></i>
                                        </h2>

                                        <div id="group-{{ $group->id }}" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                <div class="row g-2" id="content-{{ $group->id }}">
                                                    <!-- Will be dynamically filled or updated by JS -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- OFFCANVAS SETTINGS MODAL -->
                                    <div class="offcanvas offcanvas-end" tabindex="-1" id="settingsPanel-{{ $group->id }}">
                                        <div class="offcanvas-header">
                                            <h5 class="offcanvas-title">Manage: {{ $group->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                        </div>
                                        <div class="offcanvas-body">
                                            <form>
                                                @foreach($group->children as $child)
                                                    <div class="form-check mb-2 d-flex align-items-center gap-2">
                                                        <input class="form-check-input sub-check"
                                                               type="checkbox"
                                                               {{ $child->is_published ? 'checked' : '' }}
                                                               data-group-id="{{ $group->id }}"
                                                               data-image="{{ $child->image ? asset('storage/category/images/' . $child->image) : asset('default-image.png') }}"
                                                               value="{{ $child->id }}"
                                                               id="sub-{{ $child->id }}">

                                                        <label class="form-check-label d-flex align-items-center gap-2" for="sub-{{ $child->id }}">
                                                            <img src="{{ $child->image ? asset('storage/category/images/' . $child->image) : asset('default-image.png') }}"
                                                                 alt="{{ $child->name }}"
                                                                 style="width: 24px; height: 24px; object-fit: cover; border-radius: 4px;">
                                                            {{ $child->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>

</div>

<div id="giftModalContainer"></div>


@endsection

@section('script')


<script>
document.addEventListener('DOMContentLoaded', () => {
    let savedData = JSON.parse(localStorage.getItem("quick_access_grouped") || '{}');

    // 🧠 Build from DOM checkboxes every time (based on DB via Blade)
    savedData = {}; // force clear and rebuild

    document.querySelectorAll('.sub-check:checked').forEach(cb => {
        const groupId = cb.dataset.groupId;
        if (!savedData[groupId]) savedData[groupId] = [];
        savedData[groupId].push(cb.value);
    });

    localStorage.setItem("quick_access_grouped", JSON.stringify(savedData));

    // ✅ Render all based on freshly synced data
    for (const [groupId, ids] of Object.entries(savedData)) {
        renderGroupItems(groupId);
    }

    // ✅ Live interaction updates localStorage
    document.querySelectorAll('.sub-check').forEach(cb => {
        cb.addEventListener('change', () => {
            const groupId = cb.dataset.groupId;
            const id = cb.value;
            if (!savedData[groupId]) savedData[groupId] = [];

            if (cb.checked) {
                if (!savedData[groupId].includes(id)) {
                    savedData[groupId].push(id);
                }
            } else {
                savedData[groupId] = savedData[groupId].filter(i => i !== id);
            }

            localStorage.setItem("quick_access_grouped", JSON.stringify(savedData));
            renderGroupItems(groupId);
        });
    });
});

function renderGroupItems(groupId) {
    const container = document.getElementById(`content-${groupId}`);
    if (!container) return;

    const savedData = JSON.parse(localStorage.getItem("quick_access_grouped") || '{}');
    const selectedIds = savedData[groupId] || [];

    container.innerHTML = '';

    selectedIds.forEach(id => {
        const label = document.querySelector(`label[for="sub-${id}"]`);
        const input = document.querySelector(`#sub-${id}`);
        const image = input?.dataset.image || '{{ asset("default-image.png") }}';

        if (label) {
            container.innerHTML += `
                <a target="_blank" href="/admin/quick-access/view/${id}" class="col-md-3 text-decoration-none text-dark">
                    <div class="p-2 rounded m-1 text-center ">
                        <img src="${image}" alt="${label.textContent}" class="mx-auto"
                             style="width: 32px; height: 32px; object-fit: cover; border-radius: 6px; margin-bottom: 5px;">
                        <p class="fw-medium small mb-0 text-muted" style="line-height:normal">${label.textContent}</p>
                    </div>
                </a>`;
        }
    });
}
</script>

<script>
document.getElementById("imagecaptionText").addEventListener("click", function() {
    if (this.innerText === "Click to edit caption") {
        this.innerText = ".";
    }
    this.focus();
});

document.getElementById("videocaptionText").addEventListener("click", function() {
    if (this.innerText === "Click to edit caption") {
        this.innerText = ".";
    }
    this.focus();
});
</script>
<script>
function openFileSelector(inputId) {
    document.getElementById(inputId).click();
}

document.getElementById('imageInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
            new bootstrap.Tab(document.querySelector('[href="#images"]')).show();
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById('videoInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('videoPreview').src = e.target.result;
            document.getElementById('videoPreview').style.display = 'block';
            new bootstrap.Tab(document.querySelector('[href="#video"]')).show();
        };
        reader.readAsDataURL(file);
    }
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const createHeading = document.getElementById('create-post-heading');
    const postTypeSelect = document.getElementById('post_type_select');
    const childCategorySelect = document.getElementById('child_category_select');

    postTypeSelect.addEventListener('change', function() {
        const selectedOption = postTypeSelect.options[postTypeSelect.selectedIndex];
        const typeName = selectedOption.getAttribute('data-name');
        const typeId = selectedOption.value;

        // Update Heading
        // if (typeName) {
        //     createHeading.innerText = `Create ${typeName}`;
        // } else {
        //     createHeading.innerText = 'Create Post';
        // }

        // Fetch child categories (from JSON)
        if (typeId) {
            fetch(`/categories/${typeId}/childrens`) // Correct API
                .then(response => response.json())
                .then(data => {
                    childCategorySelect.innerHTML =
                        '<option value="">-- Select Child Category --</option>';

                    data.forEach(child => {
                        const option = document.createElement('option');
                        option.value = child.id;
                        option.textContent = child.name;
                        childCategorySelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching child categories:', error);
                });
        } else {
            childCategorySelect.innerHTML = '<option value="">-- Select Child Category --</option>';
        }
    });
});

// Shortcut click handling
function showCreateForm(name) {
    const createHeading = document.getElementById('create-post-heading');
    // createHeading.innerText = 'Create ' + name;

    const postTypeSelect = document.getElementById('post_type_select');
    for (let option of postTypeSelect.options) {
        if (option.getAttribute('data-name') === name) {
            option.selected = true;
            postTypeSelect.dispatchEvent(new Event('change'));
            break;
        }
    }
}
</script>





<!-- create post  -->



<script>
    
    document.querySelectorAll('.post-type-button').forEach(button => {
    button.addEventListener('click', function () {
        // Set active class
        document.querySelectorAll('.post-type-button').forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');

        const type = this.getAttribute('data-type');
        document.getElementById('post_type').value = type;

        // Toggle visibility of conditional fields
        document.getElementById('mediaFields').classList.toggle('d-none', !(type === 'video' || type === 'image' || type === 'music'));
        document.getElementById('pollFields').classList.toggle('d-none', type !== 'poll');
    });
});

    
    
 $('.post-form').on('submit', function(e) {
    e.preventDefault();

   let formData = new FormData(this);

    // Debug: log all form data key-value pairs
    for (let [key, value] of formData.entries()) {
        console.log(`${key}:`, value);
    } 

    fetch("/admin/post", {
        method: "POST",
        headers: {
            "Authorization": "Bearer YOUR_API_TOKEN"
        },
        body: formData
    }).then(res => res.json())
      .then(data => {
        if (data.status === "success") {
            alert("Post created!");
        }
    });
});

 
document.querySelector('.close-button').addEventListener('click', function() {
    document.querySelector('.create-post-container').classList.add('d-none');
});



// Get all category buttons and modals
const categoryButtons = document.querySelectorAll('.category-button');
const modals = document.querySelectorAll('.modal');
const closeButtons = document.querySelectorAll('.close-button, .modal-button.secondary');
const ctaButton = document.querySelector('.cta-button');
const addFieldsButton = document.querySelector('.add-fields-button');

 


// Function to open modal
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('active');
    }
}

// Function to close modal
function closeModal(modal) {
    modal.classList.remove('active');
}

// Add click event listeners to category buttons
categoryButtons.forEach(button => {
    button.addEventListener('click', () => {
        const category = button.getAttribute('data-category');
        openModal(`${category}-modal`);
    });
});

// Add click event listener to CTA button
ctaButton.addEventListener('click', () => {
    openModal('cta-modal');
});

// Add click event listener to Add Fields button
addFieldsButton.addEventListener('click', () => {
    openModal('add-fields-modal');
});

// Add click event listeners to close buttons
closeButtons.forEach(button => {
    button.addEventListener('click', () => {
        const modal = button.closest('.modal');
        if (modal) {
            closeModal(modal);
        }
    });
});

// Close modal when clicking outside
modals.forEach(modal => {
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal(modal);
        }
    });
});

// Close modal when pressing Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        modals.forEach(modal => {
            if (modal.classList.contains('active')) {
                closeModal(modal);
            }
        });
    }
});
</script>
 

<script>
    let selectedGift = null;
    let selectedGiftPrice = 0;

    function showAddMoney() {
        alert('Add money feature coming soon.');
    }

    function changeCategory(event, category) {
        document.querySelectorAll('.category-btn').forEach(btn => btn.classList.remove('active'));
        event.currentTarget.classList.add('active');

        document.querySelectorAll('.gift-item').forEach(item => {
            const isMatch = category === 'all' || item.dataset.category === category;
            item.style.display = isMatch ? 'block' : 'none';
        });

        selectedGift = null;
        selectedGiftPrice = 0;
        document.querySelectorAll('.gift-item .border').forEach(box => box.classList.remove('border-primary'));
    }

    function selectGift(element, price) {
        element.querySelector('.gift-item'').classList.add('border-primary');
        selectedGift = element;
        selectedGiftPrice = price;
    }

    function sendGift() {
        if (!selectedGift) {
            alert("Please select a gift.");
            return;
        }
        const balance = 50;
        if (selectedGiftPrice > balance) {
            alert("Insufficient balance.");
            return;
        }
        alert(`Gift sent! Amount: $${selectedGiftPrice}`);
        const modal = bootstrap.Modal.getInstance(document.getElementById('giftModal'));
        modal.hide();
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.like-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const postId = this.getAttribute('data-post-id');
                const btnEl = this;

                fetch(`/posts/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const icon = btnEl.querySelector('span.material-icons-outlined');
                    const count = btnEl.querySelector('.action-count');
                    let currentCount = parseInt(count.innerText);

                    if (data.status === 'liked') {
                        icon.innerText = 'favorite';
                        btnEl.classList.add('text-bg-danger'); // Add red background
                        count.innerText = currentCount + 1;
                    } else {
                        icon.innerText = 'favorite_border';
                        btnEl.classList.remove('text-bg-danger'); // Remove red background
                        count.innerText = currentCount - 1;
                    }
                });
            });
        });
    });
</script>

<script>
    
    document.addEventListener('click', function (e) {
    if (e.target.classList.contains('show-replies-btn')) {
        const commentId = e.target.getAttribute('data-comment-id');
        const hiddenReplies = document.getElementById(`extra-replies-${commentId}`);
        hiddenReplies.classList.remove('hidden');
        e.target.remove(); // Remove the "View more replies" button
    }
});


document.addEventListener('DOMContentLoaded', function () {
    // Toggle comment section
    document.querySelectorAll('.toggle-comment-btn').forEach(button => {
        button.addEventListener('click', function () {
            const postId = this.getAttribute('data-post-id');
            document.getElementById('comment-section-' + postId).classList.toggle('hidden');
        });
    });

    // Reply button logic
  document.addEventListener('click', function (e) {
    if (e.target.classList.contains('reply-btn')) {
        const button = e.target;
        const username = button.getAttribute('data-username');
        const parentId = button.getAttribute('data-parent-id');
        const postId = button.getAttribute('data-post-id');

        const section = document.querySelector(`#comment-section-${postId}`);
        const input = section.querySelector('.comment-input');
        const parentInput = section.querySelector('.parent-id-input');

        input.value = `@${username} `;
        parentInput.value = parentId;
        input.focus();
    }
});


    // AJAX comment submission
    document.querySelectorAll('.comment-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const postId = this.getAttribute('data-post-id');
            const commentInput = this.querySelector('.comment-input');
            const parentIdInput = this.querySelector('.parent-id-input');
            const token = this.querySelector('input[name="_token"]').value;

            const commentText = commentInput.value.trim();
            const parentId = parentIdInput.value;

            if (!commentText) return;

            fetch(`/post/${postId}/comment`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    comment: commentText,
                    parent_id: parentId || null
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const newComment = data.comment;
                    const commentList = document.querySelector(`#comment-section-${postId} .comment-list`);
                    
                      

                   const html = `
                    <div class="space-y-1 border-b border-gray-200 pb-2 mb-2">
                        <div class="flex justify-between items-start">
                            <div class="flex space-x-2">
                                <img src="${newComment.profile_picture}" class="w-9 h-9 rounded-full mt-1">
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <span class="font-semibold">${newComment.username}</span>
                                        <span class="text-gray-400 text-xs">${newComment.created_at}</span>
                                    </div>
                                    <p class="mt-1">${newComment.comment.replace(/@([\w\.]+)/g, '<a href="/user/$1" class="text-blue-500">@$username</a>')}</p>
                                </div>
                            </div>
                            
                        </div>
                    
                        <div class="pl-12 text-xs text-gray-500 flex space-x-4">
                            <button class="hover:underline reply-btn" 
                                    data-username="${newComment.username}" 
                                    data-parent-id="${newComment.id}" 
                                    data-post-id="${postId}">Reply</button>
                        </div>
                    
                        <div class="pl-12 mt-2 space-y-2 hidden" id="replies-${newComment.id}"></div>
                    </div>
                    `;



                    if (newComment.parent_id) {
                        const repliesDiv = document.getElementById(`replies-${newComment.parent_id}`);
                        if (repliesDiv) {
                            repliesDiv.classList.remove('hidden');
                            repliesDiv.insertAdjacentHTML('beforeend', html);
                        }
                    }
                     else {
                        // Append to top-level comment list
                        const commentList = document.querySelector(`#comment-section-${postId} .comment-list`);
                        if (commentList) {
                            commentList.insertAdjacentHTML('afterbegin', html);
                            // Re-bind reply buttons for new comments
                            document.querySelectorAll('.reply-btn').forEach(button => {
                                button.onclick = function () {
                                   
                                    const username = this.getAttribute('data-username');
                                    const parentId = this.getAttribute('data-parent-id');
                                    const postId = this.getAttribute('data-post-id');
                            
                                    const section = document.querySelector(`#comment-section-${postId}`);
                                    const input = section.querySelector('.comment-input');
                                    const parentInput = section.querySelector('.parent-id-input');
                            
                                    input.value = `@${username} `;
                                    parentInput.value = parentId;
                                    input.focus();
                                };
                            });

                        }
                    }


                    // Clear form
                    commentInput.value = '';
                    parentIdInput.value = '';
                } else {
                    alert(data.error || 'Something went wrong');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Error adding comment.');
            });
        });
    });
});
</script>


@endsection