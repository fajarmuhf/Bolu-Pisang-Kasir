<?php
	class Hubungi{
		//Local
		private $namaserver = "localhost";//127.0.0.1
		private $namauser = "root";
		private $password = "";
		private $koneksi;
		//Public
		/*private $namaserver = "mysql.3owl.com:3306";//127.0.0.1
		private $namauser = "u315190910_db";
		private $password = "021naruto";
		private $koneksi;
		*/
		public function Konek($database){
			$this->koneksi = mysql_connect($this->namaserver,$this->namauser,$this->password);
			//$database = "u315190910_db";//Public
			mysql_select_db($database);
		}
		public function getKonek(){
			return $this->koneksi;
		}
	}
?>
