<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Navbar</title>
    <style>
        /* Navbar styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .navbar {
            background-color: #4a90e2;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 17px;
        }

        .navbar a:hover {
            background-color: #357ab7;
            color: white;
        }

        .navbar-right {
            float: right;
        }

        /* Content styles */
        .content {
            padding: 20px;
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <!-- Admin Navbar -->
    <div class="navbar">
        <a href="admin.php">Daftar Buku</a>
        <a href="test123.php">Daftar Peminjam</a>
        <!-- <a href="tambahbuku.php" class="navbar-right">Tambah Buku</a> Example for adding new books -->
    </div>

    <!-- Page Content -->
    

</body>
</html>
