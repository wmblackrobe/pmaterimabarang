<div id="page-wrapper" class="gray-bg dashbard-1"><!-- Menu atas -->
    <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header"><a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a></div>

                <!-- menu atas bagian kanan -->
                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown"><a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-user-circle"></i> <font size="3" style="color:#73879C;"> <?php echo $this->session->nama; ?></font> <i class="caret"></i></a>
                        <ul class="dropdown-menu">	
                        <li class=""><a href="<?php echo base_url('index.php/login/logout');?>" class="user-profile dropdown-toggle"><span class="fa fa-sign-out" aria-hidden="true">&nbsp;<font size="3" style="color:#73879C;"> Logout</font></span></a></li>
                        </ul>
                    </li>
                </ul>
                <!-- End Menu atas bagian kanan -->

        </nav>
    </div><!-- End menu atas -->