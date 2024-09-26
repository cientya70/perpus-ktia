<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'library');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Cek jika data peminjaman sudah diterima
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['borrow_book'])) {
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
} else {
    $error_message = "Data peminjaman tidak ditemukan.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Peminjaman Buku</title>
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

        .result {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            background: #FC6C85;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        p {
            margin: 10px 0;
        }

        .error {
            color: red;
            text-align: center;
        }

        .btnpdf {
    background: linear-gradient(to right, #4a90e2, #00aaff); /* Blue gradient */
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    border-radius: 10%;
    transition: background 0.3s ease; /* Smooth transition for hover effect */
}

.btnpdf:hover {
    background: linear-gradient(to right, #00aaff, #4a90e2); /* Reverse gradient on hover */
}

        
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <h1>Hasil Peminjaman Buku</h1>
    <div class="result">
        <?php if (isset($book)): ?>
            <p><strong>Nama:</strong> <?php echo htmlspecialchars($name); ?></p>
            <p><strong>Kelas:</strong> <?php echo htmlspecialchars($class); ?></p>
            <p><strong>NIS:</strong> <?php echo htmlspecialchars($nis); ?></p>
            <p><strong>Jenis Kelamin:</strong> <?php echo htmlspecialchars($gender); ?></p>
            <p><strong>Buku Dipinjam:</strong> <?php echo htmlspecialchars($book['title']); ?> oleh <?php echo htmlspecialchars($book['author']); ?></p>
            <p><strong>Tanggal Peminjaman:</strong> <?php echo htmlspecialchars($borrow_date); ?></p>
        <?php else: ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
         <!-- Button to generate PDF -->
         <form method="POST" action="generate_pdf.php">
                <input type="hidden" name="name" value="<?php echo htmlspecialchars($name); ?>">
                <input type="hidden" name="class" value="<?php echo htmlspecialchars($class); ?>">
                <input type="hidden" name="nis" value="<?php echo htmlspecialchars($nis); ?>">
                <input type="hidden" name="gender" value="<?php echo htmlspecialchars($gender); ?>">
                <input type="hidden" name="book_id" value="<?php echo htmlspecialchars($book_id); ?>">
                <a href="generate_pdf.php"><button class="btnpdf"><i class="fa fa-print" style="font-size:24px"></i></button></a>
            </form>
    </div>
</body>
</html>
