<?php 

require '../helpers/dbConnection.php';


$id = $_GET['id'];

$sql = "select * from articals where id = $id";
$op  = mysqli_query($con,$sql);

$data = mysqli_fetch_assoc($op);

if(mysqli_num_rows($op) == 1){

   $sql = "delete from articals where id = $id";
   $op  = mysqli_query($con,$sql);

   if($op){

    unlink('./uploads/'.$data['image']);

       $Message = ["Message" => "Raw Removed"];
   }else{
       $Message = ["Message" => "Error try Again"];
   }


}else{
    $Message = ["Message" => "Invalid Id "];
}

 
   $_SESSION['Message'] = $Message;

   header("location: index.php");

?>