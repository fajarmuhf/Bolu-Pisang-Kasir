<?php
date_default_timezone_set('Asia/Jakarta');
session_start();

if(!(isset($_SESSION['username']) && isset($_SESSION['password']))){
  if(@$_SESSION['status']!="admin"){
    header('location:../index.php');
  }
}

if(isset($_REQUEST['stock']) && isset($_REQUEST['nama'])){
  $username = $_SESSION['username'];
  $password = $_SESSION['password'];  

  include "include/koneksi.php";
  $Koneksi = new Hubungi();

  $Koneksi->Konek("fandystore");

  $query="SELECT Id,Perum FROM `user-manager` WHERE Username = ? AND Password = ?";
  $exquery=$Koneksi->getKonek()->prepare($query);
  $exquery->bind_param("ss",$username,$password);
  $exquery->execute();

  if($exquery){
    $tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);

    $iduser = $tampil[0]["Id"];
    $perum = $tampil[0]["Perum"];
  }

  // Set the URL of the FCM API endpoint
  $url = 'https://fcm.googleapis.com/fcm/send';

  // Set the server key for authentication
  $server_key = 'AAAAhK6sLbo:APA91bFRAZGtiGHJKNYbaUdp7LTG8Q5pGeAej8eYPGDt3vI-yXR7PKOF3THceaggBGZa0HC9htlcGVG12VrjhdjAJ-buvMMmFXGFRzwrWDfRPL3JzMMmgn56fGht6LYN1HIqlsxc43S3';

  // Set the message payload
  $message = array(
    'data' => array(
      'title' => 'Stok Tinggal Sedikit',
      'body' => 'Stok '.$_REQUEST['stock'].' '.$_REQUEST['nama'].' di '.$perum,
      'click_action' => 'https://fandymuhf.my.id/bolupisang/control/cpanel/admin.php?page=penjualan&i=tampil'
    ),
    'registration_ids' => [
    //  device token
      ],
  );

  $query="SELECT * FROM `user-manager` WHERE token != '' ";
  $exquery=$Koneksi->getKonek()->prepare($query);
  $exquery->execute();
  if($exquery){
    $tampil=$exquery->get_result()->fetch_all(MYSQLI_ASSOC);
    
    for($i=0;$i<count($tampil);$i++){
      array_push($message['registration_ids'],$tampil[$i]["token"]);
    }
  }
  $messages = 'Stok '.$_REQUEST['stock'].' '.$_REQUEST['nama'].' di '.$perum;
  $tanggal = date("Y-m-d H:i:s");

  $query="INSERT INTO `notif` SELECT (COUNT(*)+1),?,? FROM `notif` WHERE 1 ";
  $exquery=$Koneksi->getKonek()->prepare($query);
  $exquery->bind_param("ss",$messages,$tanggal);
  $exquery->execute();

  // Set additional cURL options
  $options = array(
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => array(
      'Authorization: key=' . $server_key,
      'Content-Type: application/json',
    ),
    CURLOPT_POSTFIELDS => json_encode($message),
  );

  // Create a new cURL resource and set the options
  $curl = curl_init();
  curl_setopt_array($curl, $options);

  // Send the HTTP request and get the response
  $response = curl_exec($curl);

  // Check for errors
  if ($response === false) {
    echo 'Error sending message: ' . curl_error($curl);
  } else {
    echo 'Message sent successfully';
  }

  // Close the cURL resource
  curl_close($curl); 
}

?>
