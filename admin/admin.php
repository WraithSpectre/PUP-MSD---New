<html lang="en"
<?php
include '../connect.php';

session_start();
// Replace the following with your actual database connection logic
$host = "localhost";
$username = "root";
$password = "";
$database = "pupmsdredef";

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


	<style>
	/* Style for the button */
	.open-modal-btn {
		background-color: #4caf50; /* Green background color */
		color: white; /* White text color */
		padding: 10px 20px; /* Add some padding to the button */
		border: none; /* Remove border */
		border-radius: 5px; /* Optional: Add rounded corners */
		cursor: pointer; /* Add a pointer cursor on hover */
		display: flex; /* Make the content of the button a flex container */
		align-items: center; /* Center the content vertically */
	}

	/* Style for the box-icon inside the button */
	.open-modal-btn box-icon {
		margin-right: 5px; /* Add some margin to separate the icon from text */
	}

	/* Style for the button on hover */
	.open-modal-btn:hover {
		background-color: #45a049; /* Darker green on hover */
	}
	</style>


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
							<a class="active" href="admin.php">Admin</a>
						</li>
					</ul>
				</div>
				<button class="open-modal-btn">
            <box-icon name='user-plus'></box-icon>
            Add Admin
        </button>
			</div>

			<!-- Add Medical Staff Modal -->
			<div class="modal" id="addMedicalStaffModal" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Admin</h5>
                            <button type="button" class="btn-close close-modal-btn" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Add your form fields for adding a new patient here -->
                            <form method="post" action="add_medical_staff_process.php">
                                First Name: <input type="text" name="first_name" required><br>
                                Last Name: <input type="text" name="last_name" required><br>
                                Email: <input type="email" name="email" required><br>
                                Password: <input type="password" name="pass" required><br>
                                Re-Enter Your Password: <input type="password" name="cpass" required><br>
                                <!-- Add hidden field for designated word -->
                                <input type="hidden" name="status" value="inactive">
                                <br>
                                <input type="submit" value="Submit">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>PUPMSD Admin</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<?php 
                    $sql = "SELECT * FROM admin where account_status = 'Active' ";
                    $result = $mysqli->query($sql);
					?>
					<table>
						<thead>
						<tr>
							<th>Admin Name</th>
							<th>Email</th>
							<th>Actions</th>
    					</tr>
						</thead>
						<?php
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									echo "<tr>
											<td>" . $row["first_name"] . " " . $row["last_name"] . "</td>
											<td>" . $row["email"] . "</td>
											<td>
                                                <button data-id='" . $row['admin_id'] . "' class='archiveStaff btn btn-warning'>Archive</button>
											</td>
										</tr>";
								}
							} else {
								echo "<tr><td colspan='7'>No admin user found.</td></tr>";
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
			
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->

	<script src="script.js"></script>
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
                    url: 'archive_staff.php',
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
