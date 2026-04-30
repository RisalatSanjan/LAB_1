<div class="form-box">
    <h1>Sign In</h1>

    <?php if (!empty($_SESSION["success"])): ?>
        <div class="alert success">
            <?= htmlspecialchars($_SESSION["success"]) ?>
        </div>
        <?php unset($_SESSION["success"]); ?>
    <?php endif; ?>

    <?php if (!empty($errors["general"])): ?>
        <div class="alert error">
            <?= htmlspecialchars($errors["general"]) ?>
        </div>
    <?php endif; ?>

    <form action="index.php?page=signin" method="POST" novalidate>

        <div class="form-group">
            <label>Email</label>
            <input 
                type="email" 
                name="email" 
                value="<?= htmlspecialchars($email ?? "") ?>"
                placeholder="Enter your email"
            >

            <?php if (!empty($errors["email"])): ?>
                <small class="error-text">
                    <?= htmlspecialchars($errors["email"]) ?>
                </small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input 
                type="password" 
                name="password"
                placeholder="Enter your password"
            >

            <?php if (!empty($errors["password"])): ?>
                <small class="error-text">
                    <?= htmlspecialchars($errors["password"]) ?>
                </small>
            <?php endif; ?>
        </div>

        <button type="submit">Sign In</button>

        <p class="link-text">
            Do not have an account?
            <a href="index.php?page=signup">Sign Up</a>
        </p>

    </form>
</div>