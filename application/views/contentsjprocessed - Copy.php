
<!-- link css plugin table -->
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.3.1.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>assets/dashboard/css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">
<!-- end link css plugin table -->


<!-- CONTENT -->
    <!-- Top Content -->
    <div class="row wrapper border-bottom white-bg page-heading">

        <!-- Judul Content -->
            <div class="col-lg-10">
                <h2>Surat Jalan Processed</h2>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url('index.php/dashboard');?>">Home</a></li>
                        <li><a>Surat Jalan</a></li>
                        <li class="active"><strong>Surat Jalan Processed</strong></li>
                    </ol>
            </div>
        <!-- End Judul Content -->
    </div>
    <!-- END Top Content -->
    
<style>
.table-wrapper-scroll-y {
  display: block;
  max-height: 200px;
  overflow-y: auto;
  -ms-overflow-style: -ms-autohiding-scrollbar;
}
</style>

    <!-- Middle Content -->
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Fitur ini dibuat untuk mengontrol surat jalan yang sudah diproses oleh Head Office</h5>
                    </div>

                <div class="ibox-content" style="border:none;">
                    
                        <form action="" id="formdtb" method="post">
                        <table width="300px" border="0">
                          <!-- Notifikasi -->
                        <?php if($this->session->flashdata('berhasilupdate')): ?>
                        <div class="alert alert-info">
                        <strong><?php echo $this->session->flashdata('berhasilupdate'); ?></strong> 
                        </div>
                        <?php endif; ?>
                        <?php if($this->session->flashdata('gagalupload')): ?>
                        <div class="alert alert-warning">
                        <strong><?php echo $this->session->flashdata('gagalupload'); ?></strong> 
                        </div>
                        <?php endif; ?>
                        <!-- END Notifikasi -->
                        <tr><td>Dari Tanggal : <input type="date"  class="form-control m-b" id="tglawal" name="tglawal" ></td><tr>
                        <tr><td>Sampai Tanggal : <input type="date"  class="form-control m-b" id="tglakhir" name="tglakhir" ></td></tr>
                        <tr><td>Status : <select class="form-control m-b"  id="status" name="status"><option value="semua">--Pilih Status--</option><option value="arrival">Arrival</option><option value="approve">Approve</option><option value="reject">Reject</option></select></td></tr>
                        <tr><td><button class="btn btn-sm btn-white pull-left m-t-n-xs" id="reset" type="reset" style="font-size:14px"><i class="fa fa-refresh" onClick="document.location.reload(true)"></i> Reset</button> <button class="btn btn-sm btn-primary pull-center m-t-n-xs" type="submit" style="font-size:14px"><i class="fa fa-check"></i> Proses</button></td></tr>
                        </table>
                        </form>
                        </div>
                        <!-- End Tombol add,edit,delete -->
                    
                        <!-- Start Tabel -->
                        <br>
                        <div class="ibox-content" id="tbl1" style="display:none;">
                        <button class="btn btn-danger" type="button" data-toggle="modal"  data-target="#myModaledit" id="editbtn"><i class="fa fa-paste"></i> Edit</button>
                        <table id="example" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Surat Jalan</th>
                                        <th>No Surat Jalan</th>
                                        <th>Principal</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
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
    
 <div class="modal inmodal fade" id="myModaledit" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width:800px;">
            <div class="modal-content animated flipInY">
                <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">SURAT JALAN TERIMA BARANG</h4>
                    </div>
                    <!-- Content Modal Edit SURAT JALAN -->
                        <form method="post" id="updatesuratjalan" action="" >
                            <div class="modal-body" style="width:790px;">
                            <div id="edit-nomorsj"></div><br>
                            Tanggal DTB: <input type="date" id="tgldtb1" name="tgldtb" ><input type="text" id="peringatan" readonly style="background:none;color:red;border:none;" size="100" ><br><br>
                                
                                <table  id="tbll" style="width:100%">
                                <thead>
                                 <tr>
                                        <th class='center'>PCODE</th>
                                        <th class='center'>PCODENAME</th>
                                        <th  class='center'>NO SJ</th>
                                        <th  class='center'>QTY</th>
                                    </tr>
                                </thead>
                                </table>
                                <table class="table table-bordered table-striped table-wrapper-scroll-y" id="tbl2" style="width:100%">
                                <tbody>
                                </tbody>
                            </table>
                            <!-- END TABEl -->
                            <br>
                            <div>Status :</div>
                            <div> 
                            <input type="radio" id="statussj" name="status" checked value="sesuai">Sesuai <br>
                            <input type="radio" id="statussj" name="status" value="selisih kurang">Selisih Kurang <br>
                            <input type="radio" id="statussj" name="status" value="selisih lebih">Selisih Lebih <br>
                            <input type="radio" id="statussj" name="status" value="selisih variant">Selisih Variant 
                            </div>
                            </div>
                            <div  class="modal-footer">
                                <button type="submit" id="update-edit_btn" data-toggle="modal"  data-target="#modalstatus" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-white" data-dismiss="modal" onClick="document.location.reload(true)">Cancel</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>

    
