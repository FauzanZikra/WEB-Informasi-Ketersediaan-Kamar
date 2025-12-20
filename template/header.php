<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informasi Ketersediaan Kamar</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    
    <!-- CSS External -->
    <link rel="stylesheet" href="bed4style.css">
</head>
<body>
    <!-- Header Section -->
    <div class="hospital-header">
        <div class="container">
            <div class="logo-container">
                <?php
                $setting = mysqli_fetch_array(bukaquery("SELECT nama_instansi, alamat_instansi, kabupaten, propinsi, kontak, email, logo FROM setting LIMIT 1"));
                ?>
                
                <div class="hospital-info">
                    <h4 class="hospital-name"><?php echo htmlspecialchars($setting['nama_instansi'] ?? 'Rumah Sakit'); ?></h4>
                    <p class="hospital-address mb-2">
                        <?php 
                        echo htmlspecialchars($setting['alamat_instansi'] ?? '') . ', ' . 
                             htmlspecialchars($setting['kabupaten'] ?? '') . ', ' . 
                             htmlspecialchars($setting['propinsi'] ?? '');
                        ?>
                    </p>
                    <div class="current-time">
                        <i class="far fa-clock me-2"></i>
                        <?php echo date("d F Y, H:i"); ?> WIB
                    </div>
                </div>
                
                <?php if (!empty($setting['logo'])): ?>
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($setting['logo']); ?>" class="hospital-logo" alt="Logo Rumah Sakit">
                <?php else: ?>
                    <div class="hospital-logo d-flex align-items-center justify-content-center">
                        <i class="fas fa-hospital"></i>
                    </div>
                <?php endif; ?>

                <?php if (!empty($setting['logo'])): ?>
                    <img src="assets/logolafki.png" class="lafki-logo" alt="Logo Lafki">
                <?php else: ?>
                    <div class="lafki-logo d-flex align-items-center justify-content-center">
                        <i class="fas fa-lafki"></i>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
    
    <div class="container">