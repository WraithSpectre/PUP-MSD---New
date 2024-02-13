<?php
include '../connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    
   // $prescription = $_POST['prescription'];
    $treatment = $_POST['treatment'];
    $notes = $_POST['notes'];
    $status = $_POST['status'];
    $patientId = isset($_POST['patient_id']) ? $_POST['patient_id'] : '';
    $appointmentId = isset($_POST['appointment_id']) ? $_POST['appointment_id'] : '';
    
    $medicine = isset($_POST['medicine'])? $_POST['medicine']: '';
    $quantity = isset($_POST['quantity'])? $_POST['quantity']: '';
    $dynamicMedicine = isset($_POST['dynamic_med_holder']) ? $_POST['dynamic_med_holder'] : NULL;
    
    // Insert into the consultation table
    
    
    $insertConsultationQuery = "INSERT INTO consultation (patient_id, appointment_id, treatment, notes, status)
                                VALUES ('$patientId', '$appointmentId', '$treatment', '$notes', '$status')";
    //fetch id of latest record
    $result=$mysqli->query($insertConsultationQuery);
    $id = $mysqli->insert_id;
    
   
    if($id!=NULL){
    // if ($mysqli->query($insertConsultationQuery) === true) {
        
        
        
        
        if($dynamicMedicine != NULL){
            
            $dynamicMedicine = json_decode($dynamicMedicine);
            foreach($dynamicMedicine as $meds){
                
                if(property_exists($meds, "med_id") && property_exists($meds, "amount")){
//                    var_dump($meds->med_id);
//                    var_dump($meds->amount);
                    $medId = $meds->med_id;
                    $medQuantity = $meds->amount;
                    $dosage = $meds->med_dosage;
                    $type = $meds->med_type;
                    $insertJunction = "INSERT INTO med_junction (consultation_id, med_id, amount, dosage, type)
                               VALUES ('$id', '$medId', '$medQuantity', '$dosage', '$type')";

                    $resultJunc=$mysqli->query($insertJunction);

                    $selectQuantity = "SELECT quantity,consumed FROM medicine_inventory WHERE med_id = $medId";

                    $resultQuantity=$mysqli->query($selectQuantity);
                    $resultRow = $resultQuantity -> fetch_assoc();
                    
                    
                    $oldQuantity = $resultRow["quantity"];
                    $newQuantity = (int)$oldQuantity - $medQuantity;
                    
                    $oldConsumed = $resultRow["consumed"];
                    $newConsumed = (int)$oldConsumed + $medQuantity;

                    $updateQuantityQuery = "UPDATE medicine_inventory SET quantity=$newQuantity, consumed=$newConsumed WHERE med_id = $medId";
                    $mysqli->query($updateQuantityQuery);    
                }
                
                

            }
            
        }
        
      
        
        echo "Consultation data added successfully.";
        
        
        
    } else {
        echo "Error adding consultation data: " . $mysqli->error;
    }
} else {
    echo "Invalid request.";
}

$mysqli->close();
?>
