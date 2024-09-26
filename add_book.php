<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'library');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Proses form ketika ada pengiriman data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Menangani upload gambar
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/"; // Pastikan direktori ini ada dan dapat ditulis
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Buat direktori jika belum ada
        }

        $target_file = $target_dir . basename($_FILES['image']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        // Validasi jenis file gambar
        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $image = $target_file;
            } else {
                echo "Maaf, terjadi kesalahan saat mengunggah file.";
                exit;
            }
        } else {
            echo "Maaf, hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.";
            exit;
        }
    }

    // Ambil data dari form
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $year = $conn->real_escape_string($_POST['year']);

    // Masukkan data ke dalam database
    $sql = "INSERT INTO books (title, author, year, image) VALUES ('$title', '$author', '$year', '$image')";
    if ($conn->query($sql) === TRUE) {
        echo "Buku berhasil ditambahkan.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Ambil data buku yang tersedia untuk ditampilkan
$sql = "SELECT * FROM books";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Buku</title>
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

        input, select, textarea {
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
</head>
<body>
    <h1>TAMBAH BUKU</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="title">Judul:</label>
        <input type="text" id="title" name="title" required>

        <label for="author">Pengarang:</label>
        <input type="text" id="author" name="author" required>

        <label for="year">Tahun:</label>
        <input type="number" id="year" name="year" required>

        <label for="image">Gambar:</label>
        <input type="file" id="image" name="image" accept="image/*" required>

        <button type="submit">Tambah Buku</button>
    </form>

    <h1>DAFTAR BUKU</h1>
    <table>
        <tr>
            <th>Gambar</th>
            <th>Judul</th>
            <th>Pengarang</th>
            <th>Tahun</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td>
                    <img src="<?php echo isset($row['image']) ? $row['image'] : 'default.jpg'; ?>" alt="Gambar Buku" class="book-image">
                </td>
                <td><?php echo isset($row['title']) ? $row['title'] : 'Tidak ada judul'; ?></td>
                <td><?php echo isset($row['author']) ? $row['author'] : 'Tidak ada pengarang'; ?></td>
                <td><?php echo isset($row['year']) ? $row['year'] : 'Tidak ada tahun'; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php
$conn->close(); // Menutup koneksi
?>
