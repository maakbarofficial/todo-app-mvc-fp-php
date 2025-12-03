<?php
$success = get_flash('success');
$error   = get_flash('error');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Todo App</title>
    <link rel="stylesheet" href="<?= e(base_url('css/style.css')) ?>">
</head>

<body>
    <!-- Loader -->
<div id="loader">
  <div class="spinner"></div>
</div>
    <header class="top-bar">
        <div class="container flex-between">
            <div><a href="<?= e(base_url('/todos')) ?>" class="logo">TODO APP</a></div>
            <nav>
                <?php if (is_logged_in()): ?>
                    <span>Hi, <?= e($_SESSION['user_name'] ?? 'User') ?></span>
                    <form action="<?= e(base_url('/logout')) ?>" method="post" style="display:inline">
                        <button type="submit" class="btn btn-link">Logout</button>
                    </form>
                <?php else: ?>
                    <a href="<?= e(base_url('/login')) ?>">Login</a>
                    <a href="<?= e(base_url('/register')) ?>">Register</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <!-- Toaster container -->
    <div id="toast-container"></div>

    <main class="container">
        <?php
        // The main view:
        if (isset($viewPath) && file_exists($viewPath)) {
            include $viewPath;
        }
        ?>
    </main>

    <script>
        window.APP_FLASH = {
            success: <?= json_encode($success) ?>,
            error: <?= json_encode($error) ?>
        };
    </script>
    <script src="<?= e(base_url('js/app.js')) ?>"></script>
</body>

</html>