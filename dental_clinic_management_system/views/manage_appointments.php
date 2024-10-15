<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'includes/header.php';
include '../config/db_config.php';

// Fetch the patient ID based on the logged-in username
$userStmt = $conn->prepare("SELECT patient_id FROM patients WHERE username = ?");
$userStmt->execute([$_SESSION['username']]);
$user = $userStmt->fetch(PDO::FETCH_ASSOC);

// If the patient ID is not found, show an error or handle it accordingly
if (!$user) {
    echo "Error: Unable to find the user.";
    exit();
}
$patientId = $user['patient_id'];

// Fetch appointments for the logged-in user with service names
$stmt = $conn->prepare("SELECT a.appointment_id, p.first_name, p.last_name, a.appointment_date, a.status, s.service_name 
                        FROM appointments a 
                        JOIN patients p ON a.patient_id = p.patient_id 
                        JOIN services s ON a.service_id = s.service_id 
                        WHERE a.patient_id = ? 
                        ORDER BY a.appointment_date DESC");
$stmt->execute([$patientId]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Update appointment status if action is performed
if (isset($_GET['action'], $_GET['id']) && in_array($_GET['action'], ['accept', 'decline'])) {
    $id = (int)$_GET['id'];
    $status = $_GET['action'] === 'accept' ? 'Approved' : 'Declined'; // Set status to "Approved" or "Declined"

    // Update the status in the database
    $updateStmt = $conn->prepare('UPDATE appointments SET status = ? WHERE appointment_id = ?');
    if ($updateStmt->execute([$status, $id])) {
        $_SESSION['message'] = 'Appointment status updated successfully.';
    } else {
        $_SESSION['message'] = 'Failed to update appointment status.';
    }

    header('Location: manage_appointments.php'); // Redirect to see the updated status
    exit();
}
?>

<h2>Manage Appointments</h2>

<!-- Display success/error message -->
<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-success">
        <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
    </div>
<?php endif; ?>

<table class="table">
    <thead>
        <tr>
            <th>Patient Name</th>
            <th>Appointment Date</th>
            <th>Service</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($appointments as $appointment) : ?>
            <tr>
                <td><?= htmlspecialchars($appointment['first_name'] . ' ' . $appointment['last_name']); ?></td>
                <td><?= htmlspecialchars($appointment['appointment_date']); ?></td>
                <td><?= htmlspecialchars($appointment['service_name']); ?></td>
                <td>
                    <?php
                    // Display the status
                    if ($appointment['status'] === 'Approved') {
                        echo '<span class="badge bg-success">Approved</span>';
                    } elseif ($appointment['status'] === 'Declined') {
                        echo '<span class="badge bg-danger">Declined</span>';
                    } else {
                        echo '<span class="badge bg-warning">Pending</span>';
                    }
                    ?>
                </td>
                <td>
                    <a href="edit_appointment.php?id=<?= htmlspecialchars($appointment['appointment_id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_appointment.php?id=<?= htmlspecialchars($appointment['appointment_id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this appointment?');">Delete</a>
                    <?php if ($appointment['status'] === 'Pending'): ?>
                        <a href="?action=accept&id=<?= htmlspecialchars($appointment['appointment_id']); ?>" class="btn btn-success btn-sm">Accept</a>
                        <a href="?action=decline&id=<?= htmlspecialchars($appointment['appointment_id']); ?>" class="btn btn-danger btn-sm">Decline</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include 'includes/footer.php'; ?>
