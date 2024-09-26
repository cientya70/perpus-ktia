<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'library');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is set
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Fetch book details
    $sql = "SELECT * FROM books WHERE id = $id";
    $result = $conn->query($sql);
    $book = $result->fetch_assoc();

    if (!$book) {
        die("Buku tidak ditemukan.");
    }
}

// Update book record
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $author = $conn->real_escape_string($_POST['author']);
    $year = $conn->real_escape_string($_POST['year']);

    // Update query
    $update_sql = "UPDATE books SET title='$title', author='$author', year='$year' WHERE id=$id";

    if ($conn->query($update_sql) === TRUE) {
        header("Location: admin.php"); // Redirect to books list
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku</title>
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
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #007bff; /* Change to blue */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            color: #007bff;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Edit Buku</h1>
        <form method="post">
            <label>Judul:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
            <label>Pengarang:</label>
            <input type="text" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>
            <label>Tahun:</label>
            <input type="text" name="year" value="<?php echo htmlspecialchars($book['year']); ?>" required>
            <button type="submit">Simpan</button>
        </form>
        <a class="back-link" href="admin.php">Kembali</a>
    </div>
</body>

</html>