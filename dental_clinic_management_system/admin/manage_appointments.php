<?php
session_start();
require_once '../config/db_config.php'; // Ensure this includes the connection code

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../views/login.php');
    exit();
}

// Initialize search variables
$search_patient = isset($_POST['search_patient']) ? $_POST['search_patient'] : '';
$search_service = isset($_POST['search_service']) ? $_POST['search_service'] : '';
$search_status = isset($_POST['search_status']) ? $_POST['search_status'] : '';

// Build the base SQL query
$sql = "SELECT a.appointment_id, p.first_name, p.last_name, a.appointment_date, s.service_name, a.status
        FROM appointments a
        JOIN patients p ON a.patient_id = p.patient_id
        JOIN services s ON a.service_id = s.service_id
        WHERE 1=1"; // Start with a true condition for appending more conditions

// Add conditions based on search inputs
if (!empty($search_patient)) {
    $sql .= " AND (p.first_name LIKE :patient_name OR p.last_name LIKE :patient_name)";
}
if (!empty($search_service)) {
    $sql .= " AND s.service_name LIKE :service_name";
}
if (!empty($search_status)) {
    $sql .= " AND a.status LIKE :status";
}

$sql .= " ORDER BY a.appointment_date ASC"; // Adjust the order as needed

$query = $conn->prepare($sql); // Prepare the SQL statement

// Bind parameters if they are set
if (!empty($search_patient)) {
    $patient_name = "%" . $search_patient . "%"; // Wildcard search for patient name
    $query->bindParam(':patient_name', $patient_name);
}
if (!empty($search_service)) {
    $service_name = "%" . $search_service . "%"; // Wildcard search for service name
    $query->bindParam(':service_name', $service_name);
}
if (!empty($search_status)) {
    $status = "%" . $search_status . "%"; // Wildcard search for status
    $query->bindParam(':status', $status);
}

$query->execute(); // Execute the query

$appointments = $query->fetchAll(PDO::FETCH_ASSOC); // Fetch all results
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

        <!-- Search Form -->
        <form method="POST" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search_patient" class="form-control" placeholder="Search by Patient Name" value="<?php echo htmlspecialchars($search_patient); ?>">
                </div>
                <div class="col-md-4">
                    <input type="text" name="search_service" class="form-control" placeholder="Search by Service" value="<?php echo htmlspecialchars($search_service); ?>">
                </div>
                <div class="col-md-4">
                    <input type="text" name="search_status" class="form-control" placeholder="Search by Status" value="<?php echo htmlspecialchars($search_status); ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <!-- Display appointments -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Patient Name</th>
                    <th>Appointment Date</th>
                    <th>Service</th>
                    <th>Status </th> 
                    <th>Action</th> 
                </tr>
            </thead>
            <tbody>
            <?php
            if (count($appointments) > 0) { // Check the number of appointments
                // Output data of each row
                foreach ($appointments as $row) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row['appointment_id']) . "</td>
                        <td>" . htmlspecialchars($row['first_name'] . " " . $row['last_name']) . "</td>
                        <td>" . date('Y-m-d H:i', strtotime($row['appointment_date'])) . "</td>
                        <td>" . htmlspecialchars($row['service_name']) . "</td>
                        <td>" . htmlspecialchars($row['status']) . "</td>
                        <td>
                            <a href=\"edit_appointment.php?id=" . htmlspecialchars($row['appointment_id']) . "\" class=\"btn btn-primary\">Edit</a>
                            <a href=\"mark_done.php?id=" . htmlspecialchars($row['appointment_id']) . "\" class=\"btn btn-success btn-sm\">Done</a>
                            <a href=\"mark_postponed.php?id=" . htmlspecialchars($row['appointment_id']) . "\" class=\"btn btn-warning btn-sm\">Postponed</a>
                            <a href=\"mark_followup.php?id=" . htmlspecialchars($row['appointment_id']) . "\" class=\"btn btn-info btn-sm\">Follow Up</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No appointments found</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</body>
</html>