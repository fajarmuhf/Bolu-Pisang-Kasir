<?php
	class Penjualan{
		private $tanggal;
		private $id_user;
		private $id_barang;
		private $jumlah;
		
		public function setTanggal($x){
			$this->tanggal = $x;
		} 
		public function getTanggal(){
			return $this->tanggal;
		}
		public function setIduser($x){
			$this->id_user = $x;
		} 
		public function getIduser(){
			return $this->id_user;
		}
		public function setIdbarang($x){
			$this->id_mobil = $x;
		} 
		public function getIdbarang(){
			return $this->id_mobil;
		}
		public function setJumlah($x){
			$this->jumlah = $x;
		} 
		public function getJumlah(){
			return $this->jumlah;
		}
	}
?>
