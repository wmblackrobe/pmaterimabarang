<?php 
date_default_timezone_set("Asia/Jakarta");
class M_data extends CI_Model{	

	// LOGIN //
	Public function cek_login($table,$where){		
		return $this->db->get_where($table,$where);
	}
	
	Public function cekuser($username)
	{
		return $this->db->query("select user from user where user=? and tipe_user between 'user_depo' and 'user_ho_tb'",[$username])->row_array();
	}

	Public function resetpassword($user)
	{
		$passwordbaru=md5('pma123');
		return $this->db->query("update user set password=? where user=?",[$passwordbaru,$user]);
	}

	Public function gantipassword($username,$password)
	{
		$user='autoresetpass';
		$lastupdate=date('Y-m-d H:i:s');
		return $this->db->query("update user set password=?,last_update=?,user_update=? where user=?",[$password,$user,$lastupdate,$username]);
	}
	// END LOGIN //

	// DASHBOARD //
		// HEAD OFFICE //
		// UPLOAD FILE SJ//
	Public function upload_file($filename){
		$this->load->library('upload');
		$config['upload_path'] = './excel/';
		$config['allowed_types'] = 'xlsx';
		$config['max_size']	= '5048';
		$config['overwrite'] = true;
		$config['file_name'] = $filename;
		$this->upload->initialize($config); 
		if($this->upload->do_upload('file')){
			$return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
			return $return;
		}else{//Jika gagal
			$return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
			redirect('dashboard/upload_surat_jalan');
		}
	}
	
	Public function cekforexcel2($nosj,$tglsj,$pcode)
	{
		return $this->db->query("select * from upload_sj where no_sj=? AND tgl_sj=? AND PCODE=?",[$nosj,$tglsj,$pcode]);
	}

	Public function cekforemail($kdsap2)
	{
		return $this->db->query("select * from email_user where kd_sap2=?",[$kdsap2]);
	}
	Public function insert_multiple($data){	//  Buat sebuah fungsi untuk melakukan insert lebih dari 1 data
		$this->db->insert('upload_sj', $data);
		// $this->db->insert_batch('upload_sj', $data);
	}
	Public function insert_email($data){	//  Buat sebuah fungsi untuk melakukan insert lebih dari 1 data
		$this->db->insert('email_user', $data);
	}

	Public function tampildataemail()
	{
		return $this->db->query("SELECT * from email_user INNER JOIN rdepo ON rdepo.kd_sap2=email_user.kd_sap2 where status='Y' ");
	}
	Public function tampildatadepo()
	{
		return $this->db->query("SELECT * from rdepo");
	}

	Public function inputemailuser($data)
	{
		return $this->db->insert('email_user',$data);
	}

	Public function cekdepoforinputemail($kodesite)
	{
		return $this->db->query("select * from rdepo where kd_sap2=?",[$kodesite]);
	}

	Public function cekdataduplicate($nosj,$tglsj,$kdsap2,$pcode)
	{
		return $this->db->query("select * from upload_sj where no_sj=? and tgl_sj=? and kd_sap2=? and pcode=? ",[$nosj,$tglsj,$kdsap2,$pcode])->row_array();
	}
	Public function updateapprove($nosj)
	{
		$dbtranssj=$this->db->query("SELECT * from transaksi_sj where no_sj =? GROUP BY no_sj",[$nosj])->row_array();
		$iduser=$this->session->iduser;
		$now=date('Y-m-d H:i:s');
		$depo= $dbtranssj['Id_Depo'];
		$keterangan= $dbtranssj['keterangan'];
		return $this->db->query("update approve_sj set Id_Depo=?, status=?, keterangan=?, last_update=?,id=? where no_sj=?",[$depo,'approve',$keterangan,$now,$iduser,$nosj]);
	}

	Public function masukapprove($nosj)
	{
		$dbtranssj=$this->db->query("SELECT * from transaksi_sj where no_sj =? GROUP BY no_sj",[$nosj])->row_array();
		$iduser=$this->session->iduser;
		$now=date('Y-m-d H:i:s');
		$depo= $dbtranssj['Id_Depo'];
		$keterangan= $dbtranssj['keterangan'];
		return $this->db->query("insert into approve_sj (no_sj,Id_Depo,status,keterangan,last_update,id) values('$nosj','$depo','arrival','$keterangan','$now','$iduser')");
	}
	Public function masukapprove2($nosj)
	{
		$dbtranssj=$this->db->query("SELECT * from transaksi_sj where no_sj =? GROUP BY no_sj",[$nosj])->row_array();
		$iduser=$this->session->iduser;
		$now=date('Y-m-d H:i:s');
		$depo= $dbtranssj['Id_Depo'];
		$keterangan= $dbtranssj['keterangan'];
		return $this->db->query("update approve_sj set status=?, keterangan=?, last_update=?, id=? where no_sj=?",['arrival',$keterangan,$now,$iduser,$nosj]);
	}


	public function getemail($kdsap)
	{
		return $this->db->query("select * from email_user where kd_sap2=?",[$kdsap])->row_array();
	}
	Public function updatereject($idalasan,$nosj)
	{
		$dbtranssj=$this->db->query("SELECT * from transaksi_sj where no_sj =? GROUP BY no_sj",[$nosj])->row_array();
		$dbalasansj=$this->db->query("SELECT * from alasan_sj where id_alasan=?",[$idalasan])->row_array();
		$iduser=$this->session->iduser;
		$now=date('Y-m-d H:i:s');
		$alasan=$dbalasansj['alasan'];
		$depo= $dbtranssj['Id_Depo'];
		$keterangan= $dbtranssj['keterangan'];
		$this->db->query("update transaksi_sj set status_transaksi='U' where no_sj='$nosj' AND status_transaksi='Y'");
		return $this->db->query("update approve_sj set Id_Depo=?,id_alasan=?,status=?,keterangan=?,last_update=?,id=? where no_sj=?",[$depo,$idalasan,'reject',$alasan,$now,$iduser,$nosj]);
	}

	public function getdataalasanforreject()
	{
		return $this->db->query("select * from alasan_sj where flag='Y'");
	}
	// USER //
	Public function tampildatauser($username)//Query untuk tampil data users
	{
		return $this->db->query("select * from user INNER JOIN rdepo ON rdepo.KD_DEPO=user.id_depo where tipe_user BETWEEN 'user_depo' AND 'user_tb_ho'");
	}

