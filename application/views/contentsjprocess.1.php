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
                <h2>Surat Jalan Process</h2>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url('index.php/dashboard');?>">Home</a></li>
                        <li><a>Surat Jalan</a></li>
                        <li class="active"><strong>Surat Jalan Process</strong></li>
                    </ol>
            </div>
        <!-- End Judul Content -->

<style>
.table-wrapper-scroll-y {
  display: block;
  max-height: 200px;
  overflow-y: auto;
  -ms-overflow-style: -ms-autohiding-scrollbar;
}
</style>

      

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
                        <button class="btn btn-info" type="button" data-toggle="modal"  data-target="#myModaledit" id="editbtn"><i class="fa fa-paste"></i> Edit</button>
                        <!-- End Tombol add,edit,delete -->
                    
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

                        <!-- Start Tabel -->
                        <div class="ibox-content">
                        <table id="example" class="display" style="width:100%">
                        <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Surat Jalan</th>
                                    <th>Nomor Surat Jalan</th>
                                    <th>Principal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $nomor=0; foreach ($datasj->result() as $u){ $nomor++;?>
                                <tr class="<?php if ($nomor % 2 == 0) {echo "even gradeC";} else{echo "odd gradeX";}?>">
                                    <td class="center"><?php echo $nomor;?></td>
                                    <td class="center"><?php echo $u->tgl_sj?> </td>
                                    <td class="center"><?php echo $u->no_sj?></td>
                                    <td class="center"><?php echo $u->principal?></td>
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
                                <table class="table table-bordered table-striped" id="tbl2">
                                <thead>
                                    <tr>
                                        <th>PCODE</th>
                                        <th>PCODENAME</th>
                                        <th>NO SJ</th>
                                        <th>QTY</th>
                                    </tr>
                                </thead>
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
                                <button type="button" class="btn btn-white" data-dismiss="modal" href="<?php echo base_url('dashboard/surat_jalan_proses');?>">Cancel</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>


<!-- START MODAL EDIT STATUS -->
<div class="modal inmodal" id="modalstatus" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-lg" style="width:750px;">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">SURAT JALAN TERIMA BARANG</h4>
            </div>
            <div class="modal-body" id="modalDataStatus">
            <div id="edit-nomorsj2"></div><br>
            <form method="post" enctype="multipart/form-data" action="<?php echo base_url('index.php/dashboard/updateterimabarang');?>" >
              <div id="contentmodalstatus" ></div>
              <input type="hidden" id="tgldtb2" name="tgldtb5">
              <input type="hidden" id="statussj2" name="statussj5">
              <input type="hidden" id="tglsj2" name="tglsj5">
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id='btnupload'>Upload</button>
                <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
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
    <script src="<?php echo base_url();?>assets/dashboard/js/plugins/chosen/chosen.jquery.js"></script>

    


    <!-- Page-Level Scripts -->
    <script type="text/javascript">
    $('.chosen-select').chosen({width: "100%"});
    $(document).ready(function() {
    
        document.getElementById("editbtn").disabled = true;
        var value_grid = "";
        var value_tglsj = "";
        var value_principal = "";
        var table = $('#example').DataTable();
        var item = "";
         $('#example tbody').on('click', 'tr', function() {
        item = $(this).find("td:eq(2)").text();  
        var value_tglsj= $(this).find("td:eq(1)").text();  
        var value_principal= $(this).find("td:eq(3)").text(); 
        value_grid = item;
        $('#peringatan').val('');
        $.ajax({
            url: "<?php echo base_url('index.php/dashboard/getdatasj');?>",
            type: "POST",
            data: {no_sj: item,tgl_sj: value_tglsj},
            datatype: "JSON",
            success:function(data)
            {
                $('#peringatan').val('');
                document.getElementById("update-edit_btn").disabled = true;
                $('#tgldtb1').change(function(){
                var tgl=$('#tgldtb1').val();
                // console.log(tgl);
                var tglDate = new Date(tgl);
                var valDate = new Date(value_tglsj);
               
                    if(tglDate.getYear() == valDate.getYear())
                    {
                        console.log('tahunsama');
                        if(tglDate.getMonth() == valDate.getMonth())
                        {
                            console.log('tahunsama dan bulan sama');
                                if(tglDate.getDate() == valDate.getDate())
                                {
                                    console.log('tahunsama dan bulan sama dan tanggal sama');
                                    $('#peringatan').val('');
                                    document.getElementById("update-edit_btn").disabled = false;
                                }
                                else
                                {
                                    if(valDate.getDate()>tglDate.getDate())
                                    {
                                        $('#peringatan').val('Tanggal DTB tidak boleh lebih kecil dari tanggal SJ');
                                        document.getElementById("update-edit_btn").disabled = true;
                                    }
                                    else{
                                        $('#peringatan').val('');
                                        document.getElementById("update-edit_btn").disabled = false;
                                    }
                                    console.log('tahunsama dan bulan sama dan tanggal beda');
                                }
                        }
                        else{
                             if(valDate.getMonth()>tglDate.getMonth())
                                    {
                                        $('#peringatan').val('Tanggal DTB tidak boleh lebih kecil dari tanggal SJ');
                                        document.getElementById("update-edit_btn").disabled = true;
                                    }
                                    else{
                                        $('#peringatan').val('');
                                        document.getElementById("update-edit_btn").disabled = false;
                                    }
                            console.log('tahun sama bulan beda');
                            
                        }
                       
                    }
                    else
                    { 
                        if(valDate.getYear()>tglDate.getYear())
                                    {
                                        $('#peringatan').val('Tanggal DTB tidak boleh lebih awal dari tanggal SJ');
                                        document.getElementById("update-edit_btn").disabled = true;
                                    }
                                    else{
                                        $('#peringatan').val('');
                                        document.getElementById("update-edit_btn").disabled = false;
                                    }
                        console.log('tahunbeda dan semua beda');
                      

                    }  
                });

                $('#edit-nomorsj').html("");
                $('#edit-nomorsj').append(value_grid + ", " + value_tglsj + ", " + value_principal);
                $("#tbl2").find('tbody').html("");
                
                var body = "";
                    $.each(data,function(index, value){
                        body = "<tr><td class='center'>"+data[index].PCODE+"</td>"+
                        "<td class='center' > "+data[index].PCODENAME+"</td>"+
                        "<td class='center'>"+data[index].no_sj+"</td>"+
                        "<td class='center'>"+data[index].qty+"</td></tr>";
                        $("#tbl2").find('tbody').append(body);
                       
                    }); 
                        $('#updatesuratjalan').submit(function(){
                        $('#statussj2').val('')
                        $.ajax({
                            url: "<?php echo base_url('index.php/dashboard/getstatus');?>",
                            type: "POST",
                            data: $(this).serialize(),
                            success: function (data)
                            {
                            $('.chosen-select').chosen({width: "100%"});
                            $('#tgldtb2').val($('#tgldtb1').val());
                            $('#statussj2').val(data); 
                            $('#edit-nomorsj2').html("");
                            $('#edit-nomorsj2').append(value_grid + ", " + value_tglsj + ", " + value_principal);
                                // $("#contentmodalstatus").text(data);
                                var content="";
                                if(data=="selisih kurang")
                                {
                                    $.ajax({
                                    url: "<?php echo base_url('index.php/dashboard/getdatasj');?>",
                                    type: "POST",
                                    data: {no_sj: item,tgl_sj: value_tglsj},
                                    datatype: "JSON",
                                    success:function(data)
                                    {
                                    var content = "";     
                                    content="<div class='table-wrapper-scroll-y'><table class='table table-bordered table-striped' id='tbl3' style='font-size:10.5px;'>"+
                                            "<thead><tr><th>PCODE</th><th>NO SJ</th><th>QTY SJ </th> <th>QTY SELISIH KURANG</th><th>QTY SELISIH LEBIH</th></tr></thead>"+
                                            "<tbody></tbody></table></div>"+
                                            "<div style='font-size:12px'><b>Upload:</b><br><br>"+
                                            "<table border='0' class='table table-striped' >"+
                                            "<tr><td>Nomor Surat Jalan </td><td>:</td><td><input type='text' id='nosjbaru' name='nosjbaru' readonly style='background:#20B2AA; color:white;' value='"+value_grid+"'></td><td> FILE SJ*</td><td> :</td><td><input type='file' id='sj_upload' name='sj_upload'/></td></tr>"+
                                            "<tr><td>Nomor Surat DTB </td><td>:</td><td><input type='text' id='nodtbbaru' name='nodtbbaru'></td><td> FILE DTB*</td><td> :</td><td><input type='file' id='dtb_upload' name='dtb_upload'/></td></tr>"+
                                            "<tr><td>Nomor Surat BPPR </td><td>:</td><td><input type='text' id='nobpprbaru' name='nobpprbaru'></td><td> FILE BPPR*</td><td> :</td><td><input type='file' id='bppr_upload' name='bppr_upload'/></td></tr>"+
                                            "<tr><td>Nomor Surat BASP </td><td>:</td><td><input type='text' id='nobaspbaru' name='nobaspbaru'></td><td> FILE BASP*</td><td> :</td><td><input type='file' id='basp_upload' name='basp_upload'/></td></tr>"+
                                            "</table><div style='color:green;'>*Format file harus .pdf dan maksimal size file 500 kb</div><input type='text' style='background:none;color:red; border:none;' size='50' id='validasi' readonly name='validasi'><input name='sj' type='hidden' value='"+value_grid+"'>"+
                                            "</span></div>";

                                            $("#contentmodalstatus").html(content); 
                                            var body2 = "";
                                            $.each(data,function(index, value){
                                            body2 ="<tr><td class='center'><select class='chosen-select' tabindex='2'  id='pcodeedit' name='pcode[]' readonly><option value='"+data[index].PCODE+"'>"+data[index].PCODE +"-"+data[index].PCODENAME+ "</option></select></td>"+
                                            "<td class='center'><input type='text'  name='nosjedit[]' size='10px' value= "+data[index].no_sj+" readonly></td>"+
                                            "<td class='center'><input type='text'  name='qtysjedit[]' size='2px' value= "+data[index].qty+" readonly></td>"+
                                            "<td class='center'><input type='text'  name='qtyskedit[]' size='4px'  value='0'></td>"+
                                            "<td class='center'><input type='text' disabled name='qtysledit[]' size='4px'  value='0' ></td></tr>";
                                            $("#tbl3").find('tbody').append(body2);
                                            });
                                             
                                             //VALIDASI WAJIB DIISI
                                            $('#btnupload').prop('disabled',true);
                                            $('#validasi').val('Notifikasi : Anda harus mengisi data dengan lengkap !');

                                            //validasi no dtb
                                                $('#nodtbbaru').change(function(){
                                                var nodtbbaru=document.getElementById("nodtbbaru").value;
                                                var nobpprbaru=document.getElementById("nobpprbaru").value;
                                                var nobaspbaru=document.getElementById("nobaspbaru").value;
                                                var sjupload=document.getElementById("sj_upload").value;
                                                var dtbupload=document.getElementById("dtb_upload").value;
                                                var bpprupload=document.getElementById("bppr_upload").value;
                                                var baspupload=document.getElementById("basp_upload").value;
                                               
                                                console.log(sjupload);
                                                if(nodtbbaru != "")
                                                {
                                                    if(nobpprbaru==""|| nobaspbaru=="" || sjupload == "" || dtbupload  == "" || bpprupload=="" || baspupload=="")
                                                    {
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas ! !'); 
                                                    }
                                                    else{
                                                        $('#btnupload').prop('disabled',false);
                                                        $('#validasi').val(''); 
                                                    }
                                                }
                                                else{
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas ! !');
                                                }
                                                });

                                                 //validasi no bppr
                                                $('#nobpprbaru').change(function(){
                                                var nodtbbaru=document.getElementById("nodtbbaru").value;
                                                var nobpprbaru=document.getElementById("nobpprbaru").value;
                                                var nobaspbaru=document.getElementById("nobaspbaru").value;
                                                var sjupload=document.getElementById("sj_upload").value;
                                                var dtbupload=document.getElementById("dtb_upload").value;
                                                var bpprupload=document.getElementById("bppr_upload").value;
                                                var baspupload=document.getElementById("basp_upload").value;
                                                console.log(sjupload);
                                                if(nobpprbaru != "")
                                                {
                                                    if(nodtbbaru==""|| nobaspbaru=="" || sjupload == "" || dtbupload  == "" || bpprupload=="" || baspupload=="")
                                                    {
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas  !'); 
                                                    }
                                                    else{
                                                        $('#btnupload').prop('disabled',false);
                                                        $('#validasi').val(''); 
                                                    }
                                                }
                                                else{
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas  !');
                                                }
                                                });

                                                 //validasi no basp
                                                 $('#nobaspbaru').change(function(){
                                                var nodtbbaru=document.getElementById("nodtbbaru").value;
                                                var nobpprbaru=document.getElementById("nobpprbaru").value;
                                                var nobaspbaru=document.getElementById("nobaspbaru").value;
                                                var sjupload=document.getElementById("sj_upload").value;
                                                var dtbupload=document.getElementById("dtb_upload").value;
                                                var bpprupload=document.getElementById("bppr_upload").value;
                                                var baspupload=document.getElementById("basp_upload").value;
                                                console.log(sjupload);
                                                if(nobaspbaru != "")
                                                {
                                                    if(nodtbbaru==""|| nobpprbaru=="" || sjupload == "" || dtbupload  == "" || bpprupload=="" || baspupload=="")
                                                    {
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas ! '); 
                                                    }
                                                    else{
                                                        $('#btnupload').prop('disabled',false);
                                                        $('#validasi').val(''); 
                                                    }
                                                }
                                                else{
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas !');
                                                }
                                                });

                                                
                                                
                                                //validasi SJ UPLOAD
                                                $('#sj_upload').change(function(){
                                                var nodtbbaru=document.getElementById("nodtbbaru").value;
                                                var nobpprbaru=document.getElementById("nobpprbaru").value;
                                                var nobaspbaru=document.getElementById("nobaspbaru").value;
                                                var sjupload=document.getElementById("sj_upload").value;
                                                var dtbupload=document.getElementById("dtb_upload").value;
                                                var bpprupload=document.getElementById("bppr_upload").value;
                                                var baspupload=document.getElementById("basp_upload").value;
                                                var extensi=/(\.pdf)$/i;
                                                var sizepdfsj=document.getElementById("sj_upload").files[0];
                                                var sizepdfdtb=document.getElementById("dtb_upload").files[0];
                                                var sizepdfbppr=document.getElementById("bppr_upload").files[0];
                                                var sizepdfbasp=document.getElementById("basp_upload").files[0];
                                                console.log(sjupload);
                                                if(sjupload != "")
                                                {
                                                    if(!extensi.exec(sjupload))
                                                    {  
                                                        $('#btnupload').prop('disabled',true);
                                                        $('#validasi').val('Notifikasi : Format file SJ harus pdf !'); 
                                                    }
                                                    else{
                                                        if(sizepdfsj.size>500000)
                                                            {
                                                                $('#btnupload').prop('disabled',true);
                                                                $('#validasi').val('Notifikasi : Size file SJ tidak boleh lebih dari 500 kb!'); 
                                                            }
                                                        else{
                                                                if(nobpprbaru==""|| nobaspbaru=="" ||nodtbbaru == "" || dtbupload  == "" || bpprupload=="" || baspupload=="")
                                                                {
                                                                $('#btnupload').prop('disabled',true);
                                                                $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas !'); 
                                                                }
                                                                else{
                                                                    $('#btnupload').prop('disabled',false);
                                                                    $('#validasi').val(''); 
                                                                }
                                                        }
                                                    }
                                                }
                                                else{
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas !');
                                                }
                                                });

                                                //validasi dtb upload
                                                $('#dtb_upload').change(function(){
                                                var nodtbbaru=document.getElementById("nodtbbaru").value;
                                                var nobpprbaru=document.getElementById("nobpprbaru").value;
                                                var nobaspbaru=document.getElementById("nobaspbaru").value;
                                                var sjupload=document.getElementById("sj_upload").value;
                                                var dtbupload=document.getElementById("dtb_upload").value;
                                                var bpprupload=document.getElementById("bppr_upload").value;
                                                var baspupload=document.getElementById("basp_upload").value;
                                                var extensi=/(\.pdf)$/i;
                                                var sizepdfsj=document.getElementById("sj_upload").files[0];
                                                var sizepdfdtb=document.getElementById("dtb_upload").files[0];
                                                var sizepdfbppr=document.getElementById("bppr_upload").files[0];
                                                var sizepdfbasp=document.getElementById("basp_upload").files[0];
                                                console.log(sjupload);
                                                if(dtbupload != "")
                                                {
                                                    if(!extensi.exec(dtbupload))
                                                    {  
                                                        $('#btnupload').prop('disabled',true);
                                                        $('#validasi').val('Notifikasi : Format file DTB harus pdf !'); 
                                                    }
                                                    else{
                                                        if(sizepdfdtb.size>500000 )
                                                            {
                                                                $('#btnupload').prop('disabled',true);
                                                                $('#validasi').val('Notifikasi : Size file DTB tidak boleh lebih dari 500 kb!'); 
                                                            }
                                                        else{
                                                            if(sjupload == "" ||  nobpprbaru==""|| nobaspbaru=="" || nodtbbaru  == "" || bpprupload=="" || baspupload=="")
                                                            {
                                                            $('#btnupload').prop('disabled',true);
                                                            $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas !'); 
                                                            }
                                                            else{
                                                                $('#btnupload').prop('disabled',false);
                                                                $('#validasi').val(''); 
                                                            }
                                                        }
                                                    }
                                                }
                                                else{
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas !');
                                                }
                                            });

                                              //validasi bppr upload
                                              $('#bppr_upload').change(function(){
                                                var nodtbbaru=document.getElementById("nodtbbaru").value;
                                                var nobpprbaru=document.getElementById("nobpprbaru").value;
                                                var nobaspbaru=document.getElementById("nobaspbaru").value;
                                                var sjupload=document.getElementById("sj_upload").value;
                                                var dtbupload=document.getElementById("dtb_upload").value;
                                                var bpprupload=document.getElementById("bppr_upload").value;
                                                var baspupload=document.getElementById("basp_upload").value;
                                                var extensi=/(\.pdf)$/i;
                                                var sizepdfsj=document.getElementById("sj_upload").files[0];
                                                var sizepdfdtb=document.getElementById("dtb_upload").files[0];
                                                var sizepdfbppr=document.getElementById("bppr_upload").files[0];
                                                var sizepdfbasp=document.getElementById("basp_upload").files[0];
                                                console.log(sjupload);
                                                if(bpprupload != "")
                                                {
                                                    if(!extensi.exec(bpprupload))
                                                    {  
                                                        $('#btnupload').prop('disabled',true);
                                                        $('#validasi').val('Notifikasi : Format file BPPR harus pdf !'); 
                                                    }
                                                    else{
                                                        if(sizepdfbppr.size>500000 )
                                                            {
                                                                $('#btnupload').prop('disabled',true);
                                                                $('#validasi').val('Notifikasi : Size file BPPR tidak boleh lebih dari 500 kb!'); 
                                                            }
                                                        else{
                                                                if(sjupload == "" ||  nobpprbaru==""|| nobaspbaru=="" || nodtbbaru  == "" || dtbupload=="" || baspupload=="")
                                                                {
                                                                $('#btnupload').prop('disabled',true);
                                                                $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas !'); 
                                                                }
                                                                else{
                                                                    $('#btnupload').prop('disabled',false);
                                                                    $('#validasi').val(''); 
                                                                }
                                                        }
                                                    }
                                                }
                                                else{
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi :Mohon untuk melengkapi data form diatas !');
                                                }
                                            });

                                              //validasi basp upload
                                              $('#basp_upload').change(function(){
                                                var nodtbbaru=document.getElementById("nodtbbaru").value;
                                                var nobpprbaru=document.getElementById("nobpprbaru").value;
                                                var nobaspbaru=document.getElementById("nobaspbaru").value;
                                                var sjupload=document.getElementById("sj_upload").value;
                                                var dtbupload=document.getElementById("dtb_upload").value;
                                                var bpprupload=document.getElementById("bppr_upload").value;
                                                var baspupload=document.getElementById("basp_upload").value;
                                                var extensi=/(\.pdf)$/i;
                                                var sizepdfsj=document.getElementById("sj_upload").files[0];
                                                var sizepdfdtb=document.getElementById("dtb_upload").files[0];
                                                var sizepdfbppr=document.getElementById("bppr_upload").files[0];
                                                var sizepdfbasp=document.getElementById("basp_upload").files[0];
                                                console.log(sjupload);
                                                if(baspupload != "")
                                                {
                                                    if(!extensi.exec(baspupload))
                                                    {  
                                                        $('#btnupload').prop('disabled',true);
                                                        $('#validasi').val('Notifikasi : Format file BASP harus pdf !'); 
                                                    }
                                                    else{
                                                        if(sizepdfbasp.size>500000 )
                                                            {
                                                                $('#btnupload').prop('disabled',true);
                                                                $('#validasi').val('Notifikasi : Size file BASP tidak boleh lebih dari 500 kb!'); 
                                                            }
                                                        else{
                                                            if(sjupload == "" ||  nobpprbaru==""|| nobaspbaru=="" || nodtbbaru  == "" || dtbupload=="" || bpprupload=="")
                                                            {
                                                            $('#btnupload').prop('disabled',true);
                                                            $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas !'); 
                                                            }
                                                            else{
                                                                $('#btnupload').prop('disabled',false);
                                                                $('#validasi').val(''); 
                                                            }
                                                        }
                                                    }
                                                }
                                                else{
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas !');
                                                }
                                            });

                                        }

                                    });
                                     
                                                              
                                }
                                else if(data=="selisih lebih")
                                {
                                    $.ajax({
                                    url: "<?php echo base_url('index.php/dashboard/getdatasj');?>",
                                    type: "POST",
                                    data: {no_sj: item ,tgl_sj: value_tglsj},
                                    datatype: "JSON",
                                    success:function(data)
                                    {
                                        $('.chosen-select').chosen({width: "100%"});
                                        var content = "";
                                        content="<div class='table-wrapper-scroll-y'><table class='table table-bordered table-striped' id='tbl3' style='font-size:10.5px;'>"+
                                            "<thead><tr><th>PCODE</th><th>NO SJ</th><th>QTY SJ </th> <th>QTY SELISIH KURANG</th><th>QTY SELISIH LEBIH</th></tr></thead>"+
                                            "<tbody></tbody></table></div><button type='button' id='tambah_selisih_lebih' class='btn btn-w-m btn-warning' style='font-size:10.5px;'>Tambah</button><br>"+
                                            "<div style='font-size:12px'><b>Upload:</b><br><br>"+
                                            "<table border='0' class='table table-striped'>"+
                                            "<tr><td>Nomor Surat Jalan </td><td>:</td><td><input type='text' id='nosjbaru' name='nosjbaru' readonly style='background:#20B2AA; color:white;' value='"+value_grid+"'></td><td> FILE SJ*</td><td> :</td><td><input type='file' id='sj_upload' name='sj_upload'></td></tr>"+
                                            "<tr><td>Nomor Surat DTB </td><td>:</td><td><input type='text' id='nodtbbaru' name='nodtbbaru'></td><td> FILE DTB*</td><td> :</td><td><input type='file' id='dtb_upload' name='dtb_upload'></td></tr>"+
                                            "<tr><td>Nomor Surat DTB BARU </td><td>:</td><td><input type='text' id='nodtb2baru' name='nodtb2baru'></td><td> FILE DTB TAMBAHAN*</td><td> :</td><td><input type='file' id='dtb2_upload'  name='dtb2_upload'></td></tr>"+
                                            "<tr><td>Nomor Surat BASP </td><td>:</td><td><input type='text' id='nobaspbaru' name='nobaspbaru'></td><td> FILE BASP*</td><td> :</td><td><input type='file' id='basp_upload' name='basp_upload'></td></tr>"+
                                            "</table><div style='color:green;'>*Format file harus .pdf dan maksimal size file 500 kb</div><input type='text' style='background:none;color:red; border:none;' size='50' id='validasi' readonly name='validasi'><input name='sj' type='hidden' value='"+value_grid+"'>"+
                                            "</span></div>";

                                            $("#contentmodalstatus").html(content); 
                                            var body2 = "";
                                            $.each(data,function(index, value){
                                            body2 = "<tr><td class='center'><select  id='pcodeedit' name='pcode[]' readonly><option value='"+data[index].PCODE+"'>"+data[index].PCODE +"-"+data[index].PCODENAME+ "</option></select></td>"+
                                            "<td class='center'><input type='text'  name='nosjedit[]' size='10px' value= "+data[index].no_sj+" readonly></td>"+
                                            "<td class='center'><input type='text'  name='qtysjedit[]' size='2px' value= "+data[index].qty+" readonly></td>"+
                                            "<td class='center'><input type='text' disabled  name='qtyskedit[]' size='4px'  value='0' ></td>"+
                                            "<td class='center'><input type='text'  name='qtysledit[]' size='4px'  value='0' ></td></tr>";
                                            $("#tbl3").find('tbody').append(body2);
                                            });

                                              $('#tambah_selisih_lebih').click(function(){
                                                body3 = "<tr><td class='center'><select id='pcodeedit' name='pcode[]' class='selectpicker' data-live-search='true'>"+
                                                <?php $nomor=0; foreach($datapcode->result() as $o){ $nomor++;?> 
                                                "<option ><?php echo $o->PCODE;?>- <?php echo $o->PCODENAME;?></option>"+
                                                <?php } ?>"</select></td>"+
                                                "<td class='center'><input type='text'  name='nosjedit[]' value= "+item+" size='10px'  value='0' readonly></td>"+
                                                "<td class='center'><input type='text'  name='qtysjedit[]' size='2px' disabled value='0'></td>"+
                                                "<td class='center'><input type='text' disabled name='qtyskedit[]' size='4px' value='0' ></td>"+
                                                "<td class='center'><input type='text'  name='qtysledit[]' size='4px'  value='0' ></td></tr>";
                                                $("#tbl3").find('tbody').append(body3);
                                            });
                                             //VALIDASI WAJIB DIISI
                                            $('#btnupload').prop('disabled',true);
                                            $('#validasi').val('Notifikasi : Anda harus mengisi data dengan lengkap !');

                                            //validasi no dtb
                                                $('#nodtbbaru').change(function(){
                                                var nodtbbaru=document.getElementById("nodtbbaru").value;
                                                var nodtb2baru=document.getElementById("nodtb2baru").value;
                                                var nobaspbaru=document.getElementById("nobaspbaru").value;
                                                var sjupload=document.getElementById("sj_upload").value;
                                                var dtbupload=document.getElementById("dtb_upload").value;
                                                var dtb2upload=document.getElementById("dtb2_upload").value;
                                                var baspupload=document.getElementById("basp_upload").value;
                                                console.log(sjupload);
                                                if(nodtbbaru != "")
                                                {
                                                    if(nodtb2baru==""|| nobaspbaru=="" || sjupload == "" || dtbupload  == "" || dtb2upload=="" || baspupload=="")
                                                    {
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas  !'); 
                                                    }
                                                    else{
                                                        $('#btnupload').prop('disabled',false);
                                                        $('#validasi').val(''); 
                                                    }
                                                }
                                                else{
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas  !');
                                                }
                                                });

                                                 //validasi no bppr
                                                $('#nodtb2baru').change(function(){
                                                var nodtbbaru=document.getElementById("nodtbbaru").value;
                                                var nodtb2baru=document.getElementById("nodtb2baru").value;
                                                var nobaspbaru=document.getElementById("nobaspbaru").value;
                                                var sjupload=document.getElementById("sj_upload").value;
                                                var dtbupload=document.getElementById("dtb_upload").value;
                                                var dtb2upload=document.getElementById("dtb2_upload").value;
                                                var baspupload=document.getElementById("basp_upload").value;
                                                console.log(sjupload);
                                                if(nodtb2baru != "")
                                                {
                                                    if(nodtbbaru==""|| nobaspbaru=="" || sjupload == "" || dtbupload  == "" || dtb2upload=="" || baspupload=="")
                                                    {
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas  !'); 
                                                    }
                                                    else{
                                                        $('#btnupload').prop('disabled',false);
                                                        $('#validasi').val(''); 
                                                    }
                                                }
                                                else{
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas  !');
                                                }
                                                });

                                                 //validasi no basp
                                                $('#nobaspbaru').change(function(){
                                                var nodtbbaru=document.getElementById("nodtbbaru").value;
                                                var nodtb2baru=document.getElementById("nodtb2baru").value;
                                                var nobaspbaru=document.getElementById("nobaspbaru").value;
                                                var sjupload=document.getElementById("sj_upload").value;
                                                var dtbupload=document.getElementById("dtb_upload").value;
                                                var dtb2upload=document.getElementById("dtb2_upload").value;
                                                var baspupload=document.getElementById("basp_upload").value;
                                                console.log(sjupload);
                                                if(nobaspbaru != "")
                                                {
                                                    if(nodtbbaru==""|| nodtb2baru=="" || sjupload == "" || dtbupload  == "" || dtb2upload=="" || baspupload=="")
                                                    {
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas  !'); 
                                                    }
                                                    else{
                                                        $('#btnupload').prop('disabled',false);
                                                        $('#validasi').val(''); 
                                                    }
                                                }
                                                else{
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas  !');
                                                }
                                                });

                                                //validasi SJ UPLOAD
                                                $('#sj_upload').change(function(){
                                                var nodtbbaru=document.getElementById("nodtbbaru").value;
                                                var nodtb2baru=document.getElementById("nodtb2baru").value;
                                                var nobaspbaru=document.getElementById("nobaspbaru").value;
                                                var sjupload=document.getElementById("sj_upload").value;
                                                var dtbupload=document.getElementById("dtb_upload").value;
                                                var dtb2upload=document.getElementById("dtb2_upload").value;
                                                var baspupload=document.getElementById("basp_upload").value;
                                                var extensi=/(\.pdf)$/i;
                                                var sizepdfsj=document.getElementById("sj_upload").files[0];
                                                var sizepdfdtb=document.getElementById("dtb_upload").files[0];
                                                var sizepdfdb2=document.getElementById("dtb2_upload").files[0];
                                                var sizepdfbasp=document.getElementById("basp_upload").files[0];
                                                console.log(sjupload);
                                                if(sjupload != "")
                                                {
                                                    if(!extensi.exec(sjupload))
                                                    {  
                                                        $('#btnupload').prop('disabled',true);
                                                        $('#validasi').val('Notifikasi : Format file SJ harus pdf !'); 
                                                    }
                                                    else{
                                                        if(sizepdfsj.size>500000 )
                                                            {
                                                                $('#btnupload').prop('disabled',true);
                                                                $('#validasi').val('Notifikasi : Size file SJ tidak boleh lebih dari 500 kb!'); 
                                                            }
                                                        else{
                                                                if(nodtb2baru==""|| nobaspbaru=="" ||nodtbbaru == "" || dtbupload  == "" || dtb2upload=="" || baspupload=="")
                                                                {
                                                                $('#btnupload').prop('disabled',true);
                                                                $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas  !'); 
                                                                }
                                                                else{
                                                                    $('#btnupload').prop('disabled',false);
                                                                    $('#validasi').val(''); 
                                                                }
                                                        }
                                                    }
                                                }
                                                else{
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas  !');
                                                }
                                                });

                                                //validasi dtb upload
                                                $('#dtb_upload').change(function(){
                                                var nodtbbaru=document.getElementById("nodtbbaru").value;
                                                var nodtb2baru=document.getElementById("nodtb2baru").value;
                                                var nobaspbaru=document.getElementById("nobaspbaru").value;
                                                var sjupload=document.getElementById("sj_upload").value;
                                                var dtbupload=document.getElementById("dtb_upload").value;
                                                var dtb2upload=document.getElementById("dtb2_upload").value;
                                                var baspupload=document.getElementById("basp_upload").value;
                                                var extensi=/(\.pdf)$/i;
                                                var sizepdfsj=document.getElementById("sj_upload").files[0];
                                                var sizepdfdtb=document.getElementById("dtb_upload").files[0];
                                                var sizepdfdb2=document.getElementById("dtb2_upload").files[0];
                                                var sizepdfbasp=document.getElementById("basp_upload").files[0];
                                                console.log(sjupload);
                                                if(dtbupload != "")
                                                {
                                                    if(!extensi.exec(dtbupload))
                                                    {  
                                                        $('#btnupload').prop('disabled',true);
                                                        $('#validasi').val('Notifikasi : Format file DTB harus pdf !'); 
                                                    }
                                                    else{
                                                        if(sizepdfdtb.size>500000 )
                                                            {
                                                                $('#btnupload').prop('disabled',true);
                                                                $('#validasi').val('Notifikasi : Size file DTB tidak boleh lebih dari 500 kb!'); 
                                                            }
                                                        else{
                                                            if(sjupload == "" ||  nodtb2baru==""|| nobaspbaru=="" || nodtbbaru  == "" || dtb2upload=="" || baspupload=="")
                                                            {
                                                            $('#btnupload').prop('disabled',true);
                                                            $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas  !'); 
                                                            }
                                                            else{
                                                                $('#btnupload').prop('disabled',false);
                                                                $('#validasi').val(''); 
                                                            }
                                                        }
                                                    }
                                                }
                                                else{
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas  !');
                                                }
                                            });

                                              //validasi bppr upload
                                              $('#dtb2_upload').change(function(){
                                                var nodtbbaru=document.getElementById("nodtbbaru").value;
                                                var nodtb2baru=document.getElementById("nodtb2baru").value;
                                                var nobaspbaru=document.getElementById("nobaspbaru").value;
                                                var sjupload=document.getElementById("sj_upload").value;
                                                var dtbupload=document.getElementById("dtb_upload").value;
                                                var dtb2upload=document.getElementById("dtb2_upload").value;
                                                var baspupload=document.getElementById("basp_upload").value;
                                                var extensi=/(\.pdf)$/i;
                                                var sizepdfsj=document.getElementById("sj_upload").files[0];
                                                var sizepdfdtb=document.getElementById("dtb_upload").files[0];
                                                var sizepdfdb2=document.getElementById("dtb2_upload").files[0];
                                                var sizepdfbasp=document.getElementById("basp_upload").files[0];
                                                console.log(sjupload);
                                                if(dtb2upload != "")
                                                {
                                                    if(!extensi.exec(dtb2upload))
                                                    {  
                                                        $('#btnupload').prop('disabled',true);
                                                        $('#validasi').val('Notifikasi : Format file DTB Tambahan harus pdf !'); 
                                                    }
                                                    else{
                                                        if(sizepdfdtb2.size>500000 )
                                                            {
                                                                $('#btnupload').prop('disabled',true);
                                                                $('#validasi').val('Notifikasi : Size file DTB tambahan tidak boleh lebih dari 500 kb!'); 
                                                            }
                                                        else{
                                                            if(sjupload == "" ||  nodtb2baru==""|| nobaspbaru=="" || nodtbbaru  == "" || dtbupload=="" || baspupload=="")
                                                            {
                                                            $('#btnupload').prop('disabled',true);
                                                            $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas  !'); 
                                                            }
                                                            else{
                                                                $('#btnupload').prop('disabled',false);
                                                                $('#validasi').val(''); 
                                                            }
                                                        }
                                                    }    
                                                }
                                                else{
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas  !');
                                                }
                                            });

                                              //validasi basp upload
                                              $('#basp_upload').change(function(){
                                                var nodtbbaru=document.getElementById("nodtbbaru").value;
                                                var nodtb2baru=document.getElementById("nodtb2baru").value;
                                                var nobaspbaru=document.getElementById("nobaspbaru").value;
                                                var sjupload=document.getElementById("sj_upload").value;
                                                var dtbupload=document.getElementById("dtb_upload").value;
                                                var dtb2upload=document.getElementById("dtb2_upload").value;
                                                var baspupload=document.getElementById("basp_upload").value;
                                                var extensi=/(\.pdf)$/i;
                                                var sizepdfsj=document.getElementById("sj_upload").files[0];
                                                var sizepdfdtb=document.getElementById("dtb_upload").files[0];
                                                var sizepdfdb2=document.getElementById("dtb2_upload").files[0];
                                                var sizepdfbasp=document.getElementById("basp_upload").files[0];
                                                console.log(sjupload);
                                                if(baspupload != "")
                                                {
                                                    if(!extensi.exec(baspupload))
                                                    {  
                                                        $('#btnupload').prop('disabled',true);
                                                        $('#validasi').val('Notifikasi : Format file BASP harus pdf !'); 
                                                    }
                                                    else{
                                                        if(sizepdfbasp.size>500000 )
                                                            {
                                                                $('#btnupload').prop('disabled',true);
                                                                $('#validasi').val('Notifikasi : Size file BASP tidak boleh lebih dari 500 kb!'); 
                                                            }
                                                        else{
                                                            if(sjupload == "" ||  nodtb2baru==""|| nobaspbaru=="" || nodtbbaru  == "" || dtbupload=="" || dtb2upload=="")
                                                            {
                                                            $('#btnupload').prop('disabled',true);
                                                            $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas  !'); 
                                                            }
                                                            else{
                                                                $('#btnupload').prop('disabled',false);
                                                                $('#validasi').val(''); 
                                                            }
                                                        }
                                                    }
                                                }
                                                else{
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas  !');
                                                }
                                            });

                                        }
                                    });
                                }
                                else if(data=="selisih variant")
                                {
                                    $.ajax({
                                    url: "<?php echo base_url('index.php/dashboard/getdatasj');?>",
                                    type: "POST",
                                    data: {no_sj: item ,tgl_sj: value_tglsj},
                                    datatype: "JSON",
                                    success:function(data)
                                    {
                                        $('.chosen-select').chosen({width: "100%"});
                                        var content = "";
                                        content=" <div class='table-wrapper-scroll-y'><table class='table table-bordered table-striped' id='tbl3' style='font-size:10.5px;'>"+
                                            "<thead><tr><th>PCODE</th><th>NO SJ</th><th>QTY SJ </th> <th>QTY SELISIH KURANG</th><th>QTY SELISIH LEBIH</th></tr></thead>"+
                                            "<tbody></tbody></table></div><button type='button' id='tambah_selisih_varian' class='btn btn-w-m btn-warning' style='font-size:10.5px;'>Tambah</button><br>"+
                                            "<div style='font-size:12px'><b>Upload:</b><br><br>"+
                                            "<table border='0' class='table table-striped'>"+
                                            "<tr><td>Nomor Surat Jalan </td><td>:</td><td><input type='text' name='nosjbaru' readonly style='background:#20B2AA; color:white;' value='"+value_grid+"'></td><td> FILE SJ*</td><td> :</td><td><input type='file' id='sj_upload' name='sj_upload'/></td></tr>"+
                                            "<tr><td>Nomor Surat DTB </td><td>:</td><td><input type='text' id='nodtbbaru' name='nodtbbaru' required></td><td> FILE DTB*</td><td> :</td><td><input type='file' id='dtb_upload' name='dtb_upload' required/></td></tr>"+
                                            "<tr><td>Nomor Surat DTB BARU </td><td>:</td><td><input type='text' id='nodtb2baru' name='nodtb2baru'></td><td> FILE DTB TAMBAHAN*</td><td> :</td><td><input type='file' id='dtb2_upload' name='dtb2_upload'/></td></tr>"+
                                            "<tr><td>Nomor Surat BPPR </td><td>:</td><td><input type='text' id='nobpprbaru' name='nobpprbaru'></td><td> FILE BPPR*</td><td> :</td><td><input type='file' id='bppr_upload' name='bppr_upload'/></td></tr>"+
                                            "<tr><td>Nomor Surat BASP </td><td>:</td><td><input type='text' id='nobaspbaru' name='nobaspbaru'></td><td> FILE BASP*</td><td> :</td><td><input type='file' id='basp_upload' name='basp_upload'/></td></tr>"+
                                            "</table><div style='color:green;'>*Format file harus .pdf dan maksimal size file 500 kb</div><input type='text' style='background:none;color:red; border:none;' size='50' id='validasi' readonly name='validasi'><input name='sj' type='hidden' value='"+value_grid+"'>"+
                                            "</span></div>";

                                            $("#contentmodalstatus").html(content); 
                                            var body2 = "";
                                             $.each(data,function(index, value){
                                            body2 = "<tr><td class='center'><select class='chosen-select' tabindex='2'  id='pcodeedit' name='pcode[]' readonly><option value='"+data[index].PCODE+"'>"+data[index].PCODE +"-"+data[index].PCODENAME+ "</option></select></td>"+  
                                            "<td class='center'><input type='text'  name='nosjedit[]' size='10px' value= "+data[index].no_sj+" readonly></td>"+
                                            "<td class='center'><input type='text'  name='qtysjedit[]' size='2px' value= "+data[index].qty+" readonly></td>"+
                                            "<td class='center'><input type='text'  name='qtyskedit[]' size='4px' value='0'  ></td>"+
                                            "<td class='center'><input type='text'  name='qtysledit[]' size='4px'  value='0' ></td></tr>";
                                            $("#tbl3").find('tbody').append(body2);
                                            });

                
                                            $('#tambah_selisih_varian').click(function(){
                                            body3 = "<tr><td class='center'><input list='pcodelist' id='pcodeedit' name='pcode[]' width='200px'><datalist id='pcodelist'>"+
                                                <?php $nomor=0; foreach($datapcode->result() as $o){ $nomor++;?> 
                                                "<option><?php echo $o->PCODE;?>- <?php echo $o->PCODENAME;?></option>"+
                                                <?php } ?>"</datalist></td>"+
                                                "<td class='center'><input type='text'  name='nosjedit[]' value= "+item+" size='10px'  value='0' readonly></td>"+
                                                "<td class='center'><input type='text'  name='qtysjedit[]' size='2px' disabled value='0'></td>"+
                                                "<td class='center'><input type='text'  name='qtyskedit[]' size='4px' value='0'  ></td>"+
                                                "<td class='center'><input type='text'  name='qtysledit[]' size='4px'  value='0' ></td></tr>";
                                                $("#tbl3").find('tbody').append(body3);
                                            });
                                             //VALIDASI WAJIB DIISI
                                             $('#btnupload').prop('disabled',true);
                                            $('#validasi').val('Notifikasi : Anda harus mengisi data dengan lengkap !');

                                            //validasi no dtb
                                                $('#nodtbbaru').change(function(){
                                                var nodtbbaru=document.getElementById("nodtbbaru").value;
                                                var nodtb2baru=document.getElementById("nodtb2baru").value;
                                                var nobpprbaru=document.getElementById("nobpprbaru").value;
                                                var nobaspbaru=document.getElementById("nobaspbaru").value;
                                                var sjupload=document.getElementById("sj_upload").value;
                                                var dtbupload=document.getElementById("dtb_upload").value;
                                                var bpprupload=document.getElementById("bppr_upload").value;
                                                var dtb2upload=document.getElementById("dtb2_upload").value;
                                                var baspupload=document.getElementById("basp_upload").value;
                                                console.log(sjupload);
                                                if(nodtbbaru != "")
                                                {
                                                    if(nodtb2baru==""|| nobaspbaru=="" || sjupload == "" || dtbupload  == "" || dtb2upload=="" || baspupload=="" ||nobpprbaru=="" || bpprupload=="")
                                                    {
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Anda harus mengisi data dengan lengkap !'); 
                                                    }
                                                    else{
                                                        $('#btnupload').prop('disabled',false);
                                                        $('#validasi').val(''); 
                                                    }
                                                }
                                                else{
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Anda harus mengisi data dengan lengkap !');
                                                }
                                                });

                                                 //validasi no bppr
                                                $('#nodtb2baru').change(function(){
                                                var nodtbbaru=document.getElementById("nodtbbaru").value;
                                                var nodtb2baru=document.getElementById("nodtb2baru").value;
                                                var nobpprbaru=document.getElementById("nobpprbaru").value;
                                                var nobaspbaru=document.getElementById("nobaspbaru").value;
                                                var sjupload=document.getElementById("sj_upload").value;
                                                var dtbupload=document.getElementById("dtb_upload").value;
                                                var bpprupload=document.getElementById("bppr_upload").value;
                                                var dtb2upload=document.getElementById("dtb2_upload").value;
                                                var baspupload=document.getElementById("basp_upload").value;
                                                console.log(sjupload);
                                                if(nodtb2baru != "")
                                                {
                                                    if(nodtbbaru==""|| nobaspbaru=="" || sjupload == "" || dtbupload  == "" || dtb2upload=="" || baspupload==""|| nobpprbaru=="" || bpprupload=="")
                                                    {
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Anda harus mengisi data dengan lengkap !'); 
                                                    }
                                                    else{
                                                        $('#btnupload').prop('disabled',false);
                                                        $('#validasi').val(''); 
                                                    }
                                                }
                                                else{
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Anda harus mengisi data dengan lengkap !');
                                                }
                                                });

                                                 //validasi no basp
                                                 $('#nobaspbaru').change(function(){
                                                var nodtbbaru=document.getElementById("nodtbbaru").value;
                                                var nodtb2baru=document.getElementById("nodtb2baru").value;
                                                var nobpprbaru=document.getElementById("nobpprbaru").value;
                                                var nobaspbaru=document.getElementById("nobaspbaru").value;
                                                var sjupload=document.getElementById("sj_upload").value;
                                                var dtbupload=document.getElementById("dtb_upload").value;
                                                var bpprupload=document.getElementById("bppr_upload").value;
                                                var dtb2upload=document.getElementById("dtb2_upload").value;
                                                var baspupload=document.getElementById("basp_upload").value;
                                                console.log(sjupload);
                                                if(nobaspbaru != "")
                                                {
                                                    if(nodtbbaru==""|| nodtb2baru=="" || sjupload == "" || dtbupload  == "" || dtb2upload=="" || baspupload=="" || nobpprbaru=="" || bpprupload=="")
                                                    {
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Anda harus mengisi data dengan lengkap !'); 
                                                    }
                                                    else{
                                                        $('#btnupload').prop('disabled',false);
                                                        $('#validasi').val(''); 
                                                    }
                                                }
                                                else{
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Anda harus mengisi data dengan lengkap !');
                                                }
                                                });

                                                
                                                
                                                //validasi SJ UPLOAD
                                                $('#sj_upload').change(function(){
                                                var nodtbbaru=document.getElementById("nodtbbaru").value;
                                                var nodtb2baru=document.getElementById("nodtb2baru").value;
                                                var nobpprbaru=document.getElementById("nobpprbaru").value;
                                                var nobaspbaru=document.getElementById("nobaspbaru").value;
                                                var sjupload=document.getElementById("sj_upload").value;
                                                var dtbupload=document.getElementById("dtb_upload").value;
                                                var bpprupload=document.getElementById("bppr_upload").value;
                                                var dtb2upload=document.getElementById("dtb2_upload").value;
                                                var baspupload=document.getElementById("basp_upload").value;
                                                var extensi=/(\.pdf)$/i;
                                                var sizepdfsj=document.getElementById("sj_upload").files[0];
                                                var sizepdfdtb=document.getElementById("dtb_upload").files[0];
                                                var sizepdfdtb2=document.getElementById("dtb2_upload").files[0];
                                                var sizepdfbppr=document.getElementById("bppr_upload").files[0];
                                                var sizepdfbasp=document.getElementById("basp_upload").files[0];
                                                console.log(sjupload);
                                                if(sjupload != "")
                                                {
                                                    if(!extensi.exec(sjupload))
                                                    {  
                                                        $('#btnupload').prop('disabled',true);
                                                        $('#validasi').val('Notifikasi : Format file SJ harus pdf !'); 
                                                    }
                                                    else{
                                                        if(sizepdfsj.size>500000 )
                                                            {
                                                                $('#btnupload').prop('disabled',true);
                                                                $('#validasi').val('Notifikasi : Size file SJ tidak boleh lebih dari 500 kb!'); 
                                                            }
                                                        else{
                                                                if(nodtb2baru==""|| nobaspbaru=="" ||nodtbbaru == "" || dtbupload  == "" || dtb2upload=="" || baspupload=="" || nobpprbaru=="" || bpprupload=="")
                                                                {
                                                                $('#btnupload').prop('disabled',true);
                                                                $('#validasi').val('Notifikasi : Anda harus mengisi data dengan lengkap !'); 
                                                                }
                                                                else{
                                                                    $('#btnupload').prop('disabled',false);
                                                                    $('#validasi').val(''); 
                                                                }
                                                        }
                                                    }
                                                }
                                                else{
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Anda harus mengisi data dengan lengkap !');
                                                }
                                                });

                                                //validasi dtb upload
                                                $('#dtb_upload').change(function(){
                                                var nodtbbaru=document.getElementById("nodtbbaru").value;
                                                var nodtb2baru=document.getElementById("nodtb2baru").value;
                                                var nobpprbaru=document.getElementById("nobpprbaru").value;
                                                var nobaspbaru=document.getElementById("nobaspbaru").value;
                                                var sjupload=document.getElementById("sj_upload").value;
                                                var dtbupload=document.getElementById("dtb_upload").value;
                                                var bpprupload=document.getElementById("bppr_upload").value;
                                                var dtb2upload=document.getElementById("dtb2_upload").value;
                                                var baspupload=document.getElementById("basp_upload").value;
                                                var extensi=/(\.pdf)$/i;
                                                var sizepdfsj=document.getElementById("sj_upload").files[0];
                                                var sizepdfdtb=document.getElementById("dtb_upload").files[0];
                                                var sizepdfdtb2=document.getElementById("dtb2_upload").files[0];
                                                var sizepdfbppr=document.getElementById("bppr_upload").files[0];
                                                var sizepdfbasp=document.getElementById("basp_upload").files[0];
                                                console.log(sjupload);
                                                if(dtbupload != "")
                                                {
                                                    if(!extensi.exec(dtbupload))
                                                    {  
                                                        $('#btnupload').prop('disabled',true);
                                                        $('#validasi').val('Notifikasi : Format file DTB harus pdf !'); 
                                                    }
                                                    else{
                                                        if(sizepdfdtb.size>500000 )
                                                            {
                                                                $('#btnupload').prop('disabled',true);
                                                                $('#validasi').val('Notifikasi : Size file DTB tidak boleh lebih dari 500 kb!'); 
                                                            }
                                                        else{
                                                            if(sjupload == "" ||  nodtb2baru==""|| nobaspbaru=="" || nodtbbaru  == "" || dtb2upload=="" || baspupload=="" || nobpprbaru=="" || bpprupload=="")
                                                            {
                                                            $('#btnupload').prop('disabled',true);
                                                            $('#validasi').val('Notifikasi : Anda harus mengisi data dengan lengkap !'); 
                                                            }
                                                            else{
                                                                $('#btnupload').prop('disabled',false);
                                                                $('#validasi').val(''); 
                                                            }
                                                        }
                                                    }
                                                }
                                                else{
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Anda harus mengisi data dengan lengkap !');
                                                }
                                            });

                                              //validasi dtb2 upload
                                              $('#dtb2_upload').change(function(){
                                                var nodtbbaru=document.getElementById("nodtbbaru").value;
                                                var nodtb2baru=document.getElementById("nodtb2baru").value;
                                                var nobpprbaru=document.getElementById("nobpprbaru").value;
                                                var nobaspbaru=document.getElementById("nobaspbaru").value;
                                                var sjupload=document.getElementById("sj_upload").value;
                                                var dtbupload=document.getElementById("dtb_upload").value;
                                                var bpprupload=document.getElementById("bppr_upload").value;
                                                var dtb2upload=document.getElementById("dtb2_upload").value;
                                                var baspupload=document.getElementById("basp_upload").value;
                                                var extensi=/(\.pdf)$/i;
                                                var sizepdfsj=document.getElementById("sj_upload").files[0];
                                                var sizepdfdtb=document.getElementById("dtb_upload").files[0];
                                                var sizepdfdtb2=document.getElementById("dtb2_upload").files[0];
                                                var sizepdfbppr=document.getElementById("bppr_upload").files[0];
                                                var sizepdfbasp=document.getElementById("basp_upload").files[0];
                                                console.log(sjupload);
                                                if(dtb2upload != "")
                                                {
                                                    if(!extensi.exec(dtb2upload))
                                                    {  
                                                        $('#btnupload').prop('disabled',true);
                                                        $('#validasi').val('Notifikasi : Format file DTB tambahan harus pdf !'); 
                                                    }
                                                    else{
                                                        if(sizepdfdtb2.size>500000 )
                                                            {
                                                                $('#btnupload').prop('disabled',true);
                                                                $('#validasi').val('Notifikasi : Size file DTB tambahan tidak boleh lebih dari 500 kb!'); 
                                                            }
                                                        else{
                                                            if(sjupload == "" ||  nodtb2baru==""|| nobaspbaru=="" || nodtbbaru  == "" || dtbupload=="" || baspupload=="" || nobpprbaru=="" || bpprupload=="")
                                                            {
                                                            $('#btnupload').prop('disabled',true);
                                                            $('#validasi').val('Notifikasi : Anda harus mengisi data dengan lengkap !'); 
                                                            }
                                                            else{
                                                                $('#btnupload').prop('disabled',false);
                                                                $('#validasi').val(''); 
                                                            }
                                                        }
                                                    }
                                                }
                                                else{
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Anda harus mengisi data dengan lengkap !');
                                                }
                                            });

                                        //validasi bppr
                                            $('#bppr_upload').change(function(){
                                                var nodtbbaru=document.getElementById("nodtbbaru").value;
                                                var nodtb2baru=document.getElementById("nodtb2baru").value;
                                                var nobpprbaru=document.getElementById("nobpprbaru").value;
                                                var nobaspbaru=document.getElementById("nobaspbaru").value;
                                                var sjupload=document.getElementById("sj_upload").value;
                                                var dtbupload=document.getElementById("dtb_upload").value;
                                                var bpprupload=document.getElementById("bppr_upload").value;
                                                var dtb2upload=document.getElementById("dtb2_upload").value;
                                                var baspupload=document.getElementById("basp_upload").value;
                                                var extensi=/(\.pdf)$/i;
                                                var sizepdfsj=document.getElementById("sj_upload").files[0];
                                                var sizepdfdtb=document.getElementById("dtb_upload").files[0];
                                                var sizepdfdtb2=document.getElementById("dtb2_upload").files[0];
                                                var sizepdfbppr=document.getElementById("bppr_upload").files[0];
                                                var sizepdfbasp=document.getElementById("basp_upload").files[0];
                                                console.log(sjupload);
                                                if(bpprupload != "")
                                                {
                                                    if(!extensi.exec(bpprupload))
                                                    {  
                                                        $('#btnupload').prop('disabled',true);
                                                        $('#validasi').val('Notifikasi : Format file BPPR harus pdf !'); 
                                                    }
                                                    else{
                                                        if(sizepdfbppr.size>500000 )
                                                            {
                                                                $('#btnupload').prop('disabled',true);
                                                                $('#validasi').val('Notifikasi : Size file BPPR tidak boleh lebih dari 500 kb!'); 
                                                            }
                                                        else{
                                                            if(sjupload == "" ||  nodtb2baru==""|| nobaspbaru=="" || nodtbbaru  == "" || dtbupload=="" || dtb2upload==""|| nobpprbaru=="" || baspupload=="")
                                                            {
                                                            $('#btnupload').prop('disabled',true);
                                                            $('#validasi').val('Notifikasi : Anda harus mengisi data dengan lengkap !'); 
                                                            }
                                                            else{
                                                                $('#btnupload').prop('disabled',false);
                                                                $('#validasi').val(''); 
                                                            }
                                                        }
                                                    }
                                                }
                                                else{
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Anda harus mengisi data dengan lengkap !');
                                                }
                                            });
                                            

                                              //validasi basp upload
                                              $('#basp_upload').change(function(){
                                                var nodtbbaru=document.getElementById("nodtbbaru").value;
                                                var nodtb2baru=document.getElementById("nodtb2baru").value;
                                                var nobpprbaru=document.getElementById("nobpprbaru").value;
                                                var nobaspbaru=document.getElementById("nobaspbaru").value;
                                                var sjupload=document.getElementById("sj_upload").value;
                                                var dtbupload=document.getElementById("dtb_upload").value;
                                                var bpprupload=document.getElementById("bppr_upload").value;
                                                var dtb2upload=document.getElementById("dtb2_upload").value;
                                                var baspupload=document.getElementById("basp_upload").value;
                                                var extensi=/(\.pdf)$/i;
                                                var sizepdfsj=document.getElementById("sj_upload").files[0];
                                                var sizepdfdtb=document.getElementById("dtb_upload").files[0];
                                                var sizepdfdtb2=document.getElementById("dtb2_upload").files[0];
                                                var sizepdfbppr=document.getElementById("bppr_upload").files[0];
                                                var sizepdfbasp=document.getElementById("basp_upload").files[0];
                                                console.log(sjupload);
                                                if(baspupload != "")
                                                {
                                                    if(!extensi.exec(baspupload))
                                                    {  
                                                        $('#btnupload').prop('disabled',true);
                                                        $('#validasi').val('Notifikasi : Format file BASP harus pdf !'); 
                                                    }
                                                    else{
                                                        if(sizepdfbasp.size>500000 )
                                                            {
                                                                $('#btnupload').prop('disabled',true);
                                                                $('#validasi').val('Notifikasi : Size file BASP tidak boleh lebih dari 500 kb!'); 
                                                            }
                                                        else{
                                                            if(sjupload == "" ||  nodtb2baru==""|| nobaspbaru=="" || nodtbbaru  == "" || dtbupload=="" || dtb2upload==""|| nobpprbaru=="" || bpprupload=="")
                                                            {
                                                            $('#btnupload').prop('disabled',true);
                                                            $('#validasi').val('Notifikasi : Anda harus mengisi data dengan lengkap !'); 
                                                            }
                                                            else{
                                                                $('#btnupload').prop('disabled',false);
                                                                $('#validasi').val(''); 
                                                            }
                                                        }
                                                    }
                                                }
                                                else{
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Anda harus mengisi data dengan lengkap !');
                                                }
                                            });

                                        }
                                    });
                                }
                                else{
                                    content="<div style='font-size:12px'><b>Upload:</b><br><br>"+
                                            "<table class='table table table-striped'>"+
                                            "<tr><td>Nomor Surat Jalan </td><td>:</td><td><input type='text'  id='nosjbaru' name='nosjbaru' readonly style='background:#20B2AA; color:white;' value='"+value_grid+"'></td><td> FILE SJ*</td><td> :</td><td><input type='file' id='sj_upload' name='sj_upload'/></td></tr>"+
                                            "<tr><td>Nomor Surat DTB </td><td>:</td><td><input type='text' id='nodtbbaru' name='nodtbbaru'></td><td> FILE DTB*</td><td> :</td><td><input type='file' id='dtb_upload' name='dtb_upload'/></td></tr>"+
                                            "</table><br><div style='color:green;'>*Format file harus .pdf dan maksimal size file 500 kb</div><input type='text' style='background:none;color:red; border:none;' size='50' id='validasi' readonly name='validasi'><input name='sj' type='hidden' value='"+value_grid+"'>"+
                                            "</span></div>";
                                    $("#contentmodalstatus").html(content); 
                                    
                                    //VALIDASI WAJIB DIISI
                                    $('#btnupload').prop('disabled',true);
                                    $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas !');

                                    //validasi no dtb
                                        $('#nodtbbaru').change(function(){
                                        var nodtbbaru=document.getElementById("nodtbbaru").value;
                                        var sjupload=document.getElementById("sj_upload").value;
                                        var dtbupload=document.getElementById("dtb_upload").value;
                                        console.log(sjupload);
                                        if(nodtbbaru != "")
                                        {
                                            if(sjupload == "" || dtbupload  == "")
                                            {
                                            $('#btnupload').prop('disabled',true);
                                            $('#validasi').val('Notifikasi :Mohon untuk melengkapi data form diatas !'); 
                                            }
                                            else{
                                                $('#btnupload').prop('disabled',false);
                                                $('#validasi').val(''); 
                                            }
                                        }
                                        else{
                                            $('#btnupload').prop('disabled',true);
                                            $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas !');
                                        }
                                        });
                                        
                                        //validasi SJ UPLOAD
                                        $('#sj_upload').change(function(){
                                        var nodtbbaru=document.getElementById("nodtbbaru").value;
                                        var sjupload=document.getElementById("sj_upload").value;
                                        var dtbupload=document.getElementById("dtb_upload").value;
                                        var extensi=/(\.pdf)$/i;
                                        var sizepdfsj=document.getElementById("sj_upload").files[0];
                                        var sizepdfdtb=document.getElementById("dtb_upload").files[0];
                                        if(sj_upload != "")
                                        {
                                            if(!extensi.exec(sjupload)  )
                                            {
                                                $('#btnupload').prop('disabled',true);
                                                $('#validasi').val('Notifikasi : Format file SJ harus pdf!'); 
                                            }
                                            else{
                                                if(sizepdfsj.size>500000 )
                                                {
                                                $('#btnupload').prop('disabled',true);
                                                $('#validasi').val('Notifikasi : Size file SJ tidak boleh lebih dari 500 Kb!'); 
                                                }
                                                else{
                                                   if(nodtbbaru == "" || dtbupload  == "")
                                                        {
                                                        $('#btnupload').prop('disabled',true);
                                                        $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas !'); 
                                                        }
                                                        else{
                                                            $('#btnupload').prop('disabled',false);
                                                            $('#validasi').val(''); 
                                                        }
                                                    }
                                            }
                                        }
                                        else{
                                            $('#btnupload').prop('disabled',true);
                                            $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas !');
                                        }
                                        });

                                        //validasi dtb upload
                                        $('#dtb_upload').change(function(){
                                        var nodtbbaru=document.getElementById("nodtbbaru").value;
                                        var sjupload=document.getElementById("sj_upload").value;
                                        var dtbupload=document.getElementById("dtb_upload").value;
                                        var extensi=/(\.pdf)$/i;
                                        var sizepdfsj=document.getElementById("sj_upload").files[0];
                                        var sizepdfdtb=document.getElementById("dtb_upload").files[0];
                                        console.log(sjupload);
                                        if(dtbupload != "")
                                        {
                                            if(!extensi.exec(dtbupload))
                                            {
                                                $('#btnupload').prop('disabled',true);
                                                $('#validasi').val('Notifikasi : Format file DTB harus pdf!'); 
                                            }
                                            else{
                                                if(sizepdfdtb.size>500000 )
                                                {
                                                $('#btnupload').prop('disabled',true);
                                                $('#validasi').val('Notifikasi : Size file DTB tidak boleh lebih dari 500 Kb!'); 
                                                }
                                                else{
                                                    if(sjupload == "" || nodtbbaru  == "")
                                                    {
                                                    $('#btnupload').prop('disabled',true);
                                                    $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas !'); 
                                                    }
                                                    else{
                                                        $('#btnupload').prop('disabled',false);
                                                        $('#validasi').val(''); 
                                                    }
                                                }
                                            
                                            
                                            }
                                        }
                                        else{
                                            $('#btnupload').prop('disabled',true);
                                            $('#validasi').val('Notifikasi : Mohon untuk melengkapi data form diatas!');
                                        }
                                        });
                                        }

                  
					},
					error: function(data)
					{
						alert ("tidak dapat disimpan");
					}
				});
				return false;
			});
                },
                error:function(data)
                {
                    alert("tidak dapat diproses");
                }
                });
                if ($(this).hasClass('selected')) {
                    $(this).removeClass('selected');
                    document.getElementById("editbtn").disabled = true;
                }
                else {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    document.getElementById("editbtn").disabled = false;
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

$('#pcodeedit').change(function(){
$('#pcodenameedit').val('test');
});



    
</script>




