<h2 class="mb-4">Delete Contact(s)</h2>

<?php 
// Display error or success messages
if (!empty($msg)): ?>
    <div class="alert alert-info"><?php echo htmlspecialchars($msg); ?></div>
<?php endif; ?>

<form method="POST" action="index.php?page=deleteContacts">
    
    <div class="mb-3">
        <button type="submit" name="deleteSubmit" class="btn btn-danger">Delete</button>
    </div>

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Address</th>
                <th>City</th>
                <th>State</th>
                <th>Zip</th>
                <th>Phone</th>
                <th>Email</th>
                <th>DOB</th>
                <th>Contact</th>
                <th>Age</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
  
            if (!empty($contacts) && is_array($contacts)) {
                foreach ($contacts as $contact) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($contact['fname']) . "</td>";
                    echo "<td>" . htmlspecialchars($contact['lname']) . "</td>";
                    echo "<td>" . htmlspecialchars($contact['address']) . "</td>";
                    echo "<td>" . htmlspecialchars($contact['city']) . "</td>";
                    echo "<td>" . htmlspecialchars($contact['state']) . "</td>";
                    
                    echo "<td>" . htmlspecialchars($contact['zip'] ?? '') . "</td>"; 
                    
                    echo "<td>" . htmlspecialchars($contact['phone']) . "</td>";
                    echo "<td>" . htmlspecialchars($contact['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($contact['dob']) . "</td>";
                    
                    // Assuming contact options might be stored as a comma-separated string or array
                    $contactTypes = is_array($contact['contacts']) ? implode(',', $contact['contacts']) : $contact['contacts'];
                    echo "<td>" . htmlspecialchars($contactTypes) . "</td>";
                    
                    echo "<td>" . htmlspecialchars($contact['age']) . "</td>";
                    
                    // The Checkbox column for deletion
                    echo "<td><input type='checkbox' name='delete_ids[]' value='" . htmlspecialchars($contact['id']) . "'></td>";
                    echo "</tr>";
                }
            } else {
                // Displays if the database is empty
                echo "<tr><td colspan='12'>There are no records to display.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</form>
