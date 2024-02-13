<?php
session_start();
include '../connect.php';


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

    <title>PUPMSD Admin - Medical Staff</title>
</head>
<body>
<header>
	
<?php
include './navbar/navbar.php';
?>

</header>
    <!-- NAVBAR -->

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
							<a class="active" href="index.php">Home</a>
						</li>
					</ul>
				</div>

			</div>

			<ul class="box-info">
				<li>
				<a href="medical-staff.php"><i class='bx bxs-user-account' ></i></a>

					<?php
					$staff = mysqli_query($mysqli, "SELECT * FROM medical_staff WHERE specialization = 'Doctor' ");
					$num = mysqli_num_rows($staff);
					?>

					<span class="text">
						<h3><?php ?></h3>
						<p>PUP MSD Doctor<br> <?php echo $num; ?></p>
					</span>
				</li>
				
			<ul class="box-info">
				<li>
				<a href="medical-staff_doctors.php"><i class='bx bxs-user-account' ></i></a>

					<?php
					$staff = mysqli_query($mysqli, "SELECT * FROM medical_staff WHERE specialization = 'Nurse' ");
					$num = mysqli_num_rows($staff);
					?>

					<span class="text">
						<h3><?php ?></h3>
						<p>PUP MSD Nurse<br> <?php echo $num; ?></p>
					</span>
				</li>
				
				<li>
					<a href="admin.php"><i class='bx bxs-user-account' ></i></a>

					<?php
					$admin = mysqli_query($mysqli, "SELECT * FROM admin WHERE account_status = 'active'");
					$num = mysqli_num_rows($admin);
					?>

					<span class="text">
						<h3><?php ?></h3>
						<p>Admin <br> <?php echo $num; ?></p>
					</span>
				</li>



				<li>
				<a href="#"><i class='bx bxs-group' ></i></a>

					<?php
					$patients = mysqli_query($mysqli, "SELECT * FROM patients");
					$num = mysqli_num_rows($patients);
					?>
					<span class="text">
						<h3><?php ?></h3>
						<p>Patients <br> <?php echo $num; ?></p>
					</span>
				</li>
			</ul>


			<div class="table-data" style="padding: 10px;">
				<div class="order">
					<div class="head">
						<h3>Appointments</h3>
					</div>
					<?php 
					$sql = "SELECT a.*, p.first_name, p.last_name, p.type 
					FROM appointments a
					JOIN patients p ON a.patient_id = p.patient_id";
					$result = $mysqli->query($sql);
					?>
					<table>
						<thead>
						<tr>
							<th>Patient Name</th>
							<th>Patient Type</th>
							<th>Blood Pressure</th>
							<th>Temperature</th>
							<th>Complaint</th>
							<th>Appointment Date</th>
							<th>Appointment Time</th>
							<th>Staff in Charge</th>
							<th>Actions</th>
    					</tr>
						</thead>
						<?php
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									echo "<tr>
											<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>
											<td>" . $row["type"] . "</td>
											<td>" . $row["blood_pressure"] . "</td>
											<td>" . $row["temperature"] . "</td>
											<td>" . $row["complaint"] . "</td>
											<td>" . $row["appointment_date"] . "</td>
											<td>" . $row["appointment_time"] . "</td>
											<td>" . $row["staff_in_charge"] . "</td>
											<td>
												<button data-id='" . (isset($row['patient_id']) ? $row['patient_id'] : '') . "' class='patientinfo btn btn-success'>Show</button> 
												
											</td>
										</tr>";
								}
							} else {
								echo "<tr><td colspan='7'>No appointments found.</td></tr>";
							}
						?>
					</table>
				</div>

				<div id="patientModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog"> 
					<div class="modal-content">
					<span onclick="closePatientModal()" style="cursor: pointer;">&times;</span>
						<h2>Patient Details</h2>
						<div id="patientModalBody">
							<!-- Patient details will be dynamically inserted here -->
						</div>
					</div>
					</div>
				</div>
							
				
			</div>
			<div class="table-data" style="padding: 10px;">
			<div class="order">
					<div class="head">
						<h3>Patients</h3>
					</div>
					<?php 
					$sql = "SELECT a.*, p.first_name, p.last_name, p.type 
					FROM patients a
					JOIN patients p ON a.patient_id = p.patient_id";
					$result = $mysqli->query($sql);
					?>
					<table>
						<thead>
						<tr>
							<th>Patient Name</th>
							<th>Date of Birth</th>
							<th>Gender</th>
							<th>Address</th>
							<th>Contact Number</th>
							<th>Email</th>
							<th>Type</th>
							<th>Actions</th>
    					</tr>
						</thead>
						<?php
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									echo "<tr>
											<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>
											<td>" . $row["date_of_birth"] . "</td>
											<td>" . $row["gender"] . "</td>
											<td>" . $row["address"] . "</td>
											<td>" . $row["contact_number"] . "</td>
											<td>" . $row["email"] . "</td>
											<td>" . $row["type"] . "</td>
											<td>
												<button data-id='" . (isset($row['patient_id']) ? $row['patient_id'] : '') . "' class='patientinfo btn btn-success'>Show</button>
												 
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
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="script.js"></script>

	<script type="text/javascript">
    $(document).ready(function () {

        
        $('.patientinfo').click(function () {
            var patientid = $(this).data('id');

            // Set the patient ID in the hidden field
            $('#hiddenPatientId').val(patientid);

            // AJAX request to fetch additional information
            $.ajax({
                url: '../md_staff/get_patient_info.php',
                type: 'POST',
                data: {patient_id: patientid},
                success: function (data) {
                    // Populate the modal with patient details
                    $('#patientModalBody').html(data);

                    // Use Bootstrap's modal function to show the modal
                    $('#patientModal').modal('show');
                }
            });
        });
    });
    function closePatientModal() {
        var modal = document.getElementById('patientModal');
        modal.style.display = 'inline';
    }
</script>

<script>
        $(document).ready(function () {
            $('.archiveStaff').click(function () {
                var staffId = $(this).data('id');
                archiveStaff(staffId);
            });

            $('.unarchiveStaff').click(function () {
                var staffId = $(this).data('id');
                unarchiveStaff(staffId);
            });

            function archiveStaff(staffId) {
                // AJAX request to archive the staff member
                $.ajax({
                    url: 'archive_patients.php',
                    type: 'POST',
                    data: { patient_id: staffId },
                    success: function (response) {
                        alert(response);
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }



            // Initialize Bootstrap modal
            var myModal = new bootstrap.Modal(document.getElementById('addMedicalStaffModal'));

            // Function to open the modal
            function openAddMedicalStaffModal() {
                myModal.show();
            }

            // Function to close the modal
            function closeAddMedicalStaffModal() {
                myModal.hide();
            }

            // Attach the functions to the buttons
            $('.open-modal-btn').on('click', openAddMedicalStaffModal);
            $('.close-modal-btn').on('click', closeAddMedicalStaffModal);
        });
    </script>
</body>

</html>