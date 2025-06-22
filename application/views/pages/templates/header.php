<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SPK Rekomendasi Wisata</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?=base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="<?=base_url();?>assets/css/main.css" rel="stylesheet">

</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container position-relative d-flex align-items-center justify-content-between">

            <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
                <h1 class="sitename">SPK Rek Wisata</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="<?=base_url('pages')?>#hero">Beranda</a></li>
                    <li><a href="<?=base_url('pages')?>#recent-posts">Destinasi</a></li>
                    <li><a class="<?=$menu == 'rekomendasi'?'active':''?>"
                            href="<?=base_url('pages/rekomendasi')?>">Rekomendasi</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
            <?php if (!empty($this->session->userdata('id_auth'))): ?>
            <a class="cta-btn" href="<?= base_url('logout') ?>">Logout</a>
            <?php else: ?>
            <a class="cta-btn" href="<?= base_url('auth') ?>">Login</a>
            <?php endif; ?>
        </div>
    </header>
    <main class="main">