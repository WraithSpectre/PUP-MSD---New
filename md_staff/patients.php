<?php
// Include the database connection code
include '../connect.php';
include 'header.php';

// Check if the connection is successful
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Handle the form submission for adding a new patient
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and process the form data here
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $type = $_POST['type'];
    $college = $_POST['college'];

    // Insert new patient into the database
    $insert_sql = "INSERT INTO patients (first_name, last_name, date_of_birth, gender, address, contact_number, email, type, college) 
                    VALUES ('$first_name', '$last_name', '$date_of_birth', '$gender', '$address', '$contact_number', '$email', '$type', '$college')";

    if ($mysqli->query($insert_sql) === true) {
        // Redirect or display a success message after adding the patient
        // header("Location: patients.php"); // Uncomment and modify as needed
        // After successfully adding a patient
        header("Location: patients.php");
        exit();
    } else {
        die("Error: " . $connection->error);
    }
}

// SQL query to retrieve data from the patients table
$sql = "SELECT * FROM patients";
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
    <link rel="shortcut icon" type="x-icon" href="../styles/images/pup-logo2.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient List</title>
    <!-- Add any necessary CSS styles for your modal here -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    
    
    
    <!-- Add DataTables CSS and JS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <style>
        button {
            color: #000;
            margin-bottom: .333em;
            padding: .5em 1em;
            border: 1px solid rgba(0, 0, 0, 0.3);
            border-radius: 2px;
            cursor: pointer;
            background-color: linear-gradient(to bottom, rgba(230, 230, 230, 0.1) 0%, rgba(0, 0, 0, 0.1) 100%);
        }
        .custom-width {
    max-width: 800px; /* Adjust the width as needed */
  }
    </style>

</head>

<body>

<section class="content"  style="background-color: #F4F6F9; padding: 100px 30px 200px;">
    <div class="container col-md-11">
            <div class="card"  style="border-top: 0.2rem solid #dc3545 !important;">
            <h4 class="ml-3 pt-2 text-uppercase" style="color: #dc3545">
                Patient Lists
                <button class="btn btn-primary btn-sm float-right mr-3 mt-1" onclick="openAddPatientModal()">
                    Add Patient
                </button>
            </h4>
        </div>
        
         <div class="card">
            <div class="card-body">
                <!-- Patient Table -->
                <table id="datatableid" class="table table-striped table-bordered table-sm">
                    <!-- Patient Table -->
                    <thead class="table-dark">
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Date of Birth</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th>Contact Number</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>College</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <!-- Output data of each row -->
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["first_name"] . "</td>
                                    <td>" . $row["last_name"] . "</td>
                                    <td>" . date('m-d-Y', strtotime($row["date_of_birth"])) . "</td>
                                    <td>" . $row["gender"] . "</td>
                                    <td>" . $row["address"] . "</td>
                                    <td>" . $row["contact_number"] . "</td>
                                    <td>" . $row["email"] . "</td>
                                    <td>" . $row["type"] . "</td>
                                    <td>" . $row["college"] . "</td>
                                    <td>
                                      <button data-id='" . (isset($row['patient_id']) ? $row['patient_id'] : '') . "' class='patientinfo btn btn-success btn-sm'>Show</button>    
                                        
                                      <button data-id='" . (isset($row['patient_id']) ? $row['patient_id'] : '') . "' class='addAppointment btn btn-primary btn-sm'>Add Appointment</button>  
                
                                      <!--<button data-id='" . $row['patient_id'] . "' class='deletePatient btn btn-danger'>Delete</button>-->
                            
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No patients found.</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Add Patient Modal -->
<div id="addPatientModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Patient</h5>
                <span onclick="closeAddPatientModal()" style="cursor: pointer;">&times;</span>
            </div>
            <div class="modal-body">
                <!-- Add your form fields for adding a new patient here -->
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label>First Name: </label>
                        <input type="text" class="form-control" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name: </label>
                        <input type="text" class="form-control" name="last_name" required>
                    </div>
                    <div class="form-group">
                        <label>Patient Type:</label>
                        <select name="type" class="form-control" required>
                            <option value="Student">Student</option>
                            <option value="Staff">Staff</option>
                            <option value="Faculty">Faculty</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label>College:</label>
                        <select name="college" class="form-control" required>
                            <option value="CAF">College of Accountancy and Finance (CAF)</option>
                            <option value="CADBE">College of Design and Built Environment (CADBE)</option>
                            <option value="CAL">College of Arts and Letters (CAL)</option>
                            <option value="CBA">College of Business Administration (CBA)</option>
                            <option value="COC">College of Communication (COC)</option>
                            <option value="CCIS">College of Computer and Information Sciences (CCIS)</option>
                            <option value="COED">College of Education (CE)</option>
                            <option value="CE">College of Engineering (ITECH)</option>
                            <option value="CHK">College of Human Kinetics (CHK)</option>
                            <option value="CL">College of Law (CL)</option>
                            <option value="CPSPA">College of Political Science and Public Administration (CPSPSA)</option>
                            <option value="CSSD">College of Social Science and Development (CSSD)</option>
                            <option value="CS">College of Sciences (CS)</option>
                            <option value="CTHTM">College of Tourism, Hospitality and Transportation Management (CTHTM)</option>
                            <option value="ITECH">Institute of Technology (ITECH)</option>
                            <option value="OUS">Open University System (OUS)</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date of Birth: </label>
                        <input type="date" name="date_of_birth" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Gender: </label>
                        <select name="gender" class="form-control" required>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                            <option value="O">Others</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Address:</label>
                        <input type="text" class="form-control" name="address" required>
                    </div>
                    <div class="form-group">
                        <label>Contact Number: </label>
                        <input type="text" class="form-control" name="contact_number" required>
                    </div>
                    <div class="form-group">
                        <label>Email: </label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="submit" name="insertdata" class="btn btn-primary">Save Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Include any necessary JavaScript for the modal functionality -->
