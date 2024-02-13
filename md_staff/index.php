<?php
    include '../connect.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" type="x-icon" href="../styles/images/pup-logo2.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

    <style>
      .row .box {
        border: 1px solid #b7b7b7;
        border-radius: 5px;
        box-shadow: 10px 10px 10px rgba(0, 0, 0, 0.1);
      }
      .header-bg {
        background-color: #800000; 
        color: #fff; 
        padding: 5px;
        margin-bottom: -10px;
        border-radius: 5px 5px 0 0;  
      }
      .content-bg {
        background-color: #fff;
        padding: 20px;
        margin-bottom: -10px;
        border-radius: 0 0 5px 5px;
      }
      table {
        width: 100%;
        border-collapse: collapse;
        font-family: sans-serif;
        font-size: 14px;
        color: #333;
      }

      th, td {
        padding: 5px;
        text-align: left;
        border-bottom: 1px solid #ccc;
      }

      th {
        background-color: #f2f2f2;
        font-weight: bold;
      }

      tr:hover {
        background-color: #f5f5f5;
      }
    </style>

  <title>PUP Medical Services Department</title>
</head>

<body>
  <?php require_once('header.php'); ?>

  <section class="content"  style="background-color: #F4F6F9; padding: 80px 30px 150px;">
    <div class="container col-md-11">
      <div class="card" style="border-top: 0.2rem solid #dc3545 !important;">
        <h4 class="ml-3 pt-1" style="color: #dc3545">
          Optimizing MRMS Implementation at PUP MSD: Essential Guidelines
        </h4>
      </div>
      <div class="card">
        <div class="card-body">
          <p class="lh-lg ml-3 mr-1">Implementing an effective Medical Records Management System (MRMS) for the PUP MSD (Medical Services Department) requires a systematic and comprehensive approach. The initial phase involves conducting a detailed needs assessment involving key stakeholders, including healthcare providers, administrators, and IT personnel. This assessment helps identify specific departmental requirements, challenges, and user expectations. Adherence to regulatory standards, such as HIPAA, is paramount to ensure the privacy and security of patient information. The system design should prioritize a user-friendly interface, accommodating features such as patient information management, medical history tracking, diagnosis recording, and treatment plans. Integration with existing systems, where applicable, streamlines data flow and minimizes redundancy. Throughout the implementation process, a strong emphasis on security measures ensures the confidentiality and integrity of sensitive medical data.</p><br>         
          <p class="lh-lg ml-3 mr-1">The success of the MRMS implementation relies on effective collaboration among stakeholders, transparent communication, and ongoing training for medical staff. Continuous monitoring and feedback mechanisms should be established to identify areas for improvement and address any emerging challenges. Regular updates and maintenance activities are essential to keep the system aligned with evolving technological standards and healthcare practices. By following these guidelines, the PUP MSD can establish a robust and compliant MRMS that enhances the efficiency of medical record management while prioritizing patient privacy and data security.</p>
        </div>
      </div>

      <!-- INBOX -->
      <div class="card mt-5"  style="border-top: 0.2rem solid #dc3545 !important;">
        <h4 class="ml-3 pt-1" style="color: #dc3545">
          For Consultation        
        </h4>
      </div>
      
      <div class="card">
        <div class="card-body">
                    <!-- Consultation Table -->
                    <?php 
                    $sql = "SELECT a.*, p.first_name, p.last_name, p.type 
                    FROM appointments a
                    JOIN patients p ON a.patient_id = p.patient_id";
                    $result = $mysqli->query($sql);
                    ?>
                    <table id="datatableid" class="table table-striped table-bordered table-sm">
                        <thead class="thead-dark">
                            <tr>
                            <th>Patient Name</th>
                            <th>Patient Type</th>
                            <th>Blood Pressure</th>
                            <th>Temperature</th>
                            <th>Complaint</th>
                            <th>Appointment Date</th>
                            <th>Appointment Time</th>
                            <th>Staff in Charge</th>
                            <th>Actions</th>
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
                              <td>" . $row["complaint"] . "</td>
                              <td>" . $row["appointment_date"] . "</td>
                              <td>" . $row["appointment_time"] . "</td>
                              <td>" . $row["staff_in_charge"] . "</td>
                              <td>
                                <a href = consultation.php><button class='patientinfo btn btn-success'>Show</button></a>
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

  <?php require_once('footer.php'); ?>
  </body>
</html>