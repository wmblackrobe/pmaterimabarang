<link href="<?php echo base_url();?>assets/dashboard/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
<script src="<?php echo base_url('assets/excel/js/jquery.min.js'); ?>"></script>

<!-- Judul Content -->
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Upload Surat Jalan</h2>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('index.php/dashboard');?>">Home</a></li>
                <li class="active"><a>Upload_Surat_jalan</a></li>
            </ol>
    </div>
</div>
<!-- End Judul Content -->

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Fitur ini dibuat untuk memudahkan admin melakukan batch upload</h5>
                    <div class="ibox-tools">
                </div>
                <div class="ibox-content">

                 <!-- Notifikasi -->
                <?php if($this->session->flashdata('berhasilimport')): ?>
                <div class="alert alert-info">
                <strong><?php echo $this->session->flashdata('berhasilimport'); ?></strong>
                </div>
                <?php endif; ?> 
                <?php if($this->session->flashdata('gagalimport')): ?>
                <div class="alert alert-danger">
                <strong><?php echo $this->session->flashdata('gagalimport'); ?></strong>
                </div>
                <?php endif; ?> 
                <!-- END Notifikasi -->

                <!-- Syarat Upload -->
                    <ol>
                        <li>Format File (.xlsx)</li>
                        <li>File tidak boleh lebih dari 5 Mb </li>
                        <li>File template dapat di download <a href="<?php echo base_url("excel/formatsuratjalan.xlsx" );?>" >Disini</a></li>
                    </ol>
                <!-- End Syarat Upload -->

                <!-- Tombol Upload File -->
                <form method='post'  action="<?php echo base_url('index.php/dashboard/import');?>" enctype="multipart/form-data">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <span class="btn btn-default btn-file"><input id="filesj" type="file" name="filesj" required oninvalid="this.setCustomValidity('File tidak boleh kosong')" oninput="setCustomValidity('')"></span>
                    <span class="fileinput-filename"></span> <button  class="btn btn-sm btn-primary m-t-n-xs" id='previewsj' name="preview" type="submit" value="import"><strong>Import</strong></button> 
                </div>
                <input type='text' style='background:none;color:red; border:none;' size='50' id='validasi' readonly name='validasi'>
                </form>

                <!-- END Tombol Upload File -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    

<!-- Mainly scripts -->
<script src="<?php echo base_url();?>assets/dashboard/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url();?>assets/dashboard/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/dashboard/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url();?>assets/dashboard/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="<?php echo base_url();?>assets/dashboard/js/plugins/dataTables/datatables.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url();?>assets/dashboard/js/inspinia.js"></script>
<script src="<?php echo base_url();?>assets/dashboard/js/plugins/pace/pace.min.js"></script>


<!-- Page-Level Scripts -->
<script>
    $('#validasi').val(''); 
    $('#previewsj').prop('disabled',true);
    $('#filesj').change(function(){
    var sjupload=document.getElementById("filesj").value;
    var extensi=/(\.xlsx)$/i;
    var sizexlsj=document.getElementById("filesj").files[0];
  
        if(!extensi.exec(sjupload))
        {
            $('#validasi').val('Format file harus .xlsx !'); 
            $('#previewsj').prop('disabled',true);
        }
        else{
            $('#validasi').val(''); 
            if(sizexlsj.size>5000000)
            {
                $('#validasi').val('Size file tidak boleh lebih dari 5 mb !'); 
                $('#previewsj').prop('disabled',true);
            }
            else{
                $('#validasi').val('');
                $('#previewsj').prop('disabled',false);
            }
        }
    });
   
</script>


