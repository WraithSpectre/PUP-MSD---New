<?php
    session_start();
    include '../connect.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="../styles/images/pup-logo2.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    
    <title>Check Up Form</title>
    <link rel="stylesheet" href="styles/mypatient.css">
</head>
<body>


    <?php require_once('header.php'); ?>
  
    <section class="content" style="background-color: #F4F6F9; padding: 70px 30px 100px;">
        <div class="container col-md-9">
            <div class="card">
              <h4 class="ml-3 pt-2 text-uppercase" style="color: #dc3545;">
                Check Up Form
              </h4>                
            </div> 
            <div class="card">
                <div class="card-body">
                    <section id="patient-information">
                      <h2>Patient Information</h2>
                      <form action="#" method="post">
                        <br>
                        <div class="select-button">
                          <select>
                            <option value="" name="classification">Select Classification</option>
                            <option value="Student ">Student</option>
                            <option value="Faculty">Faculty</option>
                          </select>
                        </div>
                        <input type="text" name="first_name" placeholder="First Name">
                        <input type="text" name="last_name" placeholder="Last Name">
                        <input type="text" name="student-number" placeholder="Student Number">
                        <input type="text" name="email" placeholder="Email">
                        <label for="gender">Gender:</label>
                        <select name="gender" class="select-option" id="gender" multiple>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                          <option value="Gay">Gay</option>
                          <option value="Lesbian">Lesbian</option>
                          <option value="Transgender">Transgender</option>
                          <option value="Gender Neutral">Gender Neutral</option>
                          <option value="Non-Binary">Non-Binary</option>
                          <option value="Prefer Not to Say">Prefer Not to Say</option>
                        </select>
                        <input type="text" name="address" placeholder="Address">
                        <input type="text" name="contact_number" placeholder="Contact Number">
                        <input placeholder="Date of Birth" class="textbox-n" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" name="birthdate" />
                        <input placeholder="Date of Visitation" class="textbox-n" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" name="visitation_date" />
                
                      </form>
                    </section>
                
                    <section id="complaint-history">
                      <h2>Complaint History</h2>
                      <textarea name="complaints" placeholder="Enter your complaints here..."></textarea>
                    </section>
                
                    <section id="treatment-medications">
                      <h2>Treatment & Medications</h2>
                      <textarea name="treatment" placeholder="Enter your treatment here..."></textarea>
                      <textarea name="medications" placeholder="Enter your medications here..."></textarea>
                    </section>
                
                    <section id="follow-up">
                      <h2>Follow Up</h2>
                      <input type="date" name="follow-up-date" placeholder="Follow Up Date">
                      <textarea name="follow-up-reason" placeholder="Enter the reason for your follow-up here..."></textarea>
                    </section>
                
                    <button type="submit">Submit</button>            
                </div> 
            </div> 

        </div>
    </section>
    


  <?php require_once('footer.php'); ?>

</body>
</html>