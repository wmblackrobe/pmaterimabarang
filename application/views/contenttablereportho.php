<!-- link css plugin table -->
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.3.1.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
<!-- end link css plugin table -->

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
<!-- CONTENT -->
    <!-- Top Content -->
    <div class="row wrapper border-bottom white-bg page-heading">

        <!-- Judul Content -->
            <div class="col-lg-10">
            <h2>Report Utility</h2>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url('index.php/dashboard');?>">Home</a></li>
                        <li class="active"><strong>Report</strong></li>
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
                        <table border="0" class="display">
                        <form action="" method="POST"  id="formreport">
                        <tr><td style="padding: 2px 5px 7px;">Principal</td><td style="padding: 2px 5px 7px;">: </td><td> <select id="principal" name="txtprincipal" class="form-control m-b" style="width:200px;"><option value="semua">--PILIH PRINCIPAL--</option><option value='KSNI'>KSNI</option><option value='LOTTE'>LOTTE</option><option value='SIMBA'>SIMBA</option></select></td></tr>
                        <tr><td style="padding: 2px 5px 7px;">Group Region</td><td style="padding: 2px 5px 7px;">: </td><td> <select id="grupregion" name="txtgrupregion" class="form-control m-b" style="width:200px;"><option value="semua">--PILIH GRUP REGION--</option> <?php foreach ($datagreg->result() as $greg){?><option value="<?php echo $greg->KD_GREG?>"><?php echo $greg->NM_GREG?></option><?php }?></select></td></tr>
                        <tr><td style="padding: 2px 5px 7px;">Region</td><td style="padding: 2px 5px 7px;">: </td><td> <select id="region" name="txtregion" class="form-control m-b" style="width:200px;"><option value="semua">--PILIH REGION--</option> </select></td></tr>
                        <tr><td style="padding: 2px 5px 7px;">Area</td><td style="padding: 2px 5px 7px;">: </td><td> <select id="area" name="txtarea" class="form-control m-b" style="width:200px;"><option value="semua">--PILIH AREA--</option> </select></td></tr>
                        <tr><td style="padding: 2px 5px 7px;">Tanggal From</td><td style="padding: 2px 5px 7px;">: </td><td> <input type="date" id="tglawal"  class="form-control m-b" name="tglawal" ></td><td style="padding: 2px 5px 7px;">To</td><td style="padding: 2px 5px 7px;">: </td><td> <input type="date"  class="form-control m-b" id="tglakhir" name="tglakhir"></td></tr>
                        <tr><td style="padding: 2px 5px 7px;">Status</td><td style="padding: 2px 5px 7px;">: </td><td> <select id="status_sj" name="status_sj" class="form-control m-b" style="width:200px;"><option value="semua">--PILIH STATUS--</option> <option value="approve">Approve</option> <option value="reject">Reject</option> </select></td></tr>
                        <tr><td><button class="btn btn-info" type="submit" >Process</button>   <button class="btn btn-white" type="reset" id="reset" onClick="document.location.reload(true)">Reset</button></td></tr>
                        </form>
                     
                        </table>
                        <form action ="<?php echo base_url('index.php/dashboard/exportreportho')?>" method="post"><input type="hidden" id="principalexp" name="principalexp"><input type="hidden" id="awaltglexp" name="awaltglexp"><input type="hidden" id="akhirtglexp" name="akhirtglexp"><input type="hidden" id="statussjexp" name="statussjexp"><input type="hidden" id="grupregionexp" name="txtgrupregionexp"><input type="hidden" id="regionexp" name="txtregionexp"><input type="hidden" id="areaexp" name="txtareaexp"><button class="btn btn-danger" type="submit" >EXPORT TO EXCEL</button></td></form>
                        <!-- End Tombol add,edit,delete -->

                      
                        <!-- Start Tabel -->
                        <div class="ibox-content" id="tbl1" style="display:none;">
                        <table id="example" class="display" style="width:100%">
                                <thead>
                                <tr>
                                        <th>No</th>
                                        <th>PRINCIPAL</th>
                                        <th>GRBM</th>
                                        <th>RBM</th>
                                        <th>KODE CABANG</th>
                                        <th>NAMA CABANG</th>
                                        <th>NO PO/DO</th>
                                        <th>NO SURAT JALAN</th>
                                        <th>TGL SURAT JALAN</th>
                                        <th>ETA DATE</th>
                                        <th>NO DTB</th>
                                        <th>TGL INPUT DTB</th>
                                        <th>TGL INPUT PORTAL</th>
                                        <th>SJ ON TIME</th>
                                        <th>KODE ITEM</th>
                                        <th>NAMA ITEM</th>
                                        <th>Qty SJ</th>
                                        <th>Qty TERIMA</th>
                                        <th>SJ SELISIH</th>
                                        <th>NO BASP</th>
                                        <th>NO BPPR</th>
                                        <th>NO DTB TAMBAHAN</th>
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
            $('#awaltglexp').val('');
            $('#akhirtglexp').val('');
            $('#statussjexp').val('');
            $('#formreport').submit(function(){
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
            $('#principalexp').val($('#principal').val());
            $('#grupregionexp').val($('#grupregion').val());
            $('#regionexp').val($('#region').val());
            $('#areaexp').val($('#region').val());
            $('#awaltglexp').val($('#tglawal').val());
            $('#akhirtglexp').val($('#tglakhir').val());
            $('#statussjexp').val($('#status_sj').val());
                    $('#tbl1').show();
                    $.ajax({
                        url: "<?php echo base_url('index.php/dashboard/getDatareportho');?>",
                        type: "POST",
                        data: $(this).serialize(),
                        dataType: "json",
                        success: function(data){
                            var no = 1;
                            $("#example").find('tbody').html("");
                            $.each(data,function(index, value){
                                console.log(data);
                                var basp = data[index].no_basp == null ? '' : data[index].no_basp;
                                var bppr = data[index].no_bppr == null ? '' : data[index].no_bppr;
                                var dtb2 = data[index].no_dtb2 == null ? '' : data[index].no_dtb2;
                                var body = "<tr><td class='center'>"+no+"</td>"
                                +"<td class='center'>"+data[index].principal+"</td>"
                                +"<td class='center'>"+data[index].NM_GREG+"</td>"
                                +"<td class='center'>"+data[index].NM_REG+"</td>"
                                +"<td class='center'>"+data[index].kd_sap2+"</td>"
                                +"<td class='center'>"+data[index].NM_DEPO+"</td>"
                                +"<td class='center'>"+data[index].no_dokumen+"</td>"
                                +"<td class='center'>"+data[index].no_sj+"</td>"
                                +"<td class='center'>"+data[index].tgl_sj+"</td>"
                                +"<td class='center'>"+data[index].ETA+"</td>"
                                +"<td class='center'>"+data[index].no_dtb+"</td>"
                                +"<td class='center'>"+data[index].tgl_inputdtb+"</td>"
                                +"<td class='center'>"+data[index].tgl_inputportal+"</td>"
                                +"<td class='center'>"+data[index].total+"</td>"
                                +"<td class='center'>"+data[index].PCODE+"</td>"
                                +"<td class='center'>"+data[index].PCODENAME+"</td>"
                                +"<td class='center'>"+data[index].qty_sj+"</td>"
                                +"<td class='center'>"+data[index].qty_terima+"</td>"
                                +"<td class='center'>"+data[index].selisih+"</td>"
                                +"<td class='center'>"+basp+"</td>"
                                +"<td class='center'>"+bppr+"</td>"
                                +"<td class='center'>"+dtb2+"</td></tr>";
                                $("#example").find('tbody').append(body);
                                no++;
                            }); 
                            var table = $('#example').DataTable(); 
                        },
                        error: function(data){
                        alert("Data Tidak ada!");
                        redirect('index.php/dashboard/reportho');
                        }
                    });
                    return false;
                 }
            });
    
  
    </script>
  

     
   


   
