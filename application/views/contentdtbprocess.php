<!-- link css plugin table -->
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.3.1.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>

<!-- end link css plugin table -->

<style>
.table-wrapper-scroll-y{display: block;max-height: 150px; overflow-y: auto;-ms-overflow-style: -ms-autohiding-scrollbar;}
</style>

<!-- CONTENT -->
    <!-- Top Content -->
    <div class="row wrapper border-bottom white-bg page-heading">

        <!-- Judul Content -->
            <div class="col-lg-10">
                <h2>Data Terima Barang Process</h2>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url('index.php/dashboard');?>">Home</a></li>
                        <li><a>DTB</a></li>
                        <li class="active"><strong>DTB Process</strong></li>
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
                        <h5>Fitur ini dibuat untuk mengontrol data terima barang</h5>
                    </div>

                    <div class="ibox-content">
                        <div class="table-responsive">
                         <!-- kolom periode -->
                            <form action="<?php echo base_url('index.php/dashboard/dtb_process');?>" id="formdtb" method="post">
                            <table width="300px" border="0">
                            <tr>
                                <td>Periode</td>
                                <td>:</td>
                                <td > <select id="period" class="form-control m-b" name="periode" style="position:relative; left:-50px; top:10px;">
                                        <option value="">Bulan</option>
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select></td>
                            </tr>
                            <tr>
                                <td>Tahun</td>
                                <td>:</td>
                                <td><select id="year" class="form-control m-b" name="tahun" style="position:relative; left:-50px; top:15px;">
                                <option value="">Tahun</option>
                                <?php $tahun=date('Y'); for($i=2013; $i<=$tahun; $i++){?>
                                    <option value="<?php echo $i?>"><?php echo $i?></option> 
                                <?php }?></select><br></td>
                            </tr>
                            <tr><td><button class="btn btn-sm btn-primary pull-center m-t-n-xs" type="submit" style="font-size:14px"><i class="fa fa-check"></i> Process</button></td><td><button class="btn btn-sm btn-white pull-left m-t-n-xs" id="reset" type="reset" onClick="document.location.reload(true)" style="font-size:14px"><i class="fa fa-refresh"></i> Reset</button></td></tr>
                            </table>
                            </form>
                        <!-- End kolom periode -->
                    
                         <!-- Notifikasi -->
                        <?php if($this->session->flashdata('berhasilapprove')): ?>
                        <div class="alert alert-info">
                        <strong><?php echo $this->session->flashdata('berhasilapprove'); ?></strong>
                        </div>
                        <?php endif; ?>
                        <?php if($this->session->flashdata('gagalapprove')): ?>
                        <div class="alert alert-danger">
                        <strong><?php echo $this->session->flashdata('gagalapprove'); ?></strong>
                        </div>
                        <?php endif; ?>
                        <?php if($this->session->flashdata('berhasilreject')): ?>
                        <div class="alert alert-warning">
                        <strong><?php echo $this->session->flashdata('berhasilreject'); ?></strong>
                        </div>
                        <?php endif; ?>
                        <?php if($this->session->flashdata('gagalreject')): ?>
                        <div class="alert alert-danger">
                        <strong><?php echo $this->session->flashdata('gagalreject'); ?></strong>
                        </div>
                        <?php endif; ?>
                        <!-- End Notifikasi -->

                        <!-- Start Tabel -->
                        <br><div><button class="btn btn-warning" id='btnproses' style="display:none;" type="button" data-toggle="modal"  data-target="#myModalproses"><i class="fa fa-pencil"></i> Proses</button></div>
                        <input type="hidden" id="subbulan" name="bulan"><input type="hidden" id="subtahun" name="tahun">
                        <div class="ibox-content" id="tbl1" style="display:none;">
                        <table id="example" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Site</th>
                                        <th>Nama Site</th>
                                        <th>Total Surat Jalan</th>
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

    <!-- Modal dtb proses -->
        <div class="modal inmodal" id="myModalproses" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog"  style='width:900px;'>
                        <div class="modal-content animated flipInY">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <div class="font-bold" style="font-size:14px;" id="judulsite"></div>
                            </div>
                            <div class="modal-body"  style='width:898px;'>
                            <form method="post" id="updatedtb" action=""><div><button class="btn btn-info" id='btnproses2' type="button" data-toggle="modal"  data-target="#mydtbprosessesuai" > Proses</button></div><br>
                            <div class="ibox-content"  style="background:none;">
                            <table  class="table table-bordered table-striped" id="tbl3">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>NO SJ</th>
                                    <th>TANGGAL SJ</th>
                                    <th>PRINCIPAL</th>
                                    <th>STATUS</th>
                                    <th>HASIL SCAN</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            </table>
                            </div>
                        </form>
                            </div>
                        </div>
                    </div>
                </div>

    <!-- END Modal dtb proses -->

    <!-- Modal dtb proses setelah di pilih sj -->
    <div class="modal inmodal" id="mydtbprosessesuai" tabindex="-1" aria-hidden="true" style="display:none;">
        <div class="modal-dialog modal-lg" style="width:900px;">
            <div class="modal-content animated flipInY">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <div class="font-bold" style="font-size:14px;" id="judulsite2"></div>
                    </div>
                    <!-- Content Modal Add User -->

                        <div class="modal-body">
                            <div><button class="btn btn-danger" id='btnapprove' type="button"> Approve</button>  <button class="btn btn-info" id='btnreject' type="button" data-toggle="modal"  data-target="#myModalreject"> Reject</button></div>
                            <input type="text" id="alertsjtambahan" name="alertsjtambahan" size="100" style="border:none; background:none; color:red;" disabled> <input type="hidden" id="nosjbyclick" name="nosjbyclick"> <br>
                            <table  id="tbll" style="width:100%">
                                <thead>
                                </thead>
                                </table>
                                <table class="table table-bordered table-striped table-wrapper-scroll-y" id="tbl4" style="width:100%">
                                <tbody>
                                </tbody>
                            </table>
                            <!-- END TABEl -->
                            <br>
                        </div>
                     
                        </div>
                    </div>
                </div>
