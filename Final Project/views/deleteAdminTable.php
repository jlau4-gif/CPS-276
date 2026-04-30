<?php
?>
<h2 class="mb-3">Delete Admin(s)</h2>
<?php if (!empty($msg)): ?>
    <p class="text-dark mb-3"><?php echo htmlspecialchars($msg); ?></p>
<?php endif; ?>
<form method="POST" action="index.php?page=deleteAdmins">
    <div class="mb-3">
        <button type="submit" name="deleteSubmit" class="btn btn-danger">Delete</button>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($admins)): ?>
                <?php foreach ($admins as $admin): ?>
                    <?php
                        $nameParts = preg_split('/\s+/', trim((string)$admin['name']), 2);
                        $firstName = $nameParts[0] ?? '';
                        $lastName = $nameParts[1] ?? '';
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($firstName); ?></td>
                        <td><?php echo htmlspecialchars($lastName); ?></td>
                        <td><?php echo htmlspecialchars($admin['email']); ?></td>
                        <td><?php echo htmlspecialchars($admin['password'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($admin['status']); ?></td>
                        <td><input type="checkbox" name="delete_ids[]" value="<?php echo (int)$admin['id']; ?>"></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No admins found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</form>
