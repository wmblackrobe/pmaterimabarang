
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
                <h2>Data Email User Utility</h2>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url('index.php/dashboard');?>">Home</a></li>
                        <li><a>Master Data</a></li>
                        <li class="active"><strong>Email</strong></li>
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
                        <h5>Fitur ini dibuat untuk mengontrol alasan surat jalan</h5>
                    </div>

                <div class="ibox-content">
                    <div class="table-responsive">

                        <!-- Tombol add,edit,delete -->
                        <button class="btn btn-warning" id="addemail" type="button" data-toggle="modal" data-target="#emailadd"><i class="fa fa-plus-square"></i> Add</button>
                        <button class="btn btn-info" type="button" id="editemail" data-toggle="modal" data-target="#emailedit"><i class="fa fa-paste"></i> Edit</button>
                        <button class="btn btn-danger" type="button" id="deleteemail"><i class="fa fa-paste"></i> Delete</button>
                        <button class="btn btn-warning" type="button"  data-toggle="modal" data-target="#emailupload" id="uploademail"><i class="fa fa-upload"></i> Upload</button>
                        <a class="btn btn-info" href="<?php echo base_url('index.php/dashboard/exportemail');?>" id="downloademail" ><i class="fa fa-download"></i> Download</a>
                      
                        
                        <!-- Notifikasi -->
                        <?php if($this->session->flashdata('berhasilsimpanemail')): ?>
                        <div class="alert alert-info">
                        <strong><?php echo $this->session->flashdata('berhasilsimpanemail'); ?></strong> 
                        </div>
                        <?php endif; ?>
                        <?php if($this->session->flashdata('berhasilupdateemail')): ?>
                        <div class="alert alert-info">
                        <strong><?php echo $this->session->flashdata('berhasilupdateemail'); ?></strong> 
                        </div>
                        <?php endif; ?>
                        <?php if($this->session->flashdata('berhasilhapusemail')): ?>
                        <div class="alert alert-info">
                        <strong><?php echo $this->session->flashdata('berhasilhapusemail'); ?></strong> 
                        </div>
                        <?php endif; ?>
                        <?php if($this->session->flashdata('berhasilimport')): ?>
                        <div class="alert alert-warning">
                        <strong><?php echo $this->session->flashdata('berhasilimport'); ?></strong>
                            </div>
                            <?php endif; ?> 
                            <?php if($this->session->flashdata('gagalimport')): ?>
                        <div class="alert alert-danger">
                        <strong><?php echo $this->session->flashdata('gagalimport'); ?></strong>
                            </div>
                            <?php endif; ?> 
                       
                         <!-- End Notifikasi -->

                        <!-- End Tombol add,edit,delete -->
                    
                        <!-- Start Tabel -->
                        <div class="ibox-content">
                        <table id="example" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Site</th>
                                        <th>Nama</th>
                                        <th>BM</th>
                                        <th>SPV</th>
                                        <th>SA</th>
                                        <th>DIM</th>
                                        <th>ADIM</th>
                                        <th>DPS</th>
                                        <th>STAFF SCM 1</th>
                                        <th>STAFF SCM 2</th>
                                        <th>STAFF SCM 3</th>
                                        <th>STAFF SCM 4</th>
                                        <th>STAFF SCM 5</th>

                                    </tr>
                                </thead>
                                <tbody>
                                   <?php $nomor=0; foreach ($dataemail->result() as $u){ $nomor++;?>
                                <tr class="<?php if ($nomor % 2 == 0) {echo "even gradeC";} else{echo "odd gradeX";}?>">
                                    <td class="center"><?php echo $nomor;?></td>
                                    <td class="center"><?php echo $u->kd_sap2?></td>
                                    <td class="center"><?php echo $u->NM_DEPO?> </td>
                                    <td class="center"><?php echo $u->email_bm?> </td>
                                    <td class="center"><?php echo $u->email_spv_log?> </td>
                                    <td class="center"><?php echo $u->email_sa?> </td>
                                    <td class="center"><?php echo $u->email_dim?></td>
                                    <td class="center"><?php echo $u->email_adim?></td>
                                    <td class="center"><?php echo $u->email_dps?> </td>
                                    <td class="center"><?php echo $u->email_staff_scm_1?> </td>
                                    <td class="center"><?php echo $u->email_staff_scm_2?> </td>
                                    <td class="center"><?php echo $u->email_staff_scm_3?> </td>
                                    <td class="center"><?php echo $u->email_staff_scm_4?> </td>
                                    <td class="center"><?php echo $u->email_staff_scm_5?> </td>
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

<!-- Modal ADD Email -->
 <div class="modal inmodal fade" id="emailadd" tabindex="-1" role="dialog"  aria-hidden="true">
 <div class="modal-dialog modal-lg" style="width:900px;">
        <div class="modal-content"  style="height:550px;">
                <!-- Header Content Modal Add alasan -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Add Email</h4>
                    </div>
                    <!-- Content Modal Add alasan -->
                        <form method="post" action="<?php echo base_url('index.php/dashboard/aksi_inputemail');?>">
                            <div class="modal-body">
                                <table class="table" style="border:none;" border="0" > 
                                    <tr>
                                        <td>Kode SITE</td>
                                        <td>:</td>
                                        <td><select  class="form-control m-b" style="width:200px;" name='kdsite' required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')"><option value="">--Pilih SITE--</option><?php  foreach ($datadepo->result() as $m){ ?>
                                        <option value="<?php echo $m->kd_sap2?>"><?php echo $m->kd_sap2?>-<?php echo $m->NM_DEPO ?></option>
                                        <?php }?>
                                        </td>
                                     
                                        <td>Email DPS</td>
                                        <td>:</td>
                                        <td><input class="form-control" type="email" name="emaildps" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" placeholder="Masukkan Email DPS" style="border:none;background-color:none;" size="20px" > </td>
                                
                                    </tr>
                                     <tr>
                                        <td>Email BM</td>
                                        <td>:</td>
                                        <td><input class="form-control" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" type="email" name="emailbm" placeholder="Masukkan Email BM" style="border:none;background-color:none;" size="20px" > </td>
                                       
                                        <td>Email Staff SCM 1</td>
                                        <td>:</td>
                                        <td><input class="form-control" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" type="email" name="emailscm1" placeholder="Masukkan Email STAFF SCM 1" style="border:none;background-color:none;" size="20px" > </td>
                                  
                                    </tr>  
                                    <tr>
                                        <td>Email SPV</td>
                                        <td>:</td>
                                        <td><input class="form-control" type="email" name="emailspv" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" placeholder="Masukkan Email SPV Logistic" style="border:none;background-color:none;" size="20px" > </td>
                                        
                                        <td>Email Staff SCM 2</td>
                                        <td>:</td>
                                        <td><input class="form-control" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" type="email"name="emailscm2" placeholder="Masukkan Email Staff SCM 2"  style="border:none;background-color:none;" size="20px" > </td>
                                    
                                    </tr>   
                                    <tr>
                                        <td>Email SA</td>
                                        <td>:</td>
                                        <td><input class="form-control" type="email" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" name="emailsa" placeholder="Masukkan Email SA"  style="border:none;background-color:none;" size="20px" > </td>
                                   
                                        <td>Email Staff SCM 3</td>
                                        <td>:</td>
                                        <td><input class="form-control" type="email" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" name="emailscm3" placeholder="Masukkan Email Staff SCM 3"  style="border:none;background-color:none;" size="20px" > </td>
                                  
                                    </tr>     
                                    <tr>
                                        <td>Email DIM</td>
                                        <td>:</td>
                                        <td><input class="form-control" type="email" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" name="emaildim" placeholder="Masukkan Email DIM"  style="border:none;background-color:none;" size="20px" > </td>
                                       
                                        <td>Email Staff SCM 4</td>
                                        <td>:</td>
                                        <td><input class="form-control" type="email" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" name="emailscm4" placeholder="Masukkan Email Staff SCM 4"  style="border:none;background-color:none;" size="20px" > </td>
                                   
                                    </tr>     
                                    <tr>
                                        <td>Email ADIM</td>
                                        <td>:</td>
                                        <td><input class="form-control" type="email" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" name="emailadim" placeholder="Masukkan Email ADIM"  style="border:none;background-color:none;" size="20px" > </td>
                                        
                                        <td>Email Staff SCM 5</td>
                                        <td>:</td>
                                        <td><input class="form-control" type="email" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" name="emailscm5" placeholder="Masukkan Email Staff SCM 5" style="border:none;background-color:none;" size="20px" > </td>
                              
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
<!-- END MODAL ADD ALASAN -->