<!-- <div class="modal inmodal fade" id="myModaledit" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width:800px;">
            <div class="modal-content animated flipInY">
                <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title"> SURAT JALAN TERIMA BARANG</h4>
                    </div> -->
                    <!-- Content Modal Edit SURAT JALAN -->
                        <!-- <form method="post" id="updatesuratjalan" action="<?php echo base_url('index.php/dashboard/updatesjreject');?>" enctype="multipart/form-data" >
                            <div class="modal-body" style="width:790px;">
                            <div id="edit-nomorsj"></div><br>
                            Tanggal DTB : <input type="text" id="tgldtb1" name="tgldtb" readonly>  Status : <input type="text" id="statussj" name="statussj" readonly> <br><br>
                            <div id="contentmodalstatus" ></div>
                            <div  class="modal-footer">
                                <button type="submit" id="update-edit_btn" data-toggle="modal"  data-target="#modalstatus" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-white" data-dismiss="modal" href="<?php echo base_url('dashboard/surat_jalan_proses');?>">Cancel</button>
                            </div>
                        </form>
                        </div>
                </div> -->

    <!-- Mainly scripts -->
    <script src="<?php echo base_url(); ?>assets/dashboard/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/dashboard/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/dashboard/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url(); ?>assets/dashboard/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/dashboard/js/plugins/dataTables/datatables.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo base_url(); ?>assets/dashboard/js/inspinia.js"></script>
    <script src="<?php echo base_url(); ?>assets/dashboard/js/plugins/pace/pace.min.js"></script>
    <script src="<?php echo base_url();?>assets/dashboard/js/plugins/chosen/chosen.jquery.js"></script>

    <!-- Page-Level Scripts -->
    <script>
        $('#formdtb').submit(function(){
            var awal = $('#tglawal').val();
            var akhir = $('#tglakhir').val();
            var statussj = $('#status').val();
           
            $.ajax({
                url: "<?php echo base_url('index.php/dashboard/getDatasjprocessed'); ?>",
                type: "POST",
                data: {tglawal:awal, tglakhir:akhir, status:statussj},
                dataType: "json",
                success: function(data){
                    $('#tbl1').show();
                
                    $('#editbtn').prop('disabled', true);
                    var no = 1;
                    $("#tbl1").find('tbody').html("");
                    $.each(data,function(index, value){
                        if(data[index].status=="reject")
                        {  
                        var body = "<tr><td class='center'>"+no+"</td><td class='center'>"+data[index].tgl_sj+"</td></td><td class='center'>"+data[index].no_sj+"</td></td><td class='center'>"+data[index].principal+"</td>"+
                        "<td class='center' style='color:red;'>"+data[index].status+"</td>"+
                        "<td class='center'>"+data[index].keterangan+"</td></tr>";
                        }
                        else{
                        var body = "<tr><td class='center'>"+no+"</td><td class='center'>"+data[index].tgl_sj+"</td></td><td class='center'>"+data[index].no_sj+"</td></td><td class='center'>"+data[index].principal+"</td>"+
                        "<td class='center' style='color:green;'>"+data[index].status+"</td>"+
                        "<td class='center'>"+data[index].keterangan+"</td></tr>";
                        }
                        $("#tbl1").find('tbody').append(body);
                        no++;
                    });
                    var table = $('#example').DataTable();
                    var value_grid = "";
                    var value_tglsj = "";
                    var value_principal = "";
                    var table = $('#example').DataTable();
                    var item = "";
                    var statusapp="";
                    $('#example tbody').on('click', 'tr', function() {
                    item = $(this).find("td:eq(2)").text();  
                    var value_tglsj= $(this).find("td:eq(1)").text();  
                    var value_principal= $(this).find("td:eq(3)").text(); 
                    var statusapp=$(this).find("td:eq(4)").text();
                    value_grid = item;
                    $('#tgldtb1').val("");
                    $('#statussj').val('');
                    $('#nodtb').val('');
                    $('#nodtb2').val('');
                    $('#nobppr').val('');
                    $('#nobasp').val('');
                    $('#tgldtb1').val('');
                    $.ajax({
                        url: "<?php echo base_url('index.php/dashboard/getdatasj2');?>",
                        type: "POST",
                        data: {no_sj: item,tgl_sj: value_tglsj},
                        datatype: "JSON",
                        success:function(data)
                        {
                            $('#nosj').val(item);
                          
                            if (statusapp=="reject")
                            {
                                $('#editbtn').prop('disabled', false);
                            }
                            else{
                                $('#editbtn').prop('disabled', true);
                            }
                            
                            $('#edit-nomorsj').html("");
                            $('#edit-nomorsj').append(value_grid + ", " + value_tglsj + ", " + value_principal);
                            $("#tbl2").find('tbody').html("");
                            var body = "";
                            
                                $.each(data,function(index, value){
                                    $('#statussj').val(data[index].keterangan);
                                    $("#contentmodalstatus").html(''); 
                                    if( $('#statussj').val()=="selisih kurang")
                                    {
                                        var content = "";   
                                        content="<div class='table-wrapper-scroll-y'><table class='table table-bordered table-striped' id='tbl3' style='font-size:10.5px;'>"+
                                                "<thead><tr><th>PCODE</th><th>NO SJ</th><th>QTY SJ </th> <th>QTY SELISIH KURANG</th><th>QTY SELISIH LEBIH</th></tr></thead>"+
                                                "<tbody></tbody></table></div>"+
                                                "<div style='font-size:12px'><b>Upload:</b><br><br>"+
                                                "<table border='0' class='table table-striped' >"+
                                                "<tr><td>Nomor Surat Jalan </td><td>:</td><td><input type='text' id='nosjbaru' name='nosjbaru' readonly style='background:#20B2AA; color:white;' value='"+item+"'></td><td> FILE SJ*</td><td> :</td><td><input type='file' id='sj_upload' name='sj_upload' ></td></tr>"+
                                                "<tr><td>Nomor Surat DTB </td><td>:</td><td><input type='text' id='nodtbbaru' name='nodtbbaru' ></td><td> FILE DTB*</td><td> :</td><td><input type='file' id='dtb_upload' name='dtb_upload' ></td></tr>"+
                                                "<tr><td>Nomor Surat BPPR </td><td>:</td><td><input type='text' id='nobpprbaru' name='nobpprbaru' ></td><td> FILE BPPR*</td><td> :</td><td><input type='file' id='bppr_upload' name='bppr_upload'></td></tr>"+
                                                "<tr><td>Nomor Surat BASP </td><td>:</td><td><input type='text' id='nobaspbaru' name='nobaspbaru' ></td><td> FILE BASP*</td><td> :</td><td><input type='file' id='basp_upload' name='basp_upload'></td></tr>"+
                                                "</table><div style='color:green;'>*Format file harus .pdf dan maksimal size file 500 kb</div><input type='text' style='background:none;color:red; border:none;' size='50' id='validasi' readonly name='validasi'><input name='sj' type='hidden' value='"+value_grid+"'>"+
                                                "</span></div>";

                                                $("#contentmodalstatus").html(content); 
                                                var body2 = "";
                                                $.each(data,function(index, value){
                                                body2 ="<tr><td class='center'><select  id='pcodeedit' name='pcode[]' readonly><option value='"+data[index].PCODE+"'>"+data[index].PCODE +"-"+data[index].PCODENAME+ "</option></select></td>"+
                                                "<td class='center'><input type='text'  name='nosjedit[]' size='10px' value= "+data[index].no_sj+" readonly></td>"+
                                                "<td class='center'><input type='text'  name='qtysjedit[]' size='2px' value= "+data[index].qty+" readonly></td>"+
                                                "<td class='center'><input type='text'  name='qtyskedit[]' size='4px'  value= "+data[index].qty_selisih_kurang+"></td>"+
                                                "<td class='center'><input type='text'  name='qtysledit[]' size='4px'  value='0' ></td></tr>";
                                                $("#tbl3").find('tbody').append(body2);
                                                });

                                                $('#nosjbaru').val(data[index].no_sj);
                                                $('#nodtbbaru').val(data[index].no_dtb);
                                                $('#nobpprbaru').val(data[index].no_bppr);
                                                $('#nobaspbaru').val(data[index].no_basp);

                                   
                                    }
                                    else if($('#statussj').val()=="selisih lebih")
                                    {
                                        var content = "";
                                        content="<div class='table-wrapper-scroll-y'><table class='table table-bordered table-striped' id='tbl3' style='font-size:10.5px;'>"+
                                            "<thead><tr><th>PCODE</th><th>NO SJ</th><th>QTY SJ </th> <th>QTY SELISIH KURANG</th><th>QTY SELISIH LEBIH</th><th>SJ Tambahan</th></tr></thead>"+
                                            "<tbody></tbody></table></div><br><br><button type='button' id='tambah_selisih_lebih' class='btn btn-w-m btn-warning' style='font-size:10.5px;'>Tambah</button><br><br><br>"+
                                            "<div style='font-size:12px'><b>Upload:</b><br><br>"+
                                            "<table border='0' class='table table-striped'>"+
                                            "<tr><td>Nomor Surat Jalan </td><td>:</td><td><input type='text' id='nosjbaru' name='nosjbaru' readonly style='background:#20B2AA; color:white;' value='"+value_grid+"'></td><td> FILE SJ*</td><td> :</td><td><input type='file' id='sj_upload' name='sj_upload' ></td></tr>"+
                                            "<tr><td>Nomor Surat DTB </td><td>:</td><td><input type='text' id='nodtbbaru' name='nodtbbaru' ></td><td> FILE DTB*</td><td> :</td><td><input type='file' id='dtb_upload' name='dtb_upload' ></td></tr>"+
                                            "<tr><td>Nomor Surat DTB TAMBAHAN </td><td>:</td><td><input type='text' id='nodtb2baru' name='nodtb2baru' ></td><td> FILE DTB TAMBAHAN*</td><td> :</td><td><input type='file' id='dtb2_upload'  name='dtb2_upload' ></td></tr>"+
                                            "<tr><td>Nomor Surat BASP </td><td>:</td><td><input type='text' id='nobaspbaru' name='nobaspbaru' ></td><td> FILE BASP*</td><td> :</td><td><input type='file' id='basp_upload' name='basp_upload' ></td></tr>"+
                                            "</table><div style='color:green;'>*Format file harus .pdf dan maksimal size file 500 kb</div><input type='text' style='background:none;color:red; border:none;' size='50' id='validasi' readonly name='validasi'><input name='sj' type='hidden' value='"+value_grid+"'>"+
                                            "</span></div>";

                                            $("#contentmodalstatus").html(content); 
                                            var body2 = "";
                                            $.each(data,function(index, value){
                                            body2 = "<tr><td class='center'><select  id='pcodeedit' name='pcode[]' readonly><option value='"+data[index].PCODE+"'>"+data[index].PCODE +"-"+data[index].PCODENAME+ "</option></select></td>"+
                                            "<td class='center'><input type='text'  name='nosjedit[]' id='nosjedit' size='10px' value= "+data[index].no_sj+" readonly></td>"+
                                            "<td class='center'><input type='text'  name='qtysjedit[]' size='2px' value= "+data[index].qty+" readonly></td>"+
                                            "<td class='center'><input type='text' disabled  name='qtyskedit[]' size='4px'  value='0'></td>"+
                                            "<td class='center'><input type='text'  name='qtysledit[]' class='qtysledit' data-index='"+index+"' size='4px'  value= "+data[index].qty_selisih_lebih+" ><td class='center'><input type='text'  name='sj2[]' class='sj2"+index+"' size='10' disabled value= "+data[index].no_sj2+"></td></tr>";
                                            $("#tbl3").find('tbody').append(body2);
                                            $('.qtysledit').keyup(function(){
                                                var sj_number = $('#nosjedit').val();
                                                $('.sj2').val(sj_number+'x');
                                            });
                                            $('.qtysledit').keyup(function(){
                                                var index_edit = $(this).data('index'); 
                                                var sj_number = $('#nosjedit').val();
                                                var qty = $('.qtysledit').val();
                                                if(qty == 0) {
                                                    console.log("masukkk");
                                                    $('.sj2'+index_edit).val('0');
                                                }else{
                                                    $('.sj2'+index_edit).val(sj_number+'x');
                                                }
                                               
                                            });
                                            });
                                            
                                              $('#tambah_selisih_lebih').click(function(){
                                                body3 = "<tr><td class='center'><select data-placeholder='Pilih Pcode...' class='chosenselect'  tabindex='2' id='pcodeedit' name='pcode[]' required oninvalid=\"this.setCustomValidity('data tidak boleh kosong')\" oninput=\"setCustomValidity('')\"><option value=''>--Pilih Pcode--</option>"+
                                                <?php $nomor=0; foreach($datapcode->result() as $o){ $nomor++;?> 
                                                "<option value='<?php echo $o->PCODE;?>'><?php echo $o->PCODE;?>- <?php echo $o->PCODENAME;?></option>"+
                                                <?php } ?>"</select></td>"+
                                                "<td class='center'><input type='text'  name='nosjedit[]' value= "+item+" size='10px'  value='0' readonly></td>"+
                                                "<td class='center'><input type='text'  name='qtysjedit[]' size='2px' disabled value='0'></td>"+
                                                "<td class='center'><input type='text' disabled name='qtyskedit[]' size='4px' value='0' ></td>"+
                                                "<td class='center'><input type='text'  name='qtysledit[]' size='4px'  value='0' ><td class='center'><input type='text'  name='sj2[]' size='10' disabled value='"+item+"x'></td></tr>";
                                                $("#tbl3").find('tbody').append(body3);
                                                $('.chosenselect').chosen({width: "100%"});

                                            //});
                                            });
                                                $('#nosjbaru').val(data[index].no_sj);
                                                $('#nodtbbaru').val(data[index].no_dtb);
                                                $('#nodtb2baru').val(data[index].no_dtb2);
                                                $('#nobaspbaru').val(data[index].no_basp);

                                    }
                                    else if($('#statussj').val()=="selisih variant")
                                    {
                                        var content = "";
                                        content=" <div class='table-wrapper-scroll-y'><table class='table table-bordered table-striped' id='tbl3' style='font-size:10.5px;'>"+
                                            "<thead><tr><th>PCODE</th><th>NO SJ</th><th>QTY SJ </th> <th>QTY SELISIH KURANG</th><th>QTY SELISIH LEBIH</th><th>No. SJ Tambahan</th></tr></thead>"+
                                            "<tbody></tbody></table></div><br><br><button type='button' id='tambah_selisih_varian' class='btn btn-w-m btn-warning' style='font-size:10.5px;'>Tambah</button><br><br><br>"+
                                            "<div style='font-size:12px'><b>Upload:</b><br><br>"+
                                            "<table border='0' class='table table-striped'>"+
                                            "<tr><td>Nomor Surat Jalan </td><td>:</td><td><input type='text' name='nosjbaru' readonly  style='background:#20B2AA; color:white;' value='"+value_grid+"'></td><td> FILE SJ*</td><td> :</td><td><input type='file' id='sj_upload' name='sj_upload' ></td></tr>"+
                                            "<tr><td>Nomor Surat DTB </td><td>:</td><td><input type='text' id='nodtbbaru' name='nodtbbaru' ></td><td> FILE DTB*</td><td> :</td><td><input type='file' id='dtb_upload' name='dtb_upload' ></td></tr>"+
                                            "<tr><td>Nomor Surat DTB TAMBAHAN </td><td>:</td><td><input type='text' id='nodtb2baru'  name='nodtb2baru'></td><td> FILE DTB TAMBAHAN*</td><td> :</td><td><input type='file' id='dtb2_upload' name='dtb2_upload' ></td></tr>"+
                                            "<tr><td>Nomor Surat BPPR </td><td>:</td><td><input type='text' id='nobpprbaru'  name='nobpprbaru'></td><td> FILE BPPR*</td><td> :</td><td><input type='file' id='bppr_upload' name='bppr_upload' ></td></tr>"+
                                            "<tr><td>Nomor Surat BASP </td><td>:</td><td><input type='text' id='nobaspbaru' name='nobaspbaru'></td><td> FILE BASP*</td><td> :</td><td><input type='file' id='basp_upload' name='basp_upload' ></td></tr>"+
                                            "</table><div style='color:green;'>*Format file harus .pdf dan maksimal size file 500 kb</div><input type='text' style='background:none;color:red; border:none;' size='50' id='validasi' readonly name='validasi'><input name='sj' type='hidden' value='"+value_grid+"'>"+
                                            "</span></div>";

                                            $("#contentmodalstatus").html(content); 
                                            var body2 = "";
                                             $.each(data,function(index, value){
                                            body2 = "<tr><td class='center'><select class='chosen-select' tabindex='2'  id='pcodeedit' name='pcode[]' readonly><option value='"+data[index].PCODE+"'>"+data[index].PCODE +"-"+data[index].PCODENAME+ "</option></select></td>"+  
                                            "<td class='center'><input type='text'  name='nosjedit[]' size='10px' value= "+data[index].no_sj+" readonly></td>"+
                                            "<td class='center'><input type='text'  name='qtysjedit[]' size='2px' value= "+data[index].qty+" readonly></td>"+
                                            "<td class='center'><input type='text'  name='qtyskedit[]' size='4px' value="+data[index].qty_selisih_kurang+"  ></td>"+
                                            "<td class='center'><input type='text'  name='qtysledit[]' class='qtysledit' data-index='"+index+"' size='4px'  value="+data[index].qty_selisih_lebih+" ><td class='center'><input type='text'  name='sj2[]' class='sj2"+index+"' size='10' disabled value='"+data[index].no_sj2+"' ></td></tr>";
                                            $("#tbl3").find('tbody').append(body2);
                                            $('.qtysledit').keyup(function(){
                                                var index_edit = $(this).data('index'); 
                                                var sj_number = $('#nosjedit').val();
                                                var qty = $('.qtysledit').val();
                                                if(qty == 0) {
                                                    console.log("masukkk");
                                                    $('.sj2'+index_edit).val('0');
                                                }else{
                                                    $('.sj2'+index_edit).val(sj_number+'x');
                                                }
                                               
                                            });
                                            });

                
                                            $('#tambah_selisih_varian').click(function(){
                                                body3 = "<tr><td class='center'><select data-placeholder='Pilih Pcode...' class='chosenselect'  tabindex='2' id='pcodeedit' name='pcode[]' required oninvalid=\"this.setCustomValidity('data tidak boleh kosong')\" oninput=\"setCustomValidity('')\"><option value=''>--Pilih Pcode--</option>"+
                                                <?php $nomor=0; foreach($datapcode->result() as $o){ $nomor++;?> 
                                                "<option value='<?php echo $o->PCODE;?>'><?php echo $o->PCODE;?>- <?php echo $o->PCODENAME;?></option>"+
                                                <?php } ?>"</select></td>"+
                                                "<td class='center'><input type='text'  name='nosjedit[]' value= "+item+" size='10px'  value='0' readonly></td>"+
                                                "<td class='center'><input type='text'  name='qtysjedit[]' size='2px' disabled value='0'></td>"+
                                                "<td class='center'><input type='text'  name='qtyskedit[]' size='4px' value='0'  ></td>"+
                                                "<td class='center'><input type='text'  name='qtysledit[]' size='4px'  value='0' ></td><td><input type='text'  name='sj2[]' size='10' disabled value='"+item+"x'></td></tr>";
                                                $("#tbl3").find('tbody').append(body3);
                                                $('.chosenselect').chosen({width: "100%"});
                                            });
                                                $('#nosjbaru').val(data[index].no_sj);
                                                $('#nodtbbaru').val(data[index].no_dtb);
                                                $('#nodtb2baru').val(data[index].no_dtb2);
                                                $('#nobpprbaru') . val(data[index] . no_bppr);
                                                $('#nobaspbaru').val(data[index].no_basp);
                                    }
                                    else{
                                        content="<div style='font-size:12px'><b>Upload:</b><br><br>"+
                                            "<table class='table table table-striped'>"+
                                            "<tr><td>Nomor Surat Jalan </td><td>:</td><td><input type='text'  id='nosjbaru' name='nosjbaru' readonly style='background:#20B2AA; color:white;' value='"+value_grid+"'></td><td> FILE SJ*</td><td> :</td><td><input type='file' id='sj_upload' name='sj_upload' required oninvalid=\"this.setCustomValidity('data tidak boleh kosong')\" oninput=\"setCustomValidity('')\"></td></tr>"+
                                            "<tr><td>Nomor Surat DTB </td><td>:</td><td><input type='text' id='nodtbbaru' name='nodtbbaru' required oninvalid=\"this.setCustomValidity('data tidak boleh kosong')\" oninput=\"setCustomValidity('')\"></td><td> FILE DTB*</td><td> :</td><td><input type='file' id='dtb_upload' name='dtb_upload' required oninvalid=\"this.setCustomValidity('data tidak boleh kosong')\" oninput=\"setCustomValidity('')\"></td></tr>"+
                                            "</table><br><div style='color:green;'>*Format file harus .pdf dan maksimal size file 500 kb</div><input type='text' style='background:none;color:red; border:none;' size='50' id='validasi' readonly name='validasi'><input name='sj' type='hidden' value='"+value_grid+"'>"+
                                            "</span></div>";
                                            $("#contentmodalstatus").html(content); 
                                            $('#nosjbaru').val(data[index].no_sj);
                                            $('#nodtbbaru').val(data[index].no_dtb);
                                    }
                                    $('#nosj').val(data[index].no_sj);
                                    $('#nodtb').val(data[index].no_dtb);
                                    $('#nodtb2').val(data[index].no_dtb2);
                                    $('#nobppr').val(data[index].no_bppr);
                                    $('#nobasp').val(data[index].no_basp);
                                    $('#tgldtb1').val(data[index].tgl_inputdtb);
                                    // body =  "<tr><td class='center'><select class='chosen-select' tabindex='2'  id='pcodeedit' name='pcode[]'  readonly><option width='500%' value='"+data[index].PCODE+"'>"+data[index].PCODE +"-"+data[index].PCODENAME+ "</option></select></td>"+
                                    //         "<td class='center'><input type='text'  name='nosjedit[]' size='10px' value= "+data[index].no_sj+" readonly ></td>"+
                                    //         "<td class='center'><input type='text'  name='qtysjedit[]' size='2px' value= "+data[index].qty+" readonly ></td>"+
                                    //         "<td class='center'><input type='text'  name='qtyskedit[]' size='4px'  value= "+data[index].qty_selisih_kurang+"></td>"+
                                    //         "<td class='center'><input type='text'  name='qtysledit[]' size='4px'  value= "+data[index].qty_selisih_lebih+" ></td></tr>";
                                    // $("#tbl2").find('tbody').append(body);
                                }); 
                                        $('#tambahbaru').click(function(){
                                        body3 = "<tr><td class='center'><select class='chosen-select' tabindex='2'  id='pcodeedit' name='pcode[]'><option value='kosong'>--PILIH PCODE--</option>"+<?php $nomor=0; foreach($datapcode->result() as $o){ $nomor++;?> 
                                                "<option value='<?php echo $o->PCODE;?>'><?php echo $o->PCODE;?> - <?php echo $o->PCODENAME;?></option>"+
                                                <?php } ?>"</select></td>"+
                                                "<td class='center'><input type='text'  name='nosjedit[]' value= "+item+" size='10px'  value='0' readonly></td>"+
                                                "<td class='center'><input type='text'  name='qtysjedit[]' size='2px'  value='0'></td>"+
                                                "<td class='center'><input type='text'  name='qtyskedit[]' size='4px' value='0'  ></td>"+
                                                "<td class='center'><input type='text'  name='qtysledit[]' size='4px'  value='0' ></td></tr>";
                                                $("#tbl2").find('tbody').append(body3);
                                        });
                               
}}); 

                    if ( $(this).hasClass('selected') ) {
                        $(this).removeClass('selected');
                    }
                    else {
                        table.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }
                    } );
                
                    $('#button').click( function () {
                        table.row('.selected').remove().draw( false );
                    } );

                }
            });
            
           return false;
        });
        
        
      
      

    </script>



