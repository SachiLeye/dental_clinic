<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include 'includes/header.php';
include '../config/db_config.php'; // Ensure this file contains the connection code

// Fetch available services for the dropdown
try {
    $serviceStmt = $conn->prepare("SELECT * FROM services");
    $serviceStmt->execute();
    $services = $serviceStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching services: " . $e->getMessage();
    exit();
}

// Get booked dates with the number of appointments
$bookedDates = [];
try {
    $dateStmt = $conn->prepare("SELECT appointment_date, COUNT(*) as count FROM appointments GROUP BY DATE(appointment_date)");
    $dateStmt->execute();
    $dates = $dateStmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($dates as $date) {
        if ($date['count'] >= 3) {
            $bookedDates[] = $date['appointment_date'];
        }
    }
} catch (PDOException $e) {
    echo "Error fetching appointment dates: " . $e->getMessage();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $appointmentDate = $_POST['appointment_date'];
    $serviceId = $_POST['service_id']; // Get selected service ID

    // Check if the selected date already has three appointments
    try {
        $checkStmt = $conn->prepare("SELECT COUNT(*) as count FROM appointments WHERE DATE(appointment_date) = DATE(?)");
        $checkStmt->execute([$appointmentDate]);
        $appointmentCount = $checkStmt->fetch(PDO::FETCH_ASSOC)['count'];

        if ($appointmentCount >= 3) {
            echo "<div class='alert alert-danger'>This date is fully booked. Please choose another date.</div>";
        } else {
            // Proceed with the booking
            $stmt = $conn->prepare("INSERT INTO patients (first_name, last_name, email, phone) VALUES (?, ?, ?, ?)");
            $stmt->execute([$firstName, $lastName, $email, $phone]);

            $patientId = $conn->lastInsertId();

            // Insert appointment with the selected service
            $stmt = $conn->prepare("INSERT INTO appointments (patient_id, appointment_date, service_id) VALUES (?, ?, ?)");
            $stmt->execute([$patientId, $appointmentDate, $serviceId]);

            echo "<div class='alert alert-success'>Appointment successfully booked!</div>";
        }
    } catch (PDOException $e) {
        echo "Error booking appointment: " . $e->getMessage();
    }
}
?>

<h2>Book an Appointment</h2>
<form method="POST">
    <div class="mb-3">
        <label for="first_name" class="form-label">First Name</label>
        <input type="text" class="form-control" id="first_name" name="first_name" required>
    </div>
    <div class="mb-3">
        <label for="last_name" class="form-label">Last Name</label>
        <input type="text" class="form-control" id="last_name" name="last_name" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email">
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" class="form-control" id="phone" name="phone" required>
    </div>
    <div class="mb-3">
        <label for="appointment_date" class="form-label">Appointment Date</label>
        <input type="datetime-local" class="form-control" id="appointment_date" name="appointment_date" required>
    </div>
    <div class="mb-3">
        <label for="service_id" class="form-label">Select Service</label>
        <select class="form-select" id="service_id" name="service_id" required>
            <option value="" disabled selected>Select a service</option>
            <?php foreach ($services as $service) : ?>
                <option value="<?= htmlspecialchars($service['service_id']); ?>"><?= htmlspecialchars($service['service_name']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Book Appointment</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bookedDates = <?= json_encode($bookedDates); ?>;
        const appointmentDateInput = document.getElementById('appointment_date');
        
        appointmentDateInput.addEventListener('change', function () {
            const selectedDate = new Date(this.value).toISOString().split('T')[0];
            if (bookedDates.includes(selectedDate)) {
                alert('This date is fully booked. Please choose another date.');
                this.value = '';
            }
        });
    });
</script>

<?php include 'includes/footer.php'; ?>