<script>
    
    function openAddPatientModal() {
        $('#addPatientModal').modal('show');
    }

    function closeAddPatientModal() {
        $('#addPatientModal').modal('hide');
    }
    
</script>


<!-- Patient Details Modal -->
<div id="patientModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog custom-width" role="document"> 
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Patient Details</h5>
                <span onclick="closePatientModal()" style="cursor: pointer;">&times;</span>
            </div>
            
            <div class="modal-body">
                <div id="patientModalBody">
                    <!-- Patient details will be dynamically inserted here -->
                </div>
                <!-- Button to add more patient information -->
                <button id="closePatientModal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="button" onclick="openAddInfoModal()" data-toggle="collapse" data-target="#addInfoCollapse" aria-expanded="false" aria-controls="addInfoCollapse">
                      Add More Information
                </button>

    <form id="uploadForm" action="upload_pdf.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="patient_id" id="hiddenPatientId">
    <input type="file" name="pdf_file" id="pdf_file" accept=".pdf">
    <input type="submit" value="Upload PDF" name="submit">
    </form>
    <button class="btn btn-secondary btn-sm" onclick="viewUploadedPDF()">View PDF</button>

    
                <!-- Collapsible form for adding more information -->
                <div class="collapse" id="addInfoCollapse">
                    <div class="card card-body">
                        <!-- Add your form fields for adding more information here -->
                        <form id="addInfoForm" method="post" action="add_more_info.php" enctype="multipart/form-data">
                            <div class="form-group">
                                <h5>Health Examination Record</h5>
                                <label for="additionalInfo">Civil Status:</label>
                                <input class="" id="additionalInfo" name="additional_info" rows="1" required><br>
                                
                                <label for="contact_person">Medical History:</label>
                                <textarea class="form-control" id="contact_person" name="contact_person" rows="2" required></textarea>
                                
                                <label for="contact_person_number">Follow-up Notes:</label>
                                <textarea class="form-control" id="contact_person_number" name="contact_person_number" rows="2" required></textarea>
                                
                                
                                <!--
                                
                                <label for="college_department">College/Department:</label>
                                <input class="" id="college_department" name="college_department" rows="1" required>
                                <label for="course_school_year">Course/School Year:</label>
                                <input class="" id="course_school_year" name="course_school_year" rows="1" required>
                                </div><br>
                                
                                <div>    
                                <h6>I. Past Medical History</h6>
                                 <label for="childhood_illness">Childhood Illness:</label><br>
                                 <label><input type="checkbox" name="childhood_illness[]" value="asthma">Asthma</label>
                                 <label><input type="checkbox" name="childhood_illness[]" value="heartDisease">Heart Disease</label>
                                 <label><input type="checkbox" name="childhood_illness[]" value="seizureDisorder">Seizure Disorder</label>
                                 <label><input type="checkbox" name="childhood_illness[]" value="chickenpox">Chickenpox</label>
                                 <label><input type="checkbox" name="childhood_illness[]" value="measles">Measles</label>
                                 <label><input type="checkbox" name="childhood_illness[]" value="hyperventilation">Hyperventilation</label>
                                 <label><input type="checkbox" name="childhood_illness[]" value="others">Others</label><br><br>

                                 
                                <label for="previous_hospitalization">Previous Hospitalization:</label>
                                <label><input type="radio" name="previous_hospitalization" value="No">No</label>
                                <label><input type="radio" name="previous_hospitalization" value="Yes">Yes</label><br>
                                
                                <label for="operation_surgery">Operation/Surgery:</label>
                                <label><input type="radio" name="operation_surgery" value="No">No</label>
                                <label><input type="radio" name="operation_surgery" value="Yes">Yes</label><br>
                                
                                <label for="curMed">Current Medications:</label><br>
                                <label for="allergies_input">Allergies:</label>
                                <input class="" id="allergies_input" name="allergies" rows="1" required>
                                </div><br>
                                
                              <!--  <div>
                                <h6>II. Family History</h6>
                                 <label><input type="checkbox" name="family_history" value="asthma">Diabetes</label>
                                 <label><input type="checkbox" name="family_history" value="heartDisease">Hypertension</label>
                                 <label><input type="checkbox" name="family_history" value="seizureDisorder">PTB</label>
                                 <label><input type="checkbox" name="family_history" value="chickenpox">Cancer</label>
                                 <label><input type="checkbox" name="family_history" value="measles">Others</label>
                                </div><br>
                                
                                <div>
                                <h6>III. Personal History</h6>
                                 <label for="cigarette_smoking">Cigarette Smoking:</label>
                                 <label><input type="radio" name="cigarette_smoking" value="No">No</label>
                                 <label><input type="radio" name="cigarette_smoking" value="No">Yes</label><br>
                                 
                                 <label for="alcohol_drinking">Alcohol Drinking:</label>
                                 <label><input type="radio" name="alcohol_drinking" value="No">No</label>
                                 <label><input type="radio" name="alcohol_drinking" value="No">Yes</label><br>
                                 
                                 <label for="travel_abroad">Travel Abroad:</label>
                                 <label><input type="radio" name="travel_abroad" value="No">No</label>
                                 <label><input type="radio" name="travel_abroad" value="No">Yes</label><br>
                                </div>-->
                                
                
                            </div>
                            <input type="hidden" name="patient_id" id="hiddenPatientId">
                            <button type="button" onclick="submitForm()" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
  


