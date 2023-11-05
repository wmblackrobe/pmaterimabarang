<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PMA Terima Barang | Forgot password</title>

    <link href="<?php echo base_url();?>assets/login/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/login/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo base_url();?>assets/login/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/login/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="passwordBox animated fadeInDown">
        <div class="row">

            <div class="col-md-12">
                <div class="ibox-content">

                    <h3 class="font-bold">Silahkan Ubah Password Anda Terlebih Dahulu</3>

                    <div class="row">

                        <div class="col-lg-12">
                            <form class="m-t" role="form" method="post" action="<?php echo base_url('index.php/login/ganti_passwordbaru');?>" onSubmit="return validasi_input(this)">
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Password Baru" name="pass1" required=""><br>
                                    <input type="password" class="form-control" placeholder="Ulangi Password Baru" name="pass2" required="">
                                </div>
                                <button type="submit" class="btn btn-primary block full-width m-b">Ubah Password</button>







                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6">
                IT Development PMA
            </div>
            <div class="col-md-6 text-right">
               <small>© 2018</small>
            </div>
        </div>
    </div>

</body>

</html>