<!-- END Modal dtb proses setelah dipilih SJ -->

<!-- Modal dtb proses setelah di eksekusi sesuai status reject -->
<div class="modal inmodal" id="myModalreject" tabindex="-1" role="dialog" aria-hidden="true" style="display:none;">
        <div class="modal-dialog modal-lg" style="width:500px;">
            <div class="modal-content animated flipInY">
                <div class="modal-header">
                    <a class="close"  href="<?php echo base_url('index.php/dashboard/dtb_process');?>"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></a>
                    <div class="font-bold" style="font-size:18px;">Anda yakin ingin me-reject surat jalan ini?</div>
                </div>
                    <!-- Content Modal Add User -->
                        <form method="post" id="updatedtbreject" action="<?php echo base_url('index.php/dashboard/updatedtbreject');?>" >
                            <div class="modal-body">
                                <input type="hidden" id="nosjforreject" name="nosjforreject">
                                Alasan : <select name="alasanrow">
                                <option value="">-Pilih Alasan-</option>
                                <?php foreach ($alasanforreject->result() as $a){?>
                                    <option value="<?php echo $a->id_alasan?>"><?php echo $a->alasan?></option>
                                <?php } ?>
                                </select>
                                <div  class="modal-footer">
                                    <button type="submit"  class="btn btn-primary">Reject</button>
                                    <a class="btn btn-white" href="<?php echo base_url('index.php/dashboard/dtb_process');?>">Cancel</a>
                                </div>
                            <!-- END TABEl -->
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
<!-- END Modal dtb proses setelah di eksekusi sesuai status reject -->


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
   
        $('#formdtb').submit(function(){
            var period = $('#period').val();
            var year = $('#year').val();
            $('#subbulan').val(period);
            $('#subtahun').val(year);
            $.ajax({
                url: "<?php echo base_url('index.php/dashboard/getDataDtb'); ?>",
                type: "POST",
                data: {periode : period, tahun:year},
                dataType: "json",
                success: function(data){
                    $('#tbl1').show();
                    $('#btnproses').show();
                    $('#btnproses').prop('disabled', true);
                    var no = 1;
                    $("#tbl1").find('tbody').html("");
                    $.each(data,function(index, value){
                        var body = "<tr><td class='center'>"+no+"</td><td class='center'>"+data[index].kd_sap2+"</td></td><td class='center'>"+data[index].NM_DEPO+"</td></td><td class='center'>"+data[index].total_sj+"</td></tr>";
                        $("#tbl1").find('tbody').append(body);
                        no++;
                    });


                    var table = $('#example').DataTable();
                    $('#example tbody').on('click', 'tr', function() {
                        $('#btnproses').prop('disabled', false);

                    if ($(this).hasClass('selected') ) {
                        $('#btnproses').prop('disabled', true);
                        $(this).removeClass('selected');
                    }
                    else {
                        table.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }
                    });
                    $('#button').click( function () {
                        table.row('.selected').remove().draw( false );
                    } );
                }
            });
           return false;
        });
       
