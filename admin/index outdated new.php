<html lang="en"
<?php
include '../connect.php';

session_start();
// Replace the following with your actual database connection logic
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'pupmsd';

$conn = new mysqli($host, $username, $password, $database);

// Replace the following with the actual user authentication logic and email retrieval
if (isset($_SESSION['email'])) {
	$email = $_SESSION['email'];

	// Fetch user data from the database based on the email
	$query = "SELECT email FROM medical_staff WHERE email = ?";
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
	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="index.php" class="brand">
			<i class='bx bxs-clinic'></i>
			<span class="text">PUPMSD Admin</span>
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="index.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
      </li>   
			
			<li>
				<a href="medical-staff.php">
					<i class='bx bxs-user' ></i>
					<span class="text">Medical Staffs</span>
				</a>
			</li>

			<li>
				<a href="admin.php">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Admin User</span>
				</a>
			</li>

      <li>
				<a href="#">
					<i class='bx bxs-user' ></i>
					<span class ="text"><?php echo $_SESSION["email"] ?></span>
				</a>
				<a href="../logout.php">
					<i class='bx bxs-exit' ></i>
					<span class ="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->

	<!-- JavaScript for interactive sidebar -->
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			const sidebar = document.getElementById('sidebar');
			const sideMenuItems = document.querySelectorAll('#sidebar .side-menu a');
			const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');

			// Add click event listeners to side menu items
			sideMenuItems.forEach(item => {
				item.addEventListener('click', function () {
					// Remove the 'active' class from all menu items
					sideMenuItems.forEach(i => i.parentElement.classList.remove('active'));

					// Add the 'active' class to the clicked menu item
					this.parentElement.classList.add('active');
				});
			});

			// Toggle sidebar on small screens
			sidebarToggleBtn.addEventListener('click', function () {
				sidebar.classList.toggle('collapsed');
			});
		});
	</script>


	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			<a href="#" class="nav-link">Categories</a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
				</div>
			</form>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
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
				<a href="#"><i class='bx bxs-user-account' ></i></a>

					<?php
					$staff = mysqli_query($mysqli, "SELECT * FROM medical_staff WHERE specialization = 'md staff' ");
					$num = mysqli_num_rows($staff);
					?>

					<span class="text">
						<h3><?php ?></h3>
						<p>Medical Staff<br> <?php echo $num; ?></p>
					</span>
				</li>
				<li>
					<a href="#"><i class='bx bxs-user-account' ></i></a>

					<?php
					$admin = mysqli_query($mysqli, "SELECT * FROM medical_staff WHERE specialization = 'admin'");
					$num = mysqli_num_rows($admin);
					?>

					<span class="text">
						<h3><?php ?></h3>
						<p>Admin <br> <?php echo $num; ?></p>
					</span>
				</li>
				<li>
				<a href="#"><i class='bx bxs-user-account' ></i></a>

					<?php
					$admin = mysqli_query($mysqli, "SELECT * FROM faculty");
					$num = mysqli_num_rows($admin);
					?>

					<span class="text">
						<h3><?php ?></h3>
						<p>Faculty User <br> <?php echo $num; ?></p>
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
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
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
							
				<div class="todo">
					<div class="head">
						<h3>Todos</h3>
						<i class='bx bx-plus' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<ul class="todo-list">
						<li class="completed">
							<p>Todo List</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
						<li class="completed">
							<p>Todo List</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
						<li class="not-completed">
							<p>Todo List</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
						<li class="completed">
							<p>Todo List</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
						<li class="not-completed">
							<p>Todo List</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
					</ul>
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
					data: { patient_id: patientid },
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



</body>

</html>