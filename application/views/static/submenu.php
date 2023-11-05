
<div id="wrapper"> <!-- CONTENT -->
    <!-- menusamping -->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    
                        <!-- Menu Header -->
                        <li class="nav-header"><div style="color:white;font-size:16px;"><span class="nav-label">PMA Terima Barang</span></div></li>
                        <!-- End Menu Header -->

                        <!-- Content menu -->
                        <?php if($this->session->userdata('hakakses')=='1'):?>
                        <li><a href="<?php echo base_url('index.php/dashboard');?>"><i class="fa fa-home"></i> <span class="nav-label">Home</span></a></li>
                        <li><a href="<?php echo base_url('index.php/dashboard/upload_surat_jalan');?>"><i class="fa fa-upload"></i> <span class="nav-label">Upload Surat Jalan</span></a></li>
                        <li><a href="#"><i class="fa fa-cubes"></i> <span class="nav-label">DTB</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                            <li><a href="<?php echo base_url();?>index.php/dashboard/dtb_process">DTB Process</a></li>
                            <li><a href="<?php echo base_url();?>index.php/dashboard/dtb_processed">DTB Processed</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo base_url('index.php/dashboard/surat_jalan_tambahan');?>"><i class="fa fa-edit"></i> <span class="nav-label">Surat Jalan Tambahan</span></a></li>
                        <li><a href="<?php echo base_url('index.php/dashboard/reportho');?>"><i class="fa fa-clone"></i> <span class="nav-label">Report</span></a></li>
                        <li><a href="#"><i class="fa fa-user"></i> <span class="nav-label">Master Data</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                            <li><a href="<?php echo base_url();?>index.php/dashboard/user">User</a></li>
                            <li><a href="<?php echo base_url();?>index.php/dashboard/email">Email</a></li>
                            <li><a href="<?php echo base_url();?>index.php/dashboard/alasan">Alasan</a></li>
                            </ul>
                        </li>
                        <?php else:?>
                        <li><a href="<?php echo base_url('index.php/dashboard');?>"><i class="fa fa-home"></i> <span class="nav-label">Home</span></a></li>
                        <li><span class="nav-label" style="color:white; position:relative; left:22px; top:5px;"><h3>GENERAL</h3></span></li>
                        <li><a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Surat Jalan</span><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level collapse">
                            <li><a href="<?php echo base_url();?>index.php/dashboard/surat_jalan_process">Surat Jalan Process</a></li>
                            <li><a href="<?php echo base_url();?>index.php/dashboard/surat_jalan_processed">Surat Jalan Processed</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo base_url('index.php/dashboard/reportarea');?>"><i class="fa fa-clone"></i> <span class="nav-label">Report</span></a></li>
                        <?php endif;?>
                        <!-- End Content Menu -->

                </ul>
            </div>
        </nav>
<!-- end menu samping -->
