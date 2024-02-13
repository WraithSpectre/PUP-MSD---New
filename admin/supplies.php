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

    <title>PUPMSD Admin - Medical Staff</title>

	<?php
	include"./navbar/navbar.php";
	?>

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
							<a class="active" href="supplies.php">Supplies</a>
						</li>
					</ul>
				</div>
				<button class="open-modal-btn">
            <box-icon type='solid' name='cabinet'></box-icon>
            Add Supplies
        </button>
			</div>

			<!-- Add Supplies Modal -->
			<div class="modal" id="addSuppliesModal" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Supplies</h5>
                            <button type="button" class="btn-close close-modal-btn" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Add your form fields for adding a new patient here -->
                            <form method="post" action="add_supplies_process.php">
                                Date: <input type="date" name="date" required><br>
                                Supply: <input type="text" name="supply" required><br>
                                Quantity: <input type="int" name="quantity" required><br>
                                <input type="hidden" name="consumed" required value="0"><br>
                                Expiration Date:<input type="date" name="expiration_date" value="md staff">
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
						<h3>PUPMSD Supplies</h3>
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
                    $fetchMedicineQuery = "SELECT * FROM supply_inventory";
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
                                    <button data-id='" . $row['sup_id'] . "' class='archivesup btn btn-warning'>Remove Item</button>
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
			</div>
			
            			<!-- Add Medicine Modal -->
			<div class="modal" id="addMedicineModal" tabindex="-1" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Medicine</h5>
                            <button type="button" class="btn-close close-modal-btn" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Add your form fields for adding a new patient here -->
                            <form method="post" action="add_medicine_process.php">
                                Date: <input type="date" name="date" required><br>
                                Medicine: <input type="text" name="medicine" required><br>
                                Quantity: <input type="int" name="quantity" required><br>
                                <input type="hidden" name="consumed" required value="0"><br>
                                Expiration Date:<input type="date" name="expiration_date" value="md staff">
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
						<h3>PUPMSD Medicine</h3>
                        <button class="open-modal-btn" data-bs-toggle="modal" data-bs-target="#addMedicineModal">
                        <box-icon type='solid' name='cabinet'></box-icon>
                        Add Medicine
                         </button>
			</div>
                <table id="datatableid" class="table table-striped table-bordered table-sm">
                    <thead class="table-dark">
                        <tr>
                        <th>Date</th>
                        <th>Medicine</th>
                        <th>Quantity</th>
                        <th>Consumed</th>
                        <th>Expiration Date</th>

                    </tr>
                    </thead>
                    <?php
                    // Fetch data from medicine_inventory table
                    $fetchMedicineQuery = "SELECT * FROM medicine_inventory";
                    $result = $mysqli->query($fetchMedicineQuery);
            
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . date('m-d-Y', strtotime($row['date'])) . "</td>
                                    <td>{$row['medicine']}</td>
                                    <td>{$row['quantity']}</td>
                                    <td>{$row['consumed']}</td>
                                    <td>" . date('m-d-Y', strtotime($row['expiration_date'])) . "</td>

                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No supply in inventory.</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
        <div class="table-data">
          <div class="order"  style="overflow-x: auto;">
            <!-- Display Data in table header -->
            <h4>Medical and Supplies Request</h4>
            <?php
            $connection = mysqli_connect("localhost", "u868151448_sherry", "04202002Pjs", "u868151448_pupmsd");
            $db = mysqli_select_db($connection, 'u868151448_pupmsd');

            $query = "SELECT * FROM tbl_supply WHERE status='Pending'";
            $query_run = mysqli_query($connection, $query);
            ?>
            <table id="datatableid" class="table table-striped table-bordered table-sm">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Medicines</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Date Received</th>
                  <th scope="col">Remarks</th>
                  <th scope="col">Supplies</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Date Received</th>
                  <th scope="col">Remarks</th>
                  <th scope="col">Status</th>
                  <th scope="col">ACTION</th>
                </tr>
              </thead>
              <?php
              if ($query_run) {
                foreach ($query_run as $row) {
              ?>
                  <!tbody>
                    <tr>
                      <td><?php echo $row['id']; ?></td>
                      <td><?php echo $row['medicines']; ?></td>
                      <td><?php echo $row['m_quantity']; ?></td>
                      <td><?php echo $row['m_date_received']; ?></td>
                      <td><?php echo $row['m_remarks']; ?></td>
                      <td><?php echo $row['supplies']; ?></td>
                      <td><?php echo $row['s_quantity']; ?></td>
                      <td><?php echo $row['s_date_received']; ?></td>
                      <td><?php echo $row['s_remarks']; ?></td>
                      <td><?php echo $row['status']; ?></td>
                      <td>
                        <!--<button type="button" class="btn btn-info btn-sm viewbtn">VIEW </button>-->
                        <button type="button" class="btn btn-danger btn-sm rejectbtn">REJECT </button>
                        <button type="button" class="btn btn-success btn-sm approvebtn">APPROVE </button>
                      </td>
                    </tr>
                  <!/tbody>
              <?php
                }
              } else {
                echo "No Record Found";
              }
              ?>

              <!-- Display Prepared By and Noted By in table footer -->
              <tfoot>
                <tr>
                  <th colspan="10">Prepared By: <?php echo $prepared_by; ?> | Noted By: <?php echo $noted_by; ?></th>
                </tr>
              </tfoot>
            </table>
          </div>
        </di
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->

	<script src="script.js"></script>
<script>
  $(document).ready(function () {
    // Corrected class selector for opening Add Medicine modal
    $('.open-modal-btn').on('click', function () {
      openAddModal();
    });

    // Function to open the modal
    function openAddModal() {
      $('#addSuppliesModal').modal('show');
    }

    // Initialize Bootstrap modal for Add Supplies modal
    var addSuppliesModal = new bootstrap.Modal(document.getElementById('addSuppliesModal'));

    // Function to close the modal
    function closeAddModal() {
      addSuppliesModal.hide();
    }

    // Attach the functions to the buttons
    $('.close-modal-btn').on('click', closeAddModal);

    // Handle form submission
    $('#addSuppliesForm').submit(function (e) {
      e.preventDefault(); // prevent default form submission

      // your form processing logic here
    });

    // Handle approve button click
    $('.approvebtn').click(function () {
      var id = $(this).closest('tr').find('td:first').text(); // Get the ID from the first column

      // AJAX request to approve.php
      $.ajax({
        url: 'approve.php',
        type: 'POST',
        data: { id: id },
        success: function (response) {
          // Update the status in the table if approval is successful
          if (response == "success") {
            alert('Record approved successfully.');
            // Optionally, you can update the status cell in the current row
            // e.g., $(this).closest('tr').find('td:eq(9)').text('Approved');
          } else {
            alert('Failed to approve record');
          }
        },
        error: function (xhr, status, error) {
          console.error('Error:', error);
        }
      });
    });

    // Handle reject button click
    $('.rejectbtn').click(function () {
      var id = $(this).closest('tr').find('td:first').text(); // Get the ID from the first column

      // AJAX request to reject.php
      $.ajax({
        url: 'delete_supply_req.php',
        type: 'POST',
        data: { id: id },
        success: function (response) {
          // Update the status in the table if rejection is successful
          if (response == "success") {
            alert('Record rejected successfully.');
            // Optionally, you can update the status cell in the current row
            // e.g., $(this).closest('tr').find('td:eq(9)').text('Rejected');
          } else {
            alert('Failed to reject record');
          }
        },
        error: function (xhr, status, error) {
          console.error('Error:', error);
        }
      });
    });
  });
</script>



</body>
</html>