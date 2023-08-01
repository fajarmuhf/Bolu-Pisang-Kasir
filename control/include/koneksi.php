<?php
	class Hubungi{
		//Local
		private $namaserver = "localhost";//127.0.0.1
		private $namauser = "root";
		private $password = "";
		private $judul = "Bolu Pisang";
		private $koneksi;
		//Public
		/*private $namaserver = "mysql.3owl.com:3306";//127.0.0.1
		private $namauser = "u315190910_db";
		private $password = "021naruto";
		private $koneksi;
		*/
		public function Konek($database){
			$database = "bolupisang";//Public
			$this->koneksi = mysqli_connect($this->namaserver,$this->namauser,$this->password,$database);
		}
		public function getKonek(){
			return $this->koneksi;
		}
		public function getJudul(){
			return $this->judul;
		}
	}
?>
