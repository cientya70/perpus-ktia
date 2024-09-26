<?php
require('fpdf/fpdf.php'); // Include the FPDF library

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'library');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if required data is received
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $class = $conn->real_escape_string($_POST['class']);
    $nis = $conn->real_escape_string($_POST['nis']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $book_id = $conn->real_escape_string($_POST['book_id']);
    $borrow_date = date('Y-m-d');

    // Ambil detail buku berdasarkan book_id
    $book_sql = "SELECT title, author FROM books WHERE id = '$book_id'";
    $book_result = $conn->query($book_sql);
    $book = $book_result->fetch_assoc();

    if ($book) {
        // Create a new PDF document
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Hasil Peminjaman Buku', 0, 1, 'C');

        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'Nama: ' . htmlspecialchars($name), 0, 1);
        $pdf->Cell(0, 10, 'Kelas: ' . htmlspecialchars($class), 0, 1);
        $pdf->Cell(0, 10, 'NIS: ' . htmlspecialchars($nis), 0, 1);
        $pdf->Cell(0, 10, 'Jenis Kelamin: ' . htmlspecialchars($gender), 0, 1);
        $pdf->Cell(0, 10, 'Buku Dipinjam: ' . htmlspecialchars($book['title']) . ' oleh ' . htmlspecialchars($book['author']), 0, 1);
        $pdf->Cell(0, 10, 'Tanggal Peminjaman: ' . htmlspecialchars($borrow_date), 0, 1);

        // Save PDF to a file
        $pdf_directory = 'pdfs/';
        if (!is_dir($pdf_directory)) {
            mkdir($pdf_directory, 0777, true); // Create the directory if it doesn't exist
        }

        $pdf_filename = 'User_Peminjaman_' . $nis . '.pdf';
        $pdf_path = $pdf_directory . $pdf_filename;
        $pdf->Output('F', $pdf_path); // Save the file to the server

        // Save the PDF file path to the database
        $insert_sql = "INSERT INTO borrow_records (name, class, nis, gender, book_id, borrow_date, pdf_path) 
                       VALUES ('$name', '$class', '$nis', '$gender', '$book_id', '$borrow_date', '$pdf_path')";
        
        if ($conn->query($insert_sql) === TRUE) {
            echo "Data peminjaman berhasil disimpan dan PDF telah dibuat.";
        } else {
            echo "Error: " . $insert_sql . "<br>" . $conn->error;
        }

        // Optionally output the PDF to the browser as well
        // $pdf->Output('I', $pdf_filename); // Uncomment this line if you want to display it immediately

    } else {
        echo "Buku tidak ditemukan.";
    }
}

$conn->close();
?>
