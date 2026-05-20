<head>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📚</text></svg>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.css') }}">
    
    <style>
        /* Custom Kremowy / Beige Theme Overrides for Bootstrap 5 */
        [data-bs-theme="beige"] {
            --bs-body-bg: #f5eedc;
            --bs-body-bg-rgb: 245, 238, 220;
            --bs-body-color: #3d2c1f;
            --bs-body-color-rgb: 61, 44, 31;
            
            --bs-primary: #c2593f;
            --bs-primary-rgb: 194, 89, 63;
            --bs-primary-border-subtle: #e6d8c3;
            --bs-primary-bg-subtle: #eae1cd;
            
            --bs-secondary-color: #705c4d;
            --bs-secondary-bg: #fdfaf2;
            --bs-secondary-bg-rgb: 253, 250, 242;
            
            --bs-tertiary-bg: #eae1cd;
            --bs-tertiary-bg-rgb: 234, 225, 205;
            
            --bs-border-color: #e6d8c3;
            --bs-border-color-translucent: rgba(61, 44, 31, 0.15);
            
            --bs-link-color: #c2593f;
            --bs-link-hover-color: #a6462e;
            
            --bs-heading-color: #3d2c1f;
            
            --bs-navbar-color: #705c4d;
            --bs-navbar-hover-color: #3d2c1f;
            --bs-navbar-active-color: #3d2c1f;
            --bs-navbar-brand-color: #3d2c1f;
            --bs-navbar-brand-hover-color: #c2593f;
            
            --bs-card-bg: #fdfaf2;
            --bs-card-border-color: #e6d8c3;
            --bs-card-cap-bg: #eae1cd;
            
            --bs-list-group-bg: #fdfaf2;
            --bs-list-group-border-color: #e6d8c3;
            --bs-list-group-action-hover-bg: #eae1cd;
            
            --bs-btn-primary-bg: #c2593f;
            --bs-btn-primary-border-color: #c2593f;
            --bs-btn-primary-hover-bg: #a6462e;
            --bs-btn-primary-hover-border-color: #a6462e;
            --bs-btn-primary-active-bg: #8b3a24;
            
            --bs-nav-tabs-border-color: #e6d8c3;
            --bs-nav-tabs-link-hover-border-color: #e6d8c3 #e6d8c3 transparent;
            --bs-nav-tabs-link-active-color: #3d2c1f;
            --bs-nav-tabs-link-active-bg: #f5eedc;
            --bs-nav-tabs-link-active-border-color: #e6d8c3 #e6d8c3 #f5eedc;
            
            /* Status badges for Beige theme */
            --bs-success-bg-subtle: #d7e8d5;
            --bs-success-border-subtle: #b1d0ad;
            --bs-success-text-emphasis: #3c6e47;
            
            --bs-warning-bg-subtle: #f3dfb6;
            --bs-warning-border-subtle: #e6c589;
            --bs-warning-text-emphasis: #8e5c1e;
            
            --bs-danger-bg-subtle: #f5cfcf;
            --bs-danger-border-subtle: #e99e9e;
            --bs-danger-text-emphasis: #a13d3d;
        }

        /* Smooth transition for modern aesthetics when switching themes */
        html, body, .card, .navbar, .nav-link, .btn, .form-control, .form-select, .accordion-item, .accordion-button {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        }
    </style>
    <script src="{{ asset('js/theme.js') }}"></script>
    <script defer src="{{ asset('js/bootstrap.bundle.js') }}"></script>
    <script defer src="{{ asset('js/toast.js') }}"></script>
</head>
