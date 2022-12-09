<?php
	class Rekening{
		private $id_user;
		private $saldo;
		
		public function setIduser($x){
			$this->id_user = $x;
		} 
		public function getIduser(){
			return $this->id_user;
		}
		public function setSaldo($x){
			$this->saldo = $x;
		} 
		public function getSaldo(){
			return $this->saldo;
		}
	}
?>
