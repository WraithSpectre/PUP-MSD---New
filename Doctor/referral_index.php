<?php 
include '../connect.php';
include 'header.php';
include 'footer.php';
?>

<html>
  <head>
    <title>RX</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <link rel='stylesheet' href='https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css'>
    <script src="https://code.jquery.com/ui/1.13.0-rc.3/jquery-ui.min.js" integrity="sha256-R6eRO29lbCyPGfninb/kjIXeRjMOqY3VWPVk6gMhREk=" crossorigin="anonymous"></script>
    
  </head>
  <body>
    <section class="content" style="padding: 0px 30px 100px;">
      <div class='container pt-5'>
        <h1 class='text-center text-primary'>Printable Referral Form</h1><hr>
        <?php
          if (isset($_POST["submit"])) {
            $tto = mysqli_real_escape_string($mysqli, $_POST["tto"]);
            $date = date("Y-m-d", strtotime($_POST["date"]));
            $remarks = mysqli_real_escape_string($mysqli, $_POST["remarks"]);
            $md = mysqli_real_escape_string($mysqli, $_POST["md"]);
            $lic_no = mysqli_real_escape_string($mysqli, $_POST["lic_no"]);
        
            $sql = "INSERT INTO referral (tto, date, remarks, md, lic_no) VALUES ('$tto', '$date', '$remarks', '$md', '$lic_no')";
            
            // Execute the query
            if($mysqli->query($sql)){
              echo "<div class='alert alert-success'>Added Successfully. <a href='referral_print.php?id={$pid}' target='_BLANK'>Click </a> here to Print Referral Slip </div> ";
            }else{
              echo "<div class='alert alert-danger'>Added Failed.</div>";
            }
        }
        ?>

        <form method='post' action='referral_index.php' autocomplete='off'>
          <div class='row'>
            <div class='col-md-4'>
              <h5 class='text-success'>Doctor Information</h5>
              <div class="form-group">
                <label>M.D. Signature</label>
                <select name="md" id="md" class="form-control" >
                  <option value="">----------------- Select an option -----------------------</option>
                  <option value="Dr. Michelle O. Mallari">Dr. Michelle O. Mallari</option>
                  <option value="Dr. Felicitas A. Bermudez">Dr. Felicitas A. Bermudez</option>
                  <option value="Dr. Maria Pia V. Mendez">Dr. Maria Pia V. Mendez</option>
                </select>
              </div>
              <div class='form-group'>
                <label>Lic No.</label>
                <input type='text' name='lic_no' id='lic_no' required class='form-control'>
              </div>
            </div>
            <div class='col-md-8'>
              <h5 class='text-success'>Referral Details</h5>
              <div class='form-group'>
                <label>To:</label>
                <input type='text' name='tto' id='tto' required class='form-control'>
              </div>
              <div class='form-group'>
                <label>Date:</label>
                <input type='text' name='date' id='date' required class='form-control'>
              </div>
              <div class='form-group'>
                <label>Remarks:</label>
                <textarea name='remarks' id='remarks' rows='4' required class='form-control'></textarea>
              </div>
            </div>
          </div>

          <div class='text-end'>
            <input type='submit' name='submit' value='Save Prescription' class='btn btn-success float-right'>
          </div>
        </form>
      </div>

      <script>
        $(document).ready(function(){
          $("#date").datepicker({
            dateFormat:"dd-mm-yy"
          });
        });
      </script>
    </body>
  </html>