<!-- Modal Edit  -->
<div class="modal inmodal fade" id="emailedit" tabindex="-1" role="dialog"  aria-hidden="true">
 <div class="modal-dialog modal-lg" style="width:900px;">
        <div class="modal-content"  style="height:550px;">
                <!-- Header Content Modal Add alasan -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Edit Email</h4>
                    </div>
                    <!-- Content Modal Add alasan -->
                        <form method="post" action="<?php echo base_url('index.php/dashboard/aksi_editemailuser');?>">
                            <div class="modal-body">
                                <table class="table" style="border:none;" border="0" > 
                                    <tr>
                                        <td>Kode SITE</td>
                                        <td>:</td>
                                        <td><input class="form-control" type="text" id="editkdsite" name="editkdsite"  style="border:none;background-color:none;" size="20px" readonly ></td>
                                     
                                        <td>Email DPS</td>
                                        <td>:</td>
                                        <td><input class="form-control" type="email" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" id="editemaildps" name="editemaildps"  style="border:none;background-color:none;" size="20px" > </td>
                                    </tr>
                                     <tr>
                                        <td>Email BM</td>
                                        <td>:</td>
                                        <td><input class="form-control" type="email" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" id="editemailbm" name="editemailbm" style="border:none;background-color:none;" size="20px" > </td>
                                       
                                        <td>Email Staff SCM 1</td>
                                        <td>:</td>
                                        <td><input class="form-control" type="email" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" id="editemailscm1" name="editemailscm1"  style="border:none;background-color:none;" size="20px" > </td>
                                  
                                    </tr>  
                                    <tr>
                                        <td>Email SPV</td>
                                        <td>:</td>
                                        <td><input class="form-control" type="email" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" id="editemailspv" name="editemailspv"  style="border:none;background-color:none;" size="20px" > </td>
                                        
                                        <td>Email Staff SCM 2</td>
                                        <td>:</td>
                                        <td><input class="form-control" type="email" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" id="editemailscm2" name="editemailscm2"  style="border:none;background-color:none;" size="20px" > </td>
                                    
                                    </tr>   
                                    <tr>
                                        <td>Email SA</td>
                                        <td>:</td>
                                        <td><input class="form-control" type="email" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" id="editemailsa" name="editemailsa"   style="border:none;background-color:none;" size="20px" > </td>
                                   
                                        <td>Email Staff SCM 3</td>
                                        <td>:</td>
                                        <td><input class="form-control" type="email" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" id="editemailscm3" name="editemailscm3" style="border:none;background-color:none;" size="20px" > </td>
                                  
                                    </tr>     
                                    <tr>
                                        <td>Email DIM</td>
                                        <td>:</td>
                                        <td><input class="form-control" type="email" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" id="editemaildim" name="editemaildim"  style="border:none;background-color:none;" size="20px" > </td>
                                       
                                        <td>Email Staff SCM 4</td>
                                        <td>:</td>
                                        <td><input class="form-control" type="email"  required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" id="editemailscm4" name="editemailscm4"   style="border:none;background-color:none;" size="20px" > </td>
                                   
                                    </tr>     
                                    <tr>
                                        <td>Email ADIM</td>
                                        <td>:</td>
                                        <td><input class="form-control" type="email" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" id="editemailadim" name="editemailadim" style="border:none;background-color:none;" size="20px" > </td>
                                        
                                        <td>Email Staff SCM 5</td>
                                        <td>:</td>
                                        <td><input class="form-control" type="email" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" id="editemailscm5" name="editemailscm5"  style="border:none;background-color:none;" size="20px" > </td>
                              
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
<!-- END MODAL Edit alasan -->

