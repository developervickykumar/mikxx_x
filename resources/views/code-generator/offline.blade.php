<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offline - Code Generator</title>
    <style>
        :root {
            --primary-color: #2563eb;
            --text-color: #1f2937;
            --bg-light: #f8fafc;
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
            background: var(--bg-light);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .offline-container {
            max-width: 600px;
            text-align: center;
            padding: 2rem;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .offline-icon {
            width: 64px;
            height: 64px;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        h1 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        p {
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        .retry-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--primary-color);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        .retry-button:hover {
            background: #1d4ed8;
        }

        .retry-button svg {
            width: 20px;
            height: 20px;
        }

        @media (max-width: 640px) {
            .offline-container {
                padding: 1.5rem;
            }

            h1 {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body>
    <div class="offline-container">
        <svg class="offline-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <h1>You're Offline</h1>
        <p>Please check your internet connection and try again.</p>
        <a href="/" class="retry-button">
            <svg viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
            </svg>
            Retry Connection
        </a>
    </div>

    <script>
        // Check connection status
        function checkConnection() {
            if (navigator.onLine) {
                window.location.href = '/';
            }
        }

        // Listen for online event
        window.addEventListener('online', checkConnection);

        // Check connection periodically
        setInterval(checkConnection, 5000);
    </script>
</body>
</html> 