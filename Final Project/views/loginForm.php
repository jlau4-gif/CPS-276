<?php
?>
<h2>Login</h2>

<?php if (isset($loginError)): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($loginError); ?></div>
<?php endif; ?>

<form method="POST" action="index.php?page=login" class="w-50">
    <div class="mb-3">
        <label class="form-label" for="email">Email</label>
        <input id="email" type="email" class="form-control" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : 'jalau@admin.com'; ?>" required>
    </div>
    <div class="mb-3">
        <label class="form-label" for="password">Password</label>
        <input id="password" type="password" class="form-control" name="password" value="<?php echo htmlspecialchars($presetPassword); ?>" required>
    </div>
    <button type="submit" name="login" class="btn btn-primary">Login</button>
</form>
