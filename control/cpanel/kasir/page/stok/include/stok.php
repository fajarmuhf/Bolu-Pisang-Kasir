<?php
	class Stok{
		private $id_user;
		private $id_barang;
		private $jumlah;
		
		public function setIduser($x){
			$this->id_user = $x;
		} 
		public function getIduser(){
			return $this->id_user;
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
	}
?>
