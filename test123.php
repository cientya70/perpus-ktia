<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'library');
include 'assets/navbar.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data buku
$sql = "SELECT * FROM books";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Daftar Buku</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #444;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn-add {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 15px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn-add:hover {
            background-color: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        a {
            color: #007bff;
            text-decoration: none;
            margin: 0 5px;
            transition: color 0.3s;
        }
        a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
        

    <h1>DAFTAR PEMINJAMAN BUKU</h1>
<table>
    <tr>
        <th>Nama</th>
        <th>Kelas</th>
        <th>NIS</th>
        <th>Jenis Kelamin</th>
        <th>Judul Buku</th>
        <th>Tanggal Pinjam</th>
        <th>Aksi</th> <!-- New column for actions -->
    </tr>
    <?php
    // Ambil data peminjaman buku
    $sql_borrow = "SELECT borrow.name, borrow.class, borrow.nis, borrow.gender, books.title, borrow.borrow_date, borrow.pdf_path 
                FROM borrow_records AS borrow 
                JOIN books ON borrow.book_id = books.id";

    $borrow_result = $conn->query($sql_borrow);

    while ($borrow = $borrow_result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($borrow['name']); ?></td>
            <td><?php echo htmlspecialchars($borrow['class']); ?></td>
            <td><?php echo htmlspecialchars($borrow['nis']); ?></td>
            <td><?php echo htmlspecialchars($borrow['gender']); ?></td>
            <td><?php echo htmlspecialchars($borrow['title']); ?></td>
            <td>
                <?php 
                echo htmlspecialchars(date('Y-m-d', strtotime($borrow['borrow_date'])));
                ?>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
    
</body>
</html>
