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

                    <h2 class="font-bold">Forgot password</h2>

                    <div class="row">

                        <div class="col-lg-12">
                            <form class="m-t" role="form" method="post" action="<?php echo base_url('index.php/login/aksi_resetpassword');?>">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Masukkan Username" name="username" required="">
                                </div>
                                
                                <button type="submit" class="btn btn-primary block full-width m-b">Reset Password</button>

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
