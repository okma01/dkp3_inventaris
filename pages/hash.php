<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generator Password Hash</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow p-4" style="width: 500px;">
        <h4 class="text-center mb-4">Generator Hash Password</h4>
        
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Masukkan Password Biasa:</label>
                <input type="text" name="password" class="form-control" placeholder="Contoh: admin123" required>
            </div>
            <button type="submit" name="generate" class="btn btn-primary w-100">Buat Hash</button>
        </form>

        <?php
        if (isset($_POST['generate'])) {
            $pass_asli = $_POST['password'];
            // Algoritma hashing default PHP (Bcrypt)
            $hash = password_hash($pass_asli, PASSWORD_DEFAULT);
        ?>
            <div class="alert alert-success mt-4">
                <strong>Password Asli:</strong> <?= $pass_asli; ?><br>
                <hr>
                <strong>Hasil Hash (Copy kode ini ke Database):</strong>
                <textarea class="form-control mt-2" rows="3"><?= $hash; ?></textarea>
            </div>
            
            <div class="alert alert-info mt-2">
                <small>Cara Pakai: Copy kode aneh di atas, buka Database (tabel admin), lalu Paste di kolom <b>password</b>.</small>
            </div>
        <?php } ?>

        <div class="mt-3 text-center">
            <a href="login.php">Kembali ke Halaman Login</a>
        </div>
    </div>
</div>

</body>
</html>