<?php
// Include the database connection code
include '../connect.php';
include 'header.php';
include 'footer.php';

// Set the target folder for PDFs
$pdfFolder = $_SERVER['DOCUMENT_ROOT'] . '/md_staff/pdf_forms/';

// Function to upload a PDF file
function uploadPdf($file, $targetFolder) {
    $targetPath = $targetFolder . basename($file['name']);
    move_uploaded_file($file['tmp_name'], $targetPath);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf_file'])) {
    $pdfFile = $_FILES['pdf_file'];

    if ($pdfFile['error'] === UPLOAD_ERR_OK && $pdfFile['type'] === 'application/pdf') {
        uploadPdf($pdfFile, $pdfFolder);
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                PDF file uploaded successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Error uploading PDF file.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    }
}

// Get the updated list of PDF files in the folder
$pdfFiles = glob($pdfFolder . '*.pdf');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="../styles/images/pup-logo2.png">
    <title>PUP Medical Records Management System</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />    

    <style>
        .input-container {
            margin-bottom: 15px;
            margin-left: 200px;
        }

        .mb-3 {
            display: flex;
            flex-direction: row;
            align-items: center;
            padding: 20px;
            justify-content: space-between;
        }

        .form-control {
            flex: 1; /* Allow the input to grow and take up remaining space */
            margin-right: 30px; 
        }

        .btn-primary {
            width: 120px; /* Allow the button to adjust its width based on content */
        }
        
    </style>
</head>
<body>

<section class="content"  style="background-color: #F4F6F9; padding: 80px 30px 200px;">
    <div class="container col-md-11">
        
        <!-- Pop-up Alert Message -->
        <?php
        // Display pop-up alert message if any
        if (isset($_SESSION['alert'])) {
            echo $_SESSION['alert'];
            unset($_SESSION['alert']);
        }
        ?>
    
        <!-- PDF Upload Form 
        <div class="card mb-5" style="border-top: 0.2rem solid #dc3545 !important;">
            <div class="card-header">
                <label for="pdf_file" class="form-label">
                    <h4 class="ml-3 text-uppercase" style="color: #dc3545; margin-bottom: -10px !important;">
                        Upload PDF File
                    </h4>
                </label>
            </div>

            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="col-md-8 mb-3 input-container">
                        <input type="file" class="form-control" id="pdf_file" name="pdf_file" accept=".pdf" required>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>-->

            

        <!-- List of Downloadable PDFs -->
        <div class="card" style="border-top: 0.2rem solid #dc3545 !important;">
            <div class="card-header">
                <label for="pdf_file" class="form-label">
                    <h4 class="ml-3" style="color: #dc3545; margin-bottom: 0px !important;">
                        DOWNLOADABLE PDFs
                    </h4>
                </label>
            </div>
        
            <div class="card-body">
                <ul class="list-group">
                    <?php
                    $allowedFiles = ["ACCOMPLISHMENT REPORT TEMPLATE.pdf", 
                                    "HEALTH-INFORMATION-FORM-FOR-STUDENTS.pdf",
                                    "Inventory of medicines and supplies.pdf", 
                                    "MATRIX FOR MEDICAL CLEARANCE 2023 WITH FINDINGS.pdf",
                                    "MATRIX FOR MEDICAL CLEARANCE 2023.pdf",
                                    "MEDICAL EQUIPMENTS Inventory.pdf",
                                    "Request for medicines and supplies"
                                    ];
                    foreach ($pdfFiles as $pdf) {
                        $filename = basename($pdf);
                    
                        // Check if the file is in the allowed list
                        if (in_array($filename, $allowedFiles)) {
                            echo '<li class="list-group-item" style="font-size: 14px; ">';
                            echo '<i class="fas fa-file-pdf mr-5" style="color: #800000; margin-right: 10px; margin-left: 20px;"></i>'; // Font Awesome PDF icon
                            echo '<a href="/md_staff/pdf_forms/' . $filename . '" class="ms-2" download="' . $filename . '">' . $filename . '</a>';
                            echo '</li>';
                        }
                    }
                    
                    ?>
                </ul>
            </div>
        </div>


    </div>
</section>
    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
