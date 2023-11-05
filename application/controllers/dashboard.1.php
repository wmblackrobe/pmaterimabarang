<?php 
class Dashboard extends CI_Controller{
	Public function __construct(){
        parent::__construct();
        if($this->session->userdata('status') != "login"){
			redirect(base_url("index.php/login"));
		}		
        $this->load->model('m_data');
        date_default_timezone_set("Asia/Jakarta");
	}
	
    Public function index(){
		$data['content']='contentdashboard';
        $this->load->view('main_page',$data);
    }

	//* USER HEAD OFFICE

	//__UPLOAD SURAT JALAN__//
    Public function upload_surat_jalan()
    {
		$data['content']='contentsuratjalan';
		$this->load->view('main_page',$data);
    }

    Public function import(){
		$datesekarang=date("Ymd");
		$jamsekarang=date("His");
		$namafile=$_FILES['filesj']['name'];
		$namafileup=$datesekarang."_".$jamsekarang."_sj.xlsx";
		$config['file_name']=$namafileup;
		$config['upload_path']          = 'excel/';
		$config['allowed_types']        = 'xlsx';
		$this->load->library('upload', $config);
		if($this->upload->do_upload('filesj'))
		{
			include APPPATH.'third_party/PHPExcel/PHPExcel.php';
			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load('excel/'.$namafileup);
			$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			$last_update=date('Y-m-d H:i:s');
			$idusersession=$this->session->iduser;
			$data = array();
			$numrow = 1;
			foreach($sheet as $row){
				if($numrow>1){
					if($row['A']==""){
						continue;
					}
					else{
						$cekdata2=$this->m_data->cekforexcel2($row['C'],$row['D'],$row['H'])->num_rows();
							if($cekdata2>0)
							{
								$false[] = 1;
								continue;
							}
							else{
								$data = [
									'principal'=>$row['A'], 
									'no_dokumen'=>$row['B'],
									'no_sj'=>$row['C'], 
									'tgl_sj'=>$row['D'], 
									'kd_sap2'=>$row['E'],
									'ldp'=>$row['F'],
									'PCODE'=>$row['G'],
									'qty'=>$row['H'],
									'status_sj'=>'N',
									'last_update'=> $last_update,
									'id'=>$idusersession
								];
								$query = $this->m_data->insert_multiple($data);
								if(!$query){
									$done[] = 1;
								}else{
									$false[] = 1;
								}
							
							}

					}
				}
				//die(print_r($data));

			$numrow++;		
			}
	
			if(!empty($done)){
				$tandaSukses = array_sum($done);
			}else{
				$tandaSukses = "0";
			}
			if(!empty($false)){
				$tandaGagal = array_sum($false);
			}else{
				$tandaGagal = "0";
			}
			$this->session->set_flashdata('berhasilimport', 'DATA BERHASIL DIIMPORT!<br> Data berhasil '.$tandaSukses.'<br>Data gagal :'.$tandaGagal.'<br>');
			redirect("dashboard/upload_surat_jalan");
		}
		else
		{
			$this->session->set_flashdata('gagalimport', 'DATA GAGAL DIIMPORT!'.$this->upload->display_errors());
			redirect("dashboard/upload_surat_jalan");
		}
}		
	//__END UPLOAD SURAT JALAN__//
	
	//__DTB PROSES__//
    Public function dtb_process(){
		$data['alasanforreject']= $this->m_data->getdataalasanforreject();
		$data['content']= 'contentdtbprocess';
        $this->load->view('main_page',$data);
	}
	Public function getdatasitesjprocess() {
		header("Access-Control-Allow-Origin: *");
		header('Content-Type: application/json');
		$kdsite=$this->input->post('kdsite');
		$result = $this->m_data->dtb_datasite($kdsite);
		echo json_encode($result);
	}

	Public function getDataDtb() {
		header("Access-Control-Allow-Origin: *");
		header('Content-Type: application/json');
		$periode=$this->input->post('periode');
		$tahun=$this->input->post('tahun');
		$data = $tahun.$periode;
		$result = $this->m_data->dtb_data($data);
		echo json_encode($result);
	}

	Public function getDataDtb2() {
		header("Access-Control-Allow-Origin: *");
		header('Content-Type: application/json');
		$periode=$this->input->post('periode');
		$tahun=$this->input->post('tahun');
		$data = $tahun.$periode;
		$result = $this->m_data->dtb_data2($data);
		echo json_encode($result);
	} 

	Public function getdatasjprocessbydtb() {//JSON table alasan
		header("Access-Control-Allow-Origin: *");
		$nosj=$this->input->post('no_sj');
		$caridatasj=$this->m_data->datasjprocessed($nosj);
		header('Content-Type: application/json');
		echo json_encode($caridatasj);
	}
	
	Public function updatedtbapprove()
	{
		$nosj2=$this->input->post('txtsj2');
		$nosj=$this->input->post('nosjbyclick');
		if($nosj2=="")
		{
			$update=$this->m_data->updateapprove($nosj);
			if($update)
			{
				$this->session->set_flashdata('berhasilapprove', 'Data berhasil diapprove!');
				redirect("dashboard/dtb_process"); 
			}
			else{
				$this->session->set_flashdata('gagalapprove', 'Approve Gagal!');
				redirect("dashboard/dtb_process"); 
			}
		}
		else{
			$this->m_data->updatedatatransaksi($nosj,$nosj2);
			$update=$this->m_data->updateapprove($nosj);
			if($update)
			{
				$this->session->set_flashdata('berhasilapprove', 'Data berhasil diapprove!');
				redirect("dashboard/dtb_process"); 
			}
			else{
				$this->session->set_flashdata('gagalapprove', 'Approve Gagal!');
				redirect("dashboard/dtb_process"); 
			}
		}
	}

	Public function updatedtbreject()
	{
		$idalasan=$this->input->post('alasanrow');
		$nosj=$this->input->post('nosjforreject');
		$kdsapforsj=$this->m_data->ceksap($nosj)->row_array();
		$kdsap=$kdsapforsj['kd_sap2'];
		$update=$this->m_data->updatereject($idalasan,$nosj);
		if($update)
		{
			$this->m_data->notifikasiemail($kdsap,$idalasan,$nosj);
			$this->session->set_flashdata('berhasilreject', 'Data berhasil di Reject!');
			redirect("dashboard/dtb_process"); 
		}
		else{
			$this->session->set_flashdata('gagalreject', 'Reject Gagal!');
			redirect("dashboard/dtb_process"); 
		}
	}
	//__END DTB PROSES__//

