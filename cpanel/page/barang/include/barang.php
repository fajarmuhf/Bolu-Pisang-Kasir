<?php
	class Barang{
		private $nama;
		private $harga;
		private $ket;
		private $gambar;
		
		public function setNama($x){
			$this->nama = $x;
		} 
		public function getNama(){
			return $this->nama;
		}
		public function setKet($x){
			$this->ket = $x;
		} 
		public function getKet(){
			return $this->ket;
		}
		public function setHarga($x){
			$this->harga = $x;
		} 
		public function getHarga(){
			return $this->harga;
		}
		public function setGambar($x){
			$this->gambar = $x;
		} 
		public function getGambar(){
			return $this->gambar;
		}
	}
?>
