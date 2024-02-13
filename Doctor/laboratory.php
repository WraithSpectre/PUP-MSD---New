<?php
// Include the database connection code
include '../connect.php';
include 'header.php';
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

<!-- Diagnosis Modal -->
<div id="addDiagnosisModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Diagnose Patient</h5>
                <span onclick="closeAddPatientModal()" style="cursor: pointer;">&times;</span>
            </div>
            <div class="modal-body">
                <!-- Add your form fields for adding a new patient here -->
                <form action="process_lab_request.php" method="post">
                    <label for="lab_id">Lab ID:</label>
                    <input type="text" id="lab_id" name="lab_id" required>

                    <label for="consultation_id">Consultation ID:</label>
                    <input type="text" id="consultation_id" name="consultation_id" required>

                    <label for="lab_request">Lab Request:</label>
                    <select id="lab_request" name="lab_request" required>
                    <label for="lab_request">Chest X-Ray:</label>
                        <option value="PA">PA</option>
                        <option value="AP-LAT">AP-LAT</option>
                        <label for="lab_request">Others</label>
                        <option value="ECG">ECG</option>
                        <option value="Urinalysis">Urinalysis</option>
                        <option value="Fecalysis">Fecalysis</option>
                        <option value="CBC">CBC</option>
                        <option value="FBS">FBS</option>
                        <option value="BUN">BUN</option>
                        <option value="Creatinine">Creatinine</option>
                        <option value="Total Cholesterol">Total Cholesterol</option>
                        <option value="Triglycerides">Triglycerides</option>
                        <option value="HDL">HDL</option>
                        <option value="LDL">LDL</option>
                        <option value="Uric Acid">Uric Acid</option>
                        <option value="SGPT">SGPT</option>
                        <!-- Add other options as needed -->
                    </select>

                    <label for="others">Others:</label>
                    <input type="text" id="others" name="others">

                    <button type="submit">Submit Lab Request</button>
                    </form>
            </div>
        </div>
    </div>
</div>

<section class="content" style="background-color: #F4F6F9; padding: 70px 30px 100px;">
    <div class="container col-md-11">
        <div class="card">
            <h4 class="ml-3 pt-2 text-uppercase" style="color: #dc3545;">
                Patient Treatment
            </h4>                
        </div>
    
        <div class="card">
            <div class="card-body">
                <!-- Consultation Table -->
                <table id="datatableid" class="table table-striped table-bordered table-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>Consultation ID</th>
                            <th>Patient Name</th>
                            <th>Patient Type</th>
                            <th>College</th>
                            <th>Blood Pressure</th>
                            <th>Temperature</th>
                            <th>Chief Complaint</th>
                            <th>Staff In-charge</th>
                            <th>Diagnosis</th>
                            <th>Notes</th>
                            <th>For Lab</th>
                            <th>Laboratory Form</th>
                            <th>Print</th>
                        </tr>
                    </thead>

                    <!-- Output data of each row -->
<!-- Output data of each row -->
<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sql = "SELECT * FROM your_consultation_table WHERE for_lab = 'Yes'";
        $result = $conn->query($sql);
        // Check if the value in the "For Lab" column is 'Yes'
        if ($row["for_lab"] == 'Yes') {
            echo "<tr>
                    <td>" . $row["consultation_id"] . "</td>
                    <td>" . $row["first_name"] . " " . $row["last_name"] . "</td>
                    <td>" . $row["type"] . "</td>
                    <td>" . $row["college"] . "</td>
                    <td>" . $row["blood_pressure"] . "</td>
                    <td>" . $row["temperature"] . "</td>
                    <td>" . $row["complaint"] . "</td>
                    <td>" . $row["staff_in_charge"] . "</td>
                    <td>" . $row["diagnosis"] . "</td>
                    <td>" . $row["notes"] . "</td>
                    <td>" . $row["for_lab"] . "</td>
                    <td>
                        <button data-id='" . (isset($row['consultation_id']) ? $row['consultation_id'] : '') . "' 
                                data-patient-id='" . (isset($row['patient_id']) ? $row['patient_id'] : '') . "' 
                                class='editConsultationModal btn btn-success'>
                            Laboratory Form
                        </button>
                    </td>
                    <td>
                        <button data-id='" . (isset($row['consultation_id']) ? $row['consultation_id'] : '') . "' 
                                data-status='" . (isset($row['status']) ? $row['status'] : '') . "' 
                                class='closeConsultation btn btn-primary'>
                            Close
                        </button>
                    </td>
                </tr>";
        }
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

<!-- Add a hidden file input for selecting CSV file -->
<input type="file" id="csv_file_input" style="display: none;" accept=".csv">

<?php require_once('footer.php'); ?>

</body>
</html>
