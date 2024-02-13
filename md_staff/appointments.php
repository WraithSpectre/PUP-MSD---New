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
    <link rel="shortcut icon" type="x-icon" href="../styles/images/pup-logo2.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments</title>
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
            <div class="card"  style="border-top: 0.2rem solid #dc3545 !important;">
              <h4 class="ml-3 pt-2 text-uppercase" style="color: #dc3545;">
                Patient Appointments
              </h4>                
            </div>
            
            
            <div class="card">
                <div class="card-body">
                    <!-- Appointment Table -->
                    <table id="datatableid" class="table table-striped table-bordered table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>Patient Name</th>
                                <th>Patient Type</th>
                                <th>Blood Pressure</th>
                                <th>Temperature (C°)</th>
                                <th>Complaint</th>
                                <th>Appointment Date</th>
                                <th>Appointment Time</th>
                                <th>Staff in Charge</th>
                                <th>View Record</th>
                                <th>Send</th>
                            </tr>
                        </thead>
                    
                        <!-- Output data of each row -->
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $appDate = $row["appointment_date"];
                                $timestamp = strtotime($appDate);
                                $formattedAD = date("F j, Y", $timestamp);
                                 
                                echo "<tr>
                                        <td>" . $row["first_name"] . " " . $row["last_name"] . "</td>
                                        <td>" . $row["type"] . "</td>
                                        <td>" . $row["blood_pressure"] . "</td>
                                        <td>" . $row["temperature"] . "</td>
                                        <td>" . $row["complaint"] . "</td>
                                        <td>" . $formattedAD . "</td>
                                        <td>" . $row["appointment_time"] . "</td>
                                        <td>" . $row["staff_in_charge"] . "</td>
                                        <td>
                                            <button data-id='" . (isset($row['patient_id']) ? $row['patient_id'] : '') . "' class='patientinfo btn btn-success'>Show</button> 
                                        </td>
                                        <td>
                                            <button data-id='" . (isset($row['patient_id']) ? $row['patient_id'] : '') . "' data-appointment-id='" . (isset($row['appointment_id']) ? $row['appointment_id'] : '') . "' class='addConsultation btn btn-primary'>Add Consultation</button>
                      
                                        </td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No appointments found.</td></tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </section>

<div id="patientModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog"> 
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Patient Details</h5>    
                <span onclick="closePatientModal()" style="cursor: pointer;">&times;</span>
            </div>
            <div class="modal-body">
                <div id="patientModalBody">
                    <!-- Patient details will be dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>
</div>
    
<!-- Add Consultation Modal -->
<div id="addConsultationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Consultation</h5>
                <span onclick="closePatientConsultation()" style="cursor: pointer;">&times;</span>
            </div>
            <div class="modal-body">
                <!-- Form for adding a new consultation -->
                <form id="addConsultationForm" method="post" action="process_consultation.php">
                    <a href="javascript:void(0);" id="addMedication">Add Medication</a>
                    <div class="dynamic_medication">
                    
                    </div>
                    
                    <textarea id="dynamic_med_holder" rows=4 class="form-control mb-3" name="dynamic_med_holder" style="display:none;"></textarea>
          
                    <!-- Teatment Input -->
                    <div class="form-group">
                        <label>Treatment:</label>
                        <textarea class="form-control" name="treatment" rows="2" cols="50" required></textarea>
                    </div>
                    
                    <!-- Notes Input -->
                    <div class="form-group">
                        <label>Notes:</label>
                        <textarea class="form-control" name="notes" rows="4" cols="50" required></textarea>
                    </div>
                    
                    <!-- Status Input -->
                    <div class="form-group">
                    <label>Status:</label>
                        <select class="form-control" name="status" required>
                            <option value="Done">Done</option>
                            <option value="On-going - For Treatment">On-going - For Treatment</option>
                        </select>
                    </div>
                    
                    
                    <!-- Submit Button -->
                    <input type="hidden" name="patient_id" id="hiddenPatientIdForConsultation">
                    <input type="hidden" name="appointment_id" id="hiddenAppointmentIdForConsultation">
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="submitConsultationForm()">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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
                    var header = 'Mabini Campus College Medical Clinic Patient Appointments';
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

