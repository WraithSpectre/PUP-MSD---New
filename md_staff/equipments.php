<?php
$connection = mysqli_connect("localhost", "u868151448_sherry", "04202002Pjs");
$db = mysqli_select_db($connection, 'u868151448_pupmsd');

$query = "SELECT * FROM tbl_equipments";
$query_run = mysqli_query($connection, $query);

if ($query_run) {
    $row = mysqli_fetch_assoc($query_run);
    $month = $row['month'];
    $year = $row['year'];
    $date = ($row['date'] != '00-00-0000') ? $row['date'] : 'N/A'; 
    $submitted_by_1 = $row['submitted_by_1'];
    $submitted_by_2 = $row['submitted_by_2'];
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
  <title>Medical Equipments Inventory</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

</head>
<body>
  <?php require_once('header.php'); ?>

  <!-- Modal -->
  <div class="modal fade" id="equipmentsaddmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Data </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <form action="equipments_code.php" method="POST">

          <div class="modal-body">
            <div class="form-group">
              <label>General Description</label>
              <select name="general_description" class="form-control mb-3" >
                <option value="">----------------------- Select an option -----------------------</option>
                <option value="Stethoscope">Stethoscope</option>
                <option value="Sphygmomanometer, table, aneroid">Sphygmomanometer, table, aneroid</option>
                <option value="Sphygmomanometer, pocket, aneroid">Sphygmomanometer, pocket, aneroid</option>
                <option value="Sphygmomanometer with stand">Sphygmomanometer with stand</option>
                <option value="Oto-ophthalmoscope set">Oto-ophthalmoscope set</option>
                <option value="Thermal Scanner">Thermal Scanner</option>
                <option value="Thermoscan (Infared) with stand">Thermoscan (Infared) with stand</option>
                <option value="Nebulizer">Nebulizer</option>
                <option value="Manual resuscitator, adult">Manual resuscitator, adult</option>
                <option value="Minor surgical set">Minor surgical set</option>
                <option value="Aluminum tray with cover">Aluminum tray with cover</option>
                <option value="Aluminum kidney basin">Aluminum kidney basin</option>
                <option value="Oval magnifying lamp with stand">Oval magnifying lamp with stand</option>
                <option value="Finger pulse oximeter">Finger pulse oximeter</option>
                <option value="Oxygen tank with regulator">Oxygen tank with regulator</option>
                <option value="Oxygen tank (reserved)">Oxygen tank (reserved)</option>
                <option value="Oxygen tank carrier">Oxygen tank carrier</option>
                <option value="Portable Oxygen tank with regulator">Portable Oxygen tank with regulator</option>
                <option value="Glucometer">Glucometer</option>
                <option value="Stretcher, folding">Stretcher, folding</option>
                <option value="Wheelchair">Wheelchair</option>
                <option value="Emergency Trauma Bag">Emergency Trauma Bag</option>
                <option value="Dressing cart">Dressing cart</option>
                <option value="Hospital bed with mattress">Hospital bed with mattress</option>
                <option value="Medicine cabinet">Medicine cabinet</option>
                <option value="Weighing Scare unit height and bar type">Weighing Scare unit height and bar type</option>
                <option value="Spine board">Spine board</option>
                <option value="ECG machine">ECG machine</option>
                <option value="Ice cap">Ice cap</option>
                <option value="Ice pack (coleman)">Ice pack (coleman)</option>
                <option value="Ice chest">Ice chest</option>
                <option value="Hot water bag">Hot water bag</option>
                <option value="Towels for ice pack/ice cap">Towels for ice pack/ice cap</option>
                <option value="Bedsheets and pillow cases">Bedsheets and pillow cases</option>
                <option value="Blankets/ linens">Blankets/ linens</option>
                <option value="Pillows">Pillows</option>
                <option value="Autoclave">Autoclave</option>
                <option value="Sterilizer">Sterilizer</option>
                <option value="First Aid Kit Bag (PHN)">First Aid Kit Bag (PHN)</option>
                <option value="Electric airpot">Electric airpot</option>
                <option value="Computer">Computer</option>
                <option value="Printer">Printer</option>
                <option value="Air Purifier">Air Purifier</option>
                <option value="Ultraviolet Disinfection Light">Ultraviolet Disinfection Light</option>
                <option value="Shredder">Shredder</option>
                <option value="Folding Bed (Military Style with Bag)">Folding Bed (Military Style with Bag)</option>
                <option value="Industrial Fan (Iwata) Tripod Feet">Industrial Fan (Iwata) Tripod Feet</option>
                <option value="Standard Exhaust Fan">Standard Exhaust Fan</option>
              </select>

              <label>If not included in the list, please specify your request.</label>
              <input type="text" name="request" id="request" class="form-control" />
              <input type="hidden" name="custom_description" id="custom_description" value="0" />
            </div>

            <div class="form-group">
              <label>Quantity</label>
              <input type="text" name="quantity" class="form-control" />
            </div>

            <div class="form-group">
              <label>Please check if:</label>
              
              <div class="form-check mb-3 ml-3">
                <input type="checkbox" class="form-check-input" id="serviceable" name="serviceable" />
                <label class="form-check-label" for="serviceable">Serviceable</label>
              </div>
              
              <div class="form-check mb-3 ml-3">
                <input type="checkbox" class="form-check-input" id="nonserviceable" name="nonserviceable" />
                <label class="form-check-label">Nonserviceable</label>
                <div class="ml-4">
                  <input type="radio" class="form-check-input" id="repair" name="nonserviceable_option" value="For Repair" />
                  <label class="form-check-label" for="repair">For Repair</label>
                </div>
                <div class="ml-4">
                  <input type="radio" class="form-check-input" id="condemn" name="nonserviceable_option" value="For Condemn" />
                  <label class="form-check-label" for="condemn">For Condemn</label>
                </div>
              </div>

              <div class="form-check mb-3 ml-3">
                <input type="checkbox" class="form-check-input" id="need_replacement" name="need_replacement" />
                <label class="form-check-label" for="need_replacement">Need Replacement</label>
              </div>
              
              <div class="form-check mb-3 ml-3">
                <input type="checkbox" class="form-check-input" id="additional" name="additional" />
                <label class="form-check-label" for="additional">Additional</label>
              </div>
              
              <div class="form-group ml-3">
                <label>Quantity of Request</label>
                <input type="text" name="quantity_of_request" class="form-control" />
              </div>
            </div>
            
            <!-- ADDITIONAL INFO FOR TABLE HEADER & FOOTER -->
            <label class="mt-5 mb-3">ADDITIONAL INFO FOR TABLE HEADER & FOOTER:</label>
            <div class="form-group">
              <label>Mabini Campus College Medical Clinic As of</label>
              <input type="text" name="month" id="month" class="form-control" placeholder="Month" />
            </div>
            <div class="form-group">
              <input type="int" name="year" id="year" class="form-control" placeholder="Year" />
            </div>
            <div class="form-group">
              <label>Date of submission:</label>
              <input type="text" name="date" id="date" class="form-control" />
            </div>
            <div class="form-group">
              <label>Submitted By:</label>
              <input type="text" name="submitted_by_1" id="submitted_by_1" class="form-control" placeholder="Public Health Nurse " />
            </div>
            <div class="form-group">
              <input type="text" name="submitted_by_2" id="submitted_by_2" class="form-control" placeholder="Medical Officer" />
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

        <form action="equipments_code.php" method="POST">

          <div class="modal-body">

            <input type="hidden" name="update_id" id="update_id">

            <div class="form-group">
              <label for="general_description">General Description</label>
              <select name="general_description" id="general_description" class="form-control">
                <option value="">----------------------- Select an option -----------------------</option>
                <option value="Stethoscope">Stethoscope</option>
                <option value="Sphygmomanometer, table, aneroid">Sphygmomanometer, table, aneroid</option>
                <option value="Sphygmomanometer, pocket, aneroid">Sphygmomanometer, pocket, aneroid</option>
                <option value="Sphygmomanometer with stand">Sphygmomanometer with stand</option>
                <option value="Oto-ophthalmoscope set">Oto-ophthalmoscope set</option>
                <option value="Thermal Scanner">Thermal Scanner</option>
                <option value="Thermoscan (Infared) with stand">Thermoscan (Infared) with stand</option>
                <option value="Nebulizer">Nebulizer</option>
                <option value="Manual resuscitator, adult">Manual resuscitator, adult</option>
                <option value="Minor surgical set">Minor surgical set</option>
                <option value="Aluminum tray with cover">Aluminum tray with cover</option>
                <option value="Aluminum kidney basin">Aluminum kidney basin</option>
                <option value="Oval magnifying lamp with stand">Oval magnifying lamp with stand</option>
                <option value="Finger pulse oximeter">Finger pulse oximeter</option>
                <option value="Oxygen tank with regulator">Oxygen tank with regulator</option>
                <option value="Oxygen tank (reserved)">Oxygen tank (reserved)</option>
                <option value="Oxygen tank carrier">Oxygen tank carrier</option>
                <option value="Portable Oxygen tank with regulator">Portable Oxygen tank with regulator</option>
                <option value="Glucometer">Glucometer</option>
                <option value="Stretcher, folding">Stretcher, folding</option>
                <option value="Wheelchair">Wheelchair</option>
                <option value="Emergency Trauma Bag">Emergency Trauma Bag</option>
                <option value="Dressing cart">Dressing cart</option>
                <option value="Hospital bed with mattress">Hospital bed with mattress</option>
                <option value="Medicine cabinet">Medicine cabinet</option>
                <option value="Weighing Scare unit height and bar type">Weighing Scare unit height and bar type</option>
                <option value="Spine board">Spine board</option>
                <option value="ECG machine">ECG machine</option>
                <option value="Ice cap">Ice cap</option>
                <option value="Ice pack (coleman)">Ice pack (coleman)</option>
                <option value="Ice chest">Ice chest</option>
                <option value="Hot water bag">Hot water bag</option>
                <option value="Towels for ice pack/ice cap">Towels for ice pack/ice cap</option>
                <option value="Bedsheets and pillow cases">Bedsheets and pillow cases</option>
                <option value="Blankets/ linens">Blankets/ linens</option>
                <option value="Pillows">Pillows</option>
                <option value="Autoclave">Autoclave</option>
                <option value="Sterilizer">Sterilizer</option>
                <option value="First Aid Kit Bag (PHN)">First Aid Kit Bag (PHN)</option>
                <option value="Electric airpot">Electric airpot</option>
                <option value="Computer">Computer</option>
                <option value="Printer">Printer</option>
                <option value="Air Purifier">Air Purifier</option>
                <option value="Ultraviolet Disinfection Light">Ultraviolet Disinfection Light</option>
                <option value="Shredder">Shredder</option>
                <option value="Folding Bed (Military Style with Bag)">Folding Bed (Military Style with Bag)</option>
                <option value="Industrial Fan (Iwata) Tripod Feet">Industrial Fan (Iwata) Tripod Feet</option>
                <option value="Standard Exhaust Fan">Standard Exhaust Fan</option>
              </select>

              <label>If not included in the list, please specify your request.</label>
              <input type="text" name="request" id="request" class="form-control" />
              <input type="hidden" name="custom_description" id="custom_description" value="0" />
            </div>

            <div class="form-group">
              <label for="quantity">Quantity</label>
              <input type="text" name="quantity" id="quantity" class="form-control" />
            </div>

            <div class="form-group">
              <label>Please check if:</label>
              
              <div class="form-check mb-3 ml-3">
                <input type="checkbox" class="form-check-input" id="serviceable" name="serviceable" />
                <label class="form-check-label" for="serviceable">Serviceable</label>
              </div>
              
              <div class="form-check mb-3 ml-3">
                <input type="checkbox" class="form-check-input" id="nonserviceable" name="nonserviceable" />
                <label class="form-check-label">Nonserviceable</label>
                <div class="ml-4">
                  <input type="radio" class="form-check-input" id="repair" name="nonserviceable_option" value="For Repair" />
                  <label class="form-check-label" for="repair">For Repair</label>
                </div>
                <div class="ml-4">
                  <input type="radio" class="form-check-input" id="condemn" name="nonserviceable_option" value="For Condemn" />
                  <label class="form-check-label" for="condemn">For Condemn</label>
                </div>
              </div>

              <div class="form-check mb-3 ml-3">
                <input type="checkbox" class="form-check-input" id="need_replacement" name="need_replacement" />
                <label class="form-check-label" for="need_replacement">Need Replacement</label>
              </div>
              
              <div class="form-check mb-3 ml-3">
                <input type="checkbox" class="form-check-input" id="additional" name="additional" />
                <label class="form-check-label" for="additional">Additional</label>
              </div>
              
              <div class="form-group ml-3">
                <label>Quantity of Request</label>
                <input type="text" name="quantity_of_request" class="form-control" />
              </div>
            </div>
            
            <!-- ADDITIONAL INFO FOR TABLE HEADER & FOOTER -->
            <label class="mt-5 mb-3">ADDITIONAL INFO FOR TABLE HEADER & FOOTER:</label>
            <div class="form-group">
              <label>Mabini Campus College Medical Clinic As of</label>
              <input type="text" name="month" id="month" class="form-control" placeholder="Month" />
            </div>
            <div class="form-group">
              <input type="int" name="year" id="year" class="form-control" placeholder="Year" />
            </div>
            <div class="form-group">
              <label>Date of submission:</label>
              <input type="text" name="date" id="date" class="form-control" />
            </div>
            <div class="form-group">
              <label>Submitted By:</label>
              <input type="text" name="submitted_by_1" id="submitted_by_1" class="form-control" placeholder="Public Health Nurse " />
            </div>
            <div class="form-group">
              <input type="text" name="submitted_by_2" id="submitted_by_2" class="form-control" placeholder="Medical Officer" />
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


  <!-- Index Equipments -->
  <section class="content" style="background-color: #F4F6F9; padding: 70px 30px 200px;">
    <div class="container col-md-11">
      <!div class="jumbotron">
        <div class="card" style="border-top: 0.2rem solid #dc3545 !important;">
          <h4 class="ml-3 pt-2 text-uppercase" style="color: #dc3545">
            Medical Equipments Inventory
            <button type="button" class="btn btn-primary btn-sm float-right mr-3" data-toggle="modal" data-target="#equipmentsaddmodal">
              ADD DATA
            </button> 
          </h4>
        </div>

        <div class="card">
          <div class="card-body">
            <!-- Display Data in table header -->
            <h5 class="text-center">MEDICAL CLINIC / CAMPUS:  Mabini Campus College Medical Clinic</h5>
            <h5 class="text-center">As of <?php echo $month; ?> <?php echo $year; ?></h5>
            <h5 class="mb-5 text-center">Date of submission: <?php echo $date; ?></h5>

            <?php
            $connection = mysqli_connect("localhost", "u868151448_sherry", "04202002Pjs");
            $db = mysqli_select_db($connection, 'u868151448_pupmsd');

            $query = "SELECT * FROM tbl_equipments";
            $query_run = mysqli_query($connection, $query);
            ?>
            <table id="datatableid" class="table table-striped table-bordered table-sm">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">General Description</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Serviceable</th>
                  <th scope="col">Nonserviceable</th>
                  <th scope="col">Nonserviceable Option</th>
                  <th scope="col">Need Replacement</th>
                  <th scope="col">Additional</th>
                  <th scope="col">Quantity of Request</th>
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
                      <td><?php echo $row['general_description']; ?></td>
                      <td><?php echo $row['quantity']; ?></td>
                      <td><?php echo $row['serviceable'] == 1 ? 'Yes' : 'No'; ?></td>
                      <td><?php echo $row['nonserviceable'] == 1 ? 'Yes' : 'No'; ?></td>
                      <td><?php echo $row['nonserviceable_option']; ?></td>
                      <td><?php echo $row['need_replacement'] == 1 ? 'Yes' : 'No'; ?></td>
                      <td><?php echo $row['additional'] == 1 ? 'Yes' : 'No'; ?></td>
                      <td><?php echo $row['quantity_of_request']; ?></td>

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
                  <th colspan="10">Submitted By: </th>
                </tr>
                <tr>
                  <th colspan="10">Public Health Nurse: <?php echo $submitted_by_1; ?> | Medical Officer: <?php echo $submitted_by_2; ?> </th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- JavaScript includes -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

  <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

  <!-- Bootstrap-datepicker library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

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
      $('#datatableid').DataTable({
        dom: 'Bfrtip',
        //"pagingType": "full_numbers",
        "lengthMenu": [
          [10, 25, 50, -1],
          [10, 25, 50, "All"]
        ],
        responsive: true,
        language: {
          //search: "_INPUT_",
          searchPlaceholder: "Search records",
        },
        buttons: [
          'copy', 'csv', 'excel', {
            extend: 'pdfHtml5',
            orientation: 'landscape',
            customize: function (doc) {
              // Add header and footer to the PDF
              var header = 'Mabini Campus College Medical Clinic As of <?php echo $month; ?> <?php echo $year; ?> | Date of submission: <?php echo date('F d, Y', strtotime($date)); ?>';
              var footer = 'Submitted By | Public Health Nurse: <?php echo $submitted_by_1; ?> | Medical Officer: <?php echo $submitted_by_2; ?>';
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
            url: 'equipments_code.php', // Specify the path to your import script
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

        var data = $tr.find("td").map(function () {
          return $(this).text();
        }).get();

        console.log(data);

        $('#update_id').val(data[0]);
        //issue: selected option does not show in the view modal

        var $generalDescriptionSelect = $('#general_description');
        var selectedOption = data[1];

        $generalDescriptionSelect.empty();

        $generalDescriptionSelect.append($('<option>', {
          value: '',
          text: 'Select an option'
        }));

        var predefinedOptions = [
          'Stethoscope',
          'Sphygmomanometer, table, aneroid',
          'Sphygmomanometer, pocket, aneroid',
          'Sphygmomanometer with stand',
          'Oto-ophthalmoscope set',
          'Thermal Scanner',
          'Thermoscan (Infared) with stand',
          'Nebulizer',
          'Manual resuscitator, adult',
          'Minor surgical set',
          'Aluminum tray with cover',
          'Aluminum kidney basin',
          'Oval magnifying lamp with stand',
          'Finger pulse oximeter',
          'Oxygen tank with regulator',
          'Oxygen tank (reserved)',
          'Oxygen tank carrier',
          'Portable Oxygen tank with regulator',
          'Glucometer',
          'Stretcher, folding',
          'Wheelchair',
          'Emergency Trauma Bag',
          'Dressing cart',
          'Hospital bed with mattress',
          'Medicine cabinet',
          'Weighing Scare unit height and bar type',
          'Spine board',
          'ECG machine',
          'Ice cap',
          'Ice pack (coleman)',
          'Ice chest',
          'Hot water bag',
          'Towels for ice pack/ice cap',
          'Bedsheets and pillow cases',
          'Blankets/ linens',
          'Pillows',
          'Autoclave',
          'Sterilizer',
          'First Aid Kit Bag (PHN)',
          'Electric airpot',
          'Computer',
          'Printer',
          'Air Purifier',
          'Ultraviolet Disinfection Light',
          'Shredder',
          'Folding Bed (Military Style with Bag)',
          'Industrial Fan (Iwata) Tripod Feet',
          'Standard Exhaust Fan',
        ];

        for (var i = 0; i < predefinedOptions.length; i++) {
          var option = predefinedOptions[i];
          $generalDescriptionSelect.append($('<option>', {
            value: option,
            text: option
          }));
        }

        $generalDescriptionSelect.append($('<option>', {
          value: '',
          text: 'Other'
        }));

        if (predefinedOptions.includes(selectedOption)) {
          $generalDescriptionSelect.val(selectedOption);
          $('#request').val('');
        } else {
          $generalDescriptionSelect.val('Other');
          $('#request').val(selectedOption);
        }

        $('#general_description').val(data[1]);

        $('#quantity').val(data[2]);
        //issue: selected checkbox and radio button does not show as selected in the view modal
        $('#serviceable').prop('checked', data[3].toLowerCase() === 'yes');
        $('#nonserviceable').prop('checked', data[4].toLowerCase() === 'yes');
        $('input[name="nonserviceable_option"]').filter('[value="' + data[5] + '"]').prop('checked', true);        
        $('#need_replacement').prop('checked', data[6].toLowerCase() === 'yes');
        $('#additional').prop('checked', data[7].toLowerCase() === 'yes');

        $('#quantity_of_request').val(data[8]);
      });
    });
  </script>


  <?php require_once('footer.php'); ?>
</body>
</html>