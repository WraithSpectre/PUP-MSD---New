<?php
// Include the database connection code
include '../connect.php';
include 'header.php';
include 'footer.php';

// Check if the connection is successful
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Your existing code to fetch data from tbl_supply
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

// Close the database connection
mysqli_close($mysqli);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Request for Medicines and Supplies</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
  
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

  
</head>
<body>

  <!-- Modal -->
  <div class="modal fade" id="supplyaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Request </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form action="supply_code.php" method="POST">

          <div class="modal-body">
            
            <div class="form-group">
              <label>Medicines</label>
              <input type="text" name="medicines" class="form-control" />
            </div>
            <div class="form-group">
              <label>Quantity</label>
              <input type="text" name="m_quantity" class="form-control">
            </div>
            <div class="form-group">
              <label>Date Received</label>
              <input type="text" name="m_date_received" class="form-control datepicker" autocomplete="off" />
            </div>
            <div class="form-group">
              <label>Remarks</label>
              <textarea name="m_remarks" class="form-control" rows="4"></textarea>
            </div>
            <div class="form-group">
              <label>Supplies</label>
              <input type="text" name="supplies" class="form-control" />
            </div>
            <div class="form-group">
              <label>Quantity</label>
              <input type="text" name="s_quantity" class="form-control">
            </div>
            <div class="form-group">
              <label>Date Received</label>
              <input type="text" name="s_date_received" class="form-control datepicker" autocomplete="off" />
            </div>
            <div class="form-group">
              <label>Remarks</label>
              <textarea name="s_remarks" class="form-control" rows="4"></textarea>
            </div>

            <!-- ADDITIONAL INFO FOR TABLE HEADER & FOOTER -->
            <label class="mt-5 mb-3">ADDITIONAL INFO FOR TABLE HEADER & FOOTER:</label>
            <div class="form-group">
              <label>Date</label>
              <input type="text" name="date" class="form-control" />
            </div>
            <div class="form-group">
              <label>Clinic</label>
              <input type="text" name="clinic" class="form-control" />
            </div>
            <div class="form-group">
              <label>Campus</label>
              <input type="text" name="campus" class="form-control" />
            </div>
              <div class="form-group">
              <label>Noted By:</label>
              <input type="text" name="noted_by" class="form-control" placeholder="Medical Officer" />
            </div>
            <div class="form-group">
              <label>Status:</label>
              <input type="text" name="status" id="status" class="form-control" placeholder="Pending" value="Pending" readonly />
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="insertdata" class="btn btn-primary">Save Request</button>
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

        <form action="supply_code.php" method="POST">

          <div class="modal-body">

            <input type="hidden" name="update_id" id="update_id">

            <div class="form-group">
              <label for="medicines">Medicines</label>
              <input type="text" name="medicines" id="medicines" class="form-control" />
            </div>

            <div class="form-group">
              <label for="m_quantity">Quantity</label>
              <input type="text" name="m_quantity" id="m_quantity" class="form-control">
            </div>

            <div class="form-group">
              <label for="m_date_received">Date Received</label>
              <input type="text" name="m_date_received" id="m_date_received" class="form-control datepicker" autocomplete="off" />
            </div>

            <div class="form-group">
              <label for="m_remarks">Remarks</label>
              <textarea name="m_remarks" id="m_remarks" class="form-control" rows="4"></textarea>
            </div>

            <div class="form-group">
              <label for="supplies">Supplies</label>
              <input type="text" name="supplies" id="supplies" class="form-control" />
            </div>

            <div class="form-group">
              <label for="s_quantity">Quantity</label>
              <input type="text" name="s_quantity" id="s_quantity" class="form-control">
            </div>

            <div class="form-group">
              <label for="s_date_received">Date Received</label>
              <input type="text" name="s_date_received" id="s_date_received" class="form-control datepicker" autocomplete="off" />
            </div>

            <div class="form-group">
              <label for="s_remarks">Remarks</label>
              <textarea name="s_remarks" id="s_remarks" class="form-control" rows="4"></textarea>
            </div>

          <!-- ADDITIONAL INFO FOR TABLE HEADER & FOOTER -->
          <label class="mt-5 mb-3">ADDITIONAL INFO FOR TABLE HEADER & FOOTER:</label>
            <div class="form-group">
              <label>Date</label>
              <input type="text" name="date" id="date" class="form-control" />
            </div>
            <div class="form-group">
              <label>Clinic </label>
              <input type="text" name="clinic" id="clinic" class="form-control" />
            </div>
            <div class="form-group">
              <label>Campus</label>
              <input type="text" name="campus" id="campus" class="form-control" />
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
            <button type="submit" name="updatedata" id="date" class="btn btn-primary">Update Data</button>
          </div>
        </form>

      </div>
    </div>
  </div>

  <!-- Index Supply -->
  <section class="content" style="background-color: #F4F6F9; padding: 70px 30px 100px;">
    <div class="container col-md-11">
      <!div class="jumbotron">
        <div class="card" style="border-top: 0.2rem solid #dc3545 !important;">
          <h4 class="ml-3 pt-2 text-uppercase" style="color: #dc3545;">
            Request for Medicines and Supplies
            <button type="button" class="btn btn-primary btn-sm float-right mr-3" data-toggle="modal" data-target="#supplyaddmodal">
              Add Request
            </button>  
          </h4>                
        </div>
      
        <div class="card">
          <div class="card-body"  style="overflow-x: auto;">
            <!-- Display Data in table header -->
            <h5 class="text-center">Date: <?php echo $date; ?></h5>
            <h5 class="text-center">Clinic: <?php echo $clinic; ?></h5>
            <h5 class="mb-5 text-center">Campus: <?php echo $campus; ?></h5>

            <?php
            $connection = mysqli_connect("localhost", "u868151448_sherry", "04202002Pjs");
            $db = mysqli_select_db($connection, 'u868151448_pupmsd');

            $query = "SELECT * FROM tbl_supply";
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
                        <button type="button" class="btn btn-success btn-sm editbtn">EDIT </button>
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

      // Define openAddInfoModal function
      window.openAddInfoModal = function () {
        $('#addInfoCollapse').collapse('show');
      };

      // Define submitForm function
      window.submitForm = function () {
      // Get form data
        var formData = $('#addInfoForm').serialize();

        // AJAX request to submit the form
        $.ajax({
          url: 'supply_code.php',
          type: 'POST',
          data: formData,
          success: function (response) {

            // Hide the collapse after submission
            $('#addInfoCollapse').collapse('hide');
          }
        });
      }
    });
  </script>


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
        ]
      });

      $('#datatableid_paginate').addClass('pagination-sm');

      $('#csv_file_input').change(function () {
        var file = this.files[0];
        if (file) {
          var formData = new FormData();
          formData.append('csv_file', file);

          $.ajax({
            url: 'supply_code.php', // Specify the path to your import script
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

        $('#update_id').val(data[0]);
        $('#medicines').val(data[1]);
        $('#m_quantity').val(data[2]);
        $('#m_date_received').val(data[3]);
        $('#m_remarks').val(data[4]);
        $('#supplies').val(data[5]);
        $('#s_quantity').val(data[6]);
        $('#s_date_received').val(data[7]);
        $('#s_remarks').val(data[8]);
      });
    });
  </script>


  <?php require_once('footer.php'); ?>
</body>
</html>