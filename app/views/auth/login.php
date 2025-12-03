<h1>Login</h1>

<form action="<?= e(base_url('/login')) ?>" method="post" class="card">
    <label>
        Email
        <input type="email" name="email" required>
    </label>

    <label>
        Password
        <input type="password" name="password" required>
    </label>

    <button type="submit" class="btn">Login</button>

    <p>
        Don't have an account?
        <a href="<?= e(base_url('/register')) ?>">Register</a>
    </p>
</form>