<!-- link css plugin table -->
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.3.1.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
<!-- end link css plugin table -->


<!-- CONTENT -->
    <!-- Top Content -->
    <div class="row wrapper border-bottom white-bg page-heading">

        <!-- Judul Content -->
            <div class="col-lg-10">
                <h2>Data User Utility</h2>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url('index.php/dashboard');?>">Home</a></li>
                        <li><a>Master Data</a></li>
                        <li class="active"><strong>User</strong></li>
                    </ol>
            </div>
        <!-- End Judul Content -->

    </div>
    <!-- END Top Content -->

    <!-- Middle Content -->
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Fitur ini dibuat untuk mengontrol data user</h5>
                    </div>

                <div class="ibox-content">
                    <div class="table-responsive">

                        <!-- Tombol add,edit,delete -->
                        <button class="btn btn-warning" type="button" data-toggle="modal" data-target="#myModaladd"><i class="fa fa-plus-square"></i> Add</button>
                        <!-- End Tombol add,edit,delete -->
                    
                    <!-- Notifikasi -->
                        <?php if($this->session->flashdata('berhasilsimpanuser')): ?>
                        <div class="alert alert-info">
                        <strong><?php echo $this->session->flashdata('berhasilsimpanuser'); ?></strong> 
                        </div>
                        <?php endif; ?>
                        <?php if($this->session->flashdata('konfirmasigagal')): ?>
                        <div class="alert alert-warning">
                        <strong><?php echo $this->session->flashdata('konfirmasigagal'); ?></strong> 
                        </div>
                        <?php endif; ?>
                         <!-- END Notifikasi -->

                        <!-- Start Tabel -->
                        <div class="ibox-content">
                        <table id="example" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Site</th>
                                        <th>Nama Site</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Tipe User</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $nomor=0; foreach ($datauser->result() as $u){ $nomor++;?>
                                <tr class="<?php if ($nomor % 2 == 0) {echo "even gradeC";} else{echo "odd gradeX";}?>">
                                    <td class="center"><?php echo $nomor;?></td>
                                    <td class="center"><?php echo $u->kd_sap2?> </td>
                                    <td class="center"><?php echo $u->NM_DEPO?></td>
                                    <td class="center"><?php echo $u->user ?></td>
                                    <td class="center"><?php echo $u->email ?></td>
                                    <?php if($u->tipe_user=="user_tb_ho"){?>
                                    <td class="center">Head Office</td>
                                    <?php } elseif($u->tipe_user=="user_depo"){ ?>
                                    <td class="center">Area</td>
                                    <?php } else{ ?>
                                    <td class="center"></td>
                                    <?php } ?>
                                </tr>
                                <?php }?>
                                </tbody>
                            </table>
                            <!-- END TABEl -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Middle Content -->

<!-- Modal ADD User -->
 <div class="modal inmodal fade" id="myModaladd" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <!-- Header Content Modal Add User -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Add User</h4>
                    </div>
                    <!-- Content Modal Add User -->
                        <form method="post" action="<?php echo base_url('index.php/dashboard/aksi_inputuser');?>">
                            <div class="modal-body">
                                <table class="table" style="border:none;" height="100px" >
                                    <tr>
                                        <td width="220px">SITE</td>
                                        <td widh="10px">:</td>
                                        <td><select class="form-control m-b" name="listsite" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')">
                                                <option value="">--SITE--</option>
                                                <?php foreach ($datasite->result() as $m){?>
                                                <option value="<?php echo $m->Id_Depo ?>"><?php echo $m->kd_sap2 ?> - <?php echo $m->NM_DEPO ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                    </tr>
                                             
                                    <tr>
                                        <td>Username</td>
                                        <td widh="10px">:</td>
                                        <td><input class="form-control m-b" type="text" name="txt-username" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" placeholder="Username" style="border:none;background-color:none;" size="40px" > </td>
                                    </tr>

                                    <tr>
                                        <td>Password</td>
                                        <td widh="10px">:</td>
                                        <td><input class="form-control m-b" type="password" name="txt-password" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" placeholder="Password" style="border:none;background-color:none;" size="40px" ></td>
                                    </tr>

                                    <tr>
                                        <td>Konfirmasi Password</td>
                                        <td widh="10px">:</td>
                                        <td><input class="form-control m-b" type="password" name="txt-konfirmasi" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" placeholder="Konfirmasi Password" style="border:none;background-color:none;" size="40px" ></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td width="10px">:</td>
                                        <td><input class="form-control m-b" type="email" name="txt-email" placeholder="Email" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" style="border:none;background-color:none;" size="40px" ></td>
                                    </tr>
                                    <tr>
                                        <td>Tipe User</td>
                                        <td width="10px">:</td>
                                        <td><select name="tipeuser" class="form-control m-b" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')">
                                            <option value="">-Pilih Tipe User-</option>
                                            <option value="user_tb_ho">Head Office</option>
                                            <option value="user_depo">Area</option>
                                            </select>
                                        </td>
                                    </tr>                                                 
                                </table>   
                            </div>
    
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
<!-- END MODAL ADD USER -->

<input type="hidden" id="description" name="description">

    <!-- Mainly scripts -->
    <script src="<?php echo base_url(); ?>assets/dashboard/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/dashboard/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/dashboard/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url(); ?>assets/dashboard/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/dashboard/js/plugins/dataTables/datatables.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo base_url(); ?>assets/dashboard/js/inspinia.js"></script>
    <script src="<?php echo base_url(); ?>assets/dashboard/js/plugins/pace/pace.min.js"></script>

    <!-- Page-Level Scripts -->
    <script type="text/javascript">
    
    $(document).ready(function() {
        var table = $('#example').DataTable();
         
     
        if ( $(this).hasClass('selected')) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }

 
    $('#button').click( function () {
        table.row('.selected').remove().draw(false);
    } );
} );

 $('#checkganti').click(function() {
        if (!$(this).is(':checked')) {
            $('#edit-password').attr('disabled','disabled'); 
            $('#edit-password').val('');
        } else {
            $('#edit-password').removeAttr('disabled');
            $('#edit-password').focus();
        }
    });
</script>