	//__DTB PROCESSED__//
	Public function dtb_processed(){
		$data['all']=$this->m_data->dtb_processall();
		$data['content']= 'contentdtbprocessed';
        $this->load->view('main_page',$data);
	}
	//__END DTB PROSESSED__//

	//__REPORT__//	
	Public function reportho() 
    {
		$data['datagreg']=$this->m_data->tampildatagreg();
        $data['content']= 'contenttablereportho';
        $this->load->view('main_page',$data);
	}
	Public function getRegion($greg)
	{
		header("Access-Control-Allow-Origin: *");
		header('Content-Type: application/json');
		$region = $this->m_data->getreg($greg)->result();
		echo json_encode($region);
	}

	Public function getArea($reg)
	{
		header("Access-Control-Allow-Origin: *");
		header('Content-Type: application/json');
		$area = $this->m_data->getarea($reg)->result();
		echo json_encode($area);
	} 

	Public function getDatareportho()
	{
		header("Access-Control-Allow-Origin: *");
		header('Content-Type: application/json');
		$principal=$this->input->post('txtprincipal');
		$grupregion=$this->input->post('txtgrupregion');
		$region=$this->input->post('txtregion');
		$area=$this->input->post('txtarea');
		$awal=$this->input->post('tglawal');
		$akhir=$this->input->post('tglakhir');
		$status=$this->input->post('status_sj');
		$result = $this->m_data->tampildatalaporanho($principal,$awal,$akhir,$status,$grupregion,$region,$area)->result();
		echo json_encode($result);
	}
	Public function getDatareport()
	{
		header("Access-Control-Allow-Origin: *");
		$awal=$this->input->post('tglawal');
		$akhir=$this->input->post('tglakhir');
		$result = $this->m_data->tampildatalaporan();
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	Public function exportreportho()
	{$principal=$this->input->post('principalexp');
		$awal=$this->input->post('awaltglexp');
		$akhir=$this->input->post('akhirtglexp');
		$status=$this->input->post('statussjexp');
		$grupregion=$this->input->post('txtgrupregionexp');
		$region=$this->input->post('txtregionexp');
		$area=$this->input->post('txtareaexp');
		include APPPATH.'third_party/PHPExcel/PHPExcel.php';
		$excel = new PHPExcel();
		$style_col = array(
			'font' => array('bold' => true),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);

		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);

		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Output Report Head Office"); 
		$excel->getActiveSheet()->mergeCells('A1:M1'); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$excel->setActiveSheetIndex(0)->setCellValue('A3', "GRBM");
		$excel->setActiveSheetIndex(0)->setCellValue('B3', "RBM"); 
		$excel->setActiveSheetIndex(0)->setCellValue('C3', "KODE CABANG"); 
		$excel->setActiveSheetIndex(0)->setCellValue('D3', "NAMA CABANG");
		$excel->setActiveSheetIndex(0)->setCellValue('E3', "NO DO");
		$excel->setActiveSheetIndex(0)->setCellValue('F3', "NO SURAT JALAN");
		$excel->setActiveSheetIndex(0)->setCellValue('G3', "TGL SURAT JALAN");
		$excel->setActiveSheetIndex(0)->setCellValue('H3', "ETA");
		$excel->setActiveSheetIndex(0)->setCellValue('I3', "NO DTB");
		$excel->setActiveSheetIndex(0)->setCellValue('J3', "TGL INPUT DTB");
		$excel->setActiveSheetIndex(0)->setCellValue('K3', "TGL INPUT PORTAL");
		$excel->setActiveSheetIndex(0)->setCellValue('L3', "SJ (ontime)");
		$excel->setActiveSheetIndex(0)->setCellValue('M3', "KODE ITEM");
		$excel->setActiveSheetIndex(0)->setCellValue('N3', "NAMA ITEM");
		$excel->setActiveSheetIndex(0)->setCellValue('O3', "QTY SJ");
		$excel->setActiveSheetIndex(0)->setCellValue('P3', "QTY TERIMA");
		$excel->setActiveSheetIndex(0)->setCellValue('Q3', "SJ SELISIH");
		$excel->setActiveSheetIndex(0)->setCellValue('R3', "NO BASP");
		$excel->setActiveSheetIndex(0)->setCellValue('S3', "NO BPPR");
		$excel->setActiveSheetIndex(0)->setCellValue('T3', "NO DTB TAMBAHAN");
		
		$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('O3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('P3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('Q3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('R3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('S3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('T3')->applyFromArray($style_col);

		$laporan = $this->m_data->tampildatalaporanho($principal,$awal,$akhir,$status,$grupregion,$region,$area)->result();
		$numrow = 4;
		foreach($laporan as $data){ 
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $data->NM_GREG);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->NM_REG);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->kd_sap2);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->NM_DEPO);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->no_dokumen);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data->no_sj);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data->tgl_sj);
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data->ETA);
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data->no_dtb);
			$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $data->tgl_inputdtb);
			$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $data->tgl_inputportal);
			$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $data->total);
			$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $data->PCODE);
			$excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $data->PCODENAME);
			$excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $data->qty_sj);
			$excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, $data->hasil);
			$excel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, $data->selisih);
			$excel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, $data->no_basp);
			$excel->setActiveSheetIndex(0)->setCellValue('S'.$numrow, $data->no_bppr);
			$excel->setActiveSheetIndex(0)->setCellValue('T'.$numrow, $data->no_dtb);

			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('Q'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('R'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('S'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('T'.$numrow)->applyFromArray($style_row);
		
			$numrow++; 
		}

		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(15); 
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); 
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('I')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('J')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('K')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('L')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('M')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('N')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('O')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('P')->setWidth(25);
		$excel->getActiveSheet()->getColumnDimension('Q')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('R')->setWidth(25);   
		$excel->getActiveSheet()->getColumnDimension('S')->setWidth(25);   
		$excel->getActiveSheet()->getColumnDimension('T')->setWidth(25);   

		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$excel->getActiveSheet(0)->setTitle("Output report-Ho");
		$excel->setActiveSheetIndex(0);
		ob_end_clean();
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="reportho.xlsx"'); 
		header('Cache-Control: max-age=0');

		$write = PHPExcel_IOFactory::createWriter($excel,'Excel2007');
		$write->save('php://output');
		ob_end_clean();
		
	}
	
	//__END_REPORT__//
	
	//__USER__//
	Public function user() //Tampil User
    {
		$username=$this->input->post('username');
		$data['datauser']= $this->m_data->tampildatauser($username);
		$data['datasite']=$this->m_data->tampildatasite();
        $data['content']= 'contenttableuser';
        $this->load->view('main_page',$data);
	}

	public function aksi_inputuser()
	{
		$depo=$this->input->post('listsite');
		$username=$this->input->post('txt-username');
		$password=$this->input->post('txt-password');
		$password2=$this->input->post('txt-konfirmasi');
		$passwordmd=md5($password);
		$email=$this->input->post('txt-email');
		$tipeuser=$this->input->post('tipeuser');
		$iduser=$this->session->nmuser;
		
		if($password2==$password)
		{
			$data=array(
				'nik'=>'22222',
				'user'=>$username,
				'password'=>$passwordmd,
				'id_depo'=>$depo,
				'tipe_user'=>$tipeuser,
				'last_update'=>date('Y-m-d H:i:s'),
				'id'=>$nmuser
			);
			$this->m_data->inputuser('user',$data);
			$this->session->set_flashdata('berhasilsimpanuser', 'Data berhasil disimpan!');
			redirect('dashboard/user');
		}

		else{
			$this->session->set_flashdata('konfirmasigagal', 'konfirmasi password gagal');
			redirect('dashboard/user');
		}

		}


	//__END USER__//

	//__EMAIL__//
	Public function email() 
    {
		$data['datadepo']= $this->m_data->tampildatadepo();
		$data['dataemail']= $this->m_data->tampildataemail();
        $data['content']= 'contenttableemail';
        $this->load->view('main_page',$data);
	}

	Public function aksi_inputemail()
	{
		$kodesite=$this->input->post('kdsite');
		$emailbm=$this->input->post('emailbm');
		$emailspv=$this->input->post('emailspv');
		$emailsa=$this->input->post('emailsa');
		$emaildim=$this->input->post('emaildim');
		$emailadim=$this->input->post('emailadim');
		$emaildps=$this->input->post('emaildps');
		$emailscm1=$this->input->post('emailscm1');
		$emailscm2=$this->input->post('emailscm2');
		$emailscm3=$this->input->post('emailscm3');
		$emailscm4=$this->input->post('emailscm4');
		$emailscm5=$this->input->post('emailscm5');
		$status='Y';
		$lastupdate=date('Y-m-d H:i:s');
		$iduser=$this->session->iduser;
		$data=array(
			'kd_sap2'=>$kodesite,
			'email_bm'=>$emailbm,
			'email_spv_log'=>$emailspv,
			'email_sa'=>$emailsa,
			'email_dim'=>$emaildim,
			'email_adim'=>$emailadim,
			'email_dps'=>$emaildps,
			'email_staff_scm_1'=>$emailscm1,
			'email_staff_scm_2'=>$emailscm2,
			'email_staff_scm_3'=>$emailscm3,
			'email_staff_scm_4'=>$emailscm4,
			'email_staff_scm_5'=>$emailscm5,
			'status'=>$status,
			'last_update'=>$lastupdate,
			'id'=>$iduser
		);
		$this->m_data->inputemailuser($data);
		$this->session->set_flashdata('berhasilsimpanemail', 'Data berhasil disimpan!');
		redirect('dashboard/email');
	}

	Public function getdataemailuser() {
		header("Access-Control-Allow-Origin: *");
		$kdsap2=$this->input->post('kd_sap2');
		$result = $this->m_data->getemail($kdsap2);
		header('Content-Type: application/json');
		echo json_encode($result);
	}

	Public function aksi_editemailuser(){
		$site=$this->input->post('editkdsite');
		$bm=$this->input->post('editemailbm');
		$spv=$this->input->post('editemailspv');
		$sa=$this->input->post('editemailsa');
		$dim=$this->input->post('editemaildim');
		$adim=$this->input->post('editemailadim');
		$dps=$this->input->post('editemaildps');
		$scm1=$this->input->post('editemailscm1');
		$scm2=$this->input->post('editemailscm2');
		$scm3=$this->input->post('editemailscm3');
		$scm4=$this->input->post('editemailscm4');
		$scm5=$this->input->post('editemailscm5');
		$waktusekarang=date("Y-m-d H:i:s");
		$iduser=$this->session->iduser;
		$data=array(
			'email_bm'=> $bm,
			'email_spv_log'=> $spv,
			'email_sa'=> $sa,
			'email_dim'=> $dim,
			'email_adim'=> $adim,
			'email_dps'=> $dps,
			'email_staff_scm_1'=> $scm1,
			'email_staff_scm_2'=> $scm2,
			'email_staff_scm_3'=> $scm3,
			'email_staff_scm_4'=> $scm4,
			'email_staff_scm_5'=> $scm5,
			'last_update'=>$waktusekarang,
			'id'=>$iduser
			);
		$update= $this->m_data->updateemail($site,$data);
		if($update)
		{
			$this->session->set_flashdata('berhasilupdateemail', 'Data berhasil diupdate!');
			redirect('dashboard/email');
		}
		else{
			die('error');
		}
	}

	Public function deleteemail($sap) {
		$this->m_data->hapusemail($sap);
		$this->session->set_flashdata('berhasilhapusemail', 'Data berhasil dihapus!');
		redirect("dashboard/email"); 
	}

	Public function importemail()
	{
		$datesekarang=date("Ymd");
		$jamsekarang=date("His");
		$namafile=$_FILES['fileexcelemail']['name'];
		$namafileup=$datesekarang."_".$jamsekarang."_email.xlsx";
		$config['file_name']=$namafileup;
		$config['upload_path']          = 'excel/';
		$config['allowed_types']        = 'xlsx';
		$this->load->library('upload', $config);
		if($this->upload->do_upload('fileexcelemail'))
		{
			include APPPATH.'third_party/PHPExcel/PHPExcel.php';
			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load('excel/'.$namafileup);
			$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			$last_update=date('Y-m-d H:i:s');
			$idusersession=$this->session->iduser;
			$data = array();
			$numrow = 1;
			foreach($sheet as $row){
				if($numrow>1){
					if($row['A']==""){
						continue;
					}
					else{
						$cekdata3=$this->m_data->cekforemail($row['A'])->num_rows();
							if($cekdata3>0)
							{
								$false[] = 1;
								continue;
							}
							else{
								$data=[
										'kd_sap2'=>$row['A'], 
										'email_bm'=>$row['C'], 
										'email_spv_log'=>$row['D'], 
										'email_sa'=>$row['E'],
										'email_dim'=>$row['F'],
										'email_adim'=>$row['G'],
										'email_dps'=>$row['H'],
										'email_staff_scm_1'=>$row['I'],
										'email_staff_scm_2'=>$row['J'],
										'email_staff_scm_3'=>$row['K'],
										'email_staff_scm_4'=>$row['L'],
										'email_staff_scm_5'=>$row['M'],
										'status'=>'N',
										'last_update'=> $last_update,
										'id'=>$idusersession
								];
								$query = $this->m_data->insert_email($data);
								if(!$query){
									$done[] = 1;
								}else{
									$false[] = 1;
								}
							}
					}
				}
			$numrow++;		
			}
	
			if(!empty($done)){
				$tandaSukses = array_sum($done);
			}else{
				$tandaSukses = "0";
			}
			if(!empty($false)){
				$tandaGagal = array_sum($false);
			}else{
				$tandaGagal = "0";
			}
			$this->session->set_flashdata('berhasilimport', 'DATA BERHASIL DIIMPORT!<br> Data berhasil '.$tandaSukses.'<br>Data gagal :'.$tandaGagal.'<br>');
			redirect("dashboard/email");
	}
	else
		{
			$this->session->set_flashdata('gagalimport', 'DATA GAGAL DIIMPORT!'.$this->upload->display_errors());
			redirect("dashboard/email");
		}
	
}

	Public function exportemail()
	{
		include APPPATH.'third_party/PHPExcel/PHPExcel.php';
		$excel = new PHPExcel();
		$style_col = array(
			'font' => array('bold' => true), 
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
			)
		);

		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
			)
		);

		$excel->setActiveSheetIndex(0)->setCellValue('A1', "Email User"); 
		$excel->getActiveSheet()->mergeCells('A1:C1'); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); 
		$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$excel->setActiveSheetIndex(0)->setCellValue('A3', "kd_sap"); 
		$excel->setActiveSheetIndex(0)->setCellValue('B3', "Depo");
		$excel->setActiveSheetIndex(0)->setCellValue('C3', "mail_bm"); 
		$excel->setActiveSheetIndex(0)->setCellValue('D3', "mail_spv_log");
		$excel->setActiveSheetIndex(0)->setCellValue('E3', "mail_sa");
		$excel->setActiveSheetIndex(0)->setCellValue('F3', "DIM");
		$excel->setActiveSheetIndex(0)->setCellValue('G3', "ADIM");
		$excel->setActiveSheetIndex(0)->setCellValue('H3', "DPS");
		$excel->setActiveSheetIndex(0)->setCellValue('I3', "STAFF SCM 1");
		$excel->setActiveSheetIndex(0)->setCellValue('J3', "STAFF SCM 2");
		$excel->setActiveSheetIndex(0)->setCellValue('K3', "STAFF SCM 3");
		$excel->setActiveSheetIndex(0)->setCellValue('L3', "STAFF SCM 4");
		$excel->setActiveSheetIndex(0)->setCellValue('M3', "STAFF SCM 5");

		$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
		
		$laporan = $this->m_data->tampildataemail()->result();
		$numrow = 4;
		foreach($laporan as $data){ 
			$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $data->kd_sap2);
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->NM_DEPO);
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->email_bm);
			$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->email_spv_log);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->email_sa);
			$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data->email_dim);
			$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data->email_adim);
			$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data->email_dps);
			$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data->email_staff_scm_1);
			$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $data->email_staff_scm_2);
			$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $data->email_staff_scm_3);
			$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $data->email_staff_scm_4);
			$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $data->email_staff_scm_5);
			
			$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
			$numrow++;
		}

		$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('F')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('G')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('H')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('I')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('J')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('K')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('L')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('M')->setWidth(25); 
		$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);		
		$excel->getActiveSheet(0)->setTitle("Email User");
		$excel->setActiveSheetIndex(0);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="reportemail.xlsx"'); 
		header('Cache-Control: max-age=0');
		$write = PHPExcel_IOFactory::createWriter($excel,'Excel2007');
		$write->save('php://output');
	}
	//__END EMAIL__//

	//__ALASAN__//
	Public function alasan()
	{
		$idalasan=$this->input->post('id_alasan');
		$data['dataalasan']=$this->m_data->tampildataalasan($idalasan);
		$data['content']='contenttablealasan';
		$this->load->view('main_page',$data);
	}

	Public function getdataalasan() {
		header("Access-Control-Allow-Origin: *");
		$idalasan=$this->input->post('id_alasan');
		$result = $this->m_data->getalasan($idalasan);
		header('Content-Type: application/json');
		echo json_encode($result);
		
	}

	Public function aksi_inputalasan()
	{
		$iduser=$this->session->iduser;
		$alasaninput=$this->input->post('txt-alasan');
		$flag=$this->input->post('flag');
		$data=array(
			'alasan'=>$alasaninput,
			'flag'=>$flag,
			'last_update'=>date('Y-m-d H:i:s'),
			'id'=>$iduser
		);
		
		$this->m_data->inputalasan($data);
		$this->session->set_flashdata('berhasilsimpanalasan', 'Data berhasil disimpan!');
		redirect ('dashboard/alasan');
	}

	Public function deleteAlasan($alasan){
		$this->m_data->hapusalasan($alasan);
		$this->session->set_flashdata('berhasilhapusalasan', 'Data berhasil dihapus!');
		redirect("dashboard/alasan"); 
	}

	Public function aksi_editalasan()
	{
		$editidalasan=$this->input->post('edit-id-alasan');
		$editflag=$this->input->post('editflag');
		$edittextalasan=$this->input->post('edit-txt-alasan');
		if(empty($editidalasan) or empty($editflag) or empty($edittextalasan))
		{
			$this->session->set_flashdata('gagaleditalasan', 'Pengisian data tidak boleh kosong!');
			redirect("dashboard/alasan"); 
		}
		else{
			$this->m_data->updatealasan($editidalasan,$edittextalasan,$editflag);
			$this->session->set_flashdata('berhasileditalasan', 'Data berhasil di update!');
			redirect('dashboard/alasan');
		}
	}

