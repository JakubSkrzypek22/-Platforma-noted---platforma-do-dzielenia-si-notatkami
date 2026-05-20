<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Notet — Drugie Życie Twoich Notatek 📚</title>

    <!-- Google Fonts: Plus Jakarta Sans & Playfair Display for premium look -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..700;1,400..700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS Design System & Theme Styles -->
    <style>
        :root {
            --font-sans: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --font-serif: 'Playfair Display', Georgia, serif;
            --transition-speed: 0.3s;
            --border-radius-sm: 8px;
            --border-radius-md: 14px;
            --border-radius-lg: 20px;
        }

        /* LIGHT THEME */
        body.theme-light {
            --bg-main: #f8fafc;
            --bg-card: #ffffff;
            --bg-input: #f1f5f9;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --border: #e2e8f0;
            --accent: #4f46e5;
            --accent-hover: #4338ca;
            --accent-light: rgba(79, 70, 229, 0.08);
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
            --badge-pending-bg: #fef3c7;
            --badge-pending-text: #d97706;
            --badge-purchased-bg: #dcfce7;
            --badge-purchased-text: #15803d;
            --badge-returned-bg: #fee2e2;
            --badge-returned-text: #b91c1c;
            --gradient-start: #4f46e5;
            --gradient-end: #818cf8;
        }

        /* DARK THEME */
        body.theme-dark {
            --bg-main: #0b0f19;
            --bg-card: #151b2c;
            --bg-input: #1e293b;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --border: #1e293b;
            --accent: #818cf8;
            --accent-hover: #6366f1;
            --accent-light: rgba(129, 140, 248, 0.15);
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -2px rgba(0, 0, 0, 0.3);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.4), 0 8px 10px -6px rgba(0, 0, 0, 0.4);
            --badge-pending-bg: rgba(217, 119, 6, 0.2);
            --badge-pending-text: #fbbf24;
            --badge-purchased-bg: rgba(21, 128, 61, 0.2);
            --badge-purchased-text: #4ade80;
            --badge-returned-bg: rgba(185, 28, 28, 0.2);
            --badge-returned-text: #f87171;
            --gradient-start: #6366f1;
            --gradient-end: #ec4899;
        }

        /* CREAM / BEIGE THEME */
        body.theme-beige {
            --bg-main: #f5eedc;
            --bg-card: #fdfaf2;
            --bg-input: #eae1cd;
            --text-primary: #3d2c1f;
            --text-secondary: #705c4d;
            --border: #e6d8c3;
            --accent: #c2593f;
            --accent-hover: #a6462e;
            --accent-light: rgba(194, 89, 63, 0.12);
            --shadow: 0 4px 6px -1px rgba(61, 44, 31, 0.05), 0 2px 4px -2px rgba(61, 44, 31, 0.05);
            --shadow-lg: 0 10px 15px -3px rgba(61, 44, 31, 0.08), 0 4px 6px -4px rgba(61, 44, 31, 0.08);
            --badge-pending-bg: #f3dfb6;
            --badge-pending-text: #8e5c1e;
            --badge-purchased-bg: #d7e8d5;
            --badge-purchased-text: #3c6e47;
            --badge-returned-bg: #f5cfcf;
            --badge-returned-text: #a13d3d;
            --gradient-start: #c2593f;
            --gradient-end: #dd8068;
        }

        /* Global Defaults */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: var(--font-sans);
        }

        body {
            background-color: var(--bg-main);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: background-color var(--transition-speed) ease, color var(--transition-speed) ease, border-color var(--transition-speed) ease;
        }

        h1, h2, h3, h4, h5 {
            color: var(--text-primary);
            font-weight: 700;
        }

        p, span, li {
            color: var(--text-secondary);
        }

        input, textarea, select {
            background-color: var(--bg-input);
            color: var(--text-primary);
            border: 1px solid var(--border);
            border-radius: var(--border-radius-sm);
            padding: 10px 14px;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.2s ease;
        }

        input:focus, textarea:focus, select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-light);
        }

        button {
            cursor: pointer;
            border: none;
            background: none;
            font-family: var(--font-sans);
            transition: all 0.2s ease;
        }

        .container {
            width: 100%;
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 24px;
        }

        /* Glass Header Design */
        header {
            position: sticky;
            top: 0;
            z-index: 100;
            background-color: rgba(255, 255, 255, 0.01);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: 16px 0;
            transition: border-color var(--transition-speed) ease;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.5rem;
            font-weight: 800;
            text-decoration: none;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
        }

        .logo svg {
            width: 28px;
            height: 28px;
            stroke: var(--accent);
            fill: none;
        }

        .main-nav {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-tabs {
            display: flex;
            background-color: var(--bg-input);
            padding: 4px;
            border-radius: var(--border-radius-md);
            border: 1px solid var(--border);
        }

        .tab-btn {
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-secondary);
        }

        .tab-btn:hover {
            color: var(--text-primary);
        }

        .tab-btn.active {
            background-color: var(--bg-card);
            color: var(--text-primary);
            box-shadow: var(--shadow);
        }

        /* Laravel Auth Links Integration */
        .auth-links {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-left: 20px;
            padding-left: 20px;
            border-left: 1px solid var(--border);
        }

        .auth-link {
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: var(--border-radius-sm);
            color: var(--text-secondary);
            transition: all 0.2s ease;
        }

        .auth-link:hover {
            color: var(--text-primary);
        }

        .auth-btn-primary {
            background-color: var(--accent);
            color: white !important;
        }

        .auth-btn-primary:hover {
            background-color: var(--accent-hover);
        }

        /* Premium Theme Switcher UI */
        .theme-switcher-wrapper {
            position: relative;
        }

        .theme-switcher-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: var(--border-radius-md);
            border: 1px solid var(--border);
            background-color: var(--bg-card);
            color: var(--text-primary);
            font-size: 0.9rem;
            font-weight: 600;
            box-shadow: var(--shadow);
        }

        .theme-switcher-btn:hover {
            background-color: var(--bg-input);
        }

        .theme-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background-color: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--border-radius-md);
            box-shadow: var(--shadow-lg);
            width: 190px;
            padding: 6px;
            display: none;
            flex-direction: column;
            gap: 2px;
            z-index: 101;
            animation: slideIn 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .theme-dropdown.show {
            display: flex;
        }

        .theme-option {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px;
            border-radius: var(--border-radius-sm);
            font-size: 0.88rem;
            font-weight: 500;
            color: var(--text-secondary);
            text-align: left;
            width: 100%;
        }

        .theme-option:hover {
            background-color: var(--bg-input);
            color: var(--text-primary);
        }

        .theme-option.active {
            background-color: var(--accent-light);
            color: var(--accent);
            font-weight: 600;
        }

        .theme-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
        }

        /* Layout Main content */
        .main-wrapper {
            flex: 1;
            padding: 40px 0;
        }

        /* Animation Keyframes */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .page-content {
            display: none;
            animation: fadeIn 0.4s ease forwards;
        }

        .page-content.active {
            display: block;
        }

        /* Dashboard Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--border-radius-md);
            padding: 20px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all var(--transition-speed) ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .stat-info h4 {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
            margin-bottom: 6px;
        }

        .stat-info p {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-primary);
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--accent-light);
            color: var(--accent);
        }

        .stat-icon svg {
            width: 22px;
            height: 22px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
        }

        /* Note Manager Panel Grid */
        .manager-layout {
            display: grid;
            grid-template-columns: 360px 1fr;
            gap: 30px;
        }

        @media (max-width: 992px) {
            .manager-layout {
                grid-template-columns: 1fr;
            }
        }

        /* Left Panel - Sticky Form Card */
        .form-sticky-panel {
            position: sticky;
            top: 90px;
            height: fit-content;
        }

        .form-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--border-radius-lg);
            padding: 26px;
            box-shadow: var(--shadow);
            transition: all var(--transition-speed) ease;
        }

        .form-card h3 {
            font-size: 1.25rem;
            margin-bottom: 20px;
            border-bottom: 2px solid var(--border);
            padding-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-group {
            margin-bottom: 18px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-group label {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .btn-submit {
            background-color: var(--accent);
            color: white;
            padding: 12px;
            border-radius: var(--border-radius-sm);
            font-weight: 700;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            margin-top: 10px;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.15);
        }

        .btn-submit:hover {
            background-color: var(--accent-hover);
            transform: translateY(-1px);
        }

        .form-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-primary);
            user-select: none;
        }

        .form-checkbox input {
            cursor: pointer;
            width: 16px;
            height: 16px;
            accent-color: var(--accent);
        }

        /* Right Panel - Filters & Cards Grid */
        .notes-panel {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .filter-bar {
            background-color: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--border-radius-md);
            padding: 14px 20px;
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .search-wrapper {
            position: relative;
            flex: 1;
            min-width: 200px;
        }

        .search-wrapper input {
            width: 100%;
            padding-left: 36px;
        }

        .search-wrapper svg {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            stroke: var(--text-secondary);
            fill: none;
        }

        .filter-pills {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .filter-pill {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.82rem;
            font-weight: 600;
            border: 1px solid var(--border);
            background-color: var(--bg-input);
            color: var(--text-secondary);
        }

        .filter-pill:hover {
            color: var(--text-primary);
            border-color: var(--text-secondary);
        }

        .filter-pill.active {
            background-color: var(--accent);
            color: white;
            border-color: var(--accent);
        }

        /* Note Cards Grid */
        .notes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .empty-state {
            grid-column: 1 / -1;
            background-color: var(--bg-card);
            border: 2px dashed var(--border);
            border-radius: var(--border-radius-lg);
            padding: 60px 40px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 14px;
        }

        .empty-state svg {
            width: 50px;
            height: 50px;
            stroke: var(--text-secondary);
            fill: none;
            opacity: 0.5;
        }

        /* Premium Note Card Design */
        .note-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--border-radius-lg);
            padding: 22px;
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 240px;
            transition: all var(--transition-speed) ease;
            position: relative;
            overflow: hidden;
        }

        .note-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: var(--accent);
        }

        .note-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--gradient-start), var(--gradient-end));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .note-card:hover::before {
            opacity: 1;
        }

        .note-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 12px;
        }

        .note-title {
            font-size: 1.05rem;
            font-weight: 700;
            line-height: 1.4;
            color: var(--text-primary);
            word-break: break-word;
        }

        .favorite-btn {
            color: #ef4444;
            font-size: 1.3rem;
            transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .favorite-btn:hover {
            transform: scale(1.2);
        }

        .favorite-btn svg {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
        }

        .favorite-btn.active svg {
            fill: currentColor;
        }

        .note-body {
            font-size: 0.9rem;
            line-height: 1.5;
            color: var(--text-secondary);
            margin-bottom: 20px;
            flex-grow: 1;
            word-break: break-word;
        }

        .note-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid var(--border);
            padding-top: 14px;
            margin-top: 10px;
        }

        .price-tag {
            display: flex;
            align-items: center;
            gap: 4px;
            font-weight: 700;
            font-size: 1.05rem;
            color: var(--text-primary);
        }

        .price-tag svg {
            width: 16px;
            height: 16px;
            stroke: #d97706;
            fill: none;
        }

        .status-badge {
            font-size: 0.76rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 12px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .status-badge.pending {
            background-color: var(--badge-pending-bg);
            color: var(--badge-pending-text);
        }

        .status-badge.purchased {
            background-color: var(--badge-purchased-bg);
            color: var(--badge-purchased-text);
        }

        .status-badge.returned {
            background-color: var(--badge-returned-bg);
            color: var(--badge-returned-text);
        }

        .card-actions {
            display: flex;
            gap: 8px;
            margin-top: 12px;
            justify-content: flex-end;
        }

        .btn-action {
            padding: 6px 10px;
            border-radius: var(--border-radius-sm);
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            border: 1px solid var(--border);
        }

        .btn-action-edit {
            background-color: var(--bg-input);
            color: var(--text-primary);
        }

        .btn-action-edit:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        .btn-action-delete {
            background-color: rgba(239, 68, 68, 0.05);
            color: #ef4444;
            border-color: rgba(239, 68, 68, 0.15);
        }

        .btn-action-delete:hover {
            background-color: #ef4444;
            color: white;
            border-color: #ef4444;
        }

        /* Inline Edit Form in Card */
        .edit-form-wrapper {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 100%;
        }

        .edit-form-actions {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
            margin-top: 10px;
        }

        .btn-save {
            background-color: var(--accent);
            color: white;
            padding: 6px 12px;
            border-radius: var(--border-radius-sm);
            font-size: 0.82rem;
            font-weight: 700;
        }

        .btn-cancel {
            background-color: var(--bg-input);
            color: var(--text-secondary);
            padding: 6px 12px;
            border-radius: var(--border-radius-sm);
            font-size: 0.82rem;
            font-weight: 600;
            border: 1px solid var(--border);
        }

        /* IDEA STRONY - Premium Editorial Layout */
        .editorial-wrapper {
            max-width: 820px;
            margin: 0 auto;
            animation: fadeIn 0.4s ease forwards;
        }

        .editorial-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .editorial-tag {
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 12px;
            display: inline-block;
        }

        .editorial-title {
            font-family: var(--font-serif);
            font-size: 2.8rem;
            font-weight: 800;
            line-height: 1.15;
            color: var(--text-primary);
            margin-bottom: 24px;
            letter-spacing: -1px;
        }

        .editorial-quote {
            font-family: var(--font-serif);
            font-size: 1.35rem;
            font-style: italic;
            line-height: 1.6;
            color: var(--accent);
            border-left: 3px solid var(--accent);
            padding-left: 20px;
            margin: 30px 0;
            text-align: left;
        }

        .editorial-section {
            margin-bottom: 40px;
        }

        .editorial-subtitle {
            font-family: var(--font-serif);
            font-size: 1.65rem;
            font-weight: 700;
            margin-bottom: 16px;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border);
            padding-bottom: 8px;
        }

        .editorial-p {
            font-size: 1.05rem;
            line-height: 1.75;
            color: var(--text-secondary);
            margin-bottom: 22px;
            text-align: justify;
        }

        .editorial-p::first-letter {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .editorial-accent-box {
            background-color: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: var(--border-radius-lg);
            padding: 30px;
            margin: 35px 0;
            box-shadow: var(--shadow);
            position: relative;
        }

        .editorial-accent-box h5 {
            font-size: 1.1rem;
            margin-bottom: 10px;
            color: var(--text-primary);
        }

        /* Floating Info Footer */
        footer {
            margin-top: auto;
            border-top: 1px solid var(--border);
            background-color: var(--bg-card);
            padding: 24px 0;
            font-size: 0.88rem;
            text-align: center;
        }
    </style>
</head>
<body class="theme-system">

    <!-- Premium Sticky Header -->
    <header>
        <div class="container header-content">
            <!-- Brand Logo -->
            <a href="#" class="logo">
                <svg viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                </svg>
                <span>Notet</span>
            </a>

            <!-- Navigation & Tabs -->
            <div class="main-nav">
                <div class="nav-tabs">
                    <button class="tab-btn active" onclick="switchTab('manager')">📁 Panel Notatek</button>
                    <button class="tab-btn" onclick="switchTab('idea')">✨ Idea Platformy</button>
                </div>

                <!-- Theme Switcher -->
                <div class="theme-switcher-wrapper">
                    <button class="theme-switcher-btn" id="theme-switcher-toggle" onclick="toggleThemeDropdown()">
                        <span id="active-theme-icon">💻</span>
                        <span id="active-theme-text">Motyw</span>
                    </button>
                    <div class="theme-dropdown" id="theme-switcher-dropdown">
                        <button class="theme-option" onclick="selectTheme('light')">
                            <span>☀️ Jasny</span>
                            <span class="theme-dot" style="background-color: #4f46e5;"></span>
                        </button>
                        <button class="theme-option" onclick="selectTheme('dark')">
                            <span>🌙 Ciemny</span>
                            <span class="theme-dot" style="background-color: #818cf8;"></span>
                        </button>
                        <button class="theme-option" onclick="selectTheme('beige')">
                            <span>🌾 Kremowy</span>
                            <span class="theme-dot" style="background-color: #c2593f;"></span>
                        </button>
                        <button class="theme-option active" onclick="selectTheme('system')">
                            <span>💻 Systemowy</span>
                            <span class="theme-dot" style="background-color: #94a3b8;"></span>
                        </button>
                    </div>
                </div>

                <!-- Laravel Integration Auth Links -->
                @if (Route::has('login'))
                <div class="auth-links">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="auth-link auth-btn-primary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="auth-link">Zaloguj</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="auth-link auth-btn-primary">Zarejestruj się</a>
                        @endif
                    @endauth
                </div>
                @endif
            </div>
        </div>
    </header>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <div class="container">

            <!-- PAGE CONTENT 1: NOTE MANAGER / BASKET (CRUD) -->
            <div id="content-manager" class="page-content active">
                
                <!-- Dashboard Stats Section -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-info">
                            <h4>Wszystkie Notatki</h4>
                            <p id="stats-total">0</p>
                        </div>
                        <div class="stat-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-info">
                            <h4>Ulubione</h4>
                            <p id="stats-favorites" style="color: #ef4444;">0</p>
                        </div>
                        <div class="stat-icon" style="background-color: rgba(239, 68, 68, 0.08); color: #ef4444;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-info">
                            <h4>W Trakcie Zakupu</h4>
                            <p id="stats-pending" style="color: #d97706;">0</p>
                        </div>
                        <div class="stat-icon" style="background-color: rgba(217, 119, 6, 0.08); color: #d97706;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-info">
                            <h4>Zakupione</h4>
                            <p id="stats-purchased" style="color: #15803d;">0</p>
                        </div>
                        <div class="stat-icon" style="background-color: rgba(21, 128, 61, 0.08); color: #15803d;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                    </div>
                </div>

                <!-- Main CRUD Grid Workspace -->
                <div class="manager-layout">
                    
                    <!-- Left: Floating Creation Panel -->
                    <div class="form-sticky-panel">
                        <div class="form-card">
                            <h3>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="stroke: var(--accent);"><path d="M12 5v14M5 12h14"/></svg>
                                Wystaw Nową Notatkę
                            </h3>
                            <form id="note-form" onsubmit="handleCreateNote(event)">
                                <div class="form-group">
                                    <label for="form-title">Tytuł Opracowania</label>
                                    <input type="text" id="form-title" placeholder="np. Analiza Matematyczna - Całki" required>
                                </div>
                                <div class="form-group">
                                    <label for="form-content">Treść / Opis Notatek</label>
                                    <textarea id="form-content" rows="4" placeholder="Opisz krótko zawartość, stopień szczegółowości i liczbę stron..." required></textarea>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="form-price">Cena (PLN)</label>
                                        <input type="number" id="form-price" step="0.01" min="0" placeholder="0.00" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="form-status">Status transakcji</label>
                                        <select id="form-status" required>
                                            <option value="w trakcie zakupu" selected>W trakcie zakupu</option>
                                            <option value="zakupione">Zakupione</option>
                                            <option value="zwrócone">Zwrócone</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" style="flex-direction: row; align-items: center; margin-top: 6px;">
                                    <label class="form-checkbox">
                                        <input type="checkbox" id="form-favorite">
                                        <span>Dodaj do ulubionych (❤️)</span>
                                    </label>
                                </div>
                                <button type="submit" class="btn-submit">
                                    <span>Dodaj do Menedżera</span>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Right: Search, Filter, and Note Grid -->
                    <div class="notes-panel">
                        <!-- Filters & Search Bar -->
                        <div class="filter-bar">
                            <div class="search-wrapper">
                                <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                <input type="text" id="search-input" placeholder="Wyszukaj po tytule lub treści..." oninput="renderNotes()">
                            </div>
                            <div class="filter-pills">
                                <button class="filter-pill active" id="pill-all" onclick="setFilter('all')">Wszystkie</button>
                                <button class="filter-pill" id="pill-pending" onclick="setFilter('w trakcie zakupu')">Oczekujące</button>
                                <button class="filter-pill" id="pill-purchased" onclick="setFilter('zakupione')">Zakupione</button>
                                <button class="filter-pill" id="pill-returned" onclick="setFilter('zwrócone')">Zwrócone</button>
                                <button class="filter-pill" id="pill-favorites" onclick="setFilter('favorites')">❤️ Ulubione</button>
                            </div>
                        </div>

                        <!-- Notes Grid Dynamic Area -->
                        <div class="notes-grid" id="notes-container">
                            <!-- Populated dynamically via JS -->
                        </div>
                    </div>
                </div>

            </div>

            <!-- PAGE CONTENT 2: IDEA PLATFORMY (BOGATY CONTENT) -->
            <div id="content-idea" class="page-content">
                <div class="editorial-wrapper">
                    <div class="editorial-header">
                        <span class="editorial-tag">Wizja & Filozofia Notet</span>
                        <h2 class="editorial-title">Ekosystem Cyfrowej Synergii Poznawczej</h2>
                        <p class="editorial-p" style="font-size: 1.15rem; text-align: center; color: var(--text-primary); font-family: var(--font-serif); font-style: italic;">
                            "Notet nie powstał jako prosta baza danych. Został powołany do życia jako nowoczesny organizm wspierający niezakłócony transfer wiedzy w świecie akademickim."
                        </p>
                    </div>

                    <div class="editorial-section">
                        <h3 class="editorial-subtitle">Wstęp: Nowa Era Współdzielenia Intelektualnego</h3>
                        <p class="editorial-p">
                            W tradycyjnym modelu edukacyjnym ogromny zasób wiedzy ulega rozproszeniu. Skrupulatnie spisywane wykłady, precyzyjnie kreślone schematy i autorskie opracowania, które kosztowały studentów setki godzin wytężonej pracy intelektualnej, po zdanym egzaminie lądują na dnie zapomnianych archiwów cyfrowych lub w koszu. To niewybaczalna strata zasobów poznawczych. 
                        </p>
                        <p class="editorial-p">
                            Platforma Notet definiuje to zjawisko na nowo. Tworzymy otwarty, cyfrowy rynek wymiany wartości intelektualnych, wzorowany na dynamicznych modelach gospodarki obiegu zamkniętego (ang. <i>circular economy</i>). Dajemy drugie życie notatkom, pozwalając ich autorom na uczciwą monetyzację wysiłku, a odbiorcom – na oszczędność cennego czasu i natychmiastowy dostęp do sprawdzonych, rzetelnych syntez naukowych.
                        </p>
                    </div>

                    <div class="editorial-quote">
                        „Czas jest najcenniejszym kapitałem w procesie zdobywania wiedzy. Optymalizacja procesu nauki poprzez selekcję najlepszych materiałów dydaktycznych to fundamentalne założenie współczesnej pedagogiki.”
                    </div>

                    <div class="editorial-section">
                        <h3 class="editorial-subtitle">Demokratyzacja Poznawcza i Decentralizacja Wiedzy</h3>
                        <p class="editorial-p">
                            Nasza filozofia opiera się na pełnej autonomii poznawczej i decentralizacji. Zamiast sztywnego, odgórnego narzucania materiałów dydaktycznych, Notet stawia na dynamiczny, zdecentralizowany mechanizm oceny społecznościowej. To studenci sami określają, które materiały niosą ze sobą najwyższą wartość edukacyjną. Poprzez zaawansowane systemy recenzowania, oceny w postaci gwiazdek i konstruktywną krytykę, naturalnie selekcjonujemy i promujemy dzieła wybitne.
                        </p>
                        <p class="editorial-p">
                            Dzięki takiemu podejściu eliminujemy chaos informacyjny i chronimy studentów przed niepełnymi lub wprowadzającymi w błąd opracowaniami. Każde udostępnienie pliku staje się nowym punktem wyjścia do głębszej dyskusji wewnątrz społeczności.
                        </p>
                    </div>

                    <div class="editorial-accent-box">
                        <h5>🛡️ Trzy Filary Naszej Architektury Intelektualnej</h5>
                        <p class="editorial-p" style="font-size: 0.95rem; margin-bottom: 0;">
                            <b>1. Uczciwy Ekosystem Mikroekonomiczny:</b> Twórcy otrzymują bezpośrednie i przejrzyste wynagrodzenie za swoją sumienną pracę akademicką.<br><br>
                            <b>2. Czysta Weryfikacja Jakościowa:</b> System społecznych rekomendacji i recenzji rygorystycznie sortuje materiały pod kątem ich kompletności naukowej.<br><br>
                            <b>3. Innowacyjna Dostępność:</b> Minimalistyczny, wysoce intuicyjny design, który sprowadza barierę technologiczną do zera.
                        </p>
                    </div>

                    <div class="editorial-section">
                        <h3 class="editorial-subtitle">Rozwój Technologiczny w Zgodzie z Intuicją</h3>
                        <p class="editorial-p">
                            Wdrażanie zaawansowanych algorytmów wyszukiwania, inteligentnej taksonomii przedmiotowej oraz mechanizmów ułatwiających szybką nawigację to nasz absolutny priorytet. Dbamy o to, aby technologia nigdy nie przesłaniała samej esencji nauki, a stanowiła dla niej przezroczysty, bezbłędnie działający fundament.
                        </p>
                        <p class="editorial-p">
                            Projektując interfejs Notet, zaaplikowaliśmy innowacyjne zasady psychologii poznawczej. Wykorzystanie zharmonizowanych palet barwnych i płynnych przejść tonalnych stymuluje skupienie oraz odpręża wzrok podczas długich sesji analitycznych przed monitorami. To właśnie ta głęboka dbałość o detal czyni naszą platformę unikalną.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2026 Notet. Stworzone z pasją dla maksymalnej efektywności naukowej studentów. 🎓</p>
        </div>
    </footer>

    <!-- JavaScript logic (Theme Switcher, Tabs, Full CRUD Reactivity, LocalStorage) -->
    <script>
        // --- 1. THEME SWITCHER LOGIC ---
        let currentTheme = 'system';

        // Load theme from LocalStorage if exists
        if (localStorage.getItem('notet-theme')) {
            currentTheme = localStorage.getItem('notet-theme');
        }

        function applyTheme(theme) {
            const body = document.body;
            // Clear current theme classes
            body.classList.remove('theme-light', 'theme-dark', 'theme-beige');

            if (theme === 'system') {
                body.classList.add('theme-system');
                applySystemTheme();
                document.getElementById('active-theme-icon').innerText = '💻';
                document.getElementById('active-theme-text').innerText = 'Systemowy';
            } else if (theme === 'light') {
                body.classList.remove('theme-system');
                body.classList.add('theme-light');
                document.getElementById('active-theme-icon').innerText = '☀️';
                document.getElementById('active-theme-text').innerText = 'Jasny';
            } else if (theme === 'dark') {
                body.classList.remove('theme-system');
                body.classList.add('theme-dark');
                document.getElementById('active-theme-icon').innerText = '🌙';
                document.getElementById('active-theme-text').innerText = 'Ciemny';
            } else if (theme === 'beige') {
                body.classList.remove('theme-system');
                body.classList.add('theme-beige');
                document.getElementById('active-theme-icon').innerText = '🌾';
                document.getElementById('active-theme-text').innerText = 'Kremowy';
            }

            // Update Active class in dropdown
            const options = document.querySelectorAll('.theme-option');
            options.forEach(opt => {
                opt.classList.remove('active');
                if (opt.getAttribute('onclick').includes(theme)) {
                    opt.classList.add('active');
                }
            });
        }

        function applySystemTheme() {
            const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const body = document.body;
            body.classList.remove('theme-light', 'theme-dark', 'theme-beige');
            if (isDark) {
                body.classList.add('theme-dark');
            } else {
                body.classList.add('theme-light');
            }
        }

        // Listen for system theme changes dynamically
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
            if (currentTheme === 'system') {
                applySystemTheme();
            }
        });

        function selectTheme(theme) {
            currentTheme = theme;
            localStorage.setItem('notet-theme', theme);
            applyTheme(theme);
            toggleThemeDropdown(); // close dropdown
        }

        function toggleThemeDropdown() {
            const dropdown = document.getElementById('theme-switcher-dropdown');
            dropdown.classList.toggle('show');
        }

        // Close theme dropdown when clicking outside
        window.addEventListener('click', function(e) {
            const btn = document.getElementById('theme-switcher-toggle');
            const dropdown = document.getElementById('theme-switcher-dropdown');
            if (btn && dropdown && !btn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Initialize theme on load
        applyTheme(currentTheme);


        // --- 2. TABS MANAGEMENT LOGIC ---
        function switchTab(tabId) {
            // Update Tab Buttons UI
            const buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            
            // Find appropriate button and activate
            const activeBtn = Array.from(buttons).find(btn => btn.getAttribute('onclick').includes(tabId));
            if (activeBtn) activeBtn.classList.add('active');

            // Hide/Show Pages
            const pages = document.querySelectorAll('.page-content');
            pages.forEach(page => page.classList.remove('active'));
            
            document.getElementById(`content-${tabId}`).classList.add('active');
        }


        // --- 3. ADVANCED NOTES CRUD ENGINE ---
        // State initialized with 5 premium sample notes
        const defaultNotes = [
            {
                id: 1,
                title: "Analiza Matematyczna – Całki Oznaczone 📐",
                content: "Kompletne opracowanie twierdzeń i wzorów dotyczących całek oznaczonych wraz z przykładowymi zadaniami krok po kroku. Idealne przed nadchodzącym kolokwium!",
                price: 19.99,
                status: "zakupione",
                favorite: true
            },
            {
                id: 2,
                title: "Architektura Systemów Operacyjnych 💻",
                content: "Szczegółowe diagramy i przejrzyste omówienie zarządzania pamięcią RAM, algorytmów szeregowania procesora oraz mechanizmów synchronizacji procesów.",
                price: 24.50,
                status: "w trakcie zakupu",
                favorite: false
            },
            {
                id: 3,
                title: "Bazy Danych – Zaawansowany SQL 💾",
                content: "Kompendium wiedzy z optymalizacji zapytań SQL, działania indeksów B-Tree, transakcji ACID oraz zaawansowanych funkcji okna (Window Functions).",
                price: 14.99,
                status: "zakupione",
                favorite: true
            },
            {
                id: 4,
                title: "Wstęp do Sztucznej Inteligencji 🤖",
                content: "Przejrzyste i estetyczne notatki z podstaw sztucznych sieci neuronowych, funkcji aktywacji, wstecznej propagacji błędu oraz działania algorytmów genetycznych.",
                price: 29.99,
                status: "zwrócone",
                favorite: false
            },
            {
                id: 5,
                title: "Fizyka Klasyczna – Mechanika 🔬",
                content: "Podstawowe prawa dynamiki Newtona, zasada zachowania pędu oraz energii mechanicznej wraz z wyprowadzonymi dowodami matematycznymi i komentarzami z wykładu.",
                price: 9.99,
                status: "w trakcie zakupu",
                favorite: true
            }
        ];

        let notes = [];
        let activeFilter = 'all';
        let noteEditingId = null;

        // Load Notes from LocalStorage or Fallback to default
        if (localStorage.getItem('notet-notes')) {
            try {
                notes = JSON.parse(localStorage.getItem('notet-notes'));
            } catch (e) {
                notes = defaultNotes;
            }
        } else {
            notes = defaultNotes;
            saveNotesToStorage();
        }

        function saveNotesToStorage() {
            localStorage.setItem('notet-notes', JSON.stringify(notes));
        }

        // Stats Updates
        function updateStats() {
            document.getElementById('stats-total').innerText = notes.length;
            document.getElementById('stats-favorites').innerText = notes.filter(n => n.favorite).length;
            document.getElementById('stats-pending').innerText = notes.filter(n => n.status === 'w trakcie zakupu').length;
            document.getElementById('stats-purchased').innerText = notes.filter(n => n.status === 'zakupione').length;
        }

        // Filter Pills Handler
        function setFilter(filterType) {
            activeFilter = filterType;
            
            // Update UI filter classes
            const pills = document.querySelectorAll('.filter-pill');
            pills.forEach(pill => pill.classList.remove('active'));

            const filterMapping = {
                'all': 'pill-all',
                'w trakcie zakupu': 'pill-pending',
                'zakupione': 'pill-purchased',
                'zwrócone': 'pill-returned',
                'favorites': 'pill-favorites'
            };

            const activePill = document.getElementById(filterMapping[filterType]);
            if (activePill) activePill.classList.add('active');

            renderNotes();
        }

        // CREATE: Handle Form Submission
        function handleCreateNote(e) {
            e.preventDefault();
            
            const title = document.getElementById('form-title').value.trim();
            const content = document.getElementById('form-content').value.trim();
            const price = parseFloat(document.getElementById('form-price').value) || 0;
            const status = document.getElementById('form-status').value;
            const favorite = document.getElementById('form-favorite').checked;

            const newNote = {
                id: Date.now(), // Unique ID
                title,
                content,
                price,
                status,
                favorite
            };

            notes.unshift(newNote); // Put new note at the beginning
            saveNotesToStorage();
            updateStats();
            renderNotes();

            // Reset form
            document.getElementById('note-form').reset();
        }

        // DELETE: Remove Note
        function handleDeleteNote(id) {
            if (confirm("Czy na pewno chcesz usunąć to opracowanie z menedżera?")) {
                notes = notes.filter(n => n.id !== id);
                if (noteEditingId === id) noteEditingId = null;
                saveNotesToStorage();
                updateStats();
                renderNotes();
            }
        }

        // UPDATE: Toggle Favorite heart status
        function toggleFavorite(id, event) {
            event.stopPropagation();
            notes = notes.map(n => {
                if (n.id === id) {
                    return { ...n, favorite: !n.favorite };
                }
                return n;
            });
            saveNotesToStorage();
            updateStats();
            renderNotes();
        }

        // UPDATE: Inline Edit Triggers
        function startInlineEdit(id) {
            noteEditingId = id;
            renderNotes();
        }

        function cancelInlineEdit() {
            noteEditingId = null;
            renderNotes();
        }

        function saveInlineEdit(id) {
            const card = document.querySelector(`[data-card-id="${id}"]`);
            if (!card) return;

            const newTitle = card.querySelector('.edit-title-input').value.trim();
            const newContent = card.querySelector('.edit-content-input').value.trim();
            const newPrice = parseFloat(card.querySelector('.edit-price-input').value) || 0;
            const newStatus = card.querySelector('.edit-status-select').value;

            if (!newTitle || !newContent) {
                alert("Tytuł oraz treść nie mogą być puste!");
                return;
            }

            notes = notes.map(n => {
                if (n.id === id) {
                    return {
                        ...n,
                        title: newTitle,
                        content: newContent,
                        price: newPrice,
                        status: newStatus
                    };
                }
                return n;
            });

            noteEditingId = null;
            saveNotesToStorage();
            updateStats();
            renderNotes();
        }

        // UPDATE: Quick Status Change from card dropdown
        function handleQuickStatusChange(id, newStatus) {
            notes = notes.map(n => {
                if (n.id === id) {
                    return { ...n, status: newStatus };
                }
                return n;
            });
            saveNotesToStorage();
            updateStats();
            renderNotes();
        }

        // READ: Render dynamic note grid
        function renderNotes() {
            const container = document.getElementById('notes-container');
            container.innerHTML = '';

            const searchQuery = document.getElementById('search-input').value.toLowerCase().trim();

            // Filter & Search Logic
            let filteredNotes = notes.filter(n => {
                // Search filter
                const matchesSearch = n.title.toLowerCase().includes(searchQuery) || 
                                      n.content.toLowerCase().includes(searchQuery);
                
                if (!matchesSearch) return false;

                // Tab/Pill category filter
                if (activeFilter === 'all') return true;
                if (activeFilter === 'favorites') return n.favorite;
                return n.status === activeFilter;
            });

            // Empty State Handling
            if (filteredNotes.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                        </svg>
                        <h3>Brak pasujących notatek</h3>
                        <p>Nie odnaleźliśmy żadnych opracowań spełniających wybrane filtry. Spróbuj zmienić parametry wyszukiwania lub dodaj nową notatkę po lewej stronie!</p>
                    </div>
                `;
                return;
            }

            // Map and Append cards
            filteredNotes.forEach(note => {
                const isEditing = note.id === noteEditingId;
                const card = document.createElement('div');
                card.className = `note-card`;
                card.setAttribute('data-card-id', note.id);

                if (isEditing) {
                    // EDIT MODE RENDER
                    card.innerHTML = `
                        <div class="edit-form-wrapper">
                            <div class="form-group" style="margin-bottom: 8px;">
                                <label style="font-size: 0.75rem; font-weight: 700;">Tytuł Opracowania</label>
                                <input type="text" class="edit-title-input" value="${escapeHtml(note.title)}" required style="padding: 6px 10px; font-size: 0.88rem;">
                            </div>
                            <div class="form-group" style="margin-bottom: 8px;">
                                <label style="font-size: 0.75rem; font-weight: 700;">Treść</label>
                                <textarea class="edit-content-input" rows="3" required style="padding: 6px 10px; font-size: 0.88rem;">${escapeHtml(note.content)}</textarea>
                            </div>
                            <div class="form-row" style="margin-bottom: 4px;">
                                <div class="form-group">
                                    <label style="font-size: 0.75rem; font-weight: 700;">Cena (PLN)</label>
                                    <input type="number" class="edit-price-input" step="0.01" min="0" value="${note.price}" style="padding: 6px 10px; font-size: 0.88rem;">
                                </div>
                                <div class="form-group">
                                    <label style="font-size: 0.75rem; font-weight: 700;">Status</label>
                                    <select class="edit-status-select" style="padding: 6px 10px; font-size: 0.88rem;">
                                        <option value="w trakcie zakupu" ${note.status === 'w trakcie zakupu' ? 'selected' : ''}>W trakcie zakupu</option>
                                        <option value="zakupione" ${note.status === 'zakupione' ? 'selected' : ''}>Zakupione</option>
                                        <option value="zwrócone" ${note.status === 'zwrócone' ? 'selected' : ''}>Zwrócone</option>
                                    </select>
                                </div>
                            </div>
                            <div class="edit-form-actions">
                                <button class="btn-cancel" onclick="cancelInlineEdit()">Anuluj</button>
                                <button class="btn-save" onclick="saveInlineEdit(${note.id})">Zapisz</button>
                            </div>
                        </div>
                    `;
                } else {
                    // VIEW MODE RENDER
                    card.innerHTML = `
                        <div>
                            <div class="note-card-header">
                                <h4 class="note-title">${escapeHtml(note.title)}</h4>
                                <button class="favorite-btn ${note.favorite ? 'active' : ''}" onclick="toggleFavorite(${note.id}, event)" title="Ulubione">
                                    <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                </button>
                            </div>
                            <p class="note-body">${escapeHtml(note.content)}</p>
                        </div>
                        <div>
                            <div class="note-card-footer">
                                <div class="price-tag" title="Cena materiału">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="8"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                    <span>${note.price.toFixed(2)} PLN</span>
                                </div>
                                <select class="status-badge ${note.status === 'w trakcie zakupu' ? 'pending' : note.status === 'zakupione' ? 'purchased' : 'returned'}" 
                                        style="border: none; padding: 4px 8px; border-radius: 12px; font-weight:700; cursor:pointer;"
                                        onchange="handleQuickStatusChange(${note.id}, this.value)">
                                    <option value="w trakcie zakupu" ${note.status === 'w trakcie zakupu' ? 'selected' : ''}>Oczekuje</option>
                                    <option value="zakupione" ${note.status === 'zakupione' ? 'selected' : ''}>Kupiono</option>
                                    <option value="zwrócone" ${note.status === 'zwrócone' ? 'selected' : ''}>Zwrócono</option>
                                </select>
                            </div>
                            <div class="card-actions">
                                <button class="btn-action btn-action-edit" onclick="startInlineEdit(${note.id})">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 20h9M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                                    Edytuj
                                </button>
                                <button class="btn-action btn-action-delete" onclick="handleDeleteNote(${note.id})">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    Usuń
                                </button>
                            </div>
                        </div>
                    `;
                }

                container.appendChild(card);
            });
        }

        // HTML escaping utility
        function escapeHtml(str) {
            return str
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        // Initial rendering of CRUD dashboard
        updateStats();
        renderNotes();
    </script>
</body>
</html>