<div class="modal inmodal fade" id="emailupload" tabindex="-1" role="dialog"  aria-hidden="true">
 <div class="modal-dialog modal-lg" style="width:500px;">
        <div class="modal-content"  style="">
                <!-- Header Content Modal Add alasan -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Upload Email</h4>
                    </div>
                    <!-- Content Modal Add alasan -->
                        <form method="post" action="<?php echo base_url('index.php/dashboard/importemail');?>" enctype="multipart/form-data">
                            <div class="modal-body">
                            <a class="btn btn-warning" href="<?php echo base_url("excel/formatemail.xlsx" );?>">Format Excel</a><br><br>
                            <table>
                            <tr><td style="width:100px;">Pilih file</td><td style="width:20px;"> :</td> <td ><input type="file" name="fileexcelemail"></td></tr>
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
        $('#deleteemail').prop('disabled', true);
        $('#editemail').prop('disabled', true);
        $('#addemail').prop('disabled', false);
        var value_grid = "";
        $('#deleteemail').click(function(){
            //alert("delete "+value_grid);
            var konfirmasi = confirm("Anda yakin untuk menghapus data ini dari master email user?");
            //alert("delete "+value_grid);
            if(konfirmasi === true) {
                window.location = "<?php echo base_url();?>index.php/dashboard/deleteemail/"+value_grid;
				}else{
                    window.location = "<?php echo base_url();?>index.php/dashboard/email/";
				}
        });
        var table = $('#example').DataTable();
         $('#example tbody').on( 'click', 'tr', function() {
        $('#addemail').prop('disabled', true);
        $('#deleteemail').prop('disabled', false);
        $('#editemail').prop('disabled', false);
        var item = $(this).find("td:eq(1)").text(); 
        value_grid = item;
       
        $.ajax({
            url: "<?php echo base_url('index.php/dashboard/getdataemailuser');?>",
            type: "POST",
            data: {kd_sap2: item},
            datatype: "JSON",
            success:function(data)
            {
              
                $('#editkdsite').val(data.kd_sap2);
                $('#editemailbm').val(data.email_bm);
                $('#editemailspv').val(data.email_spv_log);
                $('#editemailsa').val(data.email_sa);
                $('#editemaildim').val(data.email_dim);
                $('#editemailadim').val(data.email_adim);
                $('#editemaildps').val(data.email_dps);
                $('#editemailscm1').val(data.email_staff_scm_1);
                $('#editemailscm2').val(data.email_staff_scm_2);
                $('#editemailscm3').val(data.email_staff_scm_3);
                $('#editemailscm4').val(data.email_staff_scm_4);
                $('#editemailscm5').val(data.email_staff_scm_5);
            },
            error:function(data)
            {
                alert("tidak dapat diproses");
            }
        });
     
        if ( $(this).hasClass('selected')) {
        $('#deleteemail').prop('disabled', true);
        $('#editemail').prop('disabled', true);
        $('#addemail').prop('disabled', false);
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
 
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



   
