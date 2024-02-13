<html lang="en"
<?php
include '../connect.php';

session_start();
// Replace the following with your actual database connection logic
$host = "localhost";
$username = "root";
$password = "";
$database = "public_html";
$conn = new mysqli($host, $username, $password, $database);

// Replace the following with the actual user authentication logic and email retrieval
if (isset($_SESSION['email'])) {
	$email = $_SESSION['email'];

	// Fetch user data from the database based on the email
	$query = "SELECT email FROM admin WHERE email = ?";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("s", $email);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		$email = $row['email'];
	} else {
		// Handle the case when the user is not found in the database
		header("Location:../index.php");
		exit;
	}
} else {
	// Handle the case when the email is not set in the session
	header("Location:../index.php");
	exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="../styles/images/pup-logo2.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- My CSS -->
    <link rel="stylesheet" href="style.css">
    
    <!-- script -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    

    <title>PUPMSD Admin - Archive</title>

	<?php
	include './navbar/navbar.php';
	?>
</head>
<body>

	<!-- CONTENT -->
	<section id="content">

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="index.php">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="archive.php">Archive</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>PUPMSD Medical Staff Archive</h3>
					</div>
					<?php 
                    $sql = "SELECT * FROM medical_staff_archive where specialization = 'md staff' ";
                    $result = $mysqli->query($sql);
					?>
					<table>
						<thead>
						<tr>
							<th>Medical Staff Name</th>
							<th>Email</th>
							<th>Password</th>
							<th>Actions</th>
    					</tr>
						</thead>
						<?php
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									echo "<tr>
											<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>
											<td>" . $row["email"] . "</td>
											<td>" . $row["pass"] . "</td>
                                            <td>
                                                <button data-id='" . $row['user_id'] . "' class='unarchiveStaff btn btn-warning'>Restore Account</button>
                                                <button data-id='" . $row['user_id'] . "' class='deleteMedicalStaff btn btn-warning'>Delete</button>
											</td>
										</tr>";
								}
							} else {
								echo "<tr><td colspan='7'>No appointments found.</td></tr>";
							}
						?>
					</table>
				</div>
			</div>
			
            <div class="table-data">
				<div class="order">
					<div class="head">
						<h3>PUPMSD Admin Archive</h3>
					</div>
					<?php 
                    $sql = "SELECT * FROM medical_staff_archive where specialization = 'admin' ";
                    $result = $mysqli->query($sql);
					?>
						<table>
						<thead>
						<tr>
							<th>Admin Name</th>
							<th>Email</th>
							<th>Password</th>
							<th>Actions</th>
    					</tr>
						</thead>
						<?php
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									echo "<tr>
											<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>
											<td>" . $row["email"] . "</td>
											<td>" . $row["pass"] . "</td>
											<td>
											<button data-id='" . $row['user_id'] . "' class='unarchiveStaff btn btn-warning'>Restore Account</button>
											<button data-id='" . $row['user_id'] . "' class='deleteMedicalStaff btn btn-warning'>Delete</button>
											</td>
										</tr>";
								}
							} else {
								echo "<tr><td colspan='7'>No appointments found.</td></tr>";
							}
						?>
					</table>
				</div>
			</div>

            <div class="table-data">
            <div class="order">
            <div class="head">
						<h3>PUPMSD Supplies Archive</h3>
					</div>
                <table id="datatableid" class="table table-striped table-bordered table-sm">
                    <thead class="table-dark">
                        <tr>
                        <th>Date</th>
                        <th>Supply</th>
                        <th>Quantity</th>
                        <th>Consumed</th>
                        <th>Expiration Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <?php
                    // Fetch data from medicine_inventory table
                    $fetchMedicineQuery = "SELECT * FROM supply_inventory_archive";
                    $result = $mysqli->query($fetchMedicineQuery);
            
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . date('m-d-Y', strtotime($row['date'])) . "</td>
                                    <td>{$row['supply']}</td>
                                    <td>{$row['quantity']}</td>
                                    <td>{$row['consumed']}</td>
                                    <td>" . date('m-d-Y', strtotime($row['expiration_date'])) . "</td>
                                    <td>
                                    <button data-id='" . $row['sup_id'] . "' class='restoresup btn btn-warning'>Restore Supply</button>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No supply in inventory.</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </div>


		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
    <!-- ... (your existing script imports) ... -->

<script>
    $(document).ready(function () {
        // Corrected class selectors
        $('.unarchiveStaff').click(function () {
            var staffId = $(this).data('id');
            unarchiveStaff(staffId);
        });

        $('.deleteMedicalStaff').click(function () {
            var staffId = $(this).data('id');
            deleteMedicalStaff(staffId);
        });

        function unarchiveStaff(staffId) {
            // AJAX request to unarchive the staff member
            $.ajax({
                url: 'unarchive_staff.php',
                type: 'POST',
                data: { user_id: staffId },
                success: function (response) {
                    alert(response);
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        // Function to handle the deletion of a medical staff member
        function deleteMedicalStaff(user_id) {
            if (confirm("Are you sure you want to delete this medical staff member?")) {
                // AJAX request to delete the medical staff member
                $.ajax({
                    url: 'delete_mdstaff.php',
                    type: 'POST',
                    data: { user_id: user_id },
                    success: function (response) {
                        alert(response);
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        }

        // Added the missing function to restore supply
        $('.restoresup').click(function () {
            var supId = $(this).data('id');
            restoresup(supId);
        });

        function restoresup(supId) {
            // AJAX request to restore the supply
            $.ajax({
                url: 'unarchive_supply.php',
                type: 'POST',
                data: { sup_id: supId },
                success: function (response) {
                    alert(response);
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        // ... (rest of your code)

        // Corrected class selectors
        $('.UNarchivePatient').click(function () {
            var patientId = $(this).data('id');
            UNarchivePatient(patientId);
        });

        $('.deletePatientAccount').click(function () {
            var patientId = $(this).data('id');
            deletePatientAccount(patientId);
        });

        function UNarchivePatient(patientId) {
            // AJAX request to unarchive the patient
            $.ajax({
                url: 'unarchive_patients.php',
                type: 'POST',
                data: { patient_id: patientId },
                success: function (response) {
                    alert(response);
                    location.reload();
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }

        // Function to handle the deletion of a patient account
        function deletePatientAccount(patientId) {
            if (confirm("Are you sure you want to delete this patient account?")) {
                // AJAX request to delete the patient account
                $.ajax({
                    url: 'delete_patient_account.php',
                    type: 'POST',
                    data: { patient_id: patientId },
                    success: function (response) {
                        alert(response);
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        }

        // ... (rest of your code)
    });
</script>
