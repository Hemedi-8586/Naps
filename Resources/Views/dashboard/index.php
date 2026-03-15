<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'NAPS Portal' ?></title>

    <link rel="stylesheet" href="/naps/Public/Assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/naps/Public/Assets/bootstrap-icons-1.11.3/font/bootstrap-icons.css">
    
    <style>
    :root { 
        --sidebar-width: 260px; 
        --header-height: 70px; 
        --bg-color: #f8fafc;
        --card-bg: #ffffff;
        --header-bg: #ffffff;
        --text-color: #1e293b;
        --border-color: #e2e8f0;
    }
    [data-theme="dark"] {
        --bg-color: #121212;
        --card-bg: #1e1e1e;
        --header-bg: #181818;
        --text-color: #f8fafc;
        --border-color: #334155;
    }

    body { 
        background: var(--bg-color); 
        color: var(--text-color);
        margin: 0; display: flex; min-height: 100vh; overflow-x: hidden; 
    }

    .sidebar-container {
        width: var(--sidebar-width);
        position: fixed;
        height: 100vh;
        background: #0f172a; 
        z-index: 1050;
        left: 0; top: 0;
    }

    .main-wrapper { 
        margin-left: var(--sidebar-width); 
        width: calc(100% - var(--sidebar-width));
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    header {
        position: fixed;
        top: 0; right: 0;
        width: calc(100% - var(--sidebar-width));
        height: var(--header-height);
        background: var(--header-bg); 
        border-bottom: 1px solid var(--border-color);
        z-index: 1000;
    }

    .content-area { flex: 1; padding: 25px; margin-top: var(--header-height); }
    
    .card { background-color: var(--card-bg) !important; color: var(--text-color) !important; border-color: var(--border-color) !important; }
    .dashboard-footer { background: var(--header-bg); padding: 15px 25px; border-top: 1px solid var(--border-color); }
</style>
</head>
<body data-theme="<?= $user_settings['theme_preference'] ?>">

    <aside class="sidebar-container">
    <?php include __DIR__ . "/../layouts/partials/sidebar.php"; ?>
</aside>

    <div class="main-wrapper">
        <header>
    <?php include __DIR__ . "/../layouts/partials/header.php"; ?>
</header>
        <main class="content-area">
    <?php 
       
        $pageToLoad = $viewFile ?? 'home';
        if ($pageToLoad === 'index') {
            $pageToLoad = 'home';
        }

        $targetFile = APP_ROOT . "/Resources/Views/dashboard/pages/" . $pageToLoad . ".php";
        if (file_exists($targetFile)) {
            include $targetFile;
        } else {
            ?>
            <div class="container-fluid mt-4">
                <div class="alert alert-custom shadow-sm border-start border-4 border-danger bg-white p-4">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill text-danger fs-1 me-4"></i>
                        <div>
                            <h4 class="text-danger mb-1">Ukurasa Haupatikani!</h4>
                            <p class="text-muted mb-0">
                                Mfumo unajaribu kupata faili la <strong><?= htmlspecialchars($pageToLoad) ?>.php</strong> 
                                lakini halipo kwenye folder la <code>/dashboard/pages/</code>.
                            </p>
                        </div>
                    </div>
                    <hr>
                    <a href="/naps/dashboard/home" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-house-door me-1"></i> Rudi Nyumbani
                    </a>
                </div>
            </div>
            <?php
        }
    ?>
</main>

        <footer class="dashboard-footer">
            <?php include __DIR__ . "/../layouts/partials/footer.php"; ?>
       </footer>
    </div>

    <script src="/naps/Public/Assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>