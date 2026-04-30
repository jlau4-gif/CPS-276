<?php

$nav = '<nav class="navbar navbar-expand-lg navbar-light bg-white mb-4">
  <div class="container-fluid">
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-lg-0">
        <li class="nav-item"><a class="nav-link text-primary" href="index.php?page=addContact">Add Contact</a></li>
        <li class="nav-item"><a class="nav-link text-primary" href="index.php?page=deleteContacts">Delete Contact(s)</a></li>';

if (isset($_SESSION['status']) && $_SESSION['status'] === 'admin') {
    $nav .= '<li class="nav-item"><a class="nav-link text-primary" href="index.php?page=addAdmin">Add Admin</a></li>
        <li class="nav-item"><a class="nav-link text-primary" href="index.php?page=deleteAdmins">Delete Admin(s)</a></li>';
}

$nav .= '<li class="nav-item"><a class="nav-link text-primary" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>';
?>
