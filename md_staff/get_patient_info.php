<?php
include '../connect.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['patient_id'])) {
    $patient_id = $_POST['patient_id'];

    // Fetch patient information and additional info using a JOIN
    $sql = "SELECT patients.*, patient_information.* 
            FROM patients
            LEFT JOIN patient_information ON patients.patient_id = patient_information.patient_id
            WHERE patients.patient_id = $patient_id";

    $result = $mysqli->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Display the combined information in the modal
            echo "<p><strong>Name:</strong> " . $row['first_name'] . " " . $row['last_name'] . "</p>";
            echo "<p><strong>Date of Birth:</strong> " . $row['date_of_birth'] . "</p>";
            echo "<p><strong>Gender:</strong> " . $row['gender'] . "</p>";
            echo "<p><strong>Address:</strong> " . $row['address'] . "</p>";
            echo "<p><strong>Contact Number:</strong> " . $row['contact_number'] . "</p>";
            echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";

            // Display additional information if available
            if (!empty($row['additional_info'])) {
                echo "<p><strong>Civil Status: </strong>". $row['additional_info'] ."</p>";
               // echo "<p>" . $row['additional_info'] . "</p>";
                
              echo "<p><strong>Medical History: </strong>". $row['contact_person'] ."</p>";
             //   echo "<p>" . $row['contact_person'] . "</p>";
                
                echo "<p><strong>Follow-up Notes:</strong>". $row['contact_person_number'] ."</p>";
              //  echo "<p>" . $row['contact_person_number'] . "</p>";
                
               /*  echo "<p><strong>College/Department:</strong></p>";
                echo "<p>" . $row['college_department'] . "</p>";
                
                echo "<p><strong>Course/School Year:</strong></p>";
                echo "<p>" . $row['course_school_year'] . "</p>";
                
                echo "<p><strong>Childhood Illness:</strong></p>";
                echo "<p>" . $row['childhood_illnesses'] . "</p>";
                
                echo "<p><strong>Previous Hospitalization:</strong></p>";
                echo "<p>" . $row['previous_hospitalization'] . "</p>";
                
                echo "<p><strong>Operation/Surgery:</strong></p>";
                echo "<p>" . $row['operation_surgery'] . "</p>";
                
                echo "<p><strong>Allergies:</strong></p>";
                echo "<p>" . $row['allergies'] . "</p>"; */
                
            } else {
                echo "<p>No additional information found for this patient.</p>";
            }
        } else {
            echo "<p>No patient found with this ID.</p>";
        }
    } else {
        echo "Error fetching patient information: " . $mysqli->error;
    }
} else {
    echo "Invalid request";
}

// Close the database my$mysqli
$mysqli->close();
?>