<!-- Add Appointment Modal -->
<div id="addAppointmentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Appointment</h5>
                <span onclick="closeAddAppointmentModal()" style="cursor: pointer;">&times;</span>
            </div>
            <div class="modal-body">
                <!-- Add your form fields for adding a new appointment here -->
                <form id="addAppointmentForm" method="post" action="add_appointment.php">
                    <div class="form-group">
                        <label for="blood_pressure">Blood Pressure:</label>
                        <input type="text" class="form-control" id="blood_pressure" name="blood_pressure" pattern="\d{2,3}/\d{2,3}" title="Please enter blood pressure in the format: systolic/diastolic (e.g., 120/80)" required>
                        <small class="form-text text-muted">Please enter blood pressure in the format: systolic/diastolic (e.g., 120/80).</small>
                    </div>
                    <div class="form-group">
                        <label for="temperature	">Temperature (C°):</label>
                        <input type="number" class="form-control" id="temperature	" name="temperature" step="0.01" min="0" max="50" required>
                        <small class="form-text text-muted">Please enter the temperature in the range of 00°C to 50°C.</small>
                    </div>
                    <div class="form-group">
                        <label for="complaint">Complaint:</label>
                        <textarea class="form-control" id="complaint" name="complaint" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="appointmentDate">Date:</label>
                        <input type="date" id="appointmentDate" name="appointment_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="appointmentTime">Time:</label>
                        <input type="time" class="form-control" id="appointmentTime" name="appointment_time" required>
                    </div>
                    <div class="form-group">
                        <label for="staffInCharge">Staff in Charge:</label>
                        <select name="staff_in_charge" id="staff_in_charge" required>
                            <option value="Jean Myreen N. Rivera, RN">Jean Myreen N. Rivera, RN</option>
                            <option value="Christopher Ian P. Egar">Christopher Ian P. Egar</option>
                    </select>
                    </div>
                    
                    <div class="modal-footer">
                        <input type="hidden" name="patient_id" id="hiddenPatientIdForAppointment">
                        <button type="button" onclick="submitAppointmentForm()" class="btn btn-primary">Submit</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal 
