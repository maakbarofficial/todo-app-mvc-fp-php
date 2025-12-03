<h1>Register</h1>

<form action="<?= e(base_url('/register')) ?>" method="post" class="card">
    <label>
        Name
        <input type="text" name="name" required>
    </label>

    <label>
        Email
        <input type="email" name="email" required>
    </label>

    <label>
        Password
        <input type="password" name="password" required>
    </label>

    <label>
        Confirm Password
        <input type="password" name="password_confirm" required>
    </label>

    <button type="submit" class="btn">Register</button>

    <p>
        Already have an account?
        <a href="<?= e(base_url('/login')) ?>">Login</a>
    </p>
</form>