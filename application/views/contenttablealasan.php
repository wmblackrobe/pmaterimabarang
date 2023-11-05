
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
                <h2>Data Alasan Utility</h2>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url('index.php/dashboard');?>">Home</a></li>
                        <li><a>Master Data</a></li>
                        <li class="active"><strong>Alasan</strong></li>
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
                        <button class="btn btn-warning" id="addalasan" type="button" data-toggle="modal" data-target="#alasanadd"><i class="fa fa-plus-square"></i> Add</button>
                        <button class="btn btn-info" id="editalasan" type="button" data-toggle="modal" data-target="#alasanedit"><i class="fa fa-paste"></i> Edit</button>
                        <button class="btn btn-danger " id="deleteAlasan" type="button"><i class="fa fa-trash-o"></i> Delete</button><br>
                        
                        <!-- Notifikasi -->
                        <?php if($this->session->flashdata('berhasilsimpanalasan')): ?>
                        <div class="alert alert-info">
                        <strong><?php echo $this->session->flashdata('berhasilsimpanalasan'); ?></strong> 
                        </div>
                        <?php endif; ?>
                        <?php if($this->session->flashdata('berhasilhapusalasan')): ?>
                        <div class="alert alert-warning">
                        <strong><?php echo $this->session->flashdata('berhasilhapusalasan'); ?></strong> 
                        </div>
                        <?php endif; ?>
                        <?php if($this->session->flashdata('gagaleditalasan')): ?>
                        <div class="alert alert-danger">
                        <strong><?php echo $this->session->flashdata('gagaleditalasan'); ?></strong> 
                        </div>
                        <?php endif; ?>
                        <?php if($this->session->flashdata('berhasileditalasan')): ?>
                        <div class="alert alert-info">
                        <strong><?php echo $this->session->flashdata('berhasileditalasan'); ?></strong> 
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
                                        <th>Kode Alasan</th>
                                        <th>Alasan</th>
                                        <th>Flag</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php $nomor=0; foreach ($dataalasan->result() as $u){ $nomor++;?>
                                <tr class="<?php if ($nomor % 2 == 0) {echo "even gradeC";} else{echo "odd gradeX";}?>">
                                    <td class="center"><?php echo $nomor;?></td>
                                    <td class="center"><?php echo $u->id_alasan?></td>
                                    <td class="center"><?php echo $u->alasan?> </td>
                                    <td class="center"><?php echo $u->flag?> </td>
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

<!-- Modal ADD alasan -->
 <div class="modal inmodal fade" id="alasanadd" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-sm ">
            <div class="modal-content">
                <!-- Header Content Modal Add alasan -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Add alasan</h4>
                    </div>
                    <!-- Content Modal Add alasan -->
                        <form method="post" action="<?php echo base_url('index.php/dashboard/aksi_inputalasan');?>">
                            <div class="modal-body">
                                <table class="table" style="border:none;" border="0" > 
                                    <tr>
                                        <td>Deskripsi Alasan</td>
                                        <td>:</td>
                                        <td><input class="form-control" type="text" name="txt-alasan" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')"  placeholder="Masukkan alasan" style="border:none;background-color:none;" size="20px" > </td>
                                    </tr>
                                     <tr>
                                        <td>Flag</td>
                                        <td>:</td>
                                        <td><input type="radio" name="flag" value="Y" checked> Ya 
                                        <br><input type="radio" name="flag" value="T"> Tidak</td>
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

<!-- Modal Edit alasan -->
<div class="modal inmodal fade" id="alasanedit" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-sm ">
            <div class="modal-content">
                <!-- Header Content Modal Add alasan -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Edit alasan</h4>
                    </div>
                    <!-- Content Modal Add alasan -->
                        <form method="post" action="<?php echo base_url('index.php/dashboard/aksi_editalasan');?>">
                            <div class="modal-body">
                                <table class="table" style="border:none;" border="0" > 
                                    <tr>
                                        <td>Deskripsi Alasan</td>
                                        <td>:</td>
                                        <td><input type="hidden" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" name="edit-id-alasan" id="editidalasan" value="" ><input class="form-control" type="text" id="txteditalasan" name="edit-txt-alasan" placeholder="Masukkan alasan" style="border:none;background-color:none;" size="20px" > </td>
                                    </tr>
                                     <tr>
                                        <td>Flag</td>
                                        <td>:</td>
                                        <td><select  class="form-control m-b" id="editflag" name='editflag'><option value='Y' selected>Ya</option><option value='N'>Tidak</option></select></td>
                                    </tr>                                 
                                </table>   
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
<!-- END MODAL Edit alasan -->

<input type="hidden" id="nmalasan" name="nmalasan">

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
        var value_grid = "";
        var value_alasan = "";
        $('#deleteAlasan').click(function(){
            //alert("delete "+value_grid);
            var konfirmasi = confirm("Anda yakin untuk menghapus '*"+$('#nmalasan').val()+"*' dari master alasan?");
            //alert("delete "+value_grid);
            if(konfirmasi === true) {
                window.location = "<?php echo base_url();?>index.php/dashboard/deleteAlasan/"+value_grid;
				}else{
                    window.location = "<?php echo base_url();?>index.php/dashboard/alasan/";
				}
        });
        var table = $('#example').DataTable();
        $('#deleteAlasan').prop('disabled', true);
        $('#editalasan').prop('disabled', true);
        $('#addalasan').prop('disabled', false);
         $('#example tbody').on( 'click', 'tr', function() {
        $('#deleteAlasan').prop('disabled', false);
        $('#editalasan').prop('disabled', false);
        $('#addalasan').prop('disabled', true);
        var item = $(this).find("td:eq(1)").text(); 
        var  value_alasan= $(this).find("td:eq(2)").text();  
        $('#nmalasan').val(value_alasan);
        $('#txteditalasan').val('');
        value_grid = item;
        $.ajax({
            url: "<?php echo base_url('index.php/dashboard/getdataalasan');?>",
            type: "POST",
            data: {id_alasan: item},
            datatype: "JSON",
            success:function(data)
            {
                console.log(data);
                $('#editidalasan').val(data.id_alasan);
                $('#txteditalasan').val(data.alasan);
            },
            error:function(data)
            {
                alert("tidak dapat diproses");
            }
        });
     
        if ( $(this).hasClass('selected')) {
        $('#deleteAlasan').prop('disabled', true);
        $('#editalasan').prop('disabled', true);
        $('#addalasan').prop('disabled', false);
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



   
