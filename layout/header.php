<?php
session_start();

// Logika Koneksi yang Benar
if (file_exists('config/koneksi.php')) {
    include 'config/koneksi.php';
} else {
    include '../config/koneksi.php';
}

// Cek Login
if($_SESSION['status'] != "login"){
    if(file_exists('login.php')){
        header("location:login.php?pesan=belum_login");
    } else {
        header("location:../login.php?pesan=belum_login");
    }
    exit; 
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris ATK DKP3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
       <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
        
        /* --- SIDEBAR MODERN --- */
        #wrapper { overflow-x: hidden; }
        
        .sidebar { 
            min-height: 100vh; 
            /* Gradasi Warna Biru Tua Elegan */
            background: linear-gradient(180deg, #1e3c72 0%, #2a5298 100%);
            color: white; 
            width: 260px; /* Sedikit lebih lebar */
            flex-shrink: 0; 
            transition: margin 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 4px 0 15px rgba(0,0,0,0.1); /* Bayangan halus */
            z-index: 100;
        }

        #wrapper.toggled .sidebar {
            margin-left: -260px;
        }

        /* Profil Admin di Sidebar */
        .sidebar-profile {
            padding: 30px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        
        /* Style Menu Link */
        .sidebar a { 
            color: rgba(255,255,255,0.8); 
            text-decoration: none; 
            display: block; 
            padding: 12px 20px; 
            margin: 5px 15px; /* Memberi jarak kiri-kanan */
            border-radius: 10px; /* Sudut melengkung */
            transition: all 0.3s;
            font-weight: 500;
            font-size: 15px;
        }

        /* Efek Hover & Aktif */
        .sidebar a:hover, .sidebar a.active { 
            background-color: rgba(255,255,255,0.2); /* Transparan Putih */
            color: white; 
            transform: translateX(5px); /* Geser sedikit ke kanan */
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .sidebar a.active {
            background-color: white;
            color: #1e3c72; /* Teks jadi biru */
            font-weight: bold;
        }

        .sidebar a.text-danger:hover {
            background-color: #ff4d4d;
            color: white;
        }

        .content { width: 100%; padding: 25px; }
        
        /* Mempercantik Navbar */
        .navbar { border-radius: 12px; }
    </style>
</head>
<body>
<div class="d-flex" id="wrapper">