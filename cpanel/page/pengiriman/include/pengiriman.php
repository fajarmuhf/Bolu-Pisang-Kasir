<?php
	class Pengiriman{
		private $tanggal;
		private $id_user;
		private $id_target;
		private $id_barang;
		private $jumlah;
		private $status;
		
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
		public function setIdtarget($x){
			$this->id_target = $x;
		} 
		public function getIdtarget(){
			return $this->id_target;
		}
		public function setIdbarang($x){
			$this->id_barang = $x;
		} 
		public function getIdbarang(){
			return $this->id_barang;
		}
		public function setJumlah($x){
			$this->jumlah = $x;
		} 
		public function getJumlah(){
			return $this->jumlah;
		}
		public function setStatus($x){
			$this->status = $x;
		} 
		public function getStatus(){
			return $this->status;
		}
	}
?>
