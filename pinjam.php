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

    table,
    th,
    td {
        border: 1px solid #ddd;
    }

    th,
    td {
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

    input,
    select {
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

        table,
        form {
            width: 95%;
        }
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<h1 id="peminjam">FORM PEMINJAMAN BUKU</h1>
<form action="hasildata.php" method="POST">
    <label for="name">Nama:</label>
    <input type="text" id="name" name="name" required>

    <label for="class">Kelas:</label>
    <input type="text" id="class" name="class" required>

    <label for="nis">NIS:</label>
    <input type="text" id="nis" name="nis" required>

    <label for="gender">Jenis Kelamin:</label>
    <select id="gender" name="gender" required>
        <option value="Laki-laki">Laki-laki</option>
        <option value="Perempuan">Perempuan</option>
    </select>

    <label for="book">Pilih Buku:</label>
    <select id="book" name="book_id" required>
        <?php
        $available_books = $conn->query("SELECT * FROM books WHERE available = 1");
        while ($book = $available_books->fetch_assoc()) {
            echo "<option value='{$book['id']}'>{$book['title']} - {$book['author']}</option>";
        }
        ?>
    </select>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <button type="submit" name="borrow_book">Pinjam Buku</button>
</form>


<?php $conn->close(); ?>