	Public function getUser($username) {
		return $this->db->query("SELECT *
								FROM USER
								INNER JOIN rdepo ON rdepo.id_depo=user.id_depo
								WHERE user = ?",[$username])->row();
	}

	Public function tampildatasite()
	{
		$this->db->select('*');
		$this->db->from('rdepo');
		$querysite= $this->db->get();
		return $querysite;
	}

	Public function inputuser($tabel,$data)
	{
		return $this->db->insert($tabel,$data);
	}
	Public function inputemail($data)
	{
		return $this->db->insert('email_user',$data);
	}

	Public function hapusemail($sap)
	{
		$tglsekarang=date('Y-m-d H:i:s');
		return $this->db->query("update email_user set status='N' where kd_sap2=?",[$sap]);
	}
	
	Public function updateemail($data1,$data)
	{
		$this->db->where('kd_sap2',$data1);
       return  $this->db->update('email_user',$data);
	}

	Public function cekpasswordedit($user)
	{
		return $this->db->query("select password from user where user =? ",[$user]);
	}

	Public function ceksap($nosj)
	{
		return $this->db->query("select * from upload_sj where no_sj=? group by no_sj",[$nosj]);
	}

	Public function kirimemail()
	{
include "PHPMailer-master/PHPMailerAutoload.php";
$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'mail.pinusmerahabadi.co.id';
$mail->SMTPAuth = true;
$mail->Username = 'sys_adm@pinusmerahabadi.co.id';
$mail->Password = 'sys0911';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->isHTML(true);

$mail->setFrom('sys_adm@pinusmerahabadi.co.id', 'ITDEV - PMA TERIMA BARANG');
$mail->addAddress($bm, $bm);
$mail->addAddress($spv, $spv);
$mail->addAddress($sa, $sa);
$mail->addAddress($dim, $dim);
$mail->addAddress($adim, $adim);
$mail->addAddress($dps, $dps);
$mail->addAddress($scm1, $scm1);
$mail->addAddress($scm2, $scm2);
$mail->addAddress($scm3, $scm3);
$mail->addAddress($scm4, $scm4);
$mail->addAddress($scm5, $scm5);

$mail->Subject = "PMA TERIMA BARANG";
$body1 = "<h2><font style=\"color:black; font-family:'Candara';\"><u>INFORMATION</u></font></h2>
			<font style=\"color:black;  font-size:'16';  font-family:'Candara';\">
					Dear all user,<br><br>
					 Dengan ini kami sampaikan bahwa : <br><br></font>
						<table border=\"1\" cellpadding=\"10\" cellspacing=\"0\" style=\"  font:'Candara';\">
							<thead>
								<tr bgcolor=\"#F08080\">
								<font style=\"color: white;font-size:'16';  font-family:'Candara';\">
									<th>No</th>
									<th>No SJ</th>
									<th>Tanggal SJ</th>
									<th>Principal</th>
									<th>Status</th>
									<th>Approve</th>
									<th>Keterangan</th>
									</font>
								</tr>
							</thead>
							<tbody>";

			$body2 = "<tr>
				<font style=\"color: black; font-size:'16';  font-family:'Candara';\">
								<td align=\"center\">1</td>
								<td align=\"left\">$nosj</td>
								<td align=\"left\">$tglsj</td>
								<td align=\"left\">$principalsj</td>
								<td align=\"left\">$caristatus</td>
								<td align=\"left\">Reject</td>
								<td align=\"left\">$nmalasan</td>
								</font>
							</tr>";

				$body3 = "  </tbody>
						</table><br>
						<font style=\"color: black; font-size:'16';  font-family:'Candara';\">
						Mohon segera lakukan perbaikan atas nomor sj yang ada diatas <br><br>
						Terimakasih
						</font>
					";
				$bodyContent = $body1 . $body2 . $body3;
				$mail->Body = $bodyContent;
				if (!$mail->Send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
					echo "Message has been sent";
				}


	}
Public function notifikasiemail($kdsap,$idalasan,$nosj)
{
	$cariemail=$this->db->query("select * from email_user where kd_sap2=? and status=? ",[$kdsap,'Y'])->row_array();
	$bm=$cariemail['email_bm'];
	$spv=$cariemail['email_spv_log'];
	$sa=$cariemail['email_sa'];
	$dim=$cariemail['email_dim'];
	$adim=$cariemail['email_adim'];
	$dps=$cariemail['email_dps'];
	$scm1=$cariemail['email_staff_scm_1'];
	$scm2=$cariemail['email_staff_scm_2'];
	$scm3=$cariemail['email_staff_scm_3'];
	$scm4=$cariemail['email_staff_scm_4'];
	$scm5=$cariemail['email_staff_scm_5'];

	$carialasan=$this->db->query("select * from alasan_sj where id_alasan=? ",[$idalasan])->row_array();
	$nmalasan=$carialasan['alasan'];

	$carisj=$this->db->query("select * from upload_sj where no_sj=? group by no_sj",[$nosj])->row_array();
	$tglsj=$carisj['tgl_sj'];
	$principalsj=$carisj['principal'];

	$carisjfromtrans=$this->db->query("select * from transaksi_sj where no_sj=? group by no_sj",[$nosj])->row_array();
	$caristatus=$carisjfromtrans['keterangan'];
	
	include "PHPMailer-master/PHPMailerAutoload.php";
    $mail = new PHPMailer;
			$mail->isSMTP();
			$mail->Host = 'mail.pinusmerahabadi.co.id';
			$mail->SMTPAuth = true;
			$mail->Username = 'sys_adm@pinusmerahabadi.co.id';
			$mail->Password = 'sys0911';
			$mail->SMTPSecure = 'tls';
			$mail->Port = 587;
			$mail->isHTML(true);
			
			$mail->setFrom('sys_adm@pinusmerahabadi.co.id', 'ITDEV - PMA TERIMA BARANG');
			$mail->addAddress($bm, $bm); 
			$mail->addAddress($spv, $spv); 
			$mail->addAddress($sa, $sa); 
			$mail->addAddress($dim, $dim); 
			$mail->addAddress($adim, $adim); 
			$mail->addAddress($dps, $dps); 
			$mail->addAddress($scm1, $scm1); 
			$mail->addAddress($scm2, $scm2); 
			$mail->addAddress($scm3, $scm3); 
			$mail->addAddress($scm4, $scm4);
			$mail->addAddress($scm5, $scm5);  
			
			$mail->Subject ="PMA TERIMA BARANG";
			$body1 = "<h2><font style=\"color:black; font-family:'Candara';\"><u>INFORMATION</u></font></h2>
			<font style=\"color:black;  font-size:'16';  font-family:'Candara';\">
					Dear all user,<br><br>
					 Dengan ini kami sampaikan bahwa : <br><br></font>
						<table border=\"1\" cellpadding=\"10\" cellspacing=\"0\" style=\"  font:'Candara';\">
							<thead>
								<tr bgcolor=\"#F08080\">
								<font style=\"color: white;font-size:'16';  font-family:'Candara';\">
									<th>No</th>
									<th>No SJ</th>
									<th>Tanggal SJ</th>
									<th>Principal</th>
									<th>Status</th>
									<th>Approve</th>
									<th>Keterangan</th>
									</font>
								</tr>
							</thead>
							<tbody>";
							
				$body2 =  "<tr>
				<font style=\"color: black; font-size:'16';  font-family:'Candara';\">
								<td align=\"center\">1</td>
								<td align=\"left\">$nosj</td>
								<td align=\"left\">$tglsj</td>
								<td align=\"left\">$principalsj</td>
								<td align=\"left\">$caristatus</td>	
								<td align=\"left\">Reject</td>
								<td align=\"left\">$nmalasan</td>
								</font>
							</tr>";
	
			$body3 = "  </tbody>
						</table><br>
						<font style=\"color: black; font-size:'16';  font-family:'Candara';\">
						Mohon segera lakukan perbaikan atas nomor sj yang ada diatas <br><br>
						Terimakasih
						</font>
					";
			$bodyContent = $body1.$body2.$body3;
      		$mail->Body = $bodyContent;
			if(!$mail->Send()) {
				echo "Mailer Error: " . $mail->ErrorInfo;
			} else {
					echo "Message has been sent";
			}
	}

	Public function tampildatalaporanho($principal,$awal,$akhir,$status,$grupregion,$region,$area)
	{

	if($status=="semua")
	{
		if($principal=="semua")
		{
				if($grupregion=="semua")
				{
					$cek=$this->db->query("SELECT c.principal, e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,a.no_sj2,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status , i.dok_sj, i.dok_dtb,i.dok_dtb2, i.dok_sj2,i.dok_bppr, i.dok_basp FROM transaksi_sj a 
					LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
					lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
					LEFT JOIN rmaster d ON a.PCODE = d.PCODE
					LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
					LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
					LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
					LEFT JOIN dokumen_sj i ON a.no_sj = i.no_sj
					where  c.tgl_sj BETWEEN '$awal' AND '$akhir' AND  a.status_transaksi='Y' group by id_trans_sj");
				}
				elseif($grupregion!="semua" && $region=="semua")
				{
				$cek=$this->db->query("SELECT c.principal,e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,a.no_sj2,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status, i.dok_sj, i.dok_dtb,i.dok_dtb2, i.dok_sj2,i.dok_bppr, i.dok_basp  FROM transaksi_sj a 
				LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
				lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
				LEFT JOIN rmaster d ON a.PCODE = d.PCODE
				LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
				LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
				LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
				LEFT JOIN dokumen_sj i ON a.no_sj = i.no_sj
				where  a.Id_Depo IN (select KD_DEPO from rdepo where b.KD_GREG='$grupregion') AND c.tgl_sj BETWEEN '$awal' AND '$akhir' AND  a.status_transaksi='Y' group by id_trans_sj");
				}
				elseif($grupregion!="semua" && $region!="semua" && $area=="semua")
				{
				$cek=$this->db->query("SELECT c.principal,e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,a.no_sj2,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status , i.dok_sj, i.dok_dtb,i.dok_dtb2, i.dok_sj2,i.dok_bppr, i.dok_basp FROM transaksi_sj a 
				LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
				lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
				LEFT JOIN rmaster d ON a.PCODE = d.PCODE
				LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
				LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
				LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
				LEFT JOIN dokumen_sj i ON a.no_sj = i.no_sj
				where  a.Id_Depo IN (select KD_DEPO from rdepo where b.KD_GREG='$grupregion' AND b.KD_REG='$region') AND c.tgl_sj BETWEEN '$awal' AND '$akhir' AND  a.status_transaksi='Y' group by id_trans_sj");
				}
				elseif($grupregion!="semua" && $region!="semua" && $area!="semua")
				{
				$cek=$this->db->query("SELECT c.principal,e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,a.no_sj2,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status, i.dok_sj, i.dok_dtb,i.dok_dtb2, i.dok_sj2,i.dok_bppr, i.dok_basp  FROM transaksi_sj a 
				LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
				lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
				LEFT JOIN rmaster d ON a.PCODE = d.PCODE
				LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
				LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
				LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
				LEFT JOIN dokumen_sj i ON a.no_sj = i.no_sj
				where  a.Id_Depo IN (select KD_DEPO from rdepo where b.KD_GREG='$grupregion' AND b.KD_REG='$region' AND b.KD_AREA='$area') AND c.tgl_sj BETWEEN '$awal' AND '$akhir' AND  a.status_transaksi='Y' group by id_trans_sj");
				}
				else{
				$cek=$this->db->query("SELECT c.principal,e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,a.no_sj2,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status, i.dok_sj, i.dok_dtb,i.dok_dtb2, i.dok_sj2,i.dok_bppr, i.dok_basp  FROM transaksi_sj a 
				LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
				lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
				LEFT JOIN rmaster d ON a.PCODE = d.PCODE
				LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
				LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
				LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
				LEFT JOIN dokumen_sj i ON a.no_sj = i.no_sj
				where  a.Id_Depo IN (select KD_DEPO from rdepo where b.KD_GREG='$grupregion' AND b.KD_REG='$region' AND b.KD_AREA='$area') AND c.tgl_sj BETWEEN '$awal' AND '$akhir' AND  a.status_transaksi='Y' group by id_trans_sj");
				}

	}
	else{
		
		if($grupregion=="semua")
		{
			$cek=$this->db->query("SELECT c.principal, e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,a.no_sj2,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status, i.dok_sj, i.dok_dtb,i.dok_dtb2, i.dok_sj2,i.dok_bppr, i.dok_basp  FROM transaksi_sj a 
			LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
			lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
			LEFT JOIN rmaster d ON a.PCODE = d.PCODE
			LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
			LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
			LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
			LEFT JOIN dokumen_sj i ON a.no_sj = i.no_sj
			where  c.tgl_sj BETWEEN '$awal' AND '$akhir' AND  a.status_transaksi='Y' AND c.principal='$principal' group by id_trans_sj");
		}
		elseif($grupregion!="semua" && $region=="semua")
		{
		$cek=$this->db->query("SELECT c.principal,e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,a.no_sj2,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status, i.dok_sj, i.dok_dtb,i.dok_dtb2, i.dok_sj2,i.dok_bppr, i.dok_basp  FROM transaksi_sj a 
		LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
		lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
		LEFT JOIN rmaster d ON a.PCODE = d.PCODE
		LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
		LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
		LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
		LEFT JOIN dokumen_sj i ON a.no_sj = i.no_sj
		where  a.Id_Depo IN (select KD_DEPO from rdepo where b.KD_GREG='$grupregion') AND c.principal='$principal' AND c.tgl_sj BETWEEN '$awal' AND '$akhir' AND  a.status_transaksi='Y' group by id_trans_sj");
		}
		elseif($grupregion!="semua" && $region!="semua" && $area=="semua")
		{
		$cek=$this->db->query("SELECT c.principal,e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,a.no_sj2,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status, i.dok_sj, i.dok_dtb,i.dok_dtb2, i.dok_sj2,i.dok_bppr, i.dok_basp  FROM transaksi_sj a 
		LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
		lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
		LEFT JOIN rmaster d ON a.PCODE = d.PCODE
		LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
		LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
		LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
		LEFT JOIN dokumen_sj i ON a.no_sj = i.no_sj
		where  a.Id_Depo IN (select KD_DEPO from rdepo where b.KD_GREG='$grupregion' AND b.KD_REG='$region') AND c.principal='$principal' AND c.tgl_sj BETWEEN '$awal' AND '$akhir' AND  a.status_transaksi='Y' group by id_trans_sj");
		}
		elseif($grupregion!="semua" && $region!="semua" && $area!="semua")
		{
		$cek=$this->db->query("SELECT c.principal,e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,a.no_sj2,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status, i.dok_sj, i.dok_dtb,i.dok_dtb2, i.dok_sj2,i.dok_bppr, i.dok_basp  FROM transaksi_sj a 
		LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
		lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
		LEFT JOIN rmaster d ON a.PCODE = d.PCODE
		LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
		LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
		LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
		LEFT JOIN dokumen_sj i ON a.no_sj = i.no_sj
		where  a.Id_Depo IN (select KD_DEPO from rdepo where b.KD_GREG='$grupregion' AND b.KD_REG='$region' AND b.KD_AREA='$area') AND c.principal='$principal' AND c.tgl_sj BETWEEN '$awal' AND '$akhir' AND  a.status_transaksi='Y' group by id_trans_sj");
		}
		else{
		$cek=$this->db->query("SELECT c.principal,e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,a.no_sj2,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status, i.dok_sj, i.dok_dtb,i.dok_dtb2, i.dok_sj2,i.dok_bppr, i.dok_basp  FROM transaksi_sj a 
		LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
		lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
		LEFT JOIN rmaster d ON a.PCODE = d.PCODE
		LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
		LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
		LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
		LEFT JOIN dokumen_sj i ON a.no_sj = i.no_sj
		where  a.Id_Depo IN (select KD_DEPO from rdepo where b.KD_GREG='$grupregion' AND b.KD_REG='$region' AND b.KD_AREA='$area') AND c.tgl_sj BETWEEN '$awal' AND '$akhir' AND  a.status_transaksi='Y' AND c.principal='$principal' group by id_trans_sj");
		}
	}
	
}


	else
	{	if($principal=="semua")
		{
			if($grupregion=="semua")
			{
				$cek=$this->db->query("SELECT c.principal, e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,a.no_sj2,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status, i.dok_sj, i.dok_dtb,i.dok_dtb2, i.dok_sj2,i.dok_bppr, i.dok_basp  FROM transaksi_sj a 
				LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
				lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
				LEFT JOIN rmaster d ON a.PCODE = d.PCODE
				LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
				LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
				LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
				LEFT JOIN dokumen_sj i ON a.no_sj = i.no_sj
				where  c.tgl_sj BETWEEN '$awal' AND '$akhir' AND h.status='$status' AND a.status_transaksi='Y' group by id_trans_sj");
			}
			elseif($grupregion!="semua" && $region=="semua")
			{
			$cek=$this->db->query("SELECT c.principal, e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,a.no_sj2,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status,i.dok_sj, i.dok_dtb,i.dok_dtb2, i.dok_sj2,i.dok_bppr, i.dok_basp  FROM transaksi_sj a 
			LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
			lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
			LEFT JOIN rmaster d ON a.PCODE = d.PCODE
			LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
			LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
			LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
			LEFT JOIN dokumen_sj i ON a.no_sj = i.no_sj
			where  a.Id_Depo IN (select KD_DEPO from rdepo where b.KD_GREG='$grupregion') AND c.tgl_sj BETWEEN '$awal' AND '$akhir' AND h.status='$status' AND  a.status_transaksi='Y' group by id_trans_sj");
			}
			elseif($grupregion!="semua" && $region!="semua" && $area=="semua")
			{
			$cek=$this->db->query("SELECT c.principal,e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,a.no_sj2,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status, i.dok_sj, i.dok_dtb,i.dok_dtb2, i.dok_sj2,i.dok_bppr, i.dok_basp  FROM transaksi_sj a 
			LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
			lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
			LEFT JOIN rmaster d ON a.PCODE = d.PCODE
			LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
			LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
			LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
			LEFT JOIN dokumen_sj i ON a.no_sj = i.no_sj
			where  a.Id_Depo IN (select KD_DEPO from rdepo where b.KD_GREG='$grupregion' AND b.KD_REG='$region') AND c.tgl_sj BETWEEN '$awal' AND '$akhir' AND h.status='$status' AND  a.status_transaksi='Y' group by id_trans_sj");
			}
			elseif($grupregion!="semua" && $region!="semua" && $area!="semua")
			{
			$cek=$this->db->query("SELECT c.principal,e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,a.no_sj2,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status, i.dok_sj, i.dok_dtb,i.dok_dtb2, i.dok_sj2,i.dok_bppr, i.dok_basp  FROM transaksi_sj a 
			LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
			lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
			LEFT JOIN rmaster d ON a.PCODE = d.PCODE
			LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
			LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
			LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
			LEFT JOIN dokumen_sj i ON a.no_sj = i.no_sj
			where  a.Id_Depo IN (select KD_DEPO from rdepo where b.KD_GREG='$grupregion' AND b.KD_REG='$region' AND b.KD_AREA='$area') AND c.tgl_sj BETWEEN '$awal' AND '$akhir' AND h.status='$status' AND  a.status_transaksi='Y' group by id_trans_sj");
			}
			else{
			$cek=$this->db->query("SELECT c.principal,e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,a.no_sj2,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status, i.dok_sj, i.dok_dtb,i.dok_dtb2, i.dok_sj2,i.dok_bppr, i.dok_basp  FROM transaksi_sj a 
			LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
			lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
			LEFT JOIN rmaster d ON a.PCODE = d.PCODE
			LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
			LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
			LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
			LEFT JOIN dokumen_sj i ON a.no_sj = i.no_sj
			where  a.Id_Depo IN (select KD_DEPO from rdepo where b.KD_GREG='$grupregion' AND b.KD_REG='$region' AND b.KD_AREA='$area') AND c.tgl_sj BETWEEN '$awal' AND '$akhir' AND h.status='$status' AND  a.status_transaksi='Y' group by id_trans_sj");
			}
		}
		else{
			if($grupregion=="semua")
		{
			$cek=$this->db->query("SELECT c.principal, e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,a.no_sj2,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status, i.dok_sj, i.dok_dtb,i.dok_dtb2, i.dok_sj2,i.dok_bppr, i.dok_basp  FROM transaksi_sj a 
			LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
			lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
			LEFT JOIN rmaster d ON a.PCODE = d.PCODE
			LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
			LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
			LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
			LEFT JOIN dokumen_sj i ON a.no_sj = i.no_sj
			where  c.tgl_sj BETWEEN '$awal' AND '$akhir' AND h.status='$status' AND c.principal='$principal' AND a.status_transaksi='Y' group by id_trans_sj");
		}
		elseif($grupregion!="semua" && $region=="semua")
		{
		$cek=$this->db->query("SELECT c.principal, e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,a.no_sj2,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status, i.dok_sj, i.dok_dtb,i.dok_dtb2, i.dok_sj2,i.dok_bppr, i.dok_basp  FROM transaksi_sj a 
		LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
		lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
		LEFT JOIN rmaster d ON a.PCODE = d.PCODE
		LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
		LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
		LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
		LEFT JOIN dokumen_sj i ON a.no_sj = i.no_sj
		where  a.Id_Depo IN (select KD_DEPO from rdepo where b.KD_GREG='$grupregion') AND c.tgl_sj BETWEEN '$awal' AND '$akhir' AND h.status='$status' AND c.principal='$principal' AND  a.status_transaksi='Y' group by id_trans_sj");
		}
		elseif($grupregion!="semua" && $region!="semua" && $area=="semua")
		{
		$cek=$this->db->query("SELECT c.principal,e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,a.no_sj2,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status, i.dok_sj, i.dok_dtb,i.dok_dtb2, i.dok_sj2,i.dok_bppr, i.dok_basp  FROM transaksi_sj a 
		LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
		lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
		LEFT JOIN rmaster d ON a.PCODE = d.PCODE
		LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
		LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
		LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
		LEFT JOIN dokumen_sj i ON a.no_sj = i.no_sj
		where  a.Id_Depo IN (select KD_DEPO from rdepo where b.KD_GREG='$grupregion' AND b.KD_REG='$region') AND c.tgl_sj BETWEEN '$awal' AND '$akhir' AND h.status='$status' AND c.principal='$principal' AND  a.status_transaksi='Y' group by id_trans_sj");
		}
		elseif($grupregion!="semua" && $region!="semua" && $area!="semua")
		{
		$cek=$this->db->query("SELECT c.principal,e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,a.no_sj2,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status, i.dok_sj, i.dok_dtb,i.dok_dtb2, i.dok_sj2,i.dok_bppr, i.dok_basp  FROM transaksi_sj a 
		LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
		lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
		LEFT JOIN rmaster d ON a.PCODE = d.PCODE
		LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
		LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
		LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
		LEFT JOIN dokumen_sj i ON a.no_sj = i.no_sj
		where  a.Id_Depo IN (select KD_DEPO from rdepo where b.KD_GREG='$grupregion' AND b.KD_REG='$region' AND b.KD_AREA='$area') AND c.tgl_sj BETWEEN '$awal' AND '$akhir' AND h.status='$status' AND c.principal='$principal' AND  a.status_transaksi='Y' group by id_trans_sj");
		}
		else{
		$cek=$this->db->query("SELECT c.principal,e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,a.no_sj2,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status , i.dok_sj, i.dok_dtb,i.dok_dtb2, i.dok_sj2,i.dok_bppr, i.dok_basp FROM transaksi_sj a 
		LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
		lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
		LEFT JOIN rmaster d ON a.PCODE = d.PCODE
		LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
		LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
		LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
		LEFT JOIN dokumen_sj i ON a.no_sj = i.no_sj
		where  a.Id_Depo IN (select KD_DEPO from rdepo where b.KD_GREG='$grupregion' AND b.KD_REG='$region' AND b.KD_AREA='$area') AND c.tgl_sj BETWEEN '$awal' AND '$akhir' AND h.status='$status' AND  a.status_transaksi='Y' AND c.principal='$principal' group by id_trans_sj");
		}
		}
		
	}
// 		if($grupregion=="semua" )
// 		{
// 			$cek=$this->db->query("SELECT e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status FROM transaksi_sj a 
// 			LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
// 			lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
// 			LEFT JOIN rmaster d ON a.PCODE = d.PCODE
// 			LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
// 			LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
// 			LEFT JOIN approve_sj h ON a.no_sj = h.no_sj");
// 		}
// 		elseif($grupregion!="semua" && $region=="semua")
// 		{
// 		$cek=$this->db->query("SELECT e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status FROM transaksi_sj a 
// 		LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
// 		lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
// 		LEFT JOIN rmaster d ON a.PCODE = d.PCODE
// 		LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
// 		LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
// 		LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
// 		where  a.Id_Depo IN (select KD_DEPO from rdepo where b.KD_GREG='$grupregion')");
// 		}
// 		elseif($grupregion!="semua" && $region!="semua" && $area=="semua")
// 		{
// 		$cek=$this->db->query("SELECT e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status FROM transaksi_sj a 
// 		LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
// 		lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
// 		LEFT JOIN rmaster d ON a.PCODE = d.PCODE
// 		LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
// 		LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
// 		LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
// 		where  a.Id_Depo IN (select KD_DEPO from rdepo where b.KD_GREG='$grupregion' AND b.KD_REG='$region')");
// 		}
// 		elseif($grupregion!="semua" && $region!="semua" && $area!="semua")
// 		{
// 		$cek=$this->db->query("SELECT e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status FROM transaksi_sj a 
// 		LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
// 		lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
// 		LEFT JOIN rmaster d ON a.PCODE = d.PCODE
// 		LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
// 		LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
// 		LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
// 		where  a.Id_Depo IN (select KD_DEPO from rdepo where b.KD_GREG='$grupregion' AND b.KD_REG='$region' AND b.KD_AREA='$area')");
// 		}
// 		else{
// 		$cek=$this->db->query("SELECT e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status FROM transaksi_sj a 
// 		LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
// 		lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
// 		LEFT JOIN rmaster d ON a.PCODE = d.PCODE
// 		LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
// 		LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
// 		LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
// 		where  a.Id_Depo IN (select KD_DEPO from rdepo where b.KD_GREG='$grupregion' AND b.KD_REG='$region' AND b.KD_AREA='$area') AND c.tgl_sj BETWEEN '$awal' AND '$akhir' AND h.status='$status'");
// }
return $cek;
		// return $this->db->query("SELECT e.NM_GREG,f.NM_REG,b.kd_sap2,b.NM_DEPO,c.no_dokumen,a.no_sj,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status FROM transaksi_sj a 
		// LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
		// lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
		// LEFT JOIN rmaster d ON a.PCODE = d.PCODE
		// LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
		// LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
		// LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
		// where  a.Id_Depo IN (select KD_DEPO from rdepo where b.KD_GREG='$grupregion' AND b.KD_REG='$region' AND b.KD_AREA='$area') AND c.tgl_sj BETWEEN '$awal' AND '$akhir' AND h.status='$status'");
	}
	
	Public function tampildatalaporanarea($principal,$awal,$akhir,$status)
	{
		$iddepo=$this->session->iddepo;
		if($principal=="kosong" && $status=="kosong")
		{
			$laporan=$this->db->query("SELECT c.principal, e.NM_GREG,f.NM_REG,b.kd_sap2, b.NM_DEPO,c.no_dokumen,a.no_sj,a.no_sj2,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status , i.dok_sj, i.dok_dtb,i.dok_dtb2, i.dok_sj2,i.dok_bppr, i.dok_basp FROM transaksi_sj a 
			LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
			lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
			LEFT JOIN rmaster d ON a.PCODE = d.PCODE
			LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
			LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
			LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
			LEFT JOIN dokumen_sj i ON a.no_sj = i.no_sj
			where a.Id_Depo ='$iddepo' AND c.tgl_sj BETWEEN '$awal' AND '$akhir' group by id_trans_sj");
		}
		else if($principal!="kosong" && $status=="kosong")
		{
			$laporan=$this->db->query("SELECT c.principal, e.NM_GREG,f.NM_REG,b.kd_sap2, b.NM_DEPO,c.no_dokumen,a.no_sj,a.no_sj2,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status, i.dok_sj, i.dok_dtb,i.dok_dtb2, i.dok_sj2,i.dok_bppr, i.dok_basp FROM transaksi_sj a 
			LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
			lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
			LEFT JOIN rmaster d ON a.PCODE = d.PCODE
			LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
			LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
			LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
			LEFT JOIN dokumen_sj i ON a.no_sj = i.no_sj
			where a.Id_Depo ='$iddepo' AND c.tgl_sj BETWEEN '$awal' AND '$akhir' AND c.principal='$principal' group by id_trans_sj");
		}
		else 
		{
			$laporan=$this->db->query("SELECT c.principal, e.NM_GREG,f.NM_REG,b.kd_sap2, b.NM_DEPO,c.no_dokumen,a.no_sj,a.no_sj2,c.tgl_sj,c.tgl_sj+ INTERVAL c.ldp DAY + INTERVAL 1 DAY as ETA ,a.no_dtb,a.tgl_inputdtb,a.tgl_inputportal,a.PCODE,d.PCODENAME,a.qty_sj,(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih) as qty_terima,a.no_basp,a.no_bppr,a.no_dtb2,datediff(a.tgl_inputportal,a.tgl_inputdtb) as hasil ,IF(datediff(a.tgl_inputportal,a.tgl_inputdtb) > 3, '0', '1') as total,IF(a.qty_sj<>(a.qty_sj - a.qty_selisih_kurang + a.qty_selisih_lebih), 'selisih', 'none') as selisih, h.status, i.dok_sj, i.dok_dtb,i.dok_dtb2, i.dok_sj2,i.dok_bppr, i.dok_basp FROM transaksi_sj a 
			LEFT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
			lEFT JOIN upload_sj c ON a.no_sj = c.no_sj
			LEFT JOIN rmaster d ON a.PCODE = d.PCODE
			LEFT JOIN rmstgreg e ON b.KD_GREG = e.KD_GREG
			LEFT JOIN rmstreg f ON b.KD_REG = f.KD_REG
			LEFT JOIN approve_sj h ON a.no_sj = h.no_sj
			LEFT JOIN dokumen_sj i ON a.no_sj = i.no_sj
			where a.Id_Depo ='$iddepo' AND c.tgl_sj BETWEEN '$awal' AND '$akhir' AND c.principal='$principal' AND h.status='$status' group by id_trans_sj");
		}
		return $laporan;
	}

	Public function tampildatagreg()
	{
		return $this->db->query("SELECT * from rmstgreg");
	}

	Public function getreg($greg)
	{
	return $this->db->query("select * from rmstreg where KD_GREG=?",[$greg]);
	}

	
	Public function getarea($reg)
	{
	return $this->db->query("select * from rarea where KD_REG=?",[$reg]);
	}

	//END  USER //

	Public function tampilnosjforsjtambahan($sj)
	{
	return $this->db->query("select no_sj2 from transaksi_sj where no_sj=? AND  no_sj2 IS NOT NULL group by no_sj",[$sj])->row_array();
	}

	// ALASAN //
	Public function getalasan($idalasan) {
		return $this->db->query("SELECT *
								FROM alasan_sj
								WHERE id_alasan = ?",[$idalasan])->row();
	}

	Public function tampildataalasan()
	{
		return $this->db->query("select * from alasan_sj where flag='Y'");
	}
	
	Public function inputalasan($data)
	{
		return $this->db->insert('alasan_sj',$data);
	}

	Public function hapusalasan($alasan)
	{
		$waktusekarang=date('Y-m-d H:i:s');
		$querydeletealasan=$this->db->query("update alasan_sj set flag=?,last_update=? where id_alasan=?",['N',$waktusekarang,$alasan]);
		return $querydeletealasan;
	}

	Public function updatealasan($editidalasan,$edittextalasan,$editflag)
	{
		$waktusekarang=date('Y-m-d H:i:s');
		$qryupdatealasan=$this->db->query("update alasan_sj set alasan=?,flag=? where id_alasan=?",[$edittextalasan,$editflag,$editidalasan]);
	
	return $qryupdatealasan;
	}
	// END ALASAN //

	// DTB //
	Public function dtb_processall()
	{
		return $this->db->query('SELECT *, COUNT(no_sj) AS total_sj from upload_sj INNER JOIN rdepo on rdepo.kd_sap2 = upload_sj.kd_sap2
								GROUP BY upload_sj.kd_sap2');
	}

	Public function dtb_data($period)
	{
		return $this->db->query("SELECT DISTINCT(a.Id_Depo),b.*,count(DISTINCT(a.no_sj)) as total_sj,(select count(`status`) from approve_sj where `status` = 'reject') as reject,(select count(`status`) from approve_sj where `status` = 'approve') as approve,(select count(`status`) from approve_sj where `status` = 'arrival') as arrival
		FROM transaksi_sj a
		INNER JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
		INNER JOIN upload_sj c ON a.no_sj = c.no_sj
		INNER JOIN approve_sj d ON a.no_sj = d.no_sj
		WHERE d.status =? AND a.status_transaksi=? AND DATE_FORMAT(c.tgl_sj, '%Y%m')=? 
		GROUP BY a.Id_Depo",['arrival','Y',$period])->result();
	}

	Public function dtb_data2($period)
	{
		return $this->db->query ("SELECT a.no_sj ,a.Id_Depo, b.kd_sap2, b.NM_DEPO,
		CASE WHEN a.status = 'reject' THEN COUNT(a.status) END AS reject, 
		CASE WHEN a.status = 'approve' THEN COUNT(a.status) END AS approve, 
		CASE WHEN a.status = 'arrival' THEN COUNT(a.status) END AS arrival
		FROM approve_sj a
		left JOIN rdepo b ON a.Id_Depo=b.KD_DEPO
		WHERE a.no_sj IN (SELECT c.no_sj FROM  upload_sj c where DATE_FORMAT(c.tgl_sj, '%Y%m') = ? GROUP BY c.no_sj, c.kd_sap2)
		GROUP BY a.Id_Depo",[$period])->result();

		// return $this->db->query("select a.Id_Depo, b.kd_sap2, b.NM_DEPO, case when a.status = 'reject' THEN count(a.status) end as reject,
		// 						case when a.status = 'approve' THEN count(a.status)
		// 						end as approve,
		// 						case when a.status = 'arrival' THEN count(a.status)
		// 						end as arrival
		// 						from approve_sj a
		// 						INNER JOIN rdepo b on a.Id_Depo=b.KD_DEPO
		// 						INNER JOIN upload_sj c on c.no_sj = a.no_sj
		// 						where DATE_FORMAT(c.tgl_sj, '%Y%m') = ?
		// 						group by a.Id_Depo",[$period])->result();
		// return $this->db->query("SELECT DISTINCT(a.Id_Depo),b.*,count(DISTINCT(a.no_sj)) as total_sj ,(select count(`status`) from approve_sj where `status` = 'reject') as reject,(select count(`status`) from approve_sj where `status` = 'approve') as approve,(select count(`status`) from approve_sj where `status` = 'arrival') as arrival
		// FROM transaksi_sj a
		// RIGHT JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
		// RIGHT JOIN upload_sj c ON a.no_sj = c.no_sj
		// RIGHT JOIN approve_sj d ON a.no_sj = d.no_sj
		// WHERE a.status_transaksi=? AND DATE_FORMAT(c.tgl_sj, '%Y%m') = ? ",['Y',$period])->result();
	}
	 
	Public function sjpro_data($tglawal,$tglakhir,$status)
	{
		$iddepo=$this->session->iddepo;
		if ($status=="semua")
		{
			$cek = $this->db->query("SELECT DISTINCT(a.no_sj),c.tgl_sj,c.principal,d.status,d.keterangan,b.*,count(DISTINCT(a.no_sj)) as total_sj
			FROM transaksi_sj a
			INNER JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
			INNER JOIN upload_sj c ON a.no_sj = c.no_sj
			INNER JOIN approve_sj d ON a.no_sj = d.no_sj
			WHERE c.tgl_sj between '$tglawal' and '$tglakhir' AND a.Id_Depo = '$iddepo'
			GROUP BY a.no_sj")->result();
		}
		else{
			$cek =$this->db->query("SELECT DISTINCT(a.no_sj),c.tgl_sj,c.principal,d.status,d.keterangan,b.*,count(DISTINCT(a.no_sj)) as total_sj
			FROM transaksi_sj a
			INNER JOIN rdepo b ON a.Id_Depo = b.KD_DEPO
			INNER JOIN upload_sj c ON a.no_sj = c.no_sj
			INNER JOIN approve_sj d ON a.no_sj = d.no_sj
			WHERE d.status ='$status' AND c.tgl_sj between '$tglawal' and '$tglakhir' AND a.Id_Depo = '$iddepo'
			GROUP BY a.no_sj")->result();
		}
		return $cek; 
	}
	Public function dtb_processedall()
	{
		return $this->db->query('SELECT *, COUNT(no_sj) AS total_sj from upload_sj INNER JOIN rdepo on rdepo.kd_sap2 = upload_sj.kd_sap2
								GROUP BY upload_sj.kd_sap2');
	}

	
	Public function updatefilesjtambah($filesj, $nosjganti)
	{
		$ceknosj=$this->db->query("select no_sj from transaksi_sj where no_sj2=?",[$nosjganti])->row_array();
		$nosj=$ceknosj['no_sj'];
		return $this->db->query("update dokumen_sj set dok_sj2=? where no_sj=?",[$filesj,$nosj]);
	}


	Public function dtb_datasite($kdsite,$period)
	{ 
		return $this->db->query("SELECT DISTINCT(a.no_sj), a.keterangan,c.principal,c.tgl_sj,d.dok_sj,d.dok_dtb,d.dok_dtb2,d.dok_bppr,d.dok_basp from transaksi_sj a INNER JOIN upload_sj c ON a.no_sj = c.no_sj INNER JOIN approve_sj g on g.no_sj = a.no_sj INNER JOIN dokumen_sj d ON d.no_sj = a.no_sj
		where NOT g.status=? AND a.Id_Depo = (select KD_DEPO from rdepo where kd_sap2=?) AND a.status_transaksi='Y' AND DATE_FORMAT(c.tgl_sj, '%Y%m')=? GROUP BY a.no_sj",['approve',$kdsite,$period])->result();
	}

	Public function datasjprocessed($data)
	{
		return $this->db->query("SELECT * from transaksi_sj a INNER JOIN rmaster b ON a.PCODE = b.PCODE INNER JOIN approve_sj c on c.no_sj = a.no_sj where NOT c.status=? AND a.no_sj =? AND a.status_transaksi=?",['approve',$data,'Y'])->result();
	}

	Public function updatedatatransaksi($nosj,$nosj2)
	{
		return $this->db->query("update transaksi_sj set no_sj2 =? where no_sj=?",[$nosj2,$nosj]);
	}
	// END DTB //
	// END HEAD OFFICE //

	// CABANG //

	// SJ TB PROSES //
	Public function tampilsuratjalan()
	{
		$iduser=$this->session->iduser;
		$iddepo=$this->session->iddepo;
		$datasap=$this->db->query("select * from rdepo where KD_DEPO='$iddepo'")->row_array();
		$sap=$datasap['kd_sap2'];
		return $this->db->query("Select * from upload_sj where kd_sap2 ='$sap'  AND status_sj='N' GROUP BY no_sj");
	}

	Public function sap($iddepo){
		
		return $this->db->query("select kd_sap2 from rdepo where KD_DEPO='$iddepo'")->row_array();
	
	}

	Public function tampilpcode(){
		return $this->db->query("select * from rmaster");
	}
	Public function getsuratjalan($nosj,$tglsj) {
		return $this->db->query("SELECT *
								FROM upload_sj
								LEFT JOIN rmaster ON  upload_sj.PCODE = rmaster.PCODE
								WHERE no_sj = ? and tgl_sj = ?",[$nosj,$tglsj])->result();
	}

	Public function getsuratjalan2($nosj,$tglsj) {
		return $this->db->query("SELECT * FROM transaksi_sj a
		INNER JOIN rmaster b ON b.PCODE = a.PCODE
		INNER JOIN upload_sj c ON c.no_sj = a.no_sj
		WHERE a.no_sj =? and c.tgl_sj = ? AND a.status_transaksi=? group by id_trans_sj",[$nosj,$tglsj,'U'])->result();
	}

	Public function deletesjtransaksi($nosj)
	{
		return $this->db->query("Delete from transaksi_sj where no_sj=?",[$nosj]);
	}

	Public function gantistatussj($nosj)
	{
	return $this->db->query("update upload_sj set status_sj='Y' where no_sj=?",[$nosj]);
	}

	Public function uploadTbsesuai($iddepo,$sj,$data_dtb,$statussj,$tglinputdtb,$tglsekarang,$iduser)
	{
	return $this->db->query("INSERT INTO transaksi_sj(Id_Depo,PCODE,no_sj,no_dtb,qty_sj,qty_selisih_kurang,qty_selisih_lebih,keterangan,status_transaksi,tgl_inputdtb,tgl_inputportal,last_update,id)
							SELECT ?,PCODE,no_sj,?,qty,?,?,?,?,?,?,?,? FROM upload_sj
							WHERE no_sj = ?",[$iddepo,$data_dtb,'0','0',$statussj,'Y',$tglinputdtb,$tglsekarang,$tglsekarang,$iduser,$sj]);
	}

	Public function uploaddataTbsesuai($nosjbaruedit,$sjupload,$dtbupload,$tglsekarang,$iduser)
	{
		$qrydatasesuai = $this->db->query("insert into dokumen_sj (no_sj,dok_sj,dok_dtb,last_update,id) values ('$nosjbaruedit','$sjupload','$dtbupload','$tglsekarang','$iduser')");
		return $qrydatasesuai;
	}

	Public function uploaddataTbsesuai2($nosjbaruedit,$sjupload,$dtbupload,$tglsekarang,$iduser)
	{
		if(empty($sjupload) && empty($dtbupload))
		{
			$qrydatasesuai = $this->db->query("update dokumen_sj set last_update=?,id =? where no_sj =?", [$tglsekarang,$iduser,$nosjbaruedit]);
		}
		else if(!empty($sjupload) && empty($dtbupload) )
		{
			$qrydatasesuai = $this->db->query("update dokumen_sj set dok_sj=?,last_update=?,id =? where no_sj =?", [$sjupload,$tglsekarang,$iduser,$nosjbaruedit]);
		}
		else if(empty($sjupload) && !empty($dtbupload) )
		{
			$qrydatasesuai = $this->db->query("update dokumen_sj set dok_dtb=?,last_update=?,id =? where no_sj =?", [$dtbupload,$tglsekarang,$iduser,$nosjbaruedit]);
		
		}
		else{
			$qrydatasesuai = $this->db->query("update dokumen_sj set dok_sj=?,dok_dtb=?,last_update=?,id =? where no_sj =?", [$sjupload,$dtbupload,$tglsekarang,$iduser,$nosjbaruedit]);
		}
		return $qrydatasesuai;
	} 
	Public function uploadTbsk($id_depo,$pcode,$nosjbaruedit,$nodtbbaruedit,$nobpprbaruedit,$nobaspbaruedit,$qtysjedit,$qtyskedit,$qtysledit,$statussj,$tglinputdtb,$tglsekarang,$iduser) {
		$qrysk = $this->db->query("insert into transaksi_sj(Id_Depo, PCODE,no_sj,no_dtb,no_bppr,no_basp,qty_sj,qty_selisih_kurang,qty_selisih_lebih,keterangan,status_transaksi,tgl_inputdtb,tgl_inputportal,last_update,id) values ('$id_depo','$pcode','$nosjbaruedit','$nodtbbaruedit','$nobpprbaruedit','$nobaspbaruedit','$qtysjedit','$qtyskedit','$qtysledit','$statussj','Y','$tglinputdtb','$tglsekarang','$tglsekarang','$iduser')");
		return $qrysk;
	}
	Public function uploaddataTbsk2($nosjbaruedit,$sjupload,$dtbupload,$bpprupload,$baspupload,$tglsekarang,$iduser)
	{
		if(empty($sjupload) && empty($dtbupload) && empty($bpprupload) && empty($baspupload) )
		{
			$qrydatask = $this->db->query("update dokumen_sj set last_update=?,id =? where no_sj =?", [$tglsekarang,$iduser,$nosjbaruedit]);
		}
		elseif(!empty($sjupload) && empty($dtbupload) && empty($bpprupload) && empty($baspupload) )
		{
			$qrydatask = $this->db->query("update dokumen_sj set dok_sj=?,last_update=?,id =? where no_sj =?", [$sjupload,$tglsekarang,$iduser,$nosjbaruedit]);
		}
		else if(!empty($sjupload) && !empty($dtbupload) && empty($bpprupload) && empty($baspupload) )
		{
			$qrydatask = $this->db->query("update dokumen_sj set dok_sj=?,dok_dtb=?,last_update=?,id =? where no_sj =?", [$sjupload,$dtbupload,$tglsekarang,$iduser,$nosjbaruedit]);
		}
		else if(!empty($sjupload) && !empty($dtbupload) && !empty($bpprupload) && empty($baspupload) )
		{
			$qrydatask = $this->db->query("update dokumen_sj set dok_sj=?,dok_dtb=?,dok_bppr=?,last_update=?,id =? where no_sj =?", [$sjupload,$dtbupload,$bpprupload,$tglsekarang,$iduser,$nosjbaruedit]);
		}
		else
		{
			$qrydatask = $this->db->query("update dokumen_sj set dok_sj=?,dok_dtb=?,dok_bppr=?,dok_basp=?,last_update=?,id =? where no_sj =?", [$sjupload,$dtbupload,$bpprupload,$baspupload,$tglsekarang,$iduser,$nosjbaruedit]);
		}
		return $qrydatask;
	}
	Public function uploaddataTbsk($nosjbaruedit,$sjupload,$dtbupload,$bpprupload,$baspupload,$tglsekarang,$iduser)
	{
		$qrydatasl = $this->db->query("insert into dokumen_sj(no_sj,dok_sj,dok_dtb,dok_bppr,dok_basp,last_update,id) values ('$nosjbaruedit','$sjupload','$dtbupload','$bpprupload','$baspupload','$tglsekarang','$iduser')");
		return $qrydatasl;
	}
	Public function uploadTbsl($iddepo,$pcode,$nosjbaruedit,$nodtbbaruedit,$nodtb2baruedit,$nobaspbaruedit,$qtysjedit,$qtyskedit,$qtysledit,$statussj,$tglinputdtb,$tglsekarang,$iduser) {
		$qrysl = $this->db->query("insert into transaksi_sj(Id_Depo, PCODE,no_sj,no_dtb,no_dtb2,no_basp,qty_sj,qty_selisih_kurang,qty_selisih_lebih,keterangan,status_transaksi,tgl_inputdtb,tgl_inputportal,last_update,id) values ('$iddepo','$pcode','$nosjbaruedit','$nodtbbaruedit','$nodtb2baruedit','$nobaspbaruedit','$qtysjedit','$qtyskedit','$qtysledit','$statussj','Y','$tglinputdtb','$tglsekarang','$tglsekarang','$iduser')");
		return $qrysl;
	}

	Public function cekyanglebih($iddepo,$nosj)
	{
		$nosjtambahan=$nosj."X";
		// $cekidtrans=$this->db->query("select id_trans_sj from transaksi_sj  where Id_Depo='$iddepo' AND no_sj='$nosj' AND status_transaksi='Y' AND qty_selisih_lebih!='0'")->result();
		// $idtrans=$cekidtrans['id_trans_sj'];
		return $this->db->query("update transaksi_sj set no_sj2='$nosjtambahan' where Id_Depo='$iddepo' AND no_sj='$nosj' AND status_transaksi='Y' AND qty_selisih_lebih!='0'");
	}
	Public function uploaddataTbsl($nosjbaruedit,$sjupload,$dtbupload,$dtb2upload,$baspupload,$tglsekarang,$iduser)
	{
		$qrydatasl = $this->db->query("insert into dokumen_sj(no_sj,dok_sj,dok_dtb,dok_dtb2,dok_basp,last_update,id) values ('$nosjbaruedit','$sjupload','$dtbupload','$dtb2upload','$baspupload','$tglsekarang','$iduser')");
		return $qrydatasl;
	}

	Public function uploaddataTbsl2($nosjbaruedit,$sjupload,$dtbupload,$dtb2upload,$baspupload,$tglsekarang,$iduser)
	{

		if(empty($sjupload) && empty($dtbupload) && empty($dtb2upload) && empty($baspupload))
		{
			$qrydatasl = $this->db->query("update dokumen_sj set last_update=?,id =? where no_sj =?", [$tglsekarang,$iduser,$nosjbaruedit]);
		}
		elseif(!empty($sjupload) && empty($dtbupload) && empty($dtb2upload) && empty($baspupload))
		{
			$qrydatasl = $this->db->query("update dokumen_sj set dok_sj=?,last_update=?,id =? where no_sj =?", [$sjupload,$tglsekarang,$iduser,$nosjbaruedit]);
		}
		elseif(!empty($sjupload) && !empty($dtbupload) && !empty($dtb2upload) && empty($baspupload))
		{
			$qrydatasl = $this->db->query("update dokumen_sj set dok_sj=?,dok_dtb=?,last_update=?,id =? where no_sj =?", [$sjupload,$dtbupload,$tglsekarang,$iduser,$nosjbaruedit]);
		}
		else
		{
			$qrydatasl = $this->db->query("update dokumen_sj set dok_sj=?,dok_dtb=?,dok_dtb2=?,dok_basp=?,last_update=?,id =? where no_sj =?", [$sjupload,$dtbupload,$dtb2upload,$baspupload,$tglsekarang,$iduser,$nosjbaruedit]);
		}
		return $qrydatasl;
	}

	Public function uploadTbsv($id_depo,$pcode,$nosjbaruedit,$nodtbbaruedit,$nodtb2baruedit,$nobpprbaruedit,$nobaspbaruedit,$qtysjedit,$qtyskedit,$qtysledit,$statussj,$tglinputdtb,$tglsekarang,$iduser) {
		$qrysv = $this->db->query("insert into transaksi_sj(Id_Depo,PCODE,no_sj,no_dtb,no_dtb2,no_bppr,no_basp,qty_sj,qty_selisih_kurang,qty_selisih_lebih,keterangan,status_transaksi,tgl_inputdtb,tgl_inputportal,last_update,id) values ('$id_depo','$pcode','$nosjbaruedit','$nodtbbaruedit','$nodtb2baruedit','$nobpprbaruedit','$nobaspbaruedit','$qtysjedit','$qtyskedit','$qtysledit','$statussj','Y','$tglinputdtb','$tglsekarang','$tglsekarang','$iduser')");
		return $qrysv;
	}
	Public function uploaddataTbsv($nosjbaruedit,$sjupload,$dtbupload,$dtb2upload,$bpprupload,$baspupload,$tglsekarang,$iduser)
	{
		$qrydatasl = $this->db->query("insert into dokumen_sj(no_sj,dok_sj,dok_dtb,dok_dtb2,dok_bppr,dok_basp,last_update,id) values ('$nosjbaruedit','$sjupload','$dtbupload','$dtb2upload','$bpprupload','$baspupload','$tglsekarang','$iduser')");
		return $qrydatasl;
	}

	Public function sjtambahan($tglawal,$tglakhir,$principal,$grupregion,$region,$area)
	{
		if($principal=="semua")
		{
			if($grupregion!="semua")
			{
				if($region=="semua")
				{
					$sqlsjtambahan=$this->db->query("select DISTINCT a.no_sj2, b.principal, a.tgl_inputdtb,c.kd_sap2,c.NM_DEPO from transaksi_sj a INNER JOIN upload_sj b on a.no_sj = b.no_sj INNER JOIN rdepo c on a.Id_Depo = c.KD_DEPO INNER JOIN rmstgreg d on c.KD_GREG = d.KD_GREG where d.KD_GREG='$grupregion' AND no_sj2 LIKE '%x%' AND a.no_sj2 is NOT NULL AND a.status_transaksi='Y' AND b.status_sj='Y' AND a.tgl_inputdtb BETWEEN '$tglawal' AND '$tglakhir'")->result();
				}
				else{
					if($area=="semua")
					{
						$sqlsjtambahan=$this->db->query("select DISTINCT a.no_sj2, b.principal, a.tgl_inputdtb,c.kd_sap2,c.NM_DEPO from transaksi_sj a INNER JOIN upload_sj b on a.no_sj = b.no_sj INNER JOIN rdepo c on a.Id_Depo = c.KD_DEPO INNER JOIN rmstgreg d on c.KD_GREG = d.KD_GREG INNER JOIN rmstreg f on c.KD_REG = f.KD_REG where d.KD_GREG='$grupregion' AND f.KD_REG='$region' AND no_sj2 LIKE '%x%' AND a.no_sj2 is NOT NULL AND a.status_transaksi='Y' AND b.status_sj='Y' AND a.tgl_inputdtb BETWEEN '$tglawal' AND '$tglakhir'")->result();
					}
					else{
						$sqlsjtambahan=$this->db->query("select DISTINCT a.no_sj2, b.principal, a.tgl_inputdtb,c.kd_sap2,c.NM_DEPO from transaksi_sj a INNER JOIN upload_sj b on a.no_sj = b.no_sj INNER JOIN rdepo c on a.Id_Depo = c.KD_DEPO INNER JOIN rmstgreg d on c.KD_GREG = d.KD_GREG INNER JOIN rmstreg f on c.KD_REG = f.KD_REG INNER JOIN rarea g on c.KD_AREA = g.KD_AREA where d.KD_GREG='$grupregion' AND f.KD_REG='$region' AND g.KD_AREA='$area' AND no_sj2 LIKE '%x%' AND a.no_sj2 is NOT NULL AND a.status_transaksi='Y' AND b.status_sj='Y' AND a.tgl_inputdtb BETWEEN '$tglawal' AND '$tglakhir'")->result();
					}
				}
			}
			else{
				$sqlsjtambahan=$this->db->query("select DISTINCT a.no_sj2, b.principal, a.tgl_inputdtb,c.kd_sap2,c.NM_DEPO from transaksi_sj a INNER JOIN upload_sj b on a.no_sj = b.no_sj INNER JOIN rdepo c on a.Id_Depo = c.KD_DEPO where   a.no_sj2 is NOT NULL AND no_sj2 LIKE '%x%' AND a.status_transaksi='Y' AND b.status_sj='Y' AND a.tgl_inputdtb BETWEEN '$tglawal' AND '$tglakhir'")->result();
			}
			
		}
		else{
			if($grupregion!="semua")
			{
				if($region=="semua")
				{
					$sqlsjtambahan=$this->db->query("select DISTINCT a.no_sj2, b.principal, a.tgl_inputdtb,c.kd_sap2,c.NM_DEPO from transaksi_sj a INNER JOIN upload_sj b on a.no_sj = b.no_sj INNER JOIN rdepo c on a.Id_Depo = c.KD_DEPO INNER JOIN rmstgreg d on c.KD_GREG = d.KD_GREG where d.KD_GREG='$grupregion' AND b.principal='$principal' AND a.no_sj2 is NOT NULL AND no_sj2 LIKE '%x%' AND a.status_transaksi='Y' AND b.status_sj='Y' AND a.tgl_inputdtb BETWEEN '$tglawal' AND '$tglakhir'")->result();
				}
				else{
					if($area=="semua")
					{
						$sqlsjtambahan=$this->db->query("select DISTINCT a.no_sj2, b.principal, a.tgl_inputdtb,c.kd_sap2,c.NM_DEPO from transaksi_sj a INNER JOIN upload_sj b on a.no_sj = b.no_sj INNER JOIN rdepo c on a.Id_Depo = c.KD_DEPO INNER JOIN rmstgreg d on c.KD_GREG = d.KD_GREG INNER JOIN rmstreg f on c.KD_REG = f.KD_REG where  d.KD_GREG='$grupregion' AND b.principal='$principal' AND f.KD_REG='$region' AND no_sj2 LIKE '%x%' AND a.no_sj2 is NOT NULL AND a.status_transaksi='Y' AND b.status_sj='Y' AND a.tgl_inputdtb BETWEEN '$tglawal' AND '$tglakhir'")->result();
					}
					else{
						$sqlsjtambahan=$this->db->query("select DISTINCT a.no_sj2, b.principal, a.tgl_inputdtb,c.kd_sap2,c.NM_DEPO from transaksi_sj a INNER JOIN upload_sj b on a.no_sj = b.no_sj INNER JOIN rdepo c on a.Id_Depo = c.KD_DEPO INNER JOIN rmstgreg d on c.KD_GREG = d.KD_GREG INNER JOIN rmstreg f on c.KD_REG = f.KD_REG INNER JOIN rarea g on c.KD_AREA = g.KD_AREA where d.KD_GREG='$grupregion' AND no_sj2 LIKE '%x%'  AND b.principal='$principal' AND f.KD_REG='$region' AND g.KD_AREA='$area' AND a.no_sj2 is NOT NULL AND a.status_transaksi='Y' AND b.status_sj='Y' AND a.tgl_inputdtb BETWEEN '$tglawal' AND '$tglakhir'")->result();
					}
				}
			}
			else{
				$sqlsjtambahan=$this->db->query("select DISTINCT a.no_sj2, b.principal, a.tgl_inputdtb,c.kd_sap2,c.NM_DEPO from transaksi_sj a INNER JOIN upload_sj b on a.no_sj = b.no_sj INNER JOIN rdepo c on a.Id_Depo = c.KD_DEPO where   a.no_sj2 is NOT NULL AND a.status_transaksi='Y' AND b.principal='$principal' AND no_sj2 LIKE '%x%' AND b.status_sj='Y' AND a.tgl_inputdtb BETWEEN '$tglawal' AND '$tglakhir'")->result();
			}
			
		}
		return $sqlsjtambahan;
	}
	Public function detailsjtambahan($nosj)
	{
		$sqlsjtambahan=$this->db->query("select  a.PCODE,a.no_sj,a.no_sj2,a.qty_sj,a.qty_selisih_lebih, a.tgl_inputdtb  from transaksi_sj a INNER JOIN upload_sj b on a.no_sj = b.no_sj where a.no_sj2 =? AND a.status_transaksi= ? group by id_trans_sj",[$nosj,'Y']);
		return $sqlsjtambahan;
	}

	Public function updatetambahansj($nosjawal,$nosjganti)
	{
		return $this->db->query("update transaksi_sj set  no_sj2 = replace(no_sj2, '$nosjawal', '$nosjganti')  where no_sj2='$nosjawal'");
	}

	Public function uploaddataTbsv2($nosjbaruedit,$sjupload,$dtbupload,$dtb2upload,$bpprupload,$baspupload,$tglsekarang,$iduser)
	{
		if(empty($sjupload) && empty($dtbupload) && empty($dtb2upload) && empty($bpprupload) && empty($baspupload))
		{
			$qrydatasv =  $this->db->query("update dokumen_sj set last_update=?,id =? where no_sj =?", [$tglsekarang,$iduser,$nosjbaruedit]);
		}
		else if(!empty($sjupload) && empty($dtbupload) && empty($dtb2upload) && empty($bpprupload) && empty($baspupload))
		{
			$qrydatasv =  $this->db->query("update dokumen_sj set dok_sj=?,last_update=?,id =? where no_sj =?", [$sjupload,$tglsekarang,$iduser,$nosjbaruedit]);
		}
		else if(!empty($sjupload) && !empty($dtbupload) && empty($dtb2upload) && empty($bpprupload) && empty($baspupload))
		{
			$qrydatasv =  $this->db->query("update dokumen_sj set dok_sj=?,dok_dtb=?,last_update=?,id =? where no_sj =?", [$sjupload,$dtbupload,$tglsekarang,$iduser,$nosjbaruedit]);
		}
		else if(!empty($sjupload) && !empty($dtbupload) && !empty($dtb2upload) && empty($bpprupload) && empty($baspupload))
		{
			$qrydatasv =  $this->db->query("update dokumen_sj set dok_sj=?,dok_dtb=?,dok_dtb2=?,last_update=?,id =? where no_sj =?", [$sjupload,$dtbupload,$dtb2upload,$tglsekarang,$iduser,$nosjbaruedit]);
		}
		else if(!empty($sjupload) && !empty($dtbupload) && !empty($dtb2upload) && !empty($bpprupload) && empty($baspupload))
		{
			$qrydatasv =  $this->db->query("update dokumen_sj set dok_sj=?,dok_dtb=?,dok_dtb2=?,dok_bppr=?,last_update=?,id =? where no_sj =?", [$sjupload,$dtbupload,$dtb2upload,$bpprupload,$tglsekarang,$iduser,$nosjbaruedit]);
		}
		else{
			$qrydatasv =  $this->db->query("update dokumen_sj set dok_sj=?,dok_dtb=?,dok_dtb2=?,dok_bppr=?,dok_basp=?,last_update=?,id =? where no_sj =?", [$sjupload,$dtbupload,$dtb2upload,$bpprupload,$baspupload,$tglsekarang,$iduser,$nosjbaruedit]);
		}
		
		return $qrydatasv;
	}
	

	// END SJ TB PROSES //
	// END CABANG //
	
}
?>