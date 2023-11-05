
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
                <h2>Data Terima Barang Processed</h2>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url('index.php/dashboard');?>">Home</a></li>
                        <li><a>DTB</a></li>
                        <li class="active"><strong>DTB Processed</strong></li>
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
                        <form action="<?php echo base_url('index.php/dashboard/dtb_process');?>" id="formdtb" method="post">
                        <table width="300px" border="0">
                        <tr>
                        <td>Periode</td>
                        <td>:</td>
                        <td> <select id="period" class="form-control m-b" name="periode" style="position:relative; left:-50px; top:10px;">
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
                        <?php 
                        $tahun=date('Y');
                        for($i=2013; $i<=$tahun; $i++)
                        {?><option value="<?php echo $i?>"><?php echo $i?></option> 
                      <?php }?>
                        </select>
                        <br>
                        </td>
                        </tr>
                        <tr><td><button class="btn btn-sm btn-primary pull-center m-t-n-xs" type="submit" style="font-size:14px"><i class="fa fa-check"></i> Proses</button></td><td><button class="btn btn-sm btn-white pull-left m-t-n-xs" id="reset" type="reset" style="font-size:14px" onClick="document.location.reload(true)"><i class="fa fa-refresh"></i> Reset</button></td></tr>
                        </table>
                        </form>
                        <!-- End Tombol add,edit,delete -->
                    
                        <!-- Start Tabel -->
                        <div class="ibox-content" id="tbl1" style="display:none; border:none;">
                        <table id="example" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Site</th>
                                        <th>Nama Site</th>
                                        <th>Approve</th>
                                        <th>Reject</th>
                                        <th>Arrival</th>
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
        $('#formdtb').submit(function(){
            var period = $('#period').val();
            var year = $('#year').val();
            $.ajax({
                url: "<?php echo base_url('index.php/dashboard/getDataDtb2'); ?>",
                type: "POST",
                data: {periode : period, tahun:year},
                dataType: "json",
                success: function(data){
                    $('#tbl1').show();
                    $('#btnproses').show();
                    var no = 1;
                    $("#tbl1").find('tbody').html("");
                    $.each(data,function(index, value){
                         var approve = data[index].approve == null ? '0' : data[index].approve;
                                var reject = data[index].reject == null ? '0' : data[index].reject;
                                var arrival = data[index].arrival == null ? '0' : data[index].arrival;
                        var body = "<tr><td class='center'>"+no+"</td><td class='center'>"+data[index].kd_sap2+"</td><td class='center'>"+data[index].NM_DEPO+"</td><td class='center'>"+approve+"</td><td class='center'>"+reject+"</td><td class='center'>"+arrival+"</td></tr>";
                        $("#tbl1").find('tbody').append(body);
                        no++;
                    });
                    var table = $('#example').DataTable();
                    $('#example tbody').on('click', 'tr', function() {
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




