<?php
?>
<h2 class="mb-4">Add Contact</h2>

<?php if (!empty($msg)): ?>
    <p class="text-dark mb-3"><?php echo htmlspecialchars($msg); ?></p>
<?php endif; ?>

<form method="POST" action="index.php?page=addContact">
    
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
        <div class="col-md-12">
            <label class="form-label" for="address">Address</label>
            <input id="address" type="text" class="form-control" name="address" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : '123 anywhere'; ?>">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label" for="city">City</label>
            <input id="city" type="text" class="form-control" name="city" value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : 'Somewhere'; ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label" for="state">State</label>
            <select id="state" class="form-select" name="state">
                <option value="MI" <?php echo (isset($_POST['state']) && $_POST['state'] === 'MI') ? 'selected' : ''; ?>>Michigan</option>
                <option value="OH" <?php echo (isset($_POST['state']) && $_POST['state'] === 'OH') ? 'selected' : ''; ?>>Ohio</option>
                <option value="IN" <?php echo (isset($_POST['state']) && $_POST['state'] === 'IN') ? 'selected' : ''; ?>>Indiana</option>
                <option value="IL" <?php echo (isset($_POST['state']) && $_POST['state'] === 'IL') ? 'selected' : ''; ?>>Illinois</option>
                <option value="WI" <?php echo (isset($_POST['state']) && $_POST['state'] === 'WI') ? 'selected' : ''; ?>>Wisconsin</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label" for="zip">Zip</label>
            <input id="zip" type="text" class="form-control" name="zip" value="<?php echo isset($_POST['zip']) ? htmlspecialchars($_POST['zip']) : '12345'; ?>">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label" for="phone">Phone</label>
            <input id="phone" type="text" class="form-control" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : '888.888.8888'; ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label" for="email">Email</label>
            <input id="email" type="text" class="form-control" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : 'jalau@wccnet.edu'; ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label" for="dob">Date of Birth</label>
            <input id="dob" type="text" class="form-control" name="dob" placeholder="mm/dd/yyyy" value="<?php echo isset($_POST['dob']) ? htmlspecialchars($_POST['dob']) : '08/08/1998'; ?>">
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label d-block">Choose an Age Range
            <?php if (!empty($ageError)): ?>
                <span class="text-danger ms-2"><?php echo htmlspecialchars($ageError); ?></span>
            <?php endif; ?>
        </label>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="age" value="0-17" <?php echo (isset($_POST['age']) && $_POST['age'] === '0-17') ? 'checked' : ''; ?>>
            <label class="form-check-label">0-17</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="age" value="18-30" <?php echo (isset($_POST['age']) && $_POST['age'] === '18-30') ? 'checked' : ''; ?>>
            <label class="form-check-label">18-30</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="age" value="30-50" <?php echo (isset($_POST['age']) && $_POST['age'] === '30-50') ? 'checked' : ''; ?>>
            <label class="form-check-label">30-50</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="age" value="50+" <?php echo (isset($_POST['age']) && $_POST['age'] === '50+') ? 'checked' : ''; ?>>
            <label class="form-check-label">50+</label>
        </div>
    </div>

    <div class="mb-4">
        <label class="form-label d-block">Select One or More Options</label>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="contacts[]" value="Newsletter" <?php echo (isset($_POST['contacts']) && in_array('Newsletter', $_POST['contacts'] ?? [])) ? 'checked' : ''; ?>>
            <label class="form-check-label">newsletter</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="contacts[]" value="Email Updates" <?php echo (isset($_POST['contacts']) && in_array('Email Updates', $_POST['contacts'] ?? [])) ? 'checked' : ''; ?>>
            <label class="form-check-label">email</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="contacts[]" value="Text Alerts" <?php echo (isset($_POST['contacts']) && in_array('Text Alerts', $_POST['contacts'] ?? [])) ? 'checked' : ''; ?>>
            <label class="form-check-label">text</label>
        </div>
    </div>

    <button type="submit" name="submitContact" class="btn btn-primary">Add Contact</button>
</form>
