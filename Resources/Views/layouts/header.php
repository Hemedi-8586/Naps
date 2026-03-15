<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'NAPS | Welcome'; ?></title>

   <link rel="stylesheet" href="/naps/Public/Assets/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="/naps/Public/Assets/bootstrap-icons-1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-blue: #0d6efd;
            --dark-navy: #061737;
            --navbar-height: 75px;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fcfcfd; }
        .navbar {
            height: var(--navbar-height);
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0,0,0,0.06);
        }
        .navbar-brand { font-size: 1.5rem; letter-spacing: -1px; }
        .nav-link {
            color: #4a5568 !important;
            font-weight: 500;
            padding: 0.5rem 1.2rem !important;
        }
        .nav-link:hover { color: var(--primary-blue) !important; }
        .btn-account {
            background-color: #f8f9fa;
            border: 1px solid #e2e8f0;
            color: var(--dark-navy);
            font-weight: 600;
            padding: 0.6rem 1.4rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        .btn-account:hover {
            background-color: var(--primary-blue);
            color: white;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
        }
        .dropdown-menu {
            border: none;
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            border-radius: 16px;
            padding: 10px;
            margin-top: 15px;
        }
        .dropdown-item {
            padding: 10px 15px;
            border-radius: 10px;
            font-weight: 500;
        }
        .dropdown-item:hover { background-color: #f0f4ff; color: var(--primary-blue); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="/naps/">
            <i class="bi bi-shield-shaded"></i>
            <span style="color: var(--dark-navy)">NAPS<span class="text-primary">.</span></span>
        </a>
        
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
            <i class="bi bi-list fs-1 text-dark"></i>
        </button>

        <div class="collapse navbar-collapse" id="navContent">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="/naps/">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="/naps/about">About</a></li>
                <li class="nav-item"><a class="nav-link" href="/naps/services">Services</a></li>
                <li class="nav-item"><a class="nav-link" href="/naps/contact">Contact</a></li>
            </ul>

            <ul class="navbar-nav align-items-center">
                <li class="nav-item dropdown">
                    <a class="btn-account text-decoration-none dropdown-toggle" href="#" id="accountDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle"></i>
                        My Account
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="accountDropdown">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="/naps/login">
                                <i class="bi bi-box-arrow-in-right me-2 text-primary"></i> Login
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="/naps/register">
                                <i class="bi bi-person-plus me-2 text-success"></i> Register
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="/naps/help">
                                <i class="bi bi-question-circle me-2"></i> Help Center
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>