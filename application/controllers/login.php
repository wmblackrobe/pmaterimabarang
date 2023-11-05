<?php 
class Login extends CI_Controller{

		Public function __construct(){
			parent::__construct();		
			$this->load->model('m_data');
			date_default_timezone_set("Asia/Jakarta");
		}

		Public function index(){//halaman utama login
			$this->load->view('login');
		}
		
		Public function aksi_login(){//Jika user login
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$passwordmd=md5($password);
			$where = array(
				'user' => $username,
				'password' => md5($password),
				);
			$cek = $this->m_data->cek_login("user",$where)->num_rows();
			$datauser = $this->m_data->cek_login("user",$where)->row_array();
			$tipe_user=$datauser['tipe_user'];
			$iddepouser=$datauser['id_depo'];
			$iduser=$datauser['id'];
			
			if($cek > 0){
				if ($tipe_user=="user_ho_tb")
				{
					if($password=='pma123')
					{
						$data_session = array(
							'nama' => $username,
							'status' => "login",
							'tipe'=> $tipe_user,
							'iduser'=> $iduser,
							'iddepo'=>$iddepouser,
							'hakakses'=>'1'
							);	
							$this->session->set_userdata($data_session);
							redirect(base_url("index.php/dashboard"));
					}
					else{
						$data_session = array(
						'nama' => $username,
						'status' => "login",
						'tipe'=> $tipe_user,
						'iduser'=> $iduser,
						'iddepo'=>$iddepouser,
						'hakakses'=>'1'
						);
						$this->session->set_userdata($data_session);
						redirect(base_url("index.php/dashboard"));
					}
				}
				elseif ($tipe_user=="user_depo")
				{
					if($password=='pma123')
					{
						$data_session = array(
							'nama' => $username,
							'status' => "login",
							'tipe'=> $tipe_user,
							'iduser'=> $iduser,
							'iddepo'=>$iddepouser,
							'hakakses'=>'2'
							);	
							$this->session->set_userdata($data_session);
							redirect(base_url("index.php/dashboard"));
					}
					else{
						$data_session = array(
						'nama' => $username,
						'status' => "login",
						'tipe'=> $tipe_user,
						'iduser'=> $iduser,
						'iddepo'=>$iddepouser,
						'hakakses'=>'2'
						);
						$this->session->set_userdata($data_session);
						redirect(base_url("index.php/dashboard"));
					}
					
				}
				else 
				{
					$this->session->set_flashdata('akses', 'Anda tidak diizinkan untuk mengakses halaman ini. Silahkan menghubungi Tim Web Development untuk aktivasi akun.');
					redirect('login');
				}
			}
			else{
				$this->session->set_flashdata('gagal', 'Username dan Password Tidak Ditemukan');
				redirect('login');
			}
		}

		Public function forgot_password() //Jika user lupa password
		{
			$this->load->view('forgot_password');
		}

		
		Public function aksi_resetpassword()//Reset password setelah user memasukan username di form forget password
		{
			$username=$this->input->post('username');
			$cek=$this->m_data->cekuser($username);
			if($cek=='')
			{
				$this->session->set_flashdata('pwresetgagal', 'Username tidak diizinkan untuk mengakses halaman ini');
				redirect (base_url('index.php/login'));
			}
			else{
				$ubah=$this->m_data->resetpassword($username);
				if($ubah)
				{
					$this->session->set_flashdata('pwresetberhasil', 'Password berhasil direset, Silahkan Login Kembali menggunakan password default');
					redirect (base_url('index.php/login'));
				}
				else
				{
					$this->session->set_flashdata('pwresetgagal', 'Password gagal di reset');
					redirect (base_url('index.php/login'));
				}
			}
		}

		Public function ganti_passwordbaru()//merubah password default dengan password baru
		{
			$nama=$this->session->nama;
			$passwordbaru=$this->input->post('pass1');
			$passwordbaru2=$this->input->post('pass2');
			if($passwordbaru==$passwordbaru2)
			{
				$passwordbarumd=md5($passwordbaru);
				$this->m_data->gantipassword($nama,$passwordbarumd);
				$this->session->set_flashdata('pwbaruberhasil', 'Password baru berhasil didaftarkan, Silahkan login kembali dengan password baru anda');
				redirect (base_url('index.php/login'));
			}
			else
			{
				$this->session->set_flashdata('pwbaruberhasil', 'Password baru berhasil didaftarkan, Silahkan login kembali dengan password baru anda');
					redirect (base_url('index.php/login'));
			}	
		}

		Public function logout(){
			$this->session->sess_destroy();
			redirect(base_url('index.php/login'));
		}	
}