</script>
<script>
    var value_idsite = "";
    $('#example tbody').on('click', 'tr', function() {
        var bulan = $('#subbulan').val();
        var thn = $('#subtahun').val();
            var idsite = $(this).find("td:eq(1)").text(); 
            var nmsite = $(this).find("td:eq(2)").text();   
            value_idsite = idsite;
            $("#judulsite").html(idsite+"-"+nmsite);
                $.ajax({
                url: "<?php echo base_url('index.php/dashboard/getdatasitesjprocess');?>",
                type: "POST",
                data: {kdsite: idsite, periode :bulan, tahun:thn},
                datatype: "JSON",
                success:function(data)
                {
                    
                    var no3 = 1;
                    $("#tbl3").find('tbody').html("");
                    $.each(data,function(index, value){
                        if(data[index].keterangan=="sesuai")
                        {
                            var body = "<tr><td class='center'>"+no3+"</td><td class='center'>"+data[index].no_sj+"</td></td><td class='center'>"+data[index].tgl_sj+"</td></td><td class='center'>"+data[index].principal+"</td><td class='center'>"+data[index].keterangan+"</td><td class='center'><a href=<?php echo base_url();?>pdf/sj/"+data[index].dok_sj+" target='_blank'>VIEW SJ</a> | <a href=<?php echo base_url();?>pdf/dtb/"+data[index].dok_dtb+" target='_blank'>VIEW DTB</a> </td></tr>";
                        }
                        else if(data[index].keterangan=="selisih kurang")
                        {
                            var body = "<tr><td class='center'>"+no3+"</td><td class='center'>"+data[index].no_sj+"</td></td><td class='center'>"+data[index].tgl_sj+"</td></td><td class='center'>"+data[index].principal+"</td><td class='center'>"+data[index].keterangan+"</td><td class='center'><a href=<?php echo base_url();?>pdf/sj/"+data[index].dok_sj+" target='_blank'>VIEW SJ</a> | <a href=<?php echo base_url();?>pdf/dtb/"+data[index].dok_dtb+" target='_blank'>VIEW DTB</a> | <a href=<?php echo base_url();?>pdf/bppr/"+data[index].dok_bppr+" target='_blank'>VIEW BPPR</a> | <a href=<?php echo base_url();?>pdf/basp/"+data[index].dok_basp+" target='_blank'>VIEW BASP</a></td></tr>";
                        }
                        else if(data[index].keterangan=="selisih lebih")
                        {
                            var body = "<tr><td class='center'>"+no3+"</td><td class='center'>"+data[index].no_sj+"</td></td><td class='center'>"+data[index].tgl_sj+"</td></td><td class='center'>"+data[index].principal+"</td><td class='center'>"+data[index].keterangan+"</td><td class='center'><a href=<?php echo base_url();?>pdf/sj/"+data[index].dok_sj+" target='_blank'>VIEW SJ</a> | <a href=<?php echo base_url();?>pdf/dtb/"+data[index].dok_dtb+" target='_blank'>VIEW DTB</a> | <a href=<?php echo base_url();?>pdf/dtb2/"+data[index].dok_dtb2+" target='_blank'>VIEW DTB TAMBAHAN</a> |  <a href=<?php echo base_url();?>pdf/basp/"+data[index].dok_basp+" target='_blank'>VIEW BASP</a></td></tr>";
                        }
                        else{
                            var body = "<tr><td class='center'>"+no3+"</td><td class='center'>"+data[index].no_sj+"</td></td><td class='center'>"+data[index].tgl_sj+"</td></td><td class='center'>"+data[index].principal+"</td><td class='center'>"+data[index].keterangan+"</td><td class='center'><a href=<?php echo base_url();?>pdf/sj/"+data[index].dok_sj+" target='_blank'>VIEW SJ</a> | <a href=<?php echo base_url();?>pdf/dtb/"+data[index].dok_dtb+" target='_blank'>VIEW DTB</a> | <a href=<?php echo base_url();?>pdf/dtb2/"+data[index].dok_dtb2+" target='_blank'>VIEW DTB TAMBAHAN</a> | <a href=<?php echo base_url();?>pdf/bppr/"+data[index].dok_bppr+" target='_blank'>VIEW BPPR</a> | <a href=<?php echo base_url();?>pdf/basp/"+data[index].dok_basp+" target='_blank'>VIEW BASP</a></td></tr>";
                        }
                        $("#tbl3").find('tbody').append(body);                     
                        no3++;});

                    var table = $('#tbl3').DataTable();
                    $('#btnproses2').prop('disabled', true);
                    $('#tbl3 tbody').on('click', 'tr', function() {
                    if ($(this).hasClass('selected') ) {
                        $('#btnproses2').prop('disabled', true);
                        $(this).removeClass('selected');
                    }
                    else {
                        $('#btnproses2').prop('disabled', false);
                        table.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }
                    });
                    $('#button').click( function () {
                        table.row('.selected').remove().draw( false );
                    });
                    
                    $("#nosjforreject").val('');
                        $('#tbl3 tbody').on('click', 'tr', function () {
                            var nosj = $(this).find("td:eq(1)").text(); 
                            var tglsj = $(this).find("td:eq(2)").text(); 
                            var cekstatussj = $(this).find("td:eq(4)").text();  
                            $.ajax({
                            url: "<?php echo base_url('index.php/dashboard/getdatasjprocessbydtb');?>",
                            type: "POST",
                            data: {no_sj: nosj,tgl_sj: tglsj},
                            datatype: "JSON",
                            success:function(data)
                            {
                                 $.ajax({
                                    url: "<?php echo base_url('index.php/dashboard/getsjtambahanfromsj');?>",
                                    type: "POST",
                                    data: {no_sj: nosj},
                                    datatype: "JSON",
                                    success:function(data)
                                    {
                                        console.log(data);
                                        $('#alertsjtambahan').val('');
                                        $('#btnapprove').prop('disabled',false);
                                         $('#btnreject').prop('disabled',false);
                                        if(data.no_sj2==="")
                                        {
                                            $('#alertsjtambahan').val('');
                                            $('#btnapprove').prop('disabled',false);
                                            $('#btnreject').prop('disabled',false);
                                        }
                                        else if(data.no_sj2===nosj+'x')
                                        {
                                            $('#alertsjtambahan').val('Mohon untuk mengganti no sj tambahan sebelum melakukan approve atau reject !');
                                            $('#btnapprove').prop('disabled',true);
                                             $('#btnreject').prop('disabled',true);
                                        }
                                        else{
                                            $('#alertsjtambahan').val('');
                                            $('#btnapprove').prop('disabled',false);
                                             $('#btnreject').prop('disabled',false);
                                        }
                                    }
                                        });

                                // $(document).ready(function() {
                                //     $('#tbl4').DataTable( {
                                //         "scrollY":        "150px",
                                //         "scrollCollapse": true,
                                //         "paging":         false,
                                //         "fixedHeader": true
                                //     });
                                // });

                                $('#btnapprove').click(function(){
                                //alert("delete "+value_grid);
                                var konfirmasi = confirm("Anda yakin untuk approve sj ini?");
                                
                                //alert("delete "+value_grid);
                                if(konfirmasi === true) {
                                    window.location = "<?php echo base_url();?>index.php/dashboard/updatedtbapprove/"+nosj;
                                    }else{
                                        window.location = "<?php echo base_url();?>index.php/dashboard/dtb_process/";
                                    }
                            });
                                if(cekstatussj=="sesuai"){
                                $("#tbll").find('thead').html("");
                                var head="<tr style='width:100%'><th class='center' style='width: 28px;'>NO</th>"+
                                "<th class='center' style='width: 54px;'>PCODE</th>"+
                                "<th class='center' style='width: 99px;'>PCODENAME</th>"+
                                "<th class='center' style='width: 72px;'>NO SJ</th>"+
                                "<th class='center' style='width: 56px;'>NO DTB</th>"+
                                "<th class='center' style='width: 34px;'>Qty SJ</th>"+
                                "<th class='center' style='width: 35px;'>Qty SK</th>"+
                                "<th class='center' style='width: 35px;'>Qty SL</th></tr>";
                                $("#tbll").find('thead').append(head);
                                $('#btnreject').click(function(){
                                $("#nosjforreject").val(nosj);});
                                var no4 = 1;
                                $("#tbl4").find('tbody').html("");
                                $.each(data,function(index, value){
                                    var body = "<tr><td  style='width: 55px;' class='center'>"+no4+"</td><td style='width: 107px;' class='center'>"+data[index].PCODE+"</td></td><td style='width: 200px;' class='center'>"+data[index].PCODENAME+"</td></td><td  style='width: 148px;' class='center'>"+data[index].no_sj+"</td><td style='width:115px;' class='center'>"+data[index].no_dtb+"</td><td  style='width: 67px;' class='center'>"+data[index].qty_sj+"</td><td  style='width: 70px;' class='center'>"+data[index].qty_selisih_kurang+"</td><td  style='width: 70px;' class='center'>"+data[index].qty_selisih_lebih+"</td></tr>";
                                    $("#tbl4").find('tbody').append(body);
                                    no4++;
                                });
                                    
                                }

                                else if(cekstatussj=="selisih kurang"){
                                $("#tbll").find('thead').html("");
                                var head="<tr style='width:100%'><th class='center' style='width: 28px;'>NO</th>"+
                                "<th class='center' style='width: 54px;'>PCODE</th>"+
                                "<th class='center' style='width: 99px;'>PCODENAME</th>"+
                                "<th class='center' style='width: 72px;'>NO SJ</th>"+
                                "<th class='center' style='width: 56px;'>NO DTB</th>"+
                                "<th class='center' style='width: 56px;'>NO BPPR</th>"+
                                "<th class='center' style='width: 56px;'>NO BASP</th>"+
                                "<th class='center' style='width: 34px;'>Qty SJ</th>"+
                                "<th class='center' style='width: 35px;'>Qty SK</th>"+
                                "<th class='center' style='width: 35px;'>Qty SL</th></tr>";
                                $("#tbll").find('thead').append(head);
                                $('#btnreject').click(function(){
                                $("#nosjforreject").val(nosj);});
                                var no4 = 1;
                                $("#tbl4").find('tbody').html("");
                                $.each(data,function(index, value){
                                    var body = "<tr><td  style='width: 55px;' class='center'>"+no4+"</td><td style='width: 107px;' class='center'>"+data[index].PCODE+"</td><td style='width: 200px;' class='center'>"+data[index].PCODENAME+"</td><td  style='width: 148px;' class='center'>"+data[index].no_sj+"</td><td style='width:115px;' class='center'>"+data[index].no_dtb+"</td><td  style='width: 148px;' class='center'>"+data[index].no_bppr+"</td><td style='width: 148px;' class='center'>"+data[index].no_basp+"</td><td  style='width: 67px;' class='center'>"+data[index].qty_sj+"</td><td  style='width: 70px;' class='center'>"+data[index].qty_selisih_kurang+"</td><td  style='width: 70px;' class='center'>"+data[index].qty_selisih_lebih+"</td></tr>";
                                    $("#tbl4").find('tbody').append(body);
                                    no4++;
                                });
                                    
                                }
                                else if(cekstatussj=="selisih lebih"){
                                $("#tbll").find('thead').html("");
                                var head="<tr style='width:100%'><th class='center' style='width: 28px;'>NO</th>"+
                                "<th class='center' style='width: 54px;'>PCODE</th>"+
                                "<th class='center' style='width: 95px;'>PCODENAME</th>"+
                                "<th class='center' style='width: 70px;'>NO SJ</th>"+
                                "<th class='center' style='width: 72px;'>NO SJ TAMBAHAN</th>"+
                                "<th class='center' style='width: 56px;'>NO DTB</th>"+
                                "<th class='center' style='width: 56px;'>NO DTB TAMBAHAN</th>"+
                                "<th class='center' style='width: 56px;'>NO BASP</th>"+
                                "<th class='center' style='width: 34px;'>Qty SJ</th>"+
                                "<th class='center' style='width: 35px;'>Qty SK</th>"+
                                "<th class='center' style='width: 35px;'>Qty SL</th></tr>";
                                $("#tbll").find('thead').append(head);
                                $('#btnreject').click(function(){
                                $("#nosjforreject").val(nosj);});
                                var no4 = 1;
                                $("#tbl4").find('tbody').html("");
                                var isi="";
                                $.each(data,function(index, value){
                                    var sj2 = data[index].no_sj2 == null ? '' : data[index].no_sj2;
                                    var body = "<tr><td style='width: 25px;' class='center'>"+no4+"</td><td style='width: 80px;' class='center'>"+data[index].PCODE+"</td><td style='width: 200px;' class='center'>"+data[index].PCODENAME+"</td><td  style='width: 100px;' class='center'>"+data[index].no_sj+"</td><td  style='width: 100px;' class='center'>"+sj2+"</td><td style='width:115px;' class='center'>"+data[index].no_dtb+"</td><td  style='width: 180px;' class='center'>"+data[index].no_dtb2+"</td><td style='width: 180px;' class='center'>"+data[index].no_basp+"</td><td  style='width: 20px;' class='center'>"+data[index].qty_sj+"</td><td  style='width: 20px;' class='center'>"+data[index].qty_selisih_kurang+"</td><td  style='width: 20px;' class='center'>"+data[index].qty_selisih_lebih+"</td></tr>";
                                    $("#tbl4").find('tbody').append(body);
                                    no4++;
                                    var textx= "x";
                                    var sj = nosj.concat(textx);
                                });
                             
                                
                                    
                                }

                                else
                                {
                                $("#tbll").find('thead').html("");
                                var head="<tr style='width:100%'><th class='center' style='width: 28px;'>NO</th>"+
                                "<th class='center' style='width: 54px;'>PCODE</th>"+
                                "<th class='center' style='width: 99px;'>PCODENAME</th>"+
                                "<th class='center' style='width: 72px;'>NO SJ</th>"+
                                "<th class='center' style='width: 56px;'>NO DTB</th>"+
                                "<th class='center' style='width: 56px;'>NO DTB TAMBAHAN</th>"+
                                "<th class='center' style='width: 56px;'>NO BPPR</th>"+
                                "<th class='center' style='width: 56px;'>NO BASP</th>"+
                                "<th class='center' style='width: 34px;'>Qty SJ</th>"+
                                "<th class='center' style='width: 35px;'>Qty SK</th>"+
                                "<th class='center' style='width: 35px;'>Qty SL</th></tr>";
                                $("#tbll").find('thead').append(head);
                                $('#btnreject').click(function(){
                                $("#nosjforreject").val(nosj);});
                                var no4 = 1;
                                $("#tbl4").find('tbody').html("");
                                $.each(data,function(index, value){
                                    var body = "<tr><td  style='width: 55px;' class='center'>"+no4+"</td><td style='width: 107px;' class='center'>"+data[index].PCODE+"</td><td style='width: 200px;' class='center'>"+data[index].PCODENAME+"</td><td  style='width: 148px;' class='center'>"+data[index].no_sj+"</td><td style='width:115px;' class='center'>"+data[index].no_dtb+"</td><td  style='width: 148px;' class='center'>"+data[index].no_dtb2+"</td><td  style='width: 148px;' class='center'>"+data[index].no_bppr+"</td><td style='width: 148px;' class='center'>"+data[index].no_basp+"</td><td  style='width: 67px;' class='center'>"+data[index].qty_sj+"</td><td  style='width: 70px;' class='center'>"+data[index].qty_selisih_kurang+"</td><td  style='width: 70px;' class='center'>"+data[index].qty_selisih_lebih+"</td></tr>";
                                    $("#tbl4").find('tbody').append(body);
                                    no4++;
                                });

                                }
                               
                            }
                        });
                    $("#btnproses2").click(function(){
                    $("#judulsite2").html(idsite+"-"+nmsite+"-"+nosj);
                    $("#nosjbyclick").val(nosj);  
                    });
                    });
                }
                });
            });

             
</script>

   
