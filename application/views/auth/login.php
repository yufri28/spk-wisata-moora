<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>SISTEM STOK YAY CBIM</title>

    <!-- Meta -->
    <meta name="description" content="" />
    <meta name="author" content="Yayasan CBIM" />
    <meta property="og:url" content="https://www.cbim.or.id/yayasan">
    <meta property="og:title" content="Sistem Stok | Yayasan CBIM">
    <meta property="og:description" content="">
    <meta property="og:type" content="Website">
    <meta property="og:site_name" content="Yayasan CBIM">
    <link rel="shortcut icon" type="image/png" href="<?=base_url()?>assets/images/logos/logo-cbim.png" />
    <link rel="stylesheet" href="<?=base_url()?>assets/css/styles.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css">
</head>

<body>
    <!-- Container start -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-sm-8 col-12">
                <form action="<?=base_url('auth/login');?>" method="post" class="my-5">
                    <div class="border rounded-2 p-4 mt-5">
                        <h2 class="text-center mb-5">LOGIN</h2>
                        <div class="login-form">
                            <?php if ($this->session->flashdata('message')): ?>
                            <div class="alert text-center">
                                <?= $this->session->flashdata('message'); ?>
                            </div>
                            <?php endif; ?>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" class="form-control"
                                    placeholder="Masukan Username" />
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Masukkan Password" />
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                            </div>
                            <div class="d-grid py-3 mt-4">
                                <button type="submit" class="btn btn-lg btn-primary">
                                    LOGIN
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Container end -->
</body>

</html>