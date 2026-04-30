<div class="dashboard">
    <h1>Welcome, <?= htmlspecialchars($_SESSION["user_name"]) ?></h1>

    <p>You are successfully logged in.</p>

    <div class="card">
        <h3>User Information</h3>

        <p>
            <strong>User ID:</strong>
            <?= htmlspecialchars($_SESSION["user_id"]) ?>
        </p>

        <p>
            <strong>Name:</strong>
            <?= htmlspecialchars($_SESSION["user_name"]) ?>
        </p>

        <p>
            <strong>Email:</strong>
            <?= htmlspecialchars($_SESSION["user_email"]) ?>
        </p>
    </div>

    <a class="logout-btn" href="index.php?page=logout">Logout</a>
</div>