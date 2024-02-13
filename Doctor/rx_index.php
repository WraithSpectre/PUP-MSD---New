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
        <h1 class='text-center text-primary'>Printable Prescription Form</h1><hr>
        <?php
          if(isset($_POST["submit"])){
            $md=mysqli_real_escape_string($mysqli,$_POST["md"]);
            $lic_no=mysqli_real_escape_string($mysqli,$_POST["lic_no"]);  
            $name=mysqli_real_escape_string($mysqli,$_POST["name"]);
            $age=mysqli_real_escape_string($mysqli,$_POST["age"]);
            $date=date("Y-m-d",strtotime($_POST["date"]));
            
            $sql="INSERT INTO rx_prescription (md,lic_no,name,age,date) values ('{$md}','{$lic_no}','{$name}','{$age}','{$date}') ";
            if($mysqli->query($sql)){
              $pid=$mysqli->insert_id;
              
              $sql2="INSERT INTO rx_prescription_details (pid,bname,gname,formulation,route,frequency,duration) values ";
              $rows=[];
              for($i=0;$i<count($_POST["bname"]);$i++)
              {
                $bname=mysqli_real_escape_string($mysqli,$_POST["bname"][$i]);
                $gname=mysqli_real_escape_string($mysqli,$_POST["gname"][$i]);
                $formulation=mysqli_real_escape_string($mysqli,$_POST["formulation"][$i]);
                $route=mysqli_real_escape_string($mysqli,$_POST["route"][$i]);
                $frequency=mysqli_real_escape_string($mysqli,$_POST["frequency"][$i]);
                $duration=mysqli_real_escape_string($mysqli,$_POST["duration"][$i]);
                $rows[] = "('$pid', '$bname', '$gname', '$formulation', '$route', '$frequency', '$duration')";
              }
              $sql2.=implode(",",$rows);
              if($mysqli->query($sql2)){
                echo "<div class='alert alert-success'>Prescription Added Successfully. <a href='rx_print.php?id={$pid}' target='_BLANK'>Click </a> here to Print Prescription </div> ";
              }else{
                echo "<div class='alert alert-danger'>Prescription Added Failed.</div>";
              }
            }else{
              echo "<div class='alert alert-danger'>Prescription Added Failed.</div>";
            }
          }
        ?>

        <form method='post' action='rx_index.php' autocomplete='off'>
          <div class='row'>
            <div class='col-md-4'>
              <h5 class='text-success'>Doctor Information</h5>
              <div class='form-group'>
                <label>M.D.</label>
                <input type='text' name='md' id='md' required class='form-control'>
              </div>
              <div class='form-group'>
                <label>Lic No.</label>
                <input type='text' name='lic_no' id='lic_no' required class='form-control'>
              </div>
            </div>
            <div class='col-md-8'>
              <h5 class='text-success'>Patient Information</h5>
              <div class='form-group'>
                <label>Patient Name:</label>
                <input type='text' name='name' id='name' required class='form-control'>
              </div>
              <div class='form-group'>
                <label>Age:</label>
                <input type='text' name='age' id='age' required class='form-control'>
              </div>
              <div class='form-group'>
                <label>Date:</label>
                <input type='text' name='date' id='date' required class='form-control'>
              </div>
            </div>
          </div>

          <div class='row'>
            <div class='col-md-12 mt-4'>
              <h5 class='text-success'>Prescription Details</h5>
              <table class='table table-bordered'>
                <thead>
                  <tr>
                    <th>Brand Name</th>
                    <th>Generic Name</th>
                    <th>Drug Formulation</th>
                    <th>Route of Administration</th>
                    <th>Frequency</th>
                    <th>Duration of Treatment</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id='product_tbody'>
                  <tr>
                    <td><input type='text' required name='bname[]' class='form-control'></td>
                    <td><input type='text' required name='gname[]' class='form-control'></td>
                    <td><input type='text' required name='formulation[]' class='form-control'></td>
                    <td><input type='text' required name='route[]' class='form-control'></td>
                    <td><input type='text' required name='frequency[]' class='form-control'></td>
                    <td><input type='text' required name='duration[]' class='form-control'></td>
                    <td><input type='button' value='x' class='btn btn-danger btn-sm btn-row-remove'> </td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <td><input type='button' value='+ Add Row' class='btn btn-primary btn-sm' id='btn-add-row'></td>
                  </tr>
                </tfoot>
              </table>
              <input type='submit' name='submit' value='Save Prescription' class='btn btn-success float-right'>
            </div>
          </div>
        </form>
      </div>

      <script>
        $(document).ready(function(){
          $("#date").datepicker({
            dateFormat:"dd-mm-yy"
          });
          
          $("#btn-add-row").click(function(){
            var row="<tr> <td><input type='text' required name='bname[]' class='form-control'></td> <td><input type='text' required name='gname[]' class='form-control price'></td> <td><input type='text' required name='formulation[]' class='form-control qty'></td> <td><input type='text' required name='route[]' class='form-control total'></td> <td><input type='text' required name='frequency[]' class='form-control qty'></td> <td><input type='text' required name='duration[]' class='form-control total'></td> <td><input type='button' value='x' class='btn btn-danger btn-sm btn-row-remove'> </td> </tr>";
            $("#product_tbody").append(row);
          });
          
          $("body").on("click",".btn-row-remove",function(){
            if(confirm("Are You Sure?")){
              $(this).closest("tr").remove();
              grand_total();
            }
          });
        });
      </script>
    </body>
  </html>
