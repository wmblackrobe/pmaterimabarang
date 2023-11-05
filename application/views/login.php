<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PMA Terima Barang | Login</title>
    <link href="<?php echo base_url();?>assets/login/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/login/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/login/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/login/css/style.css" rel="stylesheet">
</head>

<body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
             <!-- Logo -->
                <div>
                    <h1 class="logo-name"><img src="<?php echo base_url();?>assets/login/img/pma3.png" width="200px"></h1>
                </div>
             <!-- End Logo -->

            <h3>Welcome to PMA Terima Barang</h3>

            <!-- Form Login -->
            <form class="m-t" role="form" method='post' action="<?php echo base_url('index.php/login/aksi_login');?>">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Username" name="username" required="Username harus diisi">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" name="password" required="Password harus diisi">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                <a href="<?php echo base_url('index.php/login/forgot_password');?>"><small>Forgot password?</small></a>
            </form>
            <!-- End Form Login -->

            <!-- Notifikasi -->
            <?php if($this->session->flashdata('gagal')): ?>
                <div class="alert alert-warning">
                <strong>Gagal Login!</strong> <?php echo $this->session->flashdata('gagal'); ?>
                </div>
            <?php endif; ?>
            <?php if($this->session->flashdata('akses')): ?>
                <div class="alert alert-danger">
                <strong>Gagal Akses!</strong> <?php echo $this->session->flashdata('akses'); ?>
                </div>
            <?php endif; ?>
            <?php if($this->session->flashdata('pwbaruberhasil')): ?>
                <div class="alert alert-info">
                <strong>Berhasil!</strong> <?php echo $this->session->flashdata('pwbaruberhasil'); ?>
                </div>
            <?php endif; ?>
            <?php if($this->session->flashdata('pwresetberhasil')): ?>
                <div class="alert alert-info">
                <strong>Berhasil!</strong> <?php echo $this->session->flashdata('pwresetberhasil'); ?>
                </div>
            <?php endif; ?>
            <?php if($this->session->flashdata('pwresetgagal')): ?>
                <div class="alert alert-danger">
                <strong>Gagal Reset!</strong> <?php echo $this->session->flashdata('pwresetgagal'); ?>
                </div>
            <?php endif; ?>
            <!-- End Notifikasi -->


            <!-- Footer Login -->
            <p class="m-t"> <small>IT Development Pinus Merah Abadi &copy; 2018</small> </p>
            <!-- End footer Login -->

        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo base_url();?>assets/login/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url();?>assets/login/js/bootstrap.min.js"></script>

</body>
</html>
