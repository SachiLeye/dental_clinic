<?php
include 'includes/header.php';
include '../config/db_config.php'; // Make sure to include your database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve input values
    $inputUsername = $_POST['username'];
    $inputPassword = $_POST['password'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $inputUsername); // Bind the parameter
    $stmt->execute();
    
    // Check if the user exists
    if ($stmt->rowCount() > 0) {
        // Fetch the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verify the password (assuming passwords are hashed)
        if (password_verify($inputPassword, $user['password'])) {
            // Set the session variable for the logged-in user
            $_SESSION['username'] = $user['username'];
            
            // Debugging output
            echo "<script>console.log('Login successful: " . $_SESSION['username'] . "');</script>";
            
            // Redirect to the home page
            header("Location: index.php");
            exit();
        } else {
            $loginError = "Invalid username or password.";
        }
    } else {
        $loginError = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Dental Clinic Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet"> <!-- Custom CSS -->
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h3>Login</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($loginError)): ?>
                            <div class="alert alert-danger"><?php echo $loginError; ?></div>
                        <?php endif; ?>
                        <form action="login.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <small>Don't have an account? <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Register here</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Registration -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Register</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="register_user.php" method="POST" id="registerForm">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="registerUsername" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="registerEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="registerPassword" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="registerConfirmPassword" name="confirm_password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Optional: Reload the page after registration
        document.getElementById('registerForm').onsubmit = function() {
            setTimeout(function() {
                window.location.reload();
            }, 1000); // Wait for 1 second to reload
        };
    </script>
</body>
</html>

<?php include 'includes/footer.php'; ?>
