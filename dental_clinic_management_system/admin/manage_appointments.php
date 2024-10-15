<?php
session_start();
require_once '../config/db_config.php'; // Ensure this includes the connection code

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../views/login.php');
    exit();
}

$stmt = $conn->query('SELECT a.appointment_id, p.first_name, p.last_name, a.appointment_date, s.service_name, a.status
                     FROM appointments a
                     JOIN patients p ON a.patient_id = p.patient_id
                     JOIN services s ON a.service_id = s.service_id');

if (!$stmt) {
    die("Error fetching appointments: " . implode(", ", $conn->errorInfo()));
}

$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments - Dental Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include '../admin/includes/header.php'; ?> 
    
    <div class="container mt-5">
        <h3>Appointments</h3>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo strpos($_SESSION['message'], 'successfully') !== false ? 'success' : 'danger'; ?>">
                <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Patient Name</th>
                    <th>Appointment Date</th>
                    <th>Service</th>
                    <th>Status</th> 
                    <th>Action</th> 
                </tr>
            </thead>
            <tbody>
                <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($appointment['appointment_id']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['first_name'] . ' ' . $appointment['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['service_name']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['status']); ?></td> <!-- Display the status -->
                        <td>
                            <a href="mark_done.php?id=<?php echo $appointment['appointment_id']; ?>" class="btn btn-success btn-sm">Done</a>
                            <a href="mark_postponed.php?id=<?php echo $appointment['appointment_id']; ?>" class="btn btn-warning btn-sm">Postponed</a>
                            <a href="mark_followup.php?id=<?php echo $appointment['appointment_id']; ?>" class="btn btn-info btn-sm">Follow Up</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
