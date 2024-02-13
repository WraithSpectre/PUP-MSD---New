<?php
include '../connect.php';
include 'header.php'; // Include your database connection file

// Check if the form is submitted for adding a new item
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $medicine = $_POST['medicine'];
    $dosage = $_POST['dosage'];
    $type = $_POST['type'];
    $quantity = $_POST['quantity'];
    $consumed = 0; // Assuming no initial consumption
    $expiration_date = $_POST['expiration_date'];

    // Insert into medicine_inventory table
    $insertMedicineQuery = "INSERT INTO medicine_inventory (date, medicine, dosage, type, quantity, consumed, expiration_date)
                            VALUES ('$date', '$medicine', '$dosage' '$type' '$quantity', '$consumed', '$expiration_date')";

    if ($mysqli->query($insertMedicineQuery) === true) {
        // header("Location: medicine_inventory.php");
        // exit();
        echo "Adding Success";
    } else {
        echo "Error adding medicine to inventory: " . $mysqli->error;
    }
}
?>
<?php
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'public_html');

$query = "SELECT * FROM tbl_supply";
$query_run = mysqli_query($mysqli, $query);

if ($query_run) {
    $row = mysqli_fetch_assoc($query_run);
    $date = ($row['date'] != '00-00-0000') ? $row['date'] : 'N/A'; 
    $clinic = $row['clinic'];
    $campus = $row['campus'];
    $prepared_by = $row['prepared_by'];
    $noted_by = $row['noted_by'];
} else {
    echo "Error fetching data from the database.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="../styles/images/pup-logo2.png">
    <title>Medicine Inventory</title>
    <!-- Add any necessary CSS styles here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    
    <style>
        /* Add your styles here */
        /* Style for the modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 40%;
        }
        

        button {
            color: #000;
            margin-bottom: .333em;
            padding: .5em 1em;
            border: 1px solid rgba(0, 0, 0, 0.3);
            border-radius: 2px;
            cursor: pointer;
            background-color: linear-gradient(to bottom, rgba(230, 230, 230, 0.1) 0%, rgba(0, 0, 0, 0.1) 100%);
        }
    </style>

</head>
<body>
    
<section class="content"  style="background-color: #F4F6F9; padding: 100px 30px 200px;">
    <div class="container col-md-11">
        <div class="card"  style="border-top: 0.2rem solid #dc3545 !important;">
            <h4 class="ml-3 pt-2 text-uppercase" style="color: #dc3545">
                Medicine Inventory
                <!-- Button to open the modal -->
                <button class="btn btn-primary btn-sm float-right mr-3" onclick="document.getElementById('myModal').style.display='block'">
                    Add Medicine
                </button>
            </h4>
        </div>

    
        <!-- Modal for adding a new item -->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add New Medicine</h5>
                    <span onclick="document.getElementById('myModal').style.display='none'" style="float: right; cursor: pointer;">&times;</span>
                </div>

                <!-- Add your form for adding new medicine here -->
                <div class="modal-body">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <!-- Your form fields go here -->
                        <label>Date:</label>
                        <input type="date" name="date" class="form-control" required><br>
                        <label>Medicine:</label>
                        <input type="text" name="medicine" class="form-control" required><br>
                        <label>Dose:</label>
                        <input type="text" name="dosage" class="form-control" required><br>
                        <label>Type:</label>
                        <input type="text" name="type" class="form-control" required><br>
                        <label>Quantity:</label>
                        <input type="number" name="quantity" class="form-control" required><br>
                        <label>Expiration Date:</label>
                        <input type="date" name="expiration_date" class="form-control" required><br>
                        
                        <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Add Medicine</button>
                </div>
                    </form>
                </div>
                
                
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table id="datatableid" class="table table-striped table-bordered table-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>Date</th>
                            <th>Medicine</th>
                            <th>Dose</th>
                            <th>Type</th>
                            <th>Quantity (pcs)</th>
                            <th>Consumed</th>
                            <th>Expiration Date</th>
                            <th>Actions</th>
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
                                    <td>{$row['dosage']}</td>
                                    <td>{$row['type']}</td>
                                    <td>{$row['quantity']}</td>
                                    <td>{$row['consumed']}</td>
                                    <td>" . date('m-d-Y', strtotime($row['expiration_date'])) . "</td>
                                    <td class='action-buttons'> 
                                        <button class='btn btn-success btn-sm' onclick='editMedicine({$row['med_id']})'>Edit</button>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No medicine in inventory.</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</section>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <!-- Bootstrap JS and Popper.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

  <!-- DataTables CSS and JS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
  <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

  <!-- DataTables Bootstrap 4 Integration -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">
  <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>

  <!-- DataTables Buttons -->
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

  <!-- Bootstrap-datepicker -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>


  <!-- data table pagination & import/export csv, pdf, excel -->
  <script>
    $(document).ready(function () {
      var table;

      // Initialize DataTable with initComplete callback
      $('#datatableid').DataTable({
        dom: 'Bfrtip',
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        responsive: true,
        language: {
          searchPlaceholder: "Search records",
        },
        buttons: [
          'copy', 'csv', 'excel', {
            extend: 'pdfHtml5',
            orientation: 'landscape',
            customize: function (doc) {
              // Add header and footer to the PDF
              var header = 'Date: <?php echo date('F d, Y'); ?> | Clinic: <?php echo $clinic; ?> | Campus: <?php echo $campus; ?>';
              var footer = 'Prepared By: <?php echo $prepared_by; ?> | Noted By: <?php echo $noted_by; ?>';
              var fontSize = 14;

              // Set header
              doc['header'] = function (currentPage, pageCount) {
                return {
                  text: header,
                  fontSize: fontSize,
                  alignment: 'center',
                  margin: 20,
                };
              };

              // Set footer
              doc['footer'] = function (currentPage, pageCount) {
                return {
                  text: footer,
                  fontSize: fontSize,
                  alignment: 'center',
                };
              };
            },
          },
          'print', {
            text: 'Import CSV',
            action: function (e, dt, node, config) {
              $('#csv_file_input').trigger('click');
            }
          }
        ],
      });

      $('#datatableid_paginate').addClass('pagination-sm');

      $('#csv_file_input').change(function () {
        var file = this.files[0];
        if (file) {
          var formData = new FormData();
          formData.append('csv_file', file);

          $.ajax({
            url: 'medicine_inventory_csv.php', // Specify the path to your import script
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
              alert(response);
            },
            error: function () {
              alert('Error importing CSV file.');
            }
          });
        }
      });
    });
  </script>

  <!-- Add a hidden file input for selecting CSV file -->
  <input type="file" id="csv_file_input" style="display: none;"  accept=".csv">

    <script>
        // Close the modal if clicked outside of it
        window.onclick = function(event) {
            var modal = document.getElementById('myModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Function to edit a medicine
        function editMedicine(med_id) {
            // Add your code to handle editing
            alert('Edit medicine with ID ' + med_id);
        }

        
        // Function to delete a medicine
    function deleteMedicine(med_id) {
        // You can show a confirmation dialog and then perform the deletion
        var confirmDelete = confirm('Are you sure you want to delete medicine with ID ' + med_id + '?');
        if (confirmDelete) {
            // Make an AJAX request to delete the medicine
            $.ajax({
                url: 'delete_medicine.php', // Adjust the URL to your server endpoint
                type: 'POST',
                data: { med_id: med_id },
                success: function (response) {
                    // Handle the success response
                    alert(response); // You can replace this with more meaningful feedback
                    // Remove the deleted row from the table
                    $('#medicineRow_' + med_id).remove();
                },
                error: function (error) {
                    alert('Error deleting medicine: ' + error.responseText);
                }
            });
        } else {
            alert('Deletion canceled.');
        }
    }
    </script>
    
    
</body>
</html>
