<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title ?? "Auth System") ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <div class="container nav-content">
        <h2>Authentication System</h2>

        <div>
            <?php if (isset($_SESSION["user_id"])): ?>
                <a href="index.php?page=dashboard">Dashboard</a>
                <a href="index.php?page=logout">Logout</a>
            <?php else: ?>
                <a href="index.php?page=signup">Sign Up</a>
                <a href="index.php?page=signin">Sign In</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container">

    <?php require "view/" . $viewName . ".php"; ?>

</div>

</body>
</html>