<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'library');
include 'navbar.php';


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Proses saat form peminjaman buku dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['borrow_book'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $class = $conn->real_escape_string($_POST['class']);
    $nis = $conn->real_escape_string($_POST['nis']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $book_id = $conn->real_escape_string($_POST['book_id']);
    $borrow_date = date('Y-m-d');  // Tanggal peminjaman saat ini

    // Simpan data peminjaman ke database
    $sql = "INSERT INTO borrow (name, class, nis, gender, book_id, borrow_date) 
            VALUES ('$name', '$class', '$nis', '$gender', '$book_id', '$borrow_date')";

    if ($conn->query($sql) === TRUE) {
        echo "Buku berhasil dipinjam!";
    } else {
        echo "Terjadi kesalahan: " . $conn->error;
    }
}


// Ambil data buku yang tersedia
$sql = "SELECT * FROM books";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Buku & Peminjaman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #4a90e2;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #4a90e2;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .book-image {
            width: 100px;
            height: auto;
            border-radius: 5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        form {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input, select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4a90e2;
            border: none;
            color: #fff;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #357ab7;
        }

        @media (max-width: 768px) {
            table, form {
                width: 95%;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <h1>DAFTAR BUKU</h1>
    <table>
        <tr>
            <th>Gambar</th>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>Tahun</th>
            <th>Review</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td>
                    <img src="<?php echo isset($row['image']) ? $row['image'] : 'default.jpg'; ?>" alt="Gambar Buku" class="book-image">
                </td>
                <td><?php echo isset($row['title']) ? $row['title'] : 'Tidak ada judul'; ?></td>
                <td><?php echo isset($row['author']) ? $row['author'] : 'Tidak ada pengarang'; ?></td>
                <td><?php echo isset($row['year']) ? $row['year'] : 'Tidak ada tahun'; ?></td>
                <td><?php echo isset($row['review']) ? $row['review'] : 'Tidak ada review'; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>



<?php $conn->close(); ?>
