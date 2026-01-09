<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventaris DKP3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #2c3e50;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-login {
            width: 400px;
            border-radius: 10px;
            overflow: hidden;
        }
        .card-header {
            background-color: #3498db;
            color: white;
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>

    <div class="card card-login shadow-lg">
        <div class="card-header">
            <h4>DKP3 INVENTARIS</h4>
            <small>Silakan Login Terlebih Dahulu</small>
        </div>
        <div class="card-body p-4 bg-white">
            <?php 
            if(isset($_GET['pesan'])){
                if($_GET['pesan'] == "gagal"){
                    echo "<div class='alert alert-danger'>Login Gagal! Username/Password salah.</div>";
                } else if($_GET['pesan'] == "belum_login"){
                    echo "<div class='alert alert-warning'>Anda harus login dulu.</div>";
                } else if($_GET['pesan'] == "logout"){
                    echo "<div class='alert alert-success'>Anda berhasil logout.</div>";
                }
            }
            ?>

            <form action="proses/cek_login.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">MASUK</button>
                </div>
            </form>
        </div>
        <div class="card-footer text-center bg-light py-3">
            <small class="text-muted">Inventaris &copy; 2024</small>
        </div>
    </div>

</body>
</html>