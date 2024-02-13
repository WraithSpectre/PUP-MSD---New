<?php
include '../connect.php';
include 'header.php'; // Include your database connection file

// Check if the form is submitted for adding a new item
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $supply = $_POST['supply'];
    $quantity = $_POST['quantity'];
    $consumed = 0; // Assuming no initial consumption
    $expiration_date = $_POST['expiration_date'];

    // Insert into medicine_inventory table
    $insertMedicineQuery = "INSERT INTO supply_inventory (date, supply, quantity, consumed, expiration_date)
                            VALUES ('$date', '$supply', $quantity, $consumed, '$expiration_date')";

    if ($mysqli->query($insertMedicineQuery) === true) {
       echo "<script>alert('Medicine added to inventory successfully.');</script>";
       header("Location: supply_inventory.php");
       exit();
        
    } else {
        echo "Error adding supply to inventory: " . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="../styles/images/pup-logo2.png">
    <title>Supplies Inventory</title>
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
            background-color: rgba(0, 0, 0, 0.1);
            background: linear-gradient(to bottom, rgba(230, 230, 230, 0.1) 0%, rgba(0, 0, 0, 0.1) 100%);
        }

        
    </style>

</head>
<body>
<section class="content"  style="background-color: #F4F6F9; padding: 100px 30px 200px;">
    <div class="container col-md-11">
        <div class="card"  style="border-top: 0.2rem solid #dc3545 !important;">
            <h4 class="ml-3 pt-2 text-uppercase" style="margin-bottom: 0px; color: #dc3545">
                Supplies Inventory
                <!-- Button to open the modal -->
                <button class="btn btn-primary btn-sm float-right mr-3" onclick="document.getElementById('myModal').style.display='block'" style="margin-top: -1px;">
                    Add Supply
                </button>
            </h4>
        </div>


        <!-- Modal for adding a new item -->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add New Supply</h5>
                    <span onclick="document.getElementById('myModal').style.display='none'" style="float: right; cursor: pointer;">&times;</span>
                </div>
                
                <div class="modal-body">
                    <!-- Add your form for adding new medicine here -->
                    <form method="post" action="">
                        <!-- Your form fields go here -->
                        <label>Date:</label>
                        <input type="date" name="date" class="form-control" required><br>
                        <label>Supply:</label>
                        <input type="text" name="supply" class="form-control" required><br>
                        <label>Quantity:</label>
                        <input type="number" name="quantity" class="form-control" required><br>
                        <label>Expiration Date:</label>
                        <input type="date" name="expiration_date" class="form-control" required><br>
                        
                        <button type="submit" class="btn btn-primary">Add Medicine</button>
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
                        <th>Supply</th>
                        <th>Quantity</th>
                        <th>Consumed</th>
                        <th>Expiration Date</th>
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
              var header = 'Date: <?php echo date('F d, Y', strtotime($date)); ?> | Clinic: <?php echo $clinic; ?> | Campus: <?php echo $campus; ?>';
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
            url: 'supply_inventory_csv.php', // Specify the path to your import script
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
    </script>
    
  <?php require_once('footer.php'); ?>

</body>
</html>