//* END USER HEAD OFFICE

//* USER AREA

//__SJ PROSES__//

Public function surat_jalan_process()
{
	$data['datapcode']=$this->m_data->tampilpcode();
	$data['datasj']=$this->m_data->tampilsuratjalan();
	$data['content']="contentsjprocess";
	$this->load->view('main_page',$data);
}

Public function getdatasj() {
	header("Access-Control-Allow-Origin: *");
	$nosj=$this->input->post('no_sj');
	$tglsj=$this->input->post('tgl_sj');
	$result = $this->m_data->getsuratjalan($nosj,$tglsj);
	header('Content-Type: application/json');
	echo json_encode($result);
}

Public function getdatasj2() {
	header("Access-Control-Allow-Origin: *");
	$nosj=$this->input->post('no_sj');
	$tglsj=$this->input->post('tgl_sj');
	$result = $this->m_data->getsuratjalan2($nosj,$tglsj);
	header('Content-Type: application/json');
	echo json_encode($result);
}


Public function getstatus() {//JSON table alasan
	header("Access-Control-Allow-Origin: *");
	$status=$this->input->post('status');
	$tgldtb=$this->input->post('tgldtb');
	header('Content-Type: application/json');
	echo json_encode($status);
}
Public function updatesjreject()
{
	$iddepo = $this->session->iddepo;
	
	$kdsap2=$this->m_data->sap($iddepo);
	$sap2=$kdsap2['kd_sap2'];
	$iduser = $this->session->iduser;
	$tglinputdtb = $this->input->post('tgldtb');
	$tglsj = $this->input->post('tglsj5');
	$statussj = $this->input->post('statussj');
	$pcode = $this->input->post('pcode');
	$pcodename = $this->input->post('pcodename');
	$qtysjedit= $this->input->post('qtysjedit');
	$qtyskedit = $this->input->post('qtyskedit');
	$qtysledit = $this->input->post('qtysledit');
	$nosjbaruedit = $this->input->post('nosjbaru');
	$nodtbbaruedit = $this->input->post('nodtbbaru');
	$nodtb2baruedit = $this->input->post('nodtb2baru');
	$nobpprbaruedit = $this->input->post('nobpprbaru');
	$nobaspbaruedit = $this->input->post('nobaspbaru');
	$sj_upload      = $_FILES['sj_upload']['name'];
	$dtb_upload      = $_FILES['dtb_upload']['name'];
	$dtb2_upload      = $_FILES['dtb2_upload']['name'];
	$bppr_upload      = $_FILES['bppr_upload']['name'];
	$basp_upload      = $_FILES['basp_upload']['name'];
	$sj = $this->input->post('sj');
	$tglsekarang=date("Y-m-d H:i:s");
	$datesekarang=date('Ymd');
	$jamsekarang=date('His');



	$updatedeletetransaksi=$this->m_data->deletesjtransaksi($nosjbaruedit);

	$config = array();
	$namasj=$sap2."_SJ_".$datesekarang."_".$jamsekarang.".pdf";
	$config['file_name']=$namasj;
    $config['upload_path'] = './pdf/sj/';
    $config['allowed_types'] = 'pdf';
    $config['max_size'] = '100000';
    $config['max_width'] = '1024';
    $config['max_height'] = '768';
    $this->load->library('upload', $config, 'sjupload'); // Create custom object for cover upload
    $this->sjupload->initialize($config);
    $upload_sj = $this->sjupload->do_upload('sj_upload');

    // dtb upload
	$config = array();
	$namadtb=$sap2."_DTB_".$datesekarang."_".$jamsekarang.".pdf";
	$config['file_name']=$namadtb;
    $config['upload_path'] = './pdf/dtb';
    $config['allowed_types'] = 'pdf';
    $config['max_size'] = '1000000';
    $this->load->library('upload', $config, 'dtbupload');  // Create custom object for catalog upload
    $this->dtbupload->initialize($config);
	$upload_dtb = $this->dtbupload->do_upload('dtb_upload');

	$config = array();
	$namadtb2=$sap2."_DTB2_".$datesekarang."_".$jamsekarang.".pdf";
	$config['file_name']=$namadtb2;
    $config['upload_path'] = './pdf/dtb2';
    $config['allowed_types'] = 'pdf';
    $config['max_size'] = '1000000';
    $this->load->library('upload', $config, 'dtb2upload');  // Create custom object for catalog upload
    $this->dtb2upload->initialize($config);
	$upload_dtb2 = $this->dtb2upload->do_upload('dtb2_upload');
	
	 // bppr upload
	 $config = array();
	 $namabppr=$sap2."_BPPR_".$datesekarang."_".$jamsekarang.".pdf";
	$config['file_name']=$namabppr;
	 $config['upload_path'] = './pdf/bppr';
	 $config['allowed_types'] = 'pdf';
	 $config['max_size'] = '1000000';
	 $this->load->library('upload', $config, 'bpprupload');  // Create custom object for catalog upload
	 $this->bpprupload->initialize($config);
	 $upload_bppr = $this->bpprupload->do_upload('bppr_upload');

	 // basp upload
	 $config = array();
	 $namabasp=$sap2."_BASP_".$datesekarang."_".$jamsekarang.".pdf";
		$config['file_name']=$namabasp;
	 $config['upload_path'] = './pdf/basp';
	 $config['allowed_types'] = 'pdf';
	 $config['max_size'] = '1000000';
	 $this->load->library('upload', $config, 'baspupload');  // Create custom object for catalog upload
	 $this->baspupload->initialize($config);
	 $upload_basp = $this->baspupload->do_upload('basp_upload');
 
	if(empty($upload_sj) || empty($upload_dtb) || empty($upload_dtb2) || empty($upload_bppr) || empty($upload_basp))
	{
	
	}
	elseif (!$upload_sj && !$upload_dtb) {
      $sj_data = $this->sjupload->data();
      print_r($sj_data);

      $dtb_data = $this->dtbupload->data();          
      print_r($dtb_data);
	} 

	elseif (!$upload_sj && !$upload_dtb &&  !$upload_bppr &&  !$upload_basp) {

		$sj_data = $this->sjupload->data();
		print_r($sj_data);
  
		$dtb_data = $this->dtbupload->data();          
		print_r($dtb_data);

		$bppr_data = $this->bpprupload->data();
		print_r($bppr_data);
  
		$basp_data = $this->baspupload->data();          
		print_r($basp_data);
	  } 
	  elseif (!$upload_sj && !$upload_dtb &&  !$upload_dtb2 &&  !$upload_basp) {

		$sj_data = $this->sjupload->data();
		print_r($sj_data);
  
		$dtb_data = $this->dtbupload->data();          
		print_r($dtb_data);

		$dtb2_data = $this->dtb2upload->data();
		print_r($dtb2_data);
  
		$basp_data = $this->baspupload->data();          
		print_r($basp_data);
	  } 

	  elseif (!$upload_sj && !$upload_dtb &&  !$upload_dtb2 &&  !$upload_bppr &&  !$upload_basp) {

		$sj_data = $this->sjupload->data();
		print_r($sj_data);
  
		$dtb_data = $this->dtbupload->data();          
		print_r($dtb_data);

		$dtb2_data = $this->dtb2upload->data();
		print_r($dtb2_data);

		$bppr_data = $this->bpprupload->data();
		print_r($bppr_data);
  
		$basp_data = $this->baspupload->data();          
		print_r($basp_data);
	  } 
	 
	else {
      echo 'sj upload Error : ' . $this->sjupload->display_errors() . '<br/>';
      echo 'dtb upload Error : ' . $this->dtbupload->display_errors() . '<br/>';
    }


	if($updatedeletetransaksi)
	{
		if($statussj=="selisih kurang")
	{
		$this->m_data->gantistatussj($nosjbaruedit);
		for($i=0; $i<count($pcode); $i++){
			$this->m_data->uploadTbsk($iddepo,$pcode[$i],$nosjbaruedit,$nodtbbaruedit,$nobpprbaruedit,$nobaspbaruedit,$qtysjedit[$i],$qtyskedit[$i],$qtysledit[$i],$statussj,$tglinputdtb,$tglsekarang,$iduser);
		}
		$this->m_data->uploaddataTbsk2($nosjbaruedit,$namasj,$namadtb,$namabppr,$namabasp,$tglsekarang,$iduser);
		$this->m_data->masukapprove2($nosjbaruedit);
		redirect('dashboard/surat_jalan_processed');
	}
	elseif($statussj=="selisih lebih")
	{
		$this->m_data->gantistatussj($nosjbaruedit);
		for($i=0; $i < count($pcode); $i++){
			$this->m_data->uploadTbsl($iddepo,$pcode[$i],$nosjbaruedit,$nodtbbaruedit,$nodtb2baruedit,$nobaspbaruedit,$qtysjedit[$i],$qtyskedit[$i],$qtysledit[$i],$statussj,$tglinputdtb,$tglsekarang,$iduser);
		}
	
		$this->m_data->uploaddataTbsl2($nosjbaruedit,$namasj,$namadtb,$namadtb2,$namabasp,$tglsekarang,$iduser);
		$this->m_data->masukapprove2($nosjbaruedit);
		redirect('dashboard/surat_jalan_processed');
	}
	elseif($statussj=="selisih variant")
	{
		$this->m_data->gantistatussj($nosjbaruedit);
		for($i=0; $i < count($pcode); $i++){
			$this->m_data->uploadTbsv($iddepo,$pcode[$i],$nosjbaruedit,$nodtbbaruedit,$nodtb2baruedit,$nobpprbaruedit,$nobaspbaruedit,$qtysjedit[$i],$qtyskedit[$i],$qtysledit[$i],$statussj,$tglinputdtb,$tglsekarang,$iduser);
		}
		
		$this->m_data->uploaddataTbsv2($nosjbaruedit,$namasj,$namadtb,$namadtb2,$namabppr,$namabasp,$tglsekarang,$iduser);
		$this->m_data->masukapprove2($nosjbaruedit);
		redirect('dashboard/surat_jalan_processed');
	}
	else
	{
		$this->m_data->gantistatussj($nosjbaruedit);
		$this->m_data->uploaddataTbsesuai2($nosjbaruedit,$namasj,$namadtb,$tglsekarang,$iduser);
		$this->m_data->uploadTbsesuai($iddepo,$nosjbaruedit,$nodtbbaruedit,$statussj,$tglinputdtb,$tglsekarang,$iduser);
		$this->m_data->masukapprove2($nosjbaruedit);
		redirect('dashboard/surat_jalan_processed');
	}

	}
	else{
		echo "gagal";
	}
}
Public function updateterimabarang() {
	$iddepo = $this->session->iddepo;
	$kdsap2=$this->m_data->sap($iddepo);
	$sap2=$kdsap2['kd_sap2'];
	$iduser = $this->session->iduser;
	$tglinputdtb = $this->input->post('tgldtb5');
	$tglsj = $this->input->post('tglsj5');
	$statussj = $this->input->post('statussj5');
	$cekpcode = $this->input->post('pcode');
	$pcodename = $this->input->post('pcodename');
	$nosjedit = $this->input->post('nosjedit');
	$qtysjedit= $this->input->post('qtysjedit');
	$qtyskedit = $this->input->post('qtyskedit');
	$qtysledit = $this->input->post('qtysledit');
	$nosjbaruedit = $this->input->post('nosjbaru');
	$nodtbbaruedit = $this->input->post('nodtbbaru');
	$nodtb2baruedit = $this->input->post('nodtb2baru');
	$nobpprbaruedit = $this->input->post('nobpprbaru');
	$nobaspbaruedit = $this->input->post('nobaspbaru');
	$sj_upload      = $_FILES['sj_upload']['name'];
	$dtb_upload      = $_FILES['dtb_upload']['name'];
	$dtb2_upload      = $_FILES['dtb2_upload']['name'];
	$bppr_upload      = $_FILES['bppr_upload']['name'];
	$basp_upload      = $_FILES['basp_upload']['name'];
	$sj = $this->input->post('sj');
	$tglsekarang=date("Y-m-d H:i:s");
	$datesekarang=date('Ymd');
	$jamsekarang=date('His');

	$config = array();
	$namasj=$sap2."_SJ_".$datesekarang."_".$jamsekarang.".pdf";
	$config['file_name']=$namasj;
    $config['upload_path'] = './pdf/sj/';
    $config['allowed_types'] = 'pdf';
    $config['max_size'] = '100000';
    $config['max_width'] = '1024';
    $config['max_height'] = '768';
    $this->load->library('upload', $config, 'sjupload'); // Create custom object for cover upload
    $this->sjupload->initialize($config);
    $upload_sj = $this->sjupload->do_upload('sj_upload');

    // dtb upload
	$config = array();
	$namadtb=$sap2."_DTB_".$datesekarang."_".$jamsekarang.".pdf";
	$config['file_name']=$namadtb;
    $config['upload_path'] = './pdf/dtb';
    $config['allowed_types'] = 'pdf';
    $config['max_size'] = '1000000';
    $this->load->library('upload', $config, 'dtbupload');  // Create custom object for catalog upload
    $this->dtbupload->initialize($config);
	$upload_dtb = $this->dtbupload->do_upload('dtb_upload');

	$config = array();
	$namadtb2=$sap2."_DTB2_".$datesekarang."_".$jamsekarang.".pdf";
	$config['file_name']=$namadtb2;
    $config['upload_path'] = './pdf/dtb2';
    $config['allowed_types'] = 'pdf';
    $config['max_size'] = '1000000';
    $this->load->library('upload', $config, 'dtb2upload');  // Create custom object for catalog upload
    $this->dtb2upload->initialize($config);
	$upload_dtb2 = $this->dtb2upload->do_upload('dtb2_upload');
	
	 // bppr upload
	 $config = array();
	 $namabppr=$sap2."_BPPR_".$datesekarang."_".$jamsekarang.".pdf";
	$config['file_name']=$namabppr;
	 $config['upload_path'] = './pdf/bppr';
	 $config['allowed_types'] = 'pdf';
	 $config['max_size'] = '1000000';
	 $this->load->library('upload', $config, 'bpprupload');  // Create custom object for catalog upload
	 $this->bpprupload->initialize($config);
	 $upload_bppr = $this->bpprupload->do_upload('bppr_upload');

	 // basp upload
	 $config = array();
	 $namabasp=$sap2."_BASP_".$datesekarang."_".$jamsekarang.".pdf";
	$config['file_name']=$namabasp;
	 $config['upload_path'] = './pdf/basp';
	 $config['allowed_types'] = 'pdf';
	 $config['max_size'] = '1000000';
	 $this->load->library('upload', $config, 'baspupload');  // Create custom object for catalog upload
	 $this->baspupload->initialize($config);
	 $upload_basp = $this->baspupload->do_upload('basp_upload');
 
	if(empty($upload_sj) || empty($upload_dtb) || empty($upload_dtb2) || empty($upload_bppr) || empty($upload_basp))
	{
	
	}
	elseif (!$upload_sj && !$upload_dtb) {
      $sj_data = $this->sjupload->data();
      print_r($sj_data);

      $dtb_data = $this->dtbupload->data();          
      print_r($dtb_data);
	} 

	elseif (!$upload_sj && !$upload_dtb &&  !$upload_bppr &&  !$upload_basp) {

		$sj_data = $this->sjupload->data();
		print_r($sj_data);
  
		$dtb_data = $this->dtbupload->data();          
		print_r($dtb_data);

		$bppr_data = $this->bpprupload->data();
		print_r($bppr_data);
  
		$basp_data = $this->baspupload->data();          
		print_r($basp_data);
	  } 
	  elseif (!$upload_sj && !$upload_dtb &&  !$upload_dtb2 &&  !$upload_basp) {

		$sj_data = $this->sjupload->data();
		print_r($sj_data);
  
		$dtb_data = $this->dtbupload->data();          
		print_r($dtb_data);

		$dtb2_data = $this->dtb2upload->data();
		print_r($dtb2_data);
  
		$basp_data = $this->baspupload->data();          
		print_r($basp_data);
	  } 

	  elseif (!$upload_sj && !$upload_dtb &&  !$upload_dtb2 &&  !$upload_bppr &&  !$upload_basp) {

		$sj_data = $this->sjupload->data();
		print_r($sj_data);
  
		$dtb_data = $this->dtbupload->data();          
		print_r($dtb_data);

		$dtb2_data = $this->dtb2upload->data();
		print_r($dtb2_data);

		$bppr_data = $this->bpprupload->data();
		print_r($bppr_data);
  
		$basp_data = $this->baspupload->data();          
		print_r($basp_data);
	  } 
	 
	else {
      echo 'sj upload Error : ' . $this->sjupload->display_errors() . '<br/>';
      echo 'dtb upload Error : ' . $this->dtbupload->display_errors() . '<br/>';
    }

	if($statussj=="selisih kurang")
	{
		for($i=0; $i < count($pcode); $i++){
			$this->m_data->uploadTbsk($iddepo,$pcode[$i],$nosjbaruedit,$nodtbbaruedit,$nobpprbaruedit,$nobaspbaruedit,$qtysjedit[$i],$qtyskedit[$i],$qtysledit[$i],$statussj,$tglinputdtb,$tglsekarang,$iduser);
		}
		if(empty($upload_sj) || empty($upload_dtb) || empty($upload_bppr) || empty($upload_basp))
		{
			$this->session->set_flashdata('gagalupload', ' Gagal ! Data yang diupload kurang lengkap!');
			redirect('dashboard/surat_jalan_process');
		}
		else{
		$this->m_data->gantistatussj($nosjbaruedit);
		$this->m_data->uploaddataTbsk($nosjbaruedit,$namasj,$namadtb,$namabppr,$namabasp,$tglsekarang,$iduser);
		$this->m_data->masukapprove($nosjbaruedit);
		$this->session->set_flashdata('berhasilupdate', 'NO SJ :'.$nosjbaruedit.' BERHASIL DIPROSES!');
		redirect('dashboard/surat_jalan_process');
		}
	}
	elseif($statussj=="selisih lebih")
	{
		for($i=0; $i < count($cekpcode); $i++){
			$this->m_data->uploadTbsl($iddepo,$pcode[$i],$nosjbaruedit,$nodtbbaruedit,$nodtb2baruedit,$nobaspbaruedit,$qtysjedit[$i],$qtyskedit[$i],$qtysledit[$i],$statussj,$tglinputdtb,$tglsekarang,$iduser);
		}
		$this->m_data->gantistatussj($nosjbaruedit);
		$this->m_data->uploaddataTbsl($nosjbaruedit,$namasj,$namadtb,$namadtb2,$namabasp,$tglsekarang,$iduser);
		$this->m_data->masukapprove($nosjbaruedit);
		$this->session->set_flashdata('berhasilupdate', 'NO SJ :'.$nosjbaruedit.' BERHASIL DIPROSES!');
		redirect('dashboard/surat_jalan_process');
	}
	elseif($statussj=="selisih variant")
	{
		for($i=0; $i < count($pcode); $i++){
			$this->m_data->uploadTbsv($iddepo,$pcode[$i],$nosjbaruedit,$nodtbbaruedit,$nodtb2baruedit,$nobpprbaruedit,$nobaspbaruedit,$qtysjedit[$i],$qtyskedit[$i],$qtysledit[$i],$statussj,$tglinputdtb,$tglsekarang,$iduser);
		}
		$this->m_data->gantistatussj($nosjbaruedit);
		$this->m_data->uploaddataTbsv($nosjbaruedit,$namasj,$namadtb,$namadtb2,$namabppr,$namabasp,$tglsekarang,$iduser);
		$this->m_data->masukapprove($nosjbaruedit);
		$this->session->set_flashdata('berhasilupdate', 'NO SJ :'.$nosjbaruedit.' BERHASIL DIPROSES!');
		redirect('dashboard/surat_jalan_process');
	}
	else
	{
		$this->m_data->gantistatussj($nosjbaruedit);
		$this->m_data->uploaddataTbsesuai($nosjbaruedit,$namasj,$namadtb,$tglsekarang,$iduser);
		$this->m_data->uploadTbsesuai($iddepo,$nosjbaruedit,$nodtbbaruedit,$statussj,$tglinputdtb,$tglsekarang,$iduser);
		$this->m_data->masukapprove($nosjbaruedit);
		$this->session->set_flashdata('berhasilupdate', 'NO SJ :'.$nosjbaruedit.' BERHASIL DIPROSES!');
		redirect('dashboard/surat_jalan_process');
	}
}