<div id="deleteConfirmationModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <span onclick="closeDeleteConfirmationModal()" style="cursor: pointer;">&times;</span>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this record? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeDeleteConfirmationModal()">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete Record</button>
            </div>
        </div>
    </div>
</div> -->

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
              var header = 'Mabini Campus College Medical Clinic Patient Lists';
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
            url: 'patients_csv.php', // Specify the path to your import script
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
 

<!-- JavaScript for Appointment Form Submission -->
<script>
    function submitAppointmentForm() {
        // Get form data
        var formData = $('#addAppointmentForm').serialize();

        // AJAX request to submit the form
        $.ajax({
            url: 'add_appointment.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                // You can handle the response here if needed
                // For example, display a success message

                // Hide the modal after submission
                closeAddAppointmentModal();
            }
        });
    }
</script>


<!-- JavaScript to set the patient ID before showing the modal -->
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
                url: 'add_more_info.php',
                type: 'POST',
                data: formData,
                success: function (response) {
                    // You can handle the response here if needed
                    // For example, display a success message

                    // Hide the collapse after submission
                    $('#addInfoCollapse').collapse('hide');
                }
            });
        };
    });

    // Similar to the patient modal JavaScript, attach event handlers to open and close the appointment modal
$('.addAppointment').click(function () {
    // Extract patient ID and set it in the hidden field
    var patientId = $(this).data('id');
    $('#hiddenPatientIdForAppointment').val(patientId);

    // Open the appointment modal
    $('#addAppointmentModal').modal('show');
});

function closeAddAppointmentModal() {
    $('#addAppointmentModal').modal('hide');
}
function closePatientModal() {
            // close the modal
            $('#patientModal').modal('hide');
        }
  //view PDF script      
function viewUploadedPDF() {
    // Get the patient ID from the hidden input
    var patientId = $('#hiddenPatientId').val();

    // Construct the URL to the PHP script that fetches the PDF path
    var fetchPDFPathURL = 'get_pdf_path.php'; // Change to your actual PHP script

    // AJAX request to fetch the PDF path
    $.ajax({
        url: fetchPDFPathURL,
        type: 'POST',
        data: { patient_id: patientId },
        success: function (data) {
            
            // Parse the JSON response
            var response = JSON.parse(data);

            // Check if the file path is available
            if (response.pdf_path) {
                // Open the PDF in a new window or modal, depending on your preference
                window.open(response.pdf_path, '_blank');
            } else {
                alert('PDF not found.');
            }
        },
        error: function () {
            alert('Error fetching PDF path.');
        }
    });
}


</script>

<!-- JavaScript to handle delete confirmation -->
<script>
    var deletePatientId; // Variable to store the patient ID to be deleted

    // Attach event handler to delete button click
    $('.deletePatient').click(function () {
        // Extract patient ID and set it in the variable
        deletePatientId = $(this).data('id');

        // Show the delete confirmation modal
        $('#deleteConfirmationModal').modal('show');
    });

    // Event handler for confirm delete button
    $('#confirmDeleteButton').click(function () {
        console.log('Deleting patient with ID: ' + deletePatientId);
        // AJAX request to delete the patient
        $.ajax({
            url: 'delete_patient.php', // Change to your delete script
            type: 'POST',
            data: { patient_id: deletePatientId },
            success: function (response) {
                console.log('Delete response:', response);
                // You can handle the response here if needed
                // For example, display a success message

                // Hide the delete confirmation modal after deletion
                closeDeleteConfirmationModal();
            }
        });
    });

    // Function to close delete confirmation modal
    function closeDeleteConfirmationModal() {
        $('#deleteConfirmationModal').modal('hide');
    }
</script>

  <?php require_once('footer.php'); ?>

</body>
</html>
    

<?php
// Close the database connection
$mysqli->close();
?>

