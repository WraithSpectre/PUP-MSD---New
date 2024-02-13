<?php
include '../connect.php';
include 'header.php'; // Include your header file

// Fetch appointment data from the database
$sql = "SELECT c.treatment, c.status, a.complaint, p.type
        FROM consultation c
        JOIN appointments a ON c.appointment_id = a.appointment_id
        JOIN patients p ON a.patient_id = p.patient_id
        WHERE c.status = 'Done'";
$result = $mysqli->query($sql);

// Check if the query was successful
if ($result === false) {
    die("Error: " . $mysqli->error);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="../styles/images/pup-logo2.png">
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

        main {
            flex: 1;
        }

        section.content {
            flex: 1;
            
            padding: 120px 30px 100px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        tr:hover {
            background-color: #f5f5f5;
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
    
    <section class="content" style="background-color: #F4F6F9; padding: 20px 30px 100px;">
        <div class="container col-md-11 mt-5 pt-3"  style="padding-bottom: 80px;">
            <div class="card"  style="border-top: 0.2rem solid #dc3545 !important;">
                <h4 class="ml-3 pt-2 text-uppercase" style="color: #dc3545;">
                Patient Consultation Reports
                </h4>                
            </div>

            <div class="card">
                <div class="card-body">
                    <!-- Appointment Table -->
                    <table id="datatableid" class="table table-striped table-bordered table-sm" border='1'>
                        <thead class="thead-dark">
                            <tr>
                                <th>Treatment</th>
                                <th>Patient Type</th>
                                <th>Complaint</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>

                        <!-- Output data of each row -->
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . $row["treatment"] . "</td>
                                        <td>" . $row["type"] . "</td>
                                        <td>" . $row["complaint"] . "</td>
                                        <td>". $row["status"]. "</td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No found.</td></tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </section>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Bootstrap 5 JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-GLhlTQ8iK+U2FYf5hAxFfL2PawAiS+g26z/ooeJR2u81eq0q5t47X0tN2N5J9PZJ" crossorigin="anonymous"></script>

<!-- DataTables CSS and JS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<!-- DataTables Bootstrap 5 Integration -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<!-- DataTables Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>






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
              var header = 'Mabini Campus College Medical Clinic Patient Consultation Reports';
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
            },
          },
          'print'
        ],
      });

      $('#datatableid_paginate').addClass('pagination-sm');

      $('#csv_file_input').change(function () {
        var file = this.files[0];
        if (file) {
          var formData = new FormData();
          formData.append('csv_file', file);

          $.ajax({
            url: 'consultation_csv.php', // Specify the path to your import script
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