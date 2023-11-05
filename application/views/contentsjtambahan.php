
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
                <h2>Surat Jalan Tambahan</h2>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url('index.php/dashboard');?>">Home</a></li>
                        <li><a>Surat Jalan</a></li>
                        <li class="active"><strong>Surat Jalan Tambahan</strong></li>
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
<script type="text/javascript">
  $(function(){
    $('#region').prop('disabled',true);
    $('#area').prop('disabled',true);
    
    $('#grupregion').change(function(){

      if($('#grupregion').val()!="datagreg"){
        $('#region').prop('disabled',false);
        $('#area').prop('disabled',true);
      }else{
        $('#region').prop('disabled',true);
        $('#area').prop('disabled',true);
      }
    });
    
    $('#region').change(function(){
      if($('#region').val()!=""){
        $('#region').prop('disabled',false);
        $('#area').prop('disabled',false);
      }else{
        $('#region').prop('disabled',false);
        $('#area').prop('disabled',true);
      }
    });
  });
</script>
 <script>
  
  $('#tglawal').change(function(){
      $('#awaltglexp').val($('#tglawal').val());
  });
  $('#tglakhir').change(function(){
      $('#akhirtglexp').val($('#tglakhir').val());
  });
  $('#status_sj').change(function(){
      $('#statussjexp').val($('#status_sj').val());
  });
  $('#area').change(function(){
      $('#areaexp').val($('#area').val());
  });
  $('#grupregion').change(function(){
      $('#grupregionexp').val($('#grupregion').val());
  });
  $('#region').change(function(){
      $('#regionexp').val($('#region').val());
  });
  </script>
<script type="text/javascript">
$(function(){ 
    $("#grupregion").change(function(){ 
        var post_string = "KD_GREG=" + $(this).val(); 
        $.ajax({ 
            type: "GET", 
            data: post_string, 
            dataType: "json", 
            url: "<?php echo base_url('index.php/dashboard/getRegion/');?>"+$(this).val(),
            cache: false,
            beforeSend: function(){
            var awal="<option value='semua'>--PILIH REGION--</option>";
            $('#region').html(awal);
              var awal2="<option value='semua'>--PILIH AREA--</option>";
              $('#area').html(awal2);
           }, 
            error: function() { 
              $("#region").prop('disabled', true); 
              $("#area").prop('disabled', true); 
            }, 
            success: function(data) { 
              var awal="<option value='semua'>--PILIH REGION--</option>";
              $('#region').html(awal);
              $(awal).html("#region");
              $.each(data, function(id,val){
              var row = "<option value=\"" + data[id].KD_REG + "\">" + data[id].NM_REG + "</option>"; 
              $(row).appendTo("#region");});
            console.log(data);
            } 
        }); 
    });     
});
</script>

