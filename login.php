<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventaris DKP3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            height: 100vh;
            overflow: hidden;
        }

        .login-container {
            height: 100vh;
            display: flex;
            box-shadow: 0 0 50px rgba(0,0,0,0.1);
        }

        /* BAGIAN KIRI (BRANDING) */
        .login-brand {
            background: linear-gradient(135deg, #1e7256 0%, #114a36 100%);
            width: 45%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        /* Pola dekoratif background */
        .login-brand::before {
            content: '';
            position: absolute;
            top: -50px;
            left: -50px;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .login-brand::after {
            content: '';
            position: absolute;
            bottom: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .brand-logo img {
            width: 120px;
            margin-bottom: 20px;
            filter: drop-shadow(0 10px 10px rgba(0,0,0,0.2));
            transition: transform 0.3s ease;
        }

        .brand-logo img:hover {
            transform: scale(1.05);
        }

        /* BAGIAN KANAN (FORM) */
        .login-form-side {
            width: 55%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: relative;
        }

        .login-form-wrapper {
            width: 100%;
            max-width: 400px;
        }

        .form-floating > .form-control {
            border-radius: 10px;
            border: 1px solid #e9ecef;
            background-color: #fcfcfc;
        }

        .form-floating > .form-control:focus {
            border-color: #1e7256;
            box-shadow: 0 0 0 0.25rem rgba(30, 114, 86, 0.15);
        }

        .btn-login {
            background: #1e7256;
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s ease;
            font-size: 16px;
        }

        .btn-login:hover {
            background: #145c43;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(30, 114, 86, 0.2);
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #aaa;
            z-index: 10;
        }
        
        .btn-back {
            color: #6c757d;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }
        
        .btn-back:hover {
            color: #1e7256;
        }

        /* RESPONSIVE MOBILE */
        @media (max-width: 768px) {
            body { overflow: auto; }
            .login-container { flex-direction: column; height: auto; }
            .login-brand { width: 100%; padding: 40px 20px; min-height: 250px; }
            .login-form-side { width: 100%; padding: 40px 20px; min-height: 60vh; }
            .brand-logo img { width: 80px; }
        }
    </style>
    <link rel="stylesheet" href="design/app-modern.css">
</head>
<body class="login-page">

    <div class="container-fluid p-0">
        <div class="login-container">
            
            <div class="login-brand text-center">
                <div class="brand-logo">
                    <img src="assets/logo.png" alt="Logo Banjarbaru"> 
                </div>
                <h1 class="fw-bold mb-3 display-5">DKP3 Inventaris</h1>
                <p class="text-white-50 mb-4 fs-6">Dinas Ketahanan Pangan, Pertanian dan Perikanan Kota Banjarbaru</p>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-white text-success">Monitoring stok</span>
                    <span class="badge bg-white text-success">Transaksi barang</span>
                    <span class="badge bg-white text-success">Laporan PDF</span>
                </div>
            </div>

            <div class="login-form-side">
                <div class="login-form-wrapper">
                    <div class="mb-4">
                        <h2 class="fw-bold text-dark">Masuk ke Sistem</h2>
                        <p class="text-muted">Gunakan akun yang sudah terdaftar untuk mengelola inventaris.</p>
                    </div>

                    <?php 
                    if(isset($_GET['pesan'])){
                        if($_GET['pesan'] == "gagal"){
                            echo "<div class='alert alert-danger py-2 small'><i class='fas fa-exclamation-circle me-1'></i> Username atau Password salah!</div>";
                        } else if($_GET['pesan'] == "belum_login"){
                            echo "<div class='alert alert-warning py-2 small'><i class='fas fa-lock me-1'></i> Sesi habis, silakan login kembali.</div>";
                        } else if($_GET['pesan'] == "logout"){
                            echo "<div class='alert alert-success py-2 small'><i class='fas fa-check-circle me-1'></i> Berhasil logout.</div>";
                        }
                    }
                    ?>

                    <form action="proses/cek_login.php" method="POST">
                        
                        <div class="form-floating mb-3">
                            <input type="text" name="username" class="form-control" id="floatingInput" placeholder="Username" required autofocus>
                            <label for="floatingInput"><i class="fas fa-user me-2 text-muted"></i>Username</label>
                        </div>

                        <div class="form-floating mb-4 position-relative">
                            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                            <label for="floatingPassword"><i class="fas fa-lock me-2 text-muted"></i>Password</label>
                            <i class="fa-solid fa-eye password-toggle" id="toggleEye"></i>
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-login text-white btn-lg">
                                Masuk Sekarang <i class="fas fa-arrow-right ms-2 small"></i>
                            </button>
                        </div>

                        <div class="text-center">
                            <a href="landing.php" class="btn-back">
                                <i class="fas fa-arrow-left me-1"></i> Kembali ke Halaman Utama
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        const toggleEye = document.querySelector('#toggleEye');
        const password = document.querySelector('#floatingPassword');

        toggleEye.addEventListener('click', function () {
            // Ubah tipe input
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // Ubah ikon mata
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>

</body>
</html>
