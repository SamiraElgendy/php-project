<?php
require './helpers/dbConnection.php';
require './helpers/functions.php';
$dataUser=$con->query("select * from user ");
        $result=$dataUser->fetch_assoc();
if(isset($_GET['id'])){
    if($con->connect_errno){
        echo "fail connect";
    }else{
        $data=$con->query("select * from articals where id={$_GET['id']}");
        $results=$data->fetch_assoc();

}

$con->close();

}else{
    echo"error";
}
?>
<html>
<head>
    <style>
.post-image img{
 height: 250px;
 width: 50%;
}
.post-desc{
    height: 250px;
 width: 50%; 
}
</style>
</head>
<body>
        <div class="post col-md-6">
            <div class="post-image ">
                <img class="img-fluid " src="./Articales/uploads/<?php echo $results['image'];?>" alt="">
            </div><br>
            <div class="post-desc">
                <div class="post-date">
                    <?php echo date($results['date'])?>
                </div>
                <div class="post-title">
                    <h2><?php echo $results['title'];?></h2>
                </div>
                <h4 class="col-md-6"> <?php echo $results['content'];?></h4>
                <div class="post-author">
                   <span><?php echo "<b>Writer Name </b>".$result['fname']." ".$result['lname'];?></span>
                </div>
            </div>
        </div>
</body>

</html>