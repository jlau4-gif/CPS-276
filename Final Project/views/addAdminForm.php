<?php
// views/addAdminForm.php
?>
<?php if (!empty($msg)): ?>
    <p class="text-dark mb-3"><?php echo htmlspecialchars($msg); ?></p>
<?php endif; ?>

<h2 class="mb-4">Add Administrator</h2>

<form method="POST" action="index.php?page=addAdmin">
    <input type="hidden" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label" for="fname">First Name</label>
            <input id="fname" type="text" class="form-control" name="fname" value="<?php echo isset($_POST['fname']) ? htmlspecialchars($_POST['fname']) : 'Jacob'; ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label" for="lname">Last Name</label>
            <input id="lname" type="text" class="form-control" name="lname" value="<?php echo isset($_POST['lname']) ? htmlspecialchars($_POST['lname']) : 'Lau'; ?>">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label" for="email">Email</label>
            <input id="email" type="text" class="form-control" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : 'jalau@admin.com'; ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label" for="password">Password</label>
            <input id="password" type="text" class="form-control" name="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : 'password'; ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label" for="status">Status</label>
            <select id="status" class="form-select" name="status">
                <option value="" <?php echo empty($_POST['status']) ? 'selected' : ''; ?>>Please Select a Status</option>
                <option value="staff" <?php echo (isset($_POST['status']) && $_POST['status'] === 'staff') ? 'selected' : ''; ?>>Staff</option>
                <option value="admin" <?php echo (isset($_POST['status']) && $_POST['status'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
            </select>
        </div>
    </div>

    <button type="submit" name="submitAdmin" class="btn btn-primary">Add Admin</button>
</form>