<script type="text/javascript">
$(function(){ 
    $("#region").change(function(){ 
        var post_string = "KD_REG=" + $(this).val(); 
        $.ajax({ 
            type: "GET", 
            data: post_string, 
            dataType: "json", 
            url: "<?php echo base_url('index.php/dashboard/getArea/');?>"+$(this).val(),
            cache: false,
            beforeSend: function(){
              var awal2="<option value='semua'>--PILIH AREA--</option>";
              $('#area').html(awal2);
           }, 
            error: function() { 
            
              $("#area").prop('disabled', true); 
            }, 
            success: function(data) { 
              var awal="<option value='semua'>--PILIH AREA--</option>";
              $('#area').html(awal);
              $(awal).html("#area");
              $.each(data, function(id,val){
              var row = "<option value=\"" + data[id].KD_AREA + "\">" + data[id].NM_AREA + "</option>"; 
              $(row).appendTo("#area"); });
            console.log(data);
            } 
        }); 
    });     
});
</script>
    <!-- Middle Content -->
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Fitur ini dibuat untuk mengontrol surat jalan tambahan yang sudah diproses</h5>
                    </div>

                <div class="ibox-content">
                    <div class="ibox-content">
                        <div>
                        <form action="" id="formsj" method="post">
                        <table width="500px" border="0">
                        <tr><td style="padding: 2px 5px 7px;">Group Region</td><td style="padding: 2px 5px 7px;">: </td><td> <select id="grupregion" name="txtgrupregion" class="form-control m-b" style="width:200px;"><option value="semua">--PILIH GRUP REGION--</option> <?php foreach ($datagreg->result() as $greg){?><option value="<?php echo $greg->KD_GREG?>"><?php echo $greg->NM_GREG?></option><?php }?></select></td></tr>
                        <tr><td style="padding: 2px 5px 7px;">Region</td><td style="padding: 2px 5px 7px;">: </td><td> <select id="region" name="txtregion" class="form-control m-b" style="width:200px;"><option value="semua">--PILIH REGION--</option> </select></td></tr>
                        <tr><td style="padding: 2px 5px 7px;">Area</td><td style="padding: 2px 5px 7px;">: </td><td> <select id="area" name="txtarea" class="form-control m-b" style="width:200px;"><option value="semua">--PILIH AREA--</option> </select></td></tr>
                        <tr><td style="padding: 2px 5px 7px;">Tanggal From</td><td style="padding: 2px 5px 7px;">: </td><td> <input type="date" id="tglawal"  class="form-control m-b" name="tglawal" ></td><td style="padding: 2px 5px 7px;">To</td><td style="padding: 2px 5px 7px;">: </td><td> <input type="date"  class="form-control m-b" id="tglakhir" name="tglakhir"></td></tr>
                        <tr><td style="padding: 2px 5px 7px;">Principal</td><td style="padding: 2px 5px 7px;">: </td><td><select class="form-control m-b"  id="principal" name="principal"><option value="semua">--Pilih Principal--</option><option value="KSNI">KSNI</option><option value="SIMBA">SIMBA</option><option value="LOTTE">LOTTE</option></select></td></tr>
                        <tr><td colspan='6'><button class="btn btn-info" type="submit" >Process</button>   <button class="btn btn-white" type="reset" id="reset" onClick="document.location.reload(true)">Reset</button></td></tr>
                        </table>
                        </form>
                        </div>
                        <!-- End Tombol add,edit,delete -->
                      <!-- Notifikasi -->
                      <?php if($this->session->flashdata('berhasilupdate')): ?>
                        <div class="alert alert-info">
                        <strong><?php echo $this->session->flashdata('berhasilupdate'); ?></strong> 
                        </div>
                        <?php endif; ?>
                        <?php if($this->session->flashdata('gagalupdate')): ?>
                        <div class="alert alert-danger">
                        <strong><?php echo $this->session->flashdata('gagalupdate'); ?></strong> 
                        </div>
                        <?php endif; ?>

                        <!-- Start Tabel -->
                        <br>
                        <div class="ibox-content" id="tbl1" style="display:none;">
                        <button class="btn btn-danger" type="button" data-toggle="modal"  data-target="#myModaledit" id="editbtn"><i class="fa fa-see"></i> Edit</button>
                        <table id="example" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Site</th>
                                        <th>Nama Site</th>
                                        <th>Tanggal</th>
                                        <th>No Surat Jalan Sementara</th>
                                        <th>Principal</th>
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
                        <h4 class="modal-title">SURAT JALAN TAMBAHAN</h4>
                    </div>
                    <!-- Content Modal Edit SURAT JALAN -->
                        <form method="post" id="updatesuratjalan" action="<?php echo base_url('index.php/dashboard/updatesjtambahan');?>" enctype="multipart/form-data" >
                            <div class="modal-body" style="width:790px;">
                            <div id="edit-nomorsj"></div><br>
                           <div > Tanggal DTB : <input type="text" id="tgldtb1" name="tgldtb" size='8' disabled>  No. SJ Tambahan : <input type='text' id='nosjbaru' name='nosjbaru' size='10' required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" > FILE SJ Tambahan : <input type='file' id='filesj2' name='filesj2' style="position:relative; top:-20px; left:500px;" required oninvalid="this.setCustomValidity('data tidak boleh kosong')" oninput="setCustomValidity('')" > </div><input type='hidden' id='nosjcad' name='nosjcad'><input type='hidden' id='sap' name='sap'>
                              <input type="text" id="alertsjtambahan" name="alertsjtambahan" size="100" style="border:none; background:none; color:red;" disabled>
                            <div class="table-wrapper-scroll-y">
                                <table class="table table-bordered table-striped" id="tbl2">
                                <thead>
                                    <tr>
                                        <th>PCODE</th>
                                        <th>NO SURAT JALAN</th>
                                        <th>QTY</th>
                                        <th>QTY SELISIH LEBIH</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <!-- END TABEl -->
                            </div>
                            <div>
                            </div>
                            <div  class="modal-footer">
                                <button type="submit" id="update-edit_btn" data-toggle="modal"  data-target="#modalstatus" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-white" data-dismiss="modal" href="<?php echo base_url('dashboard/surat_jalan_proses');?>">Cancel</button>
                            </div>
                        </form>
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
    <script>
    $('#grupregionexp').val('');
            $('#regionexp').val('');
            $('#areaexp').val('');
        $('#formsj').submit(function(){
            if($('#tglawal').val()==='' || $('#tglakhir').val()==='')
            {
                alert("Tanggal harus wajib diisi!");
                redirect('index.php/dashboard/reportho');
            }
            else if($('#tglawal').val() >= $('#tglakhir').val())
            {
                alert("Tanggal akhir tidak boleh lebih dulu sebelum tanggal from !");
                redirect('index.php/dashboard/reportho');
            }
            else{
           
            $.ajax({
                url: "<?php echo base_url('index.php/dashboard/getDatasjtambahan'); ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(data){
                    $('#tbl1').show();
                    $('#editbtn').prop('disabled', true);
                    var no = 1;
                    $("#tbl1").find('tbody').html("");
                    $.each(data,function(index, value){
                        var body = "<tr><td class='center'>"+no+"</td><td class='center'>"+data[index].kd_sap2+"</td><td class='center'>"+data[index].NM_DEPO+"</td><td class='center'>"+data[index].tgl_inputdtb+"</td></td><td class='center'>"+data[index].no_sj2+"</td></td><td class='center'>"+data[index].principal+"</td></tr>";
                        $("#tbl1").find('tbody').append(body);
                        no++;
                    });
                    var table = $('#example').DataTable();
                    $('#tgldtb1').val('');
                    $('#nosjbaru').val('');
                    $('#nosjcad').val('');
                    $("#tbl2").find('tbody').html(""); 
                     $('#sap').val('');
                    var kdsap = ""; 
                    var tglinputdtb = ""; 
                    var sjtambahan = "";
                    $('#example tbody').on('click', 'tr', function() {
                        $('#editbtn').prop('disabled', false);
                        var kdsap = $(this).find("td:eq(1)").text(); 
                        var tglinputdtb = $(this).find("td:eq(3)").text(); 
                        var sjtambahan = $(this).find("td:eq(4)").text();
                         $('#sap').val(kdsap);
                        $.ajax({
                        url: "<?php echo base_url('index.php/dashboard/getsjtambahan'); ?>",
                        type: "POST",
                        data:{sjtmbhcek: sjtambahan},
                        dataType: "json",
                        success: function(data){
                            console.log(data);
                            $('#update-edit_btn').prop('disabled', true);
                            $('#alertsjtambahan').val(''); 
                            $('#filesj2').change(function(){
                            var sj2upload=document.getElementById("filesj2").value;
                            var extensi=/(\.pdf)$/i;
                            var sizepdfsj2=document.getElementById("filesj2").files[0];
                            if(!extensi.exec(sj2upload))
                            {  
                                $('#update-edit_btn').prop('disabled',true);
                                $('#alertsjtambahan').val('Notifikasi : Format file SJ Tambahan harus pdf !'); 
                            }
                            else{
                                if(sizepdfsj2.size>500000)
                                    {
                                    $('#update-edit_btn').prop('disabled', true);
                                    $('#alertsjtambahan').val('Notifikasi : Size file SJ Tambahan tidak boleh lebih dari 500 kb!'); 
                                    }
                                else{
                                    $('#update-edit_btn').prop('disabled', false);
                                    $('#alertsjtambahan').val(''); 
                                }
                            }
                                             

                             });
                            $("#tbl2").find('tbody').html("");
                            $('#editbtn').prop('disabled', false);
                            $('#tgldtb1').val(tglinputdtb);
                            $('#nosjbaru').val(sjtambahan);
                            $('#nosjcad').val(sjtambahan);
                            var body2="";
                            $.each(data,function(index, value){
                            var body2 = "<tr><td class='center'>"+value.PCODE+"</td><td class='center'>"+data[index].no_sj+"</td><td class='center'>"+data[index].qty_sj+"</td><td class='center'>"+data[index].qty_selisih_lebih+"</td></tr>";
                            $("#tbl2").find('tbody').append(body2);
                            // $("#tbl2").find('tbody').appendTo(body2);
                            no++;
                        });
                        }

                        });

                    if ($(this).hasClass('selected') ) {
                        $('#editbtn').prop('disabled', true);
                        $(this).removeClass('selected');
                    }
                    else {
                        table.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }
                    });
                

                },
                error: function(data){
                    alert('gagal');
                }
                
        }); 
              

return false;


           }   }); 
          

                   
             
         
      
        
      
      

    </script>



