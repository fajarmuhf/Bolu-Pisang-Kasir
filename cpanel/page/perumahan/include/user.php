<?php
	class User{
		private $username;
		private $password;
		private $status;
		
		public function setUsername($x){
			$this->username = $x;
		} 
		public function getUsername(){
			return $this->username;
		}
		public function setPassword($x){
			$this->password = $x;
		} 
		public function getPassword(){
			return $this->password;
		}
		public function setStatus($x){
			$this->status = $x;
		} 
		public function getStatus(){
			return $this->status;
		}
	}
?>
