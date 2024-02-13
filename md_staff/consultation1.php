<?php
include '../connect.php';
include 'header.php'; // Include your header file

// Fetch appointment data from the database
$sql = "SELECT a.*, p.first_name, p.last_name, p.type 
        FROM appointments a
        JOIN patients p ON a.patient_id = p.patient_id";
$result = $mysqli->query($sql);

// Check if the query was successful
if ($result === false) {
    die("Error: " . $mysqli->error);
}

$selectMedSql = "SELECT * FROM medicine_inventory";

$inventory = $mysqli->query($selectMedSql);
$inventoryObj = [];
foreach($inventory as $key=>$value) {
    $inventoryObj[$key] = ["med_id" => $value['med_id'], "medicine" => $value['medicine']];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PUP Medical Services Department</title>
    <!-- Add any necessary CSS styles here -->
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        header,
        footer {
            text-align: center;
        }


        section.content {
            flex: 1;
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
    <section class="content" style="background-color: #F4F6F9; padding: 70px 30px 100px;">
        <div class="container col-md-11">
            <div class="card">
              <h4 class="ml-3 pt-2 text-uppercase" style="color: #dc3545;">
                Patient Consultations
              </h4>                
            </div>
        
            <div class="card">
                <div class="card-body">
                    <!-- Consultation Table -->
                    <table id="datatableid" class="table table-striped table-bordered table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>Name</th>
                                <th>Patient Type</th>
                                <th>Blood Pressure</th>
                                <th>Temperature</th>
                                <th>Complaint</th>
                                <th>Medicine Given</th>
                                <th>Dose</th>
                                <th>Treatment</th>
                                <th>Notes</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <th>Close</th>
                            </tr>
                        </thead>
        
                        <!-- Output data of each row -->
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . $row["first_name"] . " " . $row["last_name"] . "</td>
                                        <td>" . $row["type"] . "</td>
                                        <td>" . $row["blood_pressure"] . "</td>
                                        <td>" . $row["temperature"] . "</td>
                                        <td>" . $row["complaint"] . "</td>";
        
                                        $medicine = (isset($row['medicine'])) ? $row['medicine'] : "";
                                        $notes = (isset($row['notes'])) ? $row['notes'] : "";
                                        $quantity = (isset($row['medAmount'])) ? $row['medAmount'] : "";
                                        
                                        echo "<td>" . $medicine . "</td>
                                        <td>" . $quantity. "</td>
                                        <td>" . $row["treatment"]. "</td>
                                        <td>" . $notes . "</td>

                                        <td>". $row["status"]."</td>
                                        <td>
                                            <button data-id='" . (isset($row['consultation_id']) ? $row['consultation_id'] : '') . "'  class='editConsultationModal btn btn-success'>
                                                Edit
                                            </button>
                                        </td>
                                        <td>
                                            <button data-id='" . (isset($row['consultation_id']) ? $row['consultation_id'] : '') . "'  data-status='" . (isset($row['status']) ? $row['status'] : '') . "'  class='closeConsultation btn btn-primary'>
                                                Close
                                            </button>
                                        </td>
                                    </tr>";
                            
                            }
                        } else {
                            echo "<tr><td colspan='9'>No consultation data found.</td></tr>";
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
                    var header = 'Mabini Campus College Medical Clinic Patient Consultations';
                    var footer = '';
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
                }
            },
        ]
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
 
    
  <?php require_once('footer.php'); ?>


</body>
</html>

<?php
// Close the database connection
$mysqli->close();
?>
