<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('/bootstrap/css/bootstrap.min.css') ?>">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url('/css/style.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('/select2/dist/css/select2.min.css') ?>" defer>
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


    <title><?= esc($title) ?> - RSGM UNEJ</title>
</head>

<body>
    <!-- <nav class="navbar navbar-expand-lg navbar-bg">
    <div class="container-fluid">
        <a class="navbar-brand text-white h4" href="#">
        <img src="/img/logo.png" alt="" width="auto" height="72" class="d-inline-block align-text-top">
            RSGM Universitas Jember
        </a>
    </div>
    </nav> -->

    <!-- tesssssst -->

    <div class="wrapper">
        <aside id="sidebar">
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo">

                </div>
            </div>
            <ul class="sidebar-nav">
                <!-- Dashboard  -->
                <li class="sidebar-item">
                    <a href="<?php echo base_url('dashboard') ?>" class="sidebar-link <?= ($pagesidebar == 1) ? 'active' : '' ?>">
                        <i class="lni lni-home"></i>
                        <span>Dashboard </span>
                    </a>
                </li>
                <!-- End Dashboard -->

                <?php if ($role == 1) : ?>
                    <!-- Master Data -->
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link <?= ($pagesidebar == 2) ? 'active' : '' ?> collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#masterdata" aria-expanded="false" aria-controls="masterdata">
                            <i class="lni lni-database"></i>
                            <span>Master Data</span>
                        </a>
                        <ul id="masterdata" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                            <li class="sidebar-item <?= ($subsidebar == 1) ? 'active' : '' ?>">
                                <a href="<?php echo base_url('recordmedical') ?>" class="sidebar-link">
                                    Rekam Medis
                                </a>
                            </li>
                            <li class="sidebar-item <?= ($subsidebar == 2) ? 'active' : '' ?>">
                                <a href="<?php echo base_url('officer') ?>" class="sidebar-link">
                                    Petugas
                                </a>
                            </li>
                            <li class="sidebar-item <?= ($subsidebar == 3) ? 'active' : '' ?>">
                                <a href="<?php echo base_url('serviceunit') ?>" class="sidebar-link">
                                    Poli
                                </a>
                            </li>
                            <li class="sidebar-item <?= ($subsidebar == 6) ? 'active' : '' ?>">
                                <a href="<?php echo base_url('coass') ?>" class="sidebar-link">
                                    Coass
                                </a>
                            </li>
                            <li class="sidebar-item <?= ($subsidebar == 7) ? 'active' : '' ?>">
                                <a href="<?php echo base_url('public') ?>" class="sidebar-link">
                                    Public
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- End Master Data -->
                <?php endif ?>

                <!-- Transaksi -->
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link <?= ($pagesidebar == 3) ? 'active' : '' ?> collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#transaction" aria-expanded="false" aria-controls="transaction">
                        <i class="lni lni-write"></i>
                        <span>Transaksi</span>
                    </a>
                    <ul id="transaction" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#transaction">
                        <li class="sidebar-item <?= ($subsidebar == 4) ? 'active' : '' ?>">
                            <a href="<?php echo base_url('loanpublic') ?>" class="sidebar-link">
                                Peminjaman
                            </a>
                        </li>
                        <li class="sidebar-item <?= ($subsidebar == 5) ? 'active' : '' ?>">
                            <a href="<?php echo base_url('returndoc') ?>" class="sidebar-link">
                                Pengembalian
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- End Transaksi -->

                <?php if ($role == 1 or $role == 2) : ?>
                    <!-- Laporan -->
                    <li class="sidebar-item">
                        <a href="<?php echo base_url('report') ?>" class="sidebar-link <?= ($pagesidebar == 4) ? 'active' : '' ?>">
                            <i class="lni lni-folder"></i>
                            <span>Laporan </span>
                        </a>
                    </li>
                    <!-- End Laporan -->
                <?php endif ?>

            </ul>
            <div class="sidebar-footer">
                <a href="<?php echo base_url('/logout') ?>" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>
        <div class="main">
            <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #0167B7;">
                <div class="container-fluid">
                    <a class="navbar-brand text-white" href="#">
                        <img src="/img/logo.png" alt="" width="auto" height="32" class="d-inline-block align-text-top">
                        RSGM Universitas Jember
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-md-end" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle me-md-2 text-white" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="lni lni-user"></i>
                                    <?= esc($username) ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="<?php echo base_url('/logout') ?>">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- <a href="#" class="sidebar-link text-white collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#account" aria-expanded="false" aria-controls="account">
                        User
                    </a>
                    <ul id="account" class="collapse" data-bs-parent="#sidebar">
                        <a href="#" class="" >
                                Logout
                        </a>  
                    </ul> -->
                    <!-- <a class="nav-link text-white" href="#">User</a>   -->
                </div>
            </nav>
            <!-- title -->


            <div class="container my-5">
                <div class="row">
                    <nav class="navbar navbar-light bg-light">
                        <div class="container-fluid">
                            <span class="navbar-text">
                                <?= esc($title) ?>
                            </span>
                        </div>
                    </nav>
                </div>
                <div class="row justify-content-md-center mt-5">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>
                    <?= $this->renderSection('content') ?>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo base_url('/js/script.js') ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?php echo base_url('bootstrap/js/bootstrap.bundle.min.js') ?>">
    </script>
</body>

</html>