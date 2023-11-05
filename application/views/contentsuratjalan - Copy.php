<link href="<?php echo base_url();?>assets/dashboard/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
<script src="<?php echo base_url('assets/excel/js/jquery.min.js'); ?>"></script>

	<script>
	$(document).ready(function(){
		// Sembunyikan alert validasi kosong
		$("#kosong").hide();
	});
	</script>

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
                               <!-- END Notifikasi -->
                <!-- Syarat Upload -->
                    <ol>
                        <li>Format File (.xlsx)</li>
                        <li>File tidak boleh lebih dari 5 Mb </li>
                        <li>File template dapat di download <a href="<?php echo base_url("excel/formatsuratjalan.xlsx" );?>" >Disini</a></li>
                    </ol>
                <!-- End Syarat Upload -->

                <!-- Tombol Upload File -->
                <form method='post' onSubmit="return validateForm()" action="<?php echo base_url('index.php/dashboard/upload_surat_jalan');?>" enctype="multipart/form-data">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <span class="btn btn-default btn-file"><input id="filesj" type="file" name="filesj"/></span>
                    <span class="fileinput-filename"></span> <button  class="btn btn-sm btn-primary m-t-n-xs" id='previewsj' name="preview" type="submit" value="preview"><strong>Preview</strong></button>
                </div> </form>
               
                <!-- END Tombol Upload File -->

                <br><br>
                <!-- Priview data excel sebelum diupload -->
                    <?php
                   if(isset($_POST['preview'])){ // Jika user menekan tombol Preview pada form 
                    ?>
                    <input type="hidden" name="filenamesj">
                    <?php 
            		if(isset($upload_error)){ // Jika proses upload gagal
            			echo "<div style='color: red;'>".$upload_error."</div>"; // Muncul pesan error upload
            			die; // stop skrip
            		}
            		
            		// Buat sebuah tag form untuk proses import data ke database
            		echo "<form method='post' action='".base_url("index.php/dashboard/import")."'>";
            		
            		// Buat sebuah div untuk alert validasi kosong
            		echo "<div style='color: red;' id='kosong'>
            		Semua data belum diisi, Ada <span id='jumlah_kosong'></span> data yang belum diisi.
            		</div>";
            		
                    echo "
                    <table class='table table-striped table-bordered table-hover dataTables-example' >
                                            <thead>
                                            <tr>
                                            <th>PRINCIPAL</th>
                                            <th>NO DO</th>
                                            <th>NO SJ</th>
                                            <th>TGL SJ</th>
                                            <th>KODE PMA</th>
                                            <th>PMA</th>
                                            <th>LDP</th>
                                            <th>KODE ITEM</th>
                                            <th>METERIAL</th>
                                            <th>QTY</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                   ";
            		$numrow = 1;
            		$kosong = 0;
            		
            		// Lakukan perulangan dari data yang ada di excel
            		// $sheet adalah variabel yang dikirim dari controller
            		foreach($sheet as $row){ 
            			// Ambil data pada excel sesuai Kolom
            			$principal = $row['A']; // Ambil data NIS
                        $nodo = $row['B']; // Ambil data nama
                        $nosj = $row['C']; // Ambil data alamat
            			$tglsj = $row['D']; // Ambil data jenis kelamin
                        $kodepma = $row['E']; // Ambil data alamat
                        $pma = $row['F']; // Ambil data alamat
                        $ldp = $row['G']; // Ambil data alamat
                        $kodeitem = $row['H']; // Ambil data alamat
                        $material = $row['I']; // Ambil data alamat
                        $qty = $row['J']; // Ambil data alamat

            			// Cek jika semua data tidak diisi
            			if(empty($principal) && empty($nodo) && empty($nosj) && empty($tglsj)  && empty($kodepma)  && empty($pma)  && empty($ldp)  && empty($kodeitem)  && empty($material)  && empty($qty))
            				continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
            			
            			// Cek $numrow apakah lebih dari 1
            			// Artinya karena baris pertama adalah nama-nama kolom
            			// Jadi dilewat saja, tidak usah diimport
            			if($numrow > 1){
            				// Validasi apakah semua data telah diisi
            				$principal_td = ( ! empty($principal))? "" : " style='background: #E07171;'"; // Jika NIS kosong, beri warna merah
            				$nodo_td = ( ! empty($nodo))? "" : " style='background: #E07171;'"; // Jika Nama kosong, beri warna merah
            				$nosj_td = ( ! empty($nosj))? "" : " style='background: #E07171;'"; // Jika Jenis Kelamin kosong, beri warna merah
                            $tglsj_td = ( ! empty($tglsj))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
                            $kodepma_td = ( ! empty($kodepma))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
                            $pma_td = ( ! empty($pma))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
                            $ldp_td = ( ! empty($ldp))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
                            $kodeitem_td = ( ! empty($kodeitem))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
                            $material_td = ( ! empty($material))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
                            $qty_td = ( ! empty($qty))? "" : " style='background: #E07171;'"; // Jika Alamat kosong, beri warna merah
            				
            				// Jika salah satu data ada yang kosong
            				if(empty($principal) or empty($nodo) or empty($nosj) or empty($tglsj) or empty($kodepma) or empty($pma) or empty($ldp) or empty($kodeitem) or empty($material) or empty($qty)){
            					$kosong++; // Tambah 1 variabel $kosong
            				}
            				
            				echo "<tr>";
            				echo "<td".$principal_td.">".$principal."</td>";
            				echo "<td".$nodo_td.">".$nodo."</td>";
            				echo "<td".$nosj_td.">".$nosj."</td>";
                            echo "<td".$tglsj_td.">".$tglsj."</td>";
                            echo "<td".$kodepma_td.">".$kodepma."</td>";
                            echo "<td".$pma_td.">".$pma."</td>";
                            echo "<td".$ldp_td.">".$ldp."</td>";
                            echo "<td".$kodeitem_td.">".$kodeitem."</td>";
                            echo "<td".$material_td.">".$material."</td>";
                            echo "<td".$qty_td.">".$qty."</td>";
            				echo "</tr>";
            			}
            			
            			$numrow++; // Tambah 1 setiap kali looping
            		}
            		
            		echo "</table>";
            		
            		// Cek apakah variabel kosong lebih dari 0
            		// Jika lebih dari 0, berarti ada data yang masih kosong
            		if($kosong > 0){
            		?>	
            			<script>
            			$(document).ready(function(){
            				// Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
            				$("#jumlah_kosong").html('<?php echo $kosong; ?>');
            				
            				$("#kosong").hide(); // Munculkan alert validasi kosong
            			});
            			</script>
            		<?php
            		}else{ // Jika semua data sudah diisi
            			echo "<hr>";
            			// Buat sebuah tombol untuk mengimport data ke database
            			echo "<input class='btn btn-sm btn-primary pull-left m-t-n-xs' type='submit' value='import'>";
            			echo "<a href='".base_url("index.php/dashboard/upload_surat_jalan")."'>  Cancel</a>";
            		}
            		echo "</form>";
            	}
            	?>
                END priview data Excel
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
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
            ]
        });

    });

    function validateForm()
    {
        function hasExtension(inputID, exts) {
            var fileName = document.getElementById(inputID).value;
            return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
        }

        if(!hasExtension('filesj', ['.xlsx'])){
            alert("Hanya file XLSX (Excel 2007) yang diijinkan.");
            redirect('dashboard/upload_surat_jalan');
        }
    }

    $('#previewsj').click(function(){

    });
</script>


