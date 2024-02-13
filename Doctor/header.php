<?php
    session_start();
    // Replace the following with your actual database connection logic
$host = "localhost";
$username = "root";
$password = "";
$database = "public_html";
    
    $conn = new mysqli($host, $username, $password, $database);
    
    // Replace the following with the actual user authentication logic and email retrieval
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
    
        // Fetch user data from the database based on the email
        $query = "SELECT email FROM medical_staff WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $email = $row['email'];
        } else {
            // Handle the case when the user is not found in the database
            header("Location:../index.php");
            exit;
        }
    } else {
        // Handle the case when the email is not set in the session
        header("Location:../index.php");
        exit;
    }


?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700" />
        
    <script defer src="header-active-page.js"></script> 

    <title>PUP Medical Services Department - Doctor</title>
    
<style>
    .navbar {
        border-bottom: 0.5rem solid rgba(128, 0, 0, 1) !important;
        height: 100px;
        display: flex;
        align-items: center;
        font-family: sans-serif;
    }

    /* logo */
    .logo {
        flex: 1;
        display: flex;
        align-items: center;
        margin-top: 20px;
        margin-bottom: 20px;
        padding-bottom: 5px;
    }

    .logo img {
        width: 60px;
        height: 60px;
        margin-left: 60px;
        margin-right: 10px;
    }

    .logo a {
        text-decoration: none; /* Remove the underline for the link */
        color: #800000; /* Inherit the color from the parent element */
        pointer-events: none; /* Make the link not clickable */
        font-size: 30px;
        display: flex;
        align-items: center; 
        line-height: 40px;
    }

    .logo b,
    .logo h5 {
        margin: 0; 
    }

    .logo h5 {
        font-weight: normal;
    }

    /* navbar-nav */
    .navbar ul { 
        display: flex;
        list-style: none;
        margin-right: 40px;
        padding: 0;        
    }

    .navbar ul li {
        margin-right: 5px; /* Adjust the spacing between menu items */
        position: relative;
    }

    .navbar ul li a {
        font-size: 20px;
        color: #808080;
        text-decoration: none;
        transition: all 0.3s;
        line-height: 40px;
    }

    .navbar ul li a:after {
        content: "";
        position: absolute;
        background-color: #800000;
        height: 3px;
        width: 0;
        left: 0;
        bottom: 0;
        transition: 0.3s;
    }

    .navbar ul li a:hover {
        color: #800000;
    }

    .navbar ul li a:hover:after{
        width: 100%;
    }

    /* dropdown-menu */
    .dropdown-menu{
        display: none;
    }

    .dropdown-menu ul {
        margin-right: 50px;
    }

    .dropdown-menu ul li a{
        font-size: 16px;
    }

    .navbar ul li:hover .dropdown-menu{
        display: block;
        position: absolute;
        left: 0px;
        top: 100%;
        background-color: #fff;
    }

    .navbar ul li:hover .dropdown-menu ul{
        display: block;
        margin: 0;
    }
    .navbar ul li:hover .dropdown-menu ul li{
        width: 180px;
        margin: 3px;
    }

    /* navbar active link */
    .navbar-nav a.active {
        color: #800000; /* Change this to your desired active link color */
        font-weight: bold; /* You can customize the style for the active link */
    }

    .navbar-nav a.active:after {
        width: 100%;
    }



</style>
  </head>
  <body>
    <div class="navbar navbar-expand-lg">
      <div class="logo">
        <a href="#"><img src="../styles/images/pup-logo2.png" alt="logo">
            <b>PUPMSD <h5>PUP Medical Services Department</h5></b>
        </a>
      </div>

      <ul class="navbar-nav">

        <li class="nav-item">
          <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="index.php">
            Home
          </a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'patients.php' ? 'active' : ''; ?>" href="#">
            Consultation/Treatment <i class="fas fa-caret-down"></i>
          </a>
          <div class="dropdown-menu" >
            <ul>
              <li><a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'diagnosis.php' ? 'active' : ''; ?>" href="diagnosis.php">Diagnosis</a></li>
              <li><a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'treatment.php' ? 'active' : ''; ?>" href="treatment.php">Treatment</a></li>
              <li><a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'laboratory.php' ? 'active' : ''; ?>" href="laboratory.php">Laboratory</a></li>
              <li><a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'rx_index.php' ? 'active' : ''; ?>" href="rx_index.php">Prescription</a></li>
              <li><a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'consultation.php' ? 'active' : ''; ?>" href="consultation.php">Laboratory Examination Form</a></li>
              <li><a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'referral_index.php' ? 'active' : ''; ?>" href="referral_index.php">Referral Slip</a></li>
            </ul>
          </div>
        </li>
        
        <!--<li class="nav-item">
          <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'medicine_inventory.php' ? 'active' : ''; ?>" href="#">
              Medical Clearance <i class="fas fa-caret-down"></i>
          </a>
          <div class="dropdown-menu">
            <ul>
              <li><a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'medicine_inventory.php' ? 'active' : ''; ?>" href="medicine_inventory.php">Medical Certificate</a></li>
              <li><a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'medicine_inventory.php' ? 'active' : ''; ?>" href="medicine_inventory.php">Medical Clearance Without Findings</a></li>
              <li><a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'medicine_inventory.php' ? 'active' : ''; ?>" href="medicine_inventory.php">Medical Clearance - Enrollment</a></li>
              <li><a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'supply_inventory.php' ? 'active' : ''; ?>" href="supply_inventory.php">Annual Medical Clearance</a></li>
              
            </ul>
          </div>
        </li>-->
        
        <li class="nav-item">
            <a class="nav-link" href="#" id="navbarDropdownForms" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="email"><?php echo $_SESSION["email"] ?></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownForms">
                <ul>
                    <li>
                        <a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </li>
      </ul>

    </div>
    
    <script>
      function menuToggle(){
        const toggleMenu = document.querySelector('.usermenu');
        toggleMenu.classList.toggle('active')
      }
    </script>

    
  </body>
</html>