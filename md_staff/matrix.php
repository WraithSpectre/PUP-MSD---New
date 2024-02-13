<?php
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'public_html');

$query = "SELECT * FROM tbl_matrix";
$query_run = mysqli_query($connection, $query);

if ($query_run) {
    $row = mysqli_fetch_assoc($query_run);
    $clinic = $row['clinic'];
    $purpose = $row['purpose'];
    $month_yr = $row['month_yr'];
    $prepared_by = $row['prepared_by'];
    $noted_by = $row['noted_by'];
} else {
    echo "Error fetching data from the database.";
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="x-icon" href="../styles/images/pup-logo2.png">
  <title>Matrix for Medical Clearance</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
  
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

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
  </style>
</head>
<body>
  <?php require_once('header.php'); ?>

  <!-- Modal -->
  <div class="modal fade" id="matrixaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Data </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form action="matrix_code.php" method="POST" enctype="multipart/form-data">

          <div class="modal-body">
            <div class="form-group">
              <label>Name</label>
              <input type="text" name="name" class="form-control" />
            </div>

            <div class="form-group">
              <label>Course YR/Sec./Department</label>
              <input type="text" name="course" class="form-control" />
            </div>

            <div class="form-group">
              <label>Age</label>
              <input type="text" name="age" class="form-control" />
            </div>

            <div class="form-group">
              <label>Gender</label>
              <div class="">
                <input type="radio" class="form-group-input" name="male" value="Male" />
                <label class="form-group-input" for="male">Male</label>
              </div>
              <div class="">
                <input type="radio" class="form-group-input" name="female" value="Female" />
                <label class="form-group-input" for="female">Female</label>
              </div>
            </div>

            <div class="form-group">
              <label>SC</label>
              <input type="text" name="sc" class="form-control">
            </div>

            <div class="form-group">
              <label>PWD</label>
              <input type="text" name="pwd" class="form-control" />
            </div>
            
            <div class="form-group">
              <label>Date of Request</label>
              <input type="text" name="date_of_request" class="form-control datepicker" autocomplete="off" />
            </div>
            
            <div class="form-group">
              <label>Date Acted Upon</label>
              <input type="text" name="date_acted_upon" class="form-control datepicker" autocomplete="off" />
            </div>


            <div class="form-group">
              <label>Remarks</label>
              <textarea name="remarks" class="form-control" rows="4"></textarea>
            </div>
            
            <!-- ADDITIONAL INFO FOR TABLE HEADER & FOOTER -->
            <label class="mt-5 mb-3">ADDITIONAL INFO FOR TABLE HEADER & FOOTER:</label>
            <div class="form-group">
              <label>Name of Clinic: </label>
              <input type="text" name="clinic" id="clinic" class="form-control" />
            </div>
            <div class="form-group">
              <label>Purpose: </label>
              <input type="text" name="purpose" id="purpose" class="form-control" />
            </div>
            <div class="form-group">
              <label>Month-Year:</label>
              <input type="text" name="month" id="month" class="form-control" placeholder="Month" />
            </div>
            <div class="form-group">
              <input type="int" name="year" id="year" class="form-control" placeholder="Year" />
            </div>

            <div class="form-group">
              <label>Prepared By:</label>
              <input type="text" name="prepared_by" class="form-control" placeholder="Public Health Nurse" />
            </div>
              <div class="form-group">
              <label>Noted By:</label>
              <input type="text" name="noted_by" class="form-control" placeholder="Medical Officer" />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="insertdata" class="btn btn-primary">Save Data</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- EDIT POP UP FORM (Bootstrap MODAL) -->
  <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Edit Data </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form action="matrix_code.php" method="POST">

          <div class="modal-body">
            <div class="form-group">
              <input type="hidden" name="update_id" id="update_id">

              <label>Name</label>
              <input type="text" name="name" id="name" class="form-control" />
            </div>

            <div class="form-group">
              <label>Course YR/Sec./Department</label>
              <input type="text" name="course" id="course" class="form-control" />
            </div>

            <div class="form-group">
              <label>Age</label>
              <input type="text" name="age" id="age"  class="form-control" />
            </div>

            <div class="form-group">
              <label>Gender</label>
              <div class="">
                <input type="radio" class="form-group-input" name="male" id="male"  value="Male" />
                <label class="form-group-input" for="male">Male</label>
              </div>
              <div class="">
                <input type="radio" class="form-group-input" name="female" id="female"  value="Female" />
                <label class="form-group-input" for="female">Female</label>
              </div>
            </div>

            <div class="form-group">
              <label>SC</label>
              <input type="text" name="sc" id="sc"  class="form-control">
            </div>

            <div class="form-group">
              <label>PWD</label>
              <input type="text" name="pwd" id="pwd"  class="form-control" />
            </div>

            <div class="form-group">
              <label>Date of Request</label>
              <input type="text" name="date_of_request" id="date_of_request"  class="form-control datepicker" autocomplete="off" />
            </div>

            <div class="form-group">
              <label>Date Acted Upon</label>
              <input type="text" name="date_acted_upon" id="date_acted_upon"  class="form-control datepicker" autocomplete="off" />
            </div>

            <div class="form-group">
              <label>Remarks</label>
              <textarea name="remarks" id="remarks"  class="form-control" rows="4"></textarea>
            </div>
            
            <!-- ADDITIONAL INFO FOR TABLE HEADER & FOOTER -->
            <label class="mt-5 mb-3">ADDITIONAL INFO FOR TABLE HEADER & FOOTER:</label>
            <div class="form-group">
              <label>Name of Clinic: </label>
              <input type="text" name="clinic" id="clinic" class="form-control" />
            </div>
            <div class="form-group">
              <label>Purpose: </label>
              <input type="text" name="purpose" id="purpose" class="form-control" />
            </div>
            <div class="form-group">
              <label>Month-Year:</label>
              <input type="text" name="month" id="month" class="form-control" placeholder="Month" />
            </div>
            <div class="form-group">
              <input type="int" name="year" id="year" class="form-control" placeholder="Year" />
            </div>

            <div class="form-group">
              <label>Prepared By:</label>
              <input type="text" name="prepared_by" id="prepared_by" class="form-control" placeholder="Public Health Nurse" />
            </div>
              <div class="form-group">
              <label>Noted By:</label>
              <input type="text" name="noted_by" id="noted_by" class="form-control" placeholder="Medical Officer" />
            </div>
          </div>
    
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="updatedata" class="btn btn-primary">Update Data</button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <!-- Index Matrix -->
  <section class="content" style="background-color: #F4F6F9; padding: 70px 30px 100px;">
    <div class="container col-md-11">
      <!div class="jumbotron">
        <div class="card" style="border-top: 0.2rem solid #dc3545 !important;">
          <h4 class="ml-3 pt-2 text-uppercase" style="color: #dc3545;">
            Matrix for Medical Clearance
            <button type="button" class="btn btn-primary btn-sm float-right mr-3" data-toggle="modal" data-target="#matrixaddmodal">
              ADD DATA
            </button>  
          </h4>                
        </div>

        <div class="card">
          <div class="card-body">
            <!-- Display Data in table header -->
            <h5 class="text-center">Name of Clinic: <?php echo $clinic; ?></h5>
            <h5 class="text-center">Purpose: <?php echo $purpose; ?></h5>
            <h5 class="mb-5 text-center">Month-Year: <?php echo $month_yr; ?></h5>

            <?php
            $connection = mysqli_connect("localhost", "root", "");
            $db = mysqli_select_db($connection, 'public_html');

            $query = "SELECT * FROM tbl_matrix";
            $query_run = mysqli_query($connection, $query);
            ?>
            <table id="datatableid" class="table table-striped table-bordered table-sm">
              <thead class="table-dark">
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">College Year & Section</th>
                  <th scope="col">Age</th>
                  <th scope="col">Gender</th>
                  <th scope="col">SC</th>
                  <th scope="col">PWD</th>
                  <th scope="col">Date of Request</th>
                  <th scope="col">Date Acted Upon</th>
                  <th scope="col">Remarks</th>
                  <th scope="col">ACTION</th>
                </tr>
              </thead>
              <?php
              if ($query_run) {
                foreach ($query_run as $row) {
              ?>
                  <tbody>
                    <tr>
                      <td><?php echo $row['name']; ?></td>
                      <td><?php echo $row['course']; ?></td>
                      <td><?php echo $row['age']; ?></td>
                      <td><?php echo $row['gender']; ?></td>
                      <td><?php echo $row['sc']; ?></td>
                      <td><?php echo $row['pwd']; ?></td>
                      <td><?php echo $row['date_of_request']; ?></td>
                      <td><?php echo $row['date_acted_upon']; ?></td>
                      <td><?php echo $row['remarks']; ?></td>
                      <td>
                        <!--<button type="button" class="btn btn-info btn-sm viewbtn">VIEW </button>-->
                        <button type="button" class="btn btn-success btn-sm editbtn">EDIT</button>
                        <a target="_blank" href="print_details_med_clearance_nrml.php?id=<?=$row['id']?>" class="btn btn-sm btn-primary"> <i class="fa fa-file-pdf-o"></i> Print  Details</a>
                      </td>
                    </tr>
                  </tbody>
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

  <!-- datepicker -->
  <script>
    $(document).ready(function () {
      // Initialize the datepicker
      $('.datepicker').datepicker({
        format: 'mm-dd-yyyy',
        autoclose: true,
        todayHighlight: true
      });
    });
  </script>


  <!-- data table pagination & import/export csv, pdf, excel -->
  <script>
    $(document).ready(function () {

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
              var header = 'Name of Clinic: <?php echo $clinic; ?> | Purpose: <?php echo $purpose; ?> | Month-Year: <?php echo $month; ?> <?php echo $year; ?>';
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
        ]
      });

      $('#datatableid_paginate').addClass('pagination-sm');

      $('#csv_file_input').change(function () {
        var file = this.files[0];
        if (file) {
          var formData = new FormData();
          formData.append('csv_file', file);

          $.ajax({
            url: 'matrix_code.php', // Specify the path to your import script
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

  <!-- editbtn -->
  <script>
    $(document).ready(function () {
      $('.editbtn').on('click', function () {
        $('#editmodal').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function () {
          return $(this).text();
        }).get();

        console.log(data);

        $('#name').val(data[0]);
        $('#course').val(data[1]);
        $('#age').val(data[2]);
        $('#gender').val(data[3]);
        $('#sc').val(data[4]);
        $('#pwd').val(data[5]);
        $('#date_of_request').val(data[6]);
        $('#date_acted_upon').val(data[7]);
        
        $('#remarks').val(data[8]);
      });
    });
  </script>



  <?php require_once('footer.php'); ?>
</body>
</html>