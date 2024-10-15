<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session if it's not already started
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dental Clinic Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet"> <!-- Custom CSS -->
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="../views/index.php">Gayoso Dental Clinic</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../admin/report.php">Charts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user.php">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_appointments.php">Appointments</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light" href="#" data-bs-toggle="modal" data-bs-target="#logoutConfirmation">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light" href="../views/login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light" href="../admin/login.php">Admin</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutConfirmation" tabindex="-1" aria-labelledby="logoutConfirmationLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutConfirmationLabel">Confirm Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to log out?
                </div>
                <div class="modal-footer">
                    <form action="logout.php" method="POST">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <!-- Main content goes here -->