//__END SJ PROSES__//

//_SJ PROCESSED__//
Public function surat_jalan_processed()
		{
			$data['datapcode']=$this->m_data->tampilpcode();
			$data['content']='contentsjprocessed';
			$this->load->view('main_page',$data);
		}
	
Public function getDatasjprocessed()
		{
			header("Access-Control-Allow-Origin: *");
			header('Content-Type: application/json');
			
			$tglawal=$this->input->post('tglawal');
			$tglakhir=$this->input->post('tglakhir');
			$status=$this->input->post('status');
			$result = $this->m_data->sjpro_data($tglawal,$tglakhir,$status);
			echo json_encode($result);
		}

Public function reportarea() 
    {
		$data['datagreg']=$this->m_data->tampildatagreg();
        $data['content']= 'contenttablereportarea';
        $this->load->view('main_page',$data);
	}


Public function exportreportarea()
{
	$principal=$this->input->post('principalexp');
	$awal=$this->input->post('awaltglexp');
	$akhir=$this->input->post('akhirtglexp');
	$status=$this->input->post('statussjexp');
	include APPPATH.'third_party/PHPExcel/PHPExcel.php';
	$excel = new PHPExcel();
	$style_col = array(
		'font' => array('bold' => true), 
		'alignment' => array(
			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
		),
		'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
		)
	);

	
	$style_row = array(
		'alignment' => array(
			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER 
		),
		'borders' => array(
			'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
			'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
			'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), 
			'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) 
		)
	);

	$excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA INDIKATOR USER"); 
	$excel->getActiveSheet()->mergeCells('A1:C1'); 
	$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); 
	$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15);
	$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 


	$excel->setActiveSheetIndex(0)->setCellValue('A3', "KODE CABANG"); 
	$excel->setActiveSheetIndex(0)->setCellValue('B3', "NAMA CABANG");
	$excel->setActiveSheetIndex(0)->setCellValue('C3', "N0 DO"); 
	$excel->setActiveSheetIndex(0)->setCellValue('D3', "NO SURAT JALAN");
	$excel->setActiveSheetIndex(0)->setCellValue('E3', "TGL SURAT JALAN");
	$excel->setActiveSheetIndex(0)->setCellValue('F3', "ETA DATE");
	$excel->setActiveSheetIndex(0)->setCellValue('G3', "NO DTB");
	$excel->setActiveSheetIndex(0)->setCellValue('H3', "TGL INPUT DTB");
	$excel->setActiveSheetIndex(0)->setCellValue('I3', "TGL INPUT PORTAL");
	$excel->setActiveSheetIndex(0)->setCellValue('J3', "ON TIME (TGL DTB vs TGL INPUT)");
	$excel->setActiveSheetIndex(0)->setCellValue('K3', "KODE ITEM");
	$excel->setActiveSheetIndex(0)->setCellValue('L3', "NAMA ITEM");
	$excel->setActiveSheetIndex(0)->setCellValue('M3', "QTY SJ");
	$excel->setActiveSheetIndex(0)->setCellValue('N3', "QTY TERIMA");
	$excel->setActiveSheetIndex(0)->setCellValue('O3', "SJ SELISIH");
	$excel->setActiveSheetIndex(0)->setCellValue('P3', "NO BASP");
	$excel->setActiveSheetIndex(0)->setCellValue('Q3', "NO BPPR");
	$excel->setActiveSheetIndex(0)->setCellValue('R3', "NO DTB TAMBAHAN");
	
	$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('O3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('P3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('Q3')->applyFromArray($style_col);
	$excel->getActiveSheet()->getStyle('R3')->applyFromArray($style_col);
	
	$row = $this->m_data->tampildatalaporanarea($principal,$awal,$akhir,$status)->result();
	$no = 1;
	$numrow = 4; 
	foreach($row as $data){ 
		$excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $data->kd_sap2);
		$excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data->NM_DEPO);
		$excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data->no_dokumen);
		$excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data->no_sj);
		$excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data->tgl_sj);
		$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data->ETA);
		$excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data->no_dtb);
		$excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data->tgl_inputdtb);
		$excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data->tgl_inputportal);
		$excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $data->total);
		$excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $data->PCODE);
		$excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $data->PCODENAME);
		$excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $data->qty_sj);
		$excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $data->hasil);
		$excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $data->selisih);
		$excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, $data->no_basp);
		$excel->setActiveSheetIndex(0)->setCellValue('Q'.$numrow, $data->no_bppr);
		$excel->setActiveSheetIndex(0)->setCellValue('R'.$numrow, $data->no_dtb2);

		$excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('Q'.$numrow)->applyFromArray($style_row);
		$excel->getActiveSheet()->getStyle('R'.$numrow)->applyFromArray($style_row);

		$no++; 
		$numrow++; 
	}

	$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
	$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); 
	$excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
	$excel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
	$excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);  
	$excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);  
	$excel->getActiveSheet()->getColumnDimension('G')->setWidth(5); 
	$excel->getActiveSheet()->getColumnDimension('H')->setWidth(15); 
	$excel->getActiveSheet()->getColumnDimension('I')->setWidth(25); 
	$excel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
	$excel->getActiveSheet()->getColumnDimension('K')->setWidth(25);  
	$excel->getActiveSheet()->getColumnDimension('L')->setWidth(25);  
	$excel->getActiveSheet()->getColumnDimension('M')->setWidth(5); 
	$excel->getActiveSheet()->getColumnDimension('N')->setWidth(15); 
	$excel->getActiveSheet()->getColumnDimension('O')->setWidth(25); 
	$excel->getActiveSheet()->getColumnDimension('P')->setWidth(25);
	$excel->getActiveSheet()->getColumnDimension('Q')->setWidth(25);  
	$excel->getActiveSheet()->getColumnDimension('R')->setWidth(25);  

	$excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
	$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
	$excel->getActiveSheet(0)->setTitle("reportarea");
	$excel->setActiveSheetIndex(0);
	ob_end_clean();
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment; filename="report_area.xlsx"'); // Set nama file excel nya
	header('Cache-Control: max-age=0');

	$write = PHPExcel_IOFactory::createWriter($excel,'Excel2007');
	$write->save('php://output');
	ob_end_clean();
}

Public function getDatareportarea()
{
	header("Access-Control-Allow-Origin: *");
	header('Content-Type: application/json');
	$principal=$this->input->post('principalsj');
	$awal=$this->input->post('tglawal');
	$akhir=$this->input->post('tglakhir');
	$status=$this->input->post('status_sj');
	$result = $this->m_data->tampildatalaporanarea($principal,$awal,$akhir,$status)->result();
	echo json_encode($result);
}
//__END SJ PROCESSED__//

//* END USER AREA
}
?>

