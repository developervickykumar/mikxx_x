@extends('layouts.master')

@section('title')

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #10B981;
            --secondary-color: #059669;
            --accent-color: #047857;
            --text-color: #1F2937;
            --light-bg: #F9FAFB;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --hover-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --border-color: #E5E7EB;
            --success-color: #10B981;
            --warning-color: #F59E0B;
            --danger-color: #EF4444;
            --info-color: #3B82F6;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
            color: var(--text-color);
            line-height: 1.6;
        }

        .profile-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
            display: flex;
            gap: 2rem;
        }

        .profile-tabs {
            background: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            width: 300px;
            flex-shrink: 0;
            position: sticky;
            top: 2rem;
            max-height: calc(100vh - 4rem);
            overflow-y: auto;
        }

        .profile-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 12px 12px 0 0;
        }

        .profile-header h2 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .profile-header p {
            font-size: 0.875rem;
            opacity: 0.9;
            margin: 0;
        }

        .profile-tab {
            padding: 1rem 1.5rem;
            color: var(--text-color);
            border-left: 3px solid transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            position: relative;
            margin-bottom: 0.25rem;
            border-radius: 0 8px 8px 0;
        }

        .profile-tab:hover {
            background: var(--light-bg);
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .profile-tab.active {
            color: var(--primary-color);
            border-left-color: var(--primary-color);
            background: #F0FDF4;
            font-weight: 500;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.1);
        }

        .profile-tab i {
            font-size: 1.25rem;
            width: 24px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .profile-tab:hover i {
            transform: scale(1.1);
        }

        .profile-content {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: var(--card-shadow);
            flex: 1;
        }

        .profile-section {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
        }

        .profile-section:hover {
            box-shadow: var(--hover-shadow);
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--text-color);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--border-color);
        }

        .section-title i {
            color: var(--primary-color);
            font-size: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            color: #4B5563;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-label i {
            color: var(--primary-color);
            font-size: 0.875rem;
        }

        .form-control,
        .form-select {
            height: 45px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            padding: 6px;
            transition: all 0.3s ease;
            background-color: white;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
            transform: translateY(-1px);
        }

        .btn-profile {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .btn-profile::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.3s ease, height 0.3s ease;
        }

        .btn-profile:hover::after {
            width: 200%;
            height: 200%;
        }

        .btn-profile.primary {
            background: var(--primary-color);
            color: white;
            border: none;
        }

        .btn-profile.primary:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(16, 185, 129, 0.2);
        }

        .btn-profile.outline {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
        }

        .btn-profile.outline:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-1px);
        }

        .profile-image-upload {
            position: relative;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .profile-image-upload img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-image-upload .upload-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.2s ease;
        }

        .profile-image-upload:hover .upload-overlay {
            opacity: 1;
        }

        .cover-photo-upload {
            position: relative;
            width: 100%;
            height: 200px;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .cover-photo-upload img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cover-photo-upload .upload-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.2s ease;
        }

        .cover-photo-upload:hover .upload-overlay {
            opacity: 1;
        }

        .tag-input {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            padding: 0.5rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            min-height: 100px;
        }

        .tag {
            background: #EFF6FF;
            color: var(--info-color);
            padding: 0.5rem 1rem;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            margin: 0.25rem;
        }

        .tag:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2);
        }

        .tag i {
            cursor: pointer;
            font-size: 0.75rem;
            transition: transform 0.3s ease;
        }

        .tag i:hover {
            transform: scale(1.2);
            color: var(--danger-color);
        }

        .tag-input input {
            border: none;
            outline: none;
            flex: 1;
            min-width: 100px;
        }

        .interest-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }

        .interest-item {
            background: var(--light-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .interest-item:hover {
            border-color: var(--primary-color);
            background: #F0FDF4;
            transform: translateY(-2px);
            box-shadow: var(--hover-shadow);
        }

        .interest-item.active {
            border-color: var(--primary-color);
            background: #F0FDF4;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);
        }

        .interest-item i {
            color: var(--primary-color);
        }

        .measurement-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }

        .measurement-item {
            background: var(--light-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .measurement-item:hover {
            transform: translateY(-2px);
            box-shadow: var(--hover-shadow);
            border-color: var(--primary-color);
        }

        .measurement-label {
            font-size: 0.875rem;
            color: #6B7280;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .measurement-value {
            font-weight: 600;
            color: var(--text-color);
            font-size: 1.125rem;
        }

        .education-item {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .education-item:hover {
            transform: translateY(-2px);
            box-shadow: var(--hover-shadow);
            border-color: var(--primary-color);
        }

        .education-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .education-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .education-subtitle {
            color: #6B7280;
            font-size: 0.875rem;
        }

        .education-actions {
            display: flex;
            gap: 0.5rem;
        }

        .project-item {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .project-item:hover {
            transform: translateY(-2px);
            box-shadow: var(--hover-shadow);
            border-color: var(--primary-color);
        }

        .project-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .project-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .project-subtitle {
            color: #6B7280;
            font-size: 0.875rem;
        }

        .project-actions {
            display: flex;
            gap: 0.5rem;
        }

        .achievement-item {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .achievement-item:hover {
            transform: translateY(-2px);
            box-shadow: var(--hover-shadow);
            border-color: var(--primary-color);
        }

        .achievement-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #EFF6FF;
            color: var(--info-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .achievement-details {
            flex: 1;
        }

        .achievement-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .achievement-subtitle {
            color: #6B7280;
            font-size: 0.875rem;
        }

        .language-item {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .language-item:hover {
            transform: translateY(-2px);
            box-shadow: var(--hover-shadow);
            border-color: var(--primary-color);
        }

        .language-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .language-name {
            font-weight: 600;
        }

        .language-level {
            display: flex;
            gap: 0.25rem;
        }

        .level-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--border-color);
            transition: all 0.3s ease;
        }

        .level-dot.active {
            background: var(--primary-color);
            transform: scale(1.2);
        }

        .bio-editor {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            min-height: 200px;
            transition: all 0.3s ease;
        }

        .bio-editor:focus-within {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .bio-toolbar {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
            flex-wrap: wrap;
        }

        .bio-toolbar button {
            background: none;
            border: none;
            color: #6B7280;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .bio-toolbar button:hover {
            background: var(--light-bg);
            color: var(--primary-color);
            transform: translateY(-1px);
        }

        .bio-content {
            outline: none;
            min-height: 150px;
            padding: 0.5rem;
        }

        /* Age Display Styles */
        .age-display {
            background: #F0FDF4;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .age-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .age-label {
            font-size: 0.875rem;
            color: #6B7280;
        }

        .age-value {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .age-group {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 16px;
            font-size: 0.875rem;
            font-weight: 500;
            background: #EFF6FF;
            color: var(--info-color);
        }

        /* Verification Request Styles */
        .verification-request {
            background: #FEF3C7;
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 2rem;
            border: 1px solid var(--warning-color);
        }

        .verification-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .verification-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: var(--warning-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .verification-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-color);
            margin: 0;
        }

        .verification-subtitle {
            font-size: 0.875rem;
            color: #6B7280;
            margin: 0;
        }

        .document-upload {
            background: white;
            border: 2px dashed var(--border-color);
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .document-upload:hover {
            border-color: var(--primary-color);
            background: #F0FDF4;
        }

        .document-upload i {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .document-upload p {
            margin: 0;
            color: #6B7280;
        }

        .document-upload .file-types {
            font-size: 0.875rem;
            color: #9CA3AF;
            margin-top: 0.5rem;
        }

        @media (max-width: 768px) {
            .profile-container {
                flex-direction: column;
                margin: 1rem auto;
            }

            .profile-tabs {
                width: 100%;
                position: static;
                max-height: none;
                margin-bottom: 1rem;
            }

            .profile-content {
                padding: 1rem;
            }

            .interest-grid,
            .measurement-grid {
                grid-template-columns: 1fr;
            }

            .bio-toolbar {
                justify-content: center;
            }

            .section-title {
                flex-direction: column;
                text-align: center;
                gap: 0.5rem;
            }
        }

        /* Modal Styles */
        .modal-custom {
            border-radius: 12px;
            border: none;
        }

        .modal-custom .modal-header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            border-radius: 12px 12px 0 0;
            padding: 1.5rem;
        }

        .modal-custom .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .modal-custom .modal-body {
            padding: 1.5rem;
        }

        .modal-custom .modal-footer {
            padding: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        .language-rating {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .rating-dot {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--border-color);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .rating-dot:hover {
            transform: scale(1.1);
        }

        .rating-dot.active {
            background: var(--primary-color);
            transform: scale(1.1);
        }

        .rating-label {
            font-size: 0.875rem;
            color: #6B7280;
            margin-top: 0.5rem;
        }

        .project-form .form-group {
            margin-bottom: 1.5rem;
        }

        .project-form .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .project-form .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
        }

        .project-form textarea.form-control {
            min-height: 100px;
        }

        /* Achievement Modal Styles */
        .achievement-icon-select {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .icon-option {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            background: var(--light-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.5rem;
            color: var(--text-color);
        }

        .icon-option:hover {
            transform: translateY(-2px);
            background: #EFF6FF;
            color: var(--info-color);
        }

        .icon-option.active {
            background: var(--primary-color);
            color: white;
            transform: scale(1.05);
        }

        /* Education Modal Styles */
        .education-form .form-group {
            margin-bottom: 1.5rem;
        }

        .education-form .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .education-form .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
        }

        .education-form textarea.form-control {
            min-height: 100px;
        }

        .education-form .degree-type {
            display: flex;
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .degree-option {
            flex: 1;
            padding: 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .degree-option:hover {
            border-color: var(--primary-color);
            background: #F0FDF4;
        }

        .degree-option.active {
            border-color: var(--primary-color);
            background: #F0FDF4;
            box-shadow: 0 2px 4px rgba(16, 185, 129, 0.1);
        }

        .degree-option i {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        /* Tailor Measurements Styles */
        .measurement-category {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .measurement-category:hover {
            transform: translateY(-2px);
            box-shadow: var(--hover-shadow);
            border-color: var(--primary-color);
        }

        .category-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .category-title i {
            color: var(--primary-color);
        }

        .measurement-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }

        .measurement-item {
            background: var(--light-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .measurement-item:hover {
            transform: translateY(-2px);
            box-shadow: var(--hover-shadow);
            border-color: var(--primary-color);
        }

        .measurement-label {
            font-size: 0.875rem;
            color: #6B7280;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .measurement-value {
            font-weight: 600;
            color: var(--text-color);
            font-size: 1.125rem;
        }

        .measurement-unit {
            font-size: 0.875rem;
            color: #6B7280;
            margin-left: 0.25rem;
        }

        /* Tailor Measurements Form Styles */
        .measurement-form {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .measurement-form:hover {
            transform: translateY(-2px);
            box-shadow: var(--hover-shadow);
            border-color: var(--primary-color);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .measurement-input {
            position: relative;
        }

        .measurement-input input {
            width: 100%;
            padding: 0.75rem 1rem;
            padding-right: 3rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .measurement-input input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .measurement-unit {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6B7280;
            font-size: 0.875rem;
            pointer-events: none;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }
    </style>
    </head>

    <body>
    @section('content')
        <div class="profile-container">
            <!-- Profile Tabs -->
            <div class="profile-tabs">
                <div class="profile-header">
                    <h2>Edit Profile</h2>
                    <p>Manage your profile information</p>
                </div>
                @foreach ($usersetting->sortByDesc('id') as $item)
                    <div class="profile-tab {{ $loop->first ? 'active' : '' }}" data-tab="{{ Str::slug($item->name) }}">
                        <i class="{{ $item->icon ?? 'fas fa-folder' }}"></i> {{ $item->name }}
                    </div>
                @endforeach

            </div>

            <!-- Profile Content -->
            @php
                use Illuminate\Support\Str;

                if (!function_exists('getFieldValue')) {
                    function getFieldValue($fieldName, $savedValues, $user)
                    {
                        $normalized = Str::snake(str_replace('-', '_', $fieldName));
                        return $savedValues[$normalized] ?? ($user->{$normalized} ?? '');
                    }
                }
            @endphp


            <div class="profile-content">
                @foreach ($usersetting as $item)
                    <div class="tab-content" id="{{ Str::slug($item->name) }}">
                        <h3>{{ $item->name }}</h3>

                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                @foreach ($item->childrenRecursive as $child)
                                    @php
                                        $field = $child->meta ?? ($child->advanced ?? []);
                                        $rawFieldName = $field['name'] ?? ($child->name ?? 'field_' . $child->id);
                                        $fieldName = Str::snake(str_replace('-', '_', $rawFieldName));
                                        $fieldLabel = $field['label'] ?? $child->name;
                                        $fieldType = strtolower(
                                            str_replace(' ', '-', $field['functionality'] ?? 'text'),
                                        );
                                        $fieldOptions =
                                            $field['options'] ??
                                            ($child->children->count() > 0
                                                ? $child->children->pluck('name')->toArray()
                                                : []);
                                        $fieldValue = getFieldValue($fieldName, $user->additional_info ?? [], $user);
                                        $fieldDescription = $field['description'] ?? null;
                                    @endphp

                                    <div class="col-lg-6 mb-4">
                                        <div class="form-group">
                                            <label class="form-label">{{ $fieldLabel }}</label>

                                            @switch($fieldType)
                                                @case('text-editor')
                                                @case('description')
                                                    <textarea name="fields[{{ $fieldName }}]" class="form-control">{{ $fieldValue }}</textarea>
                                                @break

                                                @case('select')
                                                @case('multiselect')
                                                    <select
                                                        name="fields[{{ $fieldName }}]{{ in_array($fieldType, ['multiselect']) ? '[]' : '' }}"
                                                        class="form-control"
                                                        {{ in_array($fieldType, ['multiselect']) ? 'multiple' : '' }}>
                                                        @foreach ($fieldOptions as $option)
                                                            <option value="{{ $option }}"
                                                                {{ in_array($option, (array) $fieldValue) ? 'selected' : '' }}>
                                                                {{ $option }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @break

                                                @case('radio')
                                                    @php $currentValue = trim(strtolower($fieldValue)); @endphp
                                                    <div>
                                                        @foreach ($fieldOptions as $option)
                                                            @php
                                                                $normalizedOption = trim(strtolower($option));
                                                                $isChecked = $currentValue === $normalizedOption;
                                                            @endphp
                                                            <div class="form-check form-check-inline">
                                                                <input type="radio" name="fields[{{ $fieldName }}]"
                                                                    class="form-check-input" value="{{ $option }}"
                                                                    id="{{ $fieldName . '_' . Str::slug($option) }}"
                                                                    {{ $isChecked ? 'checked' : '' }}>
                                                                <label for="{{ $fieldName . '_' . Str::slug($option) }}"
                                                                    class="form-check-label">{{ $option }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @break

                                                @case('checkbox')
                                                    @php
                                                        $checkedValues = is_array($fieldValue)
                                                            ? $fieldValue
                                                            : explode(',', $fieldValue);
                                                    @endphp
                                                    <div>
                                                        @foreach ($fieldOptions as $option)
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="fields[{{ $fieldName }}][]"
                                                                    value="{{ $option }}"
                                                                    id="{{ $fieldName . '_' . Str::slug($option) }}"
                                                                    {{ in_array($option, $checkedValues) ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="{{ $fieldName . '_' . Str::slug($option) }}">{{ $option }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @break

                                                @case('date')
                                                    <input type="date" name="fields[{{ $fieldName }}]"
                                                        value="{{ $fieldValue }}" class="form-control">
                                                @break

                                                @case('time')
                                                    <input type="time" name="fields[{{ $fieldName }}]"
                                                        value="{{ $fieldValue }}" class="form-control">
                                                @break

                                                @case('image')
                                                @case('file')
                                                    <input type="file" name="fields[{{ $fieldName }}]" class="form-control">
                                                @break

                                                @default
                                                    <input type="text" name="fields[{{ $fieldName }}]"
                                                        value="{{ $fieldValue }}" class="form-control">
                                            @endswitch

                                            @if ($fieldDescription)
                                                <small class="form-text text-muted">{{ $fieldDescription }}</small>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-primary">Save {{ $item->name }}</button>
                        </form>

                    </div>
                @endforeach
            </div>



        </div>


        <!-- Add Language Modal -->
        <div class="modal fade" id="addLanguageModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content modal-custom">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-language"></i>Add Language Skill
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">Language</label>
                            <select class="form-select" id="languageSelect">
                                <option value="">Select a language</option>
                                <option value="french">French</option>
                                <option value="german">German</option>
                                <option value="italian">Italian</option>
                                <option value="portuguese">Portuguese</option>
                                <option value="russian">Russian</option>
                                <option value="japanese">Japanese</option>
                                <option value="chinese">Chinese</option>
                                <option value="arabic">Arabic</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Proficiency Level</label>
                            <div class="language-rating" id="languageRating">
                                <div class="rating-dot" data-level="1"></div>
                                <div class="rating-dot" data-level="2"></div>
                                <div class="rating-dot" data-level="3"></div>
                                <div class="rating-dot" data-level="4"></div>
                                <div class="rating-dot" data-level="5"></div>
                            </div>
                            <div class="rating-label" id="ratingLabel">Select your proficiency level</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-profile outline" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-profile primary" id="saveLanguage">
                            <i class="fas fa-save"></i>Save Language
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Project Modal -->
        <div class="modal fade" id="addProjectModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content modal-custom">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-project-diagram"></i>Add New Project
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form class="project-form">
                            <div class="form-group">
                                <label class="form-label">Project Title</label>
                                <input type="text" class="form-control" placeholder="Enter project title">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Duration</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="month" class="form-control" placeholder="Start Date">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="month" class="form-control" placeholder="End Date">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Project Description</label>
                                <textarea class="form-control" placeholder="Describe your project"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Technologies Used</label>
                                <input type="text" class="form-control" placeholder="e.g., React, Node.js, Python">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Project URL (Optional)</label>
                                <input type="url" class="form-control" placeholder="https://">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-profile outline" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-profile primary" id="saveProject">
                            <i class="fas fa-save"></i>Save Project
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Achievement Modal -->
        <div class="modal fade" id="addAchievementModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content modal-custom">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-trophy"></i>Add Achievement
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form class="achievement-form">
                            <div class="form-group">
                                <label class="form-label">Achievement Title</label>
                                <input type="text" class="form-control" placeholder="Enter achievement title">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Issuing Organization</label>
                                <input type="text" class="form-control" placeholder="Enter organization name">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Date Received</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" placeholder="Describe your achievement"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Select Icon</label>
                                <div class="achievement-icon-select">
                                    <div class="icon-option" data-icon="trophy"><i class="fas fa-trophy"></i></div>
                                    <div class="icon-option" data-icon="medal"><i class="fas fa-medal"></i></div>
                                    <div class="icon-option" data-icon="award"><i class="fas fa-award"></i></div>
                                    <div class="icon-option" data-icon="star"><i class="fas fa-star"></i></div>
                                    <div class="icon-option" data-icon="certificate"><i class="fas fa-certificate"></i>
                                    </div>
                                    <div class="icon-option" data-icon="crown"><i class="fas fa-crown"></i></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-profile outline" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-profile primary" id="saveAchievement">
                            <i class="fas fa-save"></i>Save Achievement
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Education Modal -->
        <div class="modal fade" id="addEducationModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content modal-custom">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-graduation-cap"></i>Add Education
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form class="education-form">
                            <div class="form-group">
                                <label class="form-label">Degree Type</label>
                                <div class="degree-type">
                                    <div class="degree-option" data-degree="bachelor">
                                        <i class="fas fa-graduation-cap"></i>
                                        <div>Bachelor's</div>
                                    </div>
                                    <div class="degree-option" data-degree="master">
                                        <i class="fas fa-user-graduate"></i>
                                        <div>Master's</div>
                                    </div>
                                    <div class="degree-option" data-degree="phd">
                                        <i class="fas fa-user-tie"></i>
                                        <div>PhD</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Field of Study</label>
                                <input type="text" class="form-control" placeholder="e.g., Computer Science">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Institution</label>
                                <input type="text" class="form-control" placeholder="Enter institution name">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Duration</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="month" class="form-control" placeholder="Start Date">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="month" class="form-control" placeholder="End Date">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Grade/GPA (Optional)</label>
                                <input type="text" class="form-control" placeholder="e.g., 3.8/4.0">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" placeholder="Describe your education experience"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-profile outline" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-profile primary" id="saveEducation">
                            <i class="fas fa-save"></i>Save Education
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Tab switching functionality
                const tabs = document.querySelectorAll('.profile-tab');
                const tabContents = document.querySelectorAll('.tab-content');

                // Function to show a specific tab
                function showTab(tabId) {
                    // Hide all tab contents
                    tabContents.forEach(content => {
                        content.classList.add('d-none');
                    });

                    // Show the selected tab content
                    const selectedContent = document.getElementById(tabId);
                    if (selectedContent) {
                        selectedContent.classList.remove('d-none');
                    }
                }

                // Add click event listeners to all tabs
                tabs.forEach(tab => {
                    tab.addEventListener('click', () => {
                        // Remove active class from all tabs
                        tabs.forEach(t => t.classList.remove('active'));

                        // Add active class to clicked tab
                        tab.classList.add('active');

                        // Show the corresponding tab content
                        const tabId = tab.getAttribute('data-tab');
                        showTab(tabId);
                    });
                });

                // Show the initial active tab
                const activeTab = document.querySelector('.profile-tab.active');
                if (activeTab) {
                    const tabId = activeTab.getAttribute('data-tab');
                    showTab(tabId);
                }

                // Age Calculation
                const dateOfBirth = document.getElementById('dateOfBirth');
                const ageValue = document.getElementById('ageValue');
                const ageGroup = document.getElementById('ageGroup');

                function calculateAge(birthDate) {
                    const today = new Date();
                    const birth = new Date(birthDate);
                    let age = today.getFullYear() - birth.getFullYear();
                    const monthDiff = today.getMonth() - birth.getMonth();

                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
                        age--;
                    }

                    return age;
                }

                function getAgeGroup(age) {
                    if (age < 18) return 'Minor';
                    if (age < 25) return 'Young Adult';
                    if (age < 35) return 'Adult';
                    if (age < 50) return 'Middle Age';
                    return 'Senior';
                }

                dateOfBirth.addEventListener('change', function() {
                    const age = calculateAge(this.value);
                    ageValue.textContent = `${age} years`;
                    ageGroup.textContent = getAgeGroup(age);
                });

                // Document Upload
                const idUpload = document.getElementById('idUpload');
                const addressUpload = document.getElementById('addressUpload');

                function handleFileUpload(element) {
                    element.addEventListener('click', function() {
                        const input = document.createElement('input');
                        input.type = 'file';
                        input.accept = '.pdf,.jpg,.jpeg,.png';
                        input.onchange = function(e) {
                            const file = e.target.files[0];
                            if (file) {
                                element.querySelector('p').textContent = file.name;
                                element.style.borderColor = 'var(--success-color)';
                                element.style.background = '#F0FDF4';
                            }
                        };
                        input.click();
                    });
                }

                handleFileUpload(idUpload);
                handleFileUpload(addressUpload);

                // Language Rating
                const ratingDots = document.querySelectorAll('.rating-dot');
                const ratingLabel = document.getElementById('ratingLabel');
                const ratingLabels = {
                    1: 'Beginner',
                    2: 'Elementary',
                    3: 'Intermediate',
                    4: 'Advanced',
                    5: 'Native/Fluent'
                };

                ratingDots.forEach(dot => {
                    dot.addEventListener('click', function() {
                        const level = this.getAttribute('data-level');
                        ratingDots.forEach(d => d.classList.remove('active'));
                        for (let i = 0; i < level; i++) {
                            ratingDots[i].classList.add('active');
                        }
                        ratingLabel.textContent = ratingLabels[level];
                    });

                    dot.addEventListener('mouseenter', function() {
                        const level = this.getAttribute('data-level');
                        ratingLabel.textContent = ratingLabels[level];
                    });

                    dot.addEventListener('mouseleave', function() {
                        const activeDot = document.querySelector('.rating-dot.active');
                        if (activeDot) {
                            const level = activeDot.getAttribute('data-level');
                            ratingLabel.textContent = ratingLabels[level];
                        } else {
                            ratingLabel.textContent = 'Select your proficiency level';
                        }
                    });
                });

                // Save Language
                document.getElementById('saveLanguage').addEventListener('click', function() {
                    const language = document.getElementById('languageSelect').value;
                    const rating = document.querySelectorAll('.rating-dot.active').length;

                    if (language && rating > 0) {
                        // Add new language item
                        const languageItem = document.createElement('div');
                        languageItem.className = 'language-item';
                        languageItem.innerHTML = `
                        <div class="language-header">
                            <div class="language-name">${language.charAt(0).toUpperCase() + language.slice(1)}</div>
                            <div class="language-level">
                                ${Array(5).fill().map((_, i) => 
                                    `<div class="level-dot ${i < rating ? 'active' : ''}"></div>`
                                ).join('')}
                            </div>
                        </div>
                    `;

                        document.querySelector('#languages .profile-section').insertBefore(
                            languageItem,
                            document.querySelector('#languages .btn-profile')
                        );

                        // Close modal and reset form
                        bootstrap.Modal.getInstance(document.getElementById('addLanguageModal')).hide();
                        document.getElementById('languageSelect').value = '';
                        ratingDots.forEach(dot => dot.classList.remove('active'));
                        ratingLabel.textContent = 'Select your proficiency level';
                    }
                });

                // Save Project
                document.getElementById('saveProject').addEventListener('click', function() {
                    const form = document.querySelector('.project-form');
                    const title = form.querySelector('input[type="text"]').value;
                    const startDate = form.querySelector('input[type="month"]:first-child').value;
                    const endDate = form.querySelector('input[type="month"]:last-child').value;

                    if (title && startDate) {
                        // Add new project item
                        const projectItem = document.createElement('div');
                        projectItem.className = 'project-item';
                        projectItem.innerHTML = `
                        <div class="project-header">
                            <div>
                                <div class="project-title">${title}</div>
                                <div class="project-subtitle">${startDate} - ${endDate || 'Present'}</div>
                            </div>
                            <div class="project-actions">
                                <button class="btn btn-profile outline">
                                    <i class="fas fa-edit"></i>Edit
                                </button>
                                <button class="btn btn-profile danger">
                                    <i class="fas fa-trash"></i>Delete
                                </button>
                            </div>
                        </div>
                    `;

                        document.querySelector('#projects .profile-section').insertBefore(
                            projectItem,
                            document.querySelector('#projects .btn-profile')
                        );

                        // Close modal and reset form
                        bootstrap.Modal.getInstance(document.getElementById('addProjectModal')).hide();
                        form.reset();
                    }
                });

                // Achievement Icon Selection
                const iconOptions = document.querySelectorAll('.icon-option');
                iconOptions.forEach(option => {
                    option.addEventListener('click', function() {
                        iconOptions.forEach(opt => opt.classList.remove('active'));
                        this.classList.add('active');
                    });
                });

                // Degree Type Selection
                const degreeOptions = document.querySelectorAll('.degree-option');
                degreeOptions.forEach(option => {
                    option.addEventListener('click', function() {
                        degreeOptions.forEach(opt => opt.classList.remove('active'));
                        this.classList.add('active');
                    });
                });

                // Save Achievement
                document.getElementById('saveAchievement').addEventListener('click', function() {
                    const form = document.querySelector('.achievement-form');
                    const title = form.querySelector('input[type="text"]').value;
                    const organization = form.querySelectorAll('input[type="text"]')[1].value;
                    const date = form.querySelector('input[type="date"]').value;
                    const description = form.querySelector('textarea').value;
                    const selectedIcon = document.querySelector('.icon-option.active');

                    if (title && organization && date && selectedIcon) {
                        const iconClass = selectedIcon.querySelector('i').className;
                        const achievementItem = document.createElement('div');
                        achievementItem.className = 'achievement-item';
                        achievementItem.innerHTML = `
                        <div class="achievement-icon">
                            <i class="${iconClass}"></i>
                        </div>
                        <div class="achievement-details">
                            <div class="achievement-title">${title}</div>
                            <div class="achievement-subtitle">${organization} • ${date}</div>
                            ${description ? `<p class="achievement-description">${description}</p>` : ''}
                        </div>
                    `;

                        document.querySelector('#achievements .profile-section').insertBefore(
                            achievementItem,
                            document.querySelector('#achievements .btn-profile')
                        );

                        // Close modal and reset form
                        bootstrap.Modal.getInstance(document.getElementById('addAchievementModal')).hide();
                        form.reset();
                        iconOptions.forEach(opt => opt.classList.remove('active'));
                    }
                });

                // Save Education
                document.getElementById('saveEducation').addEventListener('click', function() {
                    const form = document.querySelector('.education-form');
                    const degreeType = document.querySelector('.degree-option.active')?.getAttribute(
                        'data-degree');
                    const fieldOfStudy = form.querySelector('input[type="text"]').value;
                    const institution = form.querySelectorAll('input[type="text"]')[1].value;
                    const startDate = form.querySelector('input[type="month"]:first-child').value;
                    const endDate = form.querySelector('input[type="month"]:last-child').value;
                    const grade = form.querySelectorAll('input[type="text"]')[2].value;
                    const description = form.querySelector('textarea').value;

                    if (degreeType && fieldOfStudy && institution && startDate) {
                        const educationItem = document.createElement('div');
                        educationItem.className = 'education-item';
                        educationItem.innerHTML = `
                        <div class="education-header">
                            <div>
                                <div class="education-title">${degreeType.charAt(0).toUpperCase() + degreeType.slice(1)} in ${fieldOfStudy}</div>
                                <div class="education-subtitle">${institution} • ${startDate} - ${endDate || 'Present'}</div>
                                ${grade ? `<div class="education-grade">Grade: ${grade}</div>` : ''}
                                ${description ? `<p class="education-description">${description}</p>` : ''}
                            </div>
                            <div class="education-actions">
                                <button class="btn btn-profile outline">
                                    <i class="fas fa-edit"></i>Edit
                                </button>
                                <button class="btn btn-profile danger">
                                    <i class="fas fa-trash"></i>Delete
                                </button>
                            </div>
                        </div>
                    `;

                        document.querySelector('#education .profile-section').insertBefore(
                            educationItem,
                            document.querySelector('#education .btn-profile')
                        );

                        // Close modal and reset form
                        bootstrap.Modal.getInstance(document.getElementById('addEducationModal')).hide();
                        form.reset();
                        degreeOptions.forEach(opt => opt.classList.remove('active'));
                    }
                });

                // Tailor Measurements Form Handling
                const tailorForm = document.getElementById('tailorMeasurementsForm');
                if (tailorForm) {
                    tailorForm.addEventListener('submit', function(e) {
                        e.preventDefault();

                        // Collect all measurements
                        const measurements = {};
                        const inputs = this.querySelectorAll('input');
                        inputs.forEach(input => {
                            const label = input.previousElementSibling.textContent.trim();
                            measurements[label] = input.value;
                        });

                        // Here you would typically send the data to your server
                        console.log('Saving measurements:', measurements);

                        // Show success message
                        alert('Measurements saved successfully!');
                    });

                    // Height input special handling
                    const heightInput = tailorForm.querySelector('input[placeholder="Height"]');
                    if (heightInput) {
                        heightInput.addEventListener('input', function(e) {
                            // Allow only numbers, single quote, and double quote
                            this.value = this.value.replace(/[^0-9'"]/g, '');
                        });
                    }

                    // Add validation for numeric inputs
                    const numericInputs = tailorForm.querySelectorAll('input[type="number"]');
                    numericInputs.forEach(input => {
                        input.addEventListener('input', function() {
                            if (this.value < 0) {
                                this.value = 0;
                            }
                        });
                    });
                }
            });
        </script>
    @endsection
