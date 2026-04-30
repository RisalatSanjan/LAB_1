<div class="form-box">
    <h1>Create Account</h1>

    <?php if (!empty($errors["general"])): ?>
        <div class="alert error">
            <?= htmlspecialchars($errors["general"]) ?>
        </div>
    <?php endif; ?>

    <form action="index.php?page=signup" method="POST" novalidate>

        <div class="form-group">
            <label>Name</label>
            <input 
                type="text" 
                name="name" 
                value="<?= htmlspecialchars($name ?? "") ?>"
                placeholder="Enter your name"
            >

            <?php if (!empty($errors["name"])): ?>
                <small class="error-text">
                    <?= htmlspecialchars($errors["name"]) ?>
                </small>
            <?php endif; ?>
        </div>

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

        <div class="form-group">
            <label>Confirm Password</label>
            <input 
                type="password" 
                name="confirm_password"
                placeholder="Confirm your password"
            >

            <?php if (!empty($errors["confirm_password"])): ?>
                <small class="error-text">
                    <?= htmlspecialchars($errors["confirm_password"]) ?>
                </small>
            <?php endif; ?>
        </div>

        <button type="submit">Sign Up</button>

        <p class="link-text">
            Already have an account?
            <a href="index.php?page=signin">Sign In</a>
        </p>

    </form>
</div>