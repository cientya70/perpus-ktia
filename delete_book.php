<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'library');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is set
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // First, delete related borrow records
    $delete_borrow_sql = "DELETE FROM borrow_records WHERE book_id = $id";
    if (!$conn->query($delete_borrow_sql)) {
        echo "Error deleting related borrow records: " . $conn->error;
        exit;
    }

    // Then, delete the book record
    $delete_sql = "DELETE FROM books WHERE id = $id";
    
    if ($conn->query($delete_sql) === TRUE) {
        header("Location: admin.php"); // Redirect to the book list page after deletion
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "ID tidak ditentukan.";
}
?>
