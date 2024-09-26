<?php
require 'fpdf/fpdf.php'; // Pastikan sudah mengunduh dan meletakkan fpdf library

// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'library');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari form
$name = $_POST['name'];
$class = $_POST['class'];
$nis = $_POST['nis'];
$gender = $_POST['gender'];
$book_id = $_POST['book_id'];

// Insert data peminjaman
$sql = "INSERT INTO borrow_records (name, class, nis, gender, book_id) VALUES ('$name', '$class', '$nis', '$gender', '$book_id')";
$conn->query($sql);

// Update ketersediaan buku
$conn->query("UPDATE books SET available = 0 WHERE id = $book_id");

// Buat PDF bukti peminjaman
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, 'Bukti Peminjaman Buku');
$pdf->Ln();
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 10, 'Nama: ' . $name);
$pdf->Ln();
$pdf->Cell(40, 10, 'Kelas: ' . $class);
$pdf->Ln();
$pdf->Cell(40, 10, 'NIS: ' . $nis);
$pdf->Ln();
$pdf->Cell(40, 10, 'Jenis Kelamin: ' . $gender);
$pdf->Ln();
$pdf->Cell(40, 10, 'Judul Buku: ' . $conn->query("SELECT title FROM books WHERE id = $book_id")->fetch_assoc()['title']);
$pdf->Ln();

$pdf->Output('D', 'Bukti_Peminjaman.pdf');

// Redirect ke halaman utama
header('Location: index.php');
?>
