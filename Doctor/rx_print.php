<?php
require("fpdf186/fpdf.php");
include '../connect.php';

// doc and patient info
$info = [
    "md" => "",
    "lic_no" => "",
    "name" => "",
    "age" => "",
    "date" => "",
];

// doc and patient info from POST data
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Fetch doc and patient info from the database
    $sql = "SELECT * FROM rx_prescription WHERE pid = '{$id}'";
    $result = $mysqli->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $info = [
            "md" => $row["md"],
            "lic_no" => $row["lic_no"],
            "name" => $row["name"],
            "age" => $row["age"],
            "date" => date("d-m-Y", strtotime($row["date"])),
        ];
    }
}

// patient details
$prescription_info = [];

// Select patient details from Database
if (isset($_GET["id"])) {
    $sql = "SELECT * FROM rx_prescription_details WHERE pid='{$_GET["id"]}'";
    $res = $mysqli->query($sql);

    if ($res && $res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $prescription_info[] = [
                "bname" => $row["bname"],
                "gname" => $row["gname"],
                "formulation" => $row["formulation"],
                "route" => $row["route"],
                "frequency" => $row["frequency"],
                "duration" => $row["duration"],
            ];
        }
    }
}

class PDF extends FPDF
{
    private $footerInfo; // Property to store info for the Footer

    function Header(){
      
        // Centered text
        $this->SetY(20); // Adjust the Y position based on your layout
        $this->SetX(25);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 7, "POLYTECHNIC UNIVERSITY OF THE PHILIPPINES", 0, 1, 'C');

        // Logo image
        $imagePath = 'logo2.png'; // Replace with the actual path to your logo image
        $this->Image($imagePath, 25, $this->GetY() - 10, 23); // Adjust the X and Y positions based on your layout

        // Subtitle
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 7, "MEDICAL CLINIC", 0, 1, 'C');

        // Location
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 7, "Manila", 0, 1, 'C');

        
        //Display INVOICE text
        $this->SetY(1);
        $this->SetX(-40);
        $this->SetFont('Arial','',8);
        $this->Cell(50,10,"PUP-MEPF-6-MEDS-001",0,1);
        $this->SetY(5);
        $this->SetX(-40);
        $this->SetFont('Arial','',8);
        $this->Cell(50,10,"Rev.0",0,1);
        $this->SetY(9);
        $this->SetX(-40);
        $this->SetFont('Arial','',8);
        $this->Cell(50,10,"May 15, 2018",0,1);
      }

    function body($info, $prescription_info)
    {
        // Set X and Y position after header
        $this->SetY(60);
        $this->SetX(25);
        $this->SetFont('Arial', '', 12);
        $this->Cell(50, 7, "Patient Name: " . $info["name"], 0, 1);
        $this->SetX(25);
        $this->Cell(50, 7, "Age               : " . $info["age"], 0, 0);
        $this->SetX(130);
        $this->Cell(50, 7, "Date: " . $info["date"], 0, 1);

        // Logo image
        $this->SetY(100);
        $imagePath = 'rx.png'; // Replace with the actual path to your logo image
        $this->Image($imagePath, 25, $this->GetY() - 10, 17); // Adjust the X and Y positions based on your layout

        //Display prescription_info
        foreach ($prescription_info as $medication) {
            $this->SetY(90);
            $this->SetX(50);
            $this->SetFont('Arial', '', 12);
            $this->Cell(50, 7, "Brand Name: " . ($medication["bname"] ?? ''), 0, 1);
            $this->SetX(50);
            $this->Cell(50, 7, "Generic Name: " . ($medication["gname"] ?? ''), 0, 1);
            $this->SetX(50);
            $this->Cell(50, 7, "Drug Formulation: " . ($medication["formulation"] ?? ''), 0, 1);
            $this->SetX(50);
            $this->Cell(50, 7, "Route of Administration: " . ($medication["route"] ?? ''), 0, 1);
            $this->SetX(50);
            $this->Cell(50, 7, "Frequency: " . ($medication["frequency"] ?? ''), 0, 1);
            $this->SetX(50);
            $this->Cell(50, 7, "Duration of Treatment: " . ($medication["duration"] ?? ''), 0, 1);
        }
        
        // Set the footerInfo property for use in the Footer
        $this->footerInfo = $info;

        $this->Footer();
    }

    function Footer()
    {
        // Set footer position
        $this->SetY(-80);
        $this->Ln(15);
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 10, $this->footerInfo["md"] . " M.D.", 0, 1, "R");
        $this->Cell(0, 10, "Lic No.: " . $this->footerInfo["lic_no"], 0, 1, "R");
    }
}

// ... Existing code ...

// Create A4 Page with Portrait
$pdf = new PDF("P", "mm", "A4");
$pdf->AddPage();
$pdf->body($info, $prescription_info);
$pdf->Output();
?>