<!-- JavaScript to handle modal interactions -->
        <script type="text/javascript">
            $(document).ready(function () {
                // Existing code for patient info modal
                var counter = 0;
                
                // Function to open the modal
                function openConsultationModal() {
                    $('#addConsultationModal').modal('show');
                }

                // Function to close the modal
                function closeAddConsultation() {
                    $('#addConsultationModal').modal('hide');
                }

                // Function to submit the form using AJAX
                function submitConsultationForm() {
                    // Gather form data
                    formData = $('#addConsultationForm').serialize();

                    // Use AJAX to send data to the server
                    $.ajax({
                        url: 'process_consultation.php', // Replace with your actual processing script
                        type: 'POST',
                        data: formData,
                        success: function (response) {
                            // Handle the response, e.g., display a success message
                            alert(response);
                            // Close the modal
                            closeAddConsultation();
                        },
                        error: function (xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                }
                
                $("#addMedication").on("click", function(){
                    
                    var inventoryOptions = '<?php echo json_encode($inventoryObj) ;?>';

                    inventoryOptions = JSON.parse(inventoryOptions);
                    var medication_select = "<label>Medication</label> <select name='medication_"+counter+"'>";
                    for (i in inventoryOptions){
                        medication_select += "<option value='"+inventoryOptions[i]['med_id']+"'>"+inventoryOptions[i]['medicine']+"</option>"
                    }
                    medication_select += "</select>";
                    var medication_input = "<label>Amount: </label> <input type='number' name='quantity_"+counter+"'/><br>";
                    var medication_type = "<label>Type: </label> <select name='type_"+counter+"'>";
                        medication_type += "<option value='Ea'>Ea</option>" 
                                          + "<option value='Box'>Box</option>"
                                          + "<option value='Bottle'>Bottle</option>"
                                          +"</select>";
                        
                    var medication_dosage = "<label>Dosage </label> <input type='text' name='dosage_"+counter+"'/><br>";

                    $(".dynamic_medication").append($(medication_select + medication_input + medication_type + medication_dosage) );
                    counter++;
                    console.log(counter,'counter');

                });

                // Attach click event to the button
                $('.addConsultation').click(function () {
                    openConsultationModal();
                    var patientId = $(this).data('id');
                $('#hiddenPatientIdForConsultation').val(patientId);
                    var appointmentId = $(this).data('appointment-id');
                $('#hiddenAppointmentIdForConsultation').val(appointmentId);
                });
            });

            function closePatientModal() {
                // close the modal
                $('#patientModal').modal('hide');
            }
        </script>
 

    
<!-- JavaScript to handle modal interactions -->
<script>
    var dynamicValueHolder = [];
    // Function to open the modal
    function openConsultationModal() {
        $('#consultationModal').modal('show');
    }

    // Function to close the modal
    function closeConsultationModal() {
        $('#consultationModal').modal('hide');
    }

    // Function to submit the form using AJAX
    function submitConsultationForm() {
        // Gather form data
        var medValues = $(".dynamic_medication select, input").not('[id*="hidden"]');
        var medicineLen = medValues.length / 2;
        for (i=0; i <= medicineLen; i++){
            var medId = $(".dynamic_medication select[name*=medication_"+i+"]").val();
            var medAmount = $(".dynamic_medication input[name*=quantity_"+i+"]").val();
            var medDosage = $(".dynamic_medication input[name*=dosage_"+i+"]").val();
            var medType = $(".dynamic_medication select[name*=type_"+i+"]").val();
            dynamicValueHolder.push({"med_id": medId, "amount": medAmount, "med_dosage": medDosage, "med_type": medType });
        }
        
        $("#dynamic_med_holder").text(JSON.stringify(dynamicValueHolder));
        
        var formData = $('#addConsultationForm').serialize();

        // Use AJAX to send data to the server
        $.ajax({
            url: 'process_consultation.php', // Replace with your actual processing script
            type: 'POST',
            data: formData,
            success: function (response) {
                // Handle the response, e.g., display a success message
                alert(response);
                // Close the modal
                closeConsultationModal();
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    }

    // Attach click event to the button
    $('#openModalBtn').click(function () {
        openConsultationModal();
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.patientinfo').click(function () {
            var patientid = $(this).data('id');

            // Set the patient ID in the hidden field
            $('#hiddenPatientId').val(patientid);

            // AJAX request to fetch additional information
            $.ajax({
                url: 'get_patient_info.php',
                type: 'POST',
                data: {patient_id: patientid},
                success: function (data) {
                    // Populate the modal with patient details
                    $('#patientModalBody').html(data);

                    // Use Bootstrap's modal function to show the modal
                    $('#patientModal').modal('show');
                }
            });
        });
    });
</script>
    


    <?php require_once('footer.php'); ?>

</body>
</html>

<?php
// Close the database connection
$mysqli->close();
?>