<!-- link css plugin table -->
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.3.1.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
<!-- end link css plugin table -->
<script>
 
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
                        <tr><td style="padding: 2px 5px 7px;">Principal</td><td style="padding: 2px 5px 7px;">: </td><td> <select id="principalsj" name="principalsj" class="form-control m-b" style="width:200px;"><option value="kosong">--PILIH PRINCIPAL--</option> <option value="KSNI">KSNI</option><option value="SIMBA">SIMBA</option> <option value="LOTTE">LOTTE</option> </select></td></tr>
                        <tr><td style="padding: 2px 5px 7px;">Tanggal From</td><td style="padding: 2px 5px 7px;">: </td><td> <input type="date" id="tglawal"  class="form-control m-b" name="tglawal" ></td><td style="padding: 2px 5px 7px;">To</td><td style="padding: 2px 5px 7px;">: </td><td> <input type="date"  class="form-control m-b" id="tglakhir" name="tglakhir"></td></tr>
                        <tr><td style="padding: 2px 5px 7px;">Status</td><td style="padding: 2px 5px 7px;">: </td><td> <select id="status_sj" name="status_sj" class="form-control m-b" style="width:200px;"><option value="kosong">--PILIH STATUS--</option> <option value="approve">Approve</option> <option value="reject">Reject</option> </select></td></tr>
                        <tr><td><button class="btn btn-info" type="submit">Process</button>   <button class="btn btn-white" type="reset" id="reset" onClick="document.location.reload(true)">Reset</button></td></tr>
                        </form>
                     
                        </table>
                        <form action ="<?php echo base_url('index.php/dashboard/exportreportarea')?>" method="post"><input type="hidden" id="principalexp" name="principalexp"><input type="hidden" id="awaltglexp" name="awaltglexp"><input type="hidden" id="akhirtglexp" name="akhirtglexp"><input type="hidden" id="statussjexp" name="statussjexp"><button class="btn btn-danger" type="submit" >EXPORT TO EXCEL</button></td></form>
                        <!-- End Tombol add,edit,delete -->
                    
                        <!-- Start Tabel -->
                        <div class="ibox-content" id="tbl1" style="display:none;">
                        <table id="example" class="display" style="width:100%">
                                <thead>
                                <tr>
                                        <th>No</th>
                                        <th>PRINCIPAL</th>
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
             
            $('#tbl1').show();
            $.ajax({
                url: "<?php echo base_url('index.php/dashboard/getDatareportarea');?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(data){
                  
                    var no = 1;
                    $("#example").find('tbody').html("");
                    $.each(data,function(index, value){
                        var basp = data[index].no_basp == null ? '' : data[index].no_basp;
                        var bppr = data[index].no_bppr == null ? '' : data[index].no_bppr;
                        var dtb2 = data[index].no_dtb2 == null ? '' : data[index].no_dtb2;
                        var body = "<tr><td class='center'>"+no+"</td>"
                        +"<td class='center'>"+data[index].principal+"</td>"
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
                }
            });
            return false;
            }
            });
        
        $('#reset').click(function(){
            $("#tblreport").html("");
        });

    </script>
    <script>
      $('#principalsj').change(function(){
        $('#principalexp').val($('#principalsj').val());
        $('#statussjexp').val($('#status_sj').val());
    });
    $('#tglawal').change(function(){
        $('#awaltglexp').val($('#tglawal').val());
        $('#statussjexp').val($('#status_sj').val());
        $('#principalexp').val($('#principalsj').val());
    });
    $('#tglakhir').change(function(){
        $('#akhirtglexp').val($('#tglakhir').val());
        $('#statussjexp').val($('#status_sj').val());
        $('#principalexp').val($('#principalsj').val());
    });
    $('#status_sj').change(function(){
        $('#statussjexp').val($('#status_sj').val());
        $('#principalexp').val($('#principalsj').val());
    });
    
    </script>


   
