<?php
require '../helpers/dbConnection.php';
require '../helpers/functions.php';



$sql = "select * from roles";
$RoleOp  = mysqli_query($con,$sql);



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fname      = Clean($_POST['fname']);
    $lname      = Clean($_POST['lname']);
    $email     = Clean($_POST['email']);
    $password  = Clean($_POST['password']); 
    $role_id   = $_POST['role_id'];
    $date   = Clean($_POST['date']);


   
    $errors = [];

    if (!Validate($fname, 1)) {
        $errors['fName'] = 'Required Field';
    } elseif (!Validate($fname, 6)) {
        $errors['fName'] = 'Invalid String';
    }

    if (!Validate($lname, 1)) {
        $errors['lName'] = 'Required Field';
    } elseif (!Validate($lname, 6)) {
        $errors['lName'] = 'Invalid String';
    }

    if (!Validate($email,1)) {
        $errors['Email'] = 'Field Required';
    } elseif (!Validate($email,2)) {
        $errors['Email'] = 'Invalid Email';
    }


    
    if (!Validate($password,1)) {
        $errors['Password'] = 'Field Required';
    } elseif (!Validate($password,3)) {
        $errors['Password'] = 'Length must be >= 6 chars';
    }

   
     if (!Validate($role_id,1)) {
        $errors['Role'] = 'Field Required';
    }elseif(!Validate($role_id,4)){
        $errors['Role'] = "Invalid Id";
    }

   
    if (!Validate($_FILES['image']['name'],1)) {
        $errors['Image'] = 'Field Required';
    }else{

         $ImgTempPath = $_FILES['image']['tmp_name'];
         $ImgName     = $_FILES['image']['name'];

         $extArray = explode('.',$ImgName);
         $ImageExtension = strtolower(end($extArray));

         if (!Validate($ImageExtension,7)) {
            $errors['Image'] = 'Invalid Extension';
         }else{
             $FinalName = time().rand().'.'.$ImageExtension;
         }

    }


    if (count($errors) > 0) {
        $Message = $errors;
    } else {
        
       $disPath = './uploads/'.$FinalName;


       if(move_uploaded_file($ImgTempPath,$disPath)){

        $sql = "insert into user (fname,lname,email,password,image,role_id,date) values ('$fname','$lname','$email','$password','$FinalName',$role_id,'$date')";
        $op = mysqli_query($con, $sql);

        if ($op) {
            $Message = ['Message' => 'Raw Inserted'];
        } else {
            $Message = ['Message' => 'Error Try Again ' . mysqli_error($con)];
        }
    
       }else{
        $Message = ['Message' => 'Error  in uploading Image  Try Again ' ];
       }
    
    }

    $_SESSION['Message'] = $Message;
}


?>

<head>
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</head>

<main>
    <div class="container-fluid">
        <ol class="breadcrumb mb-4">
            <h2 class="breadcrumb-item active">Register</h2>

            <?php
            echo '<br>';
            if (isset($_SESSION['Message'])) {
                Messages($_SESSION['Message']);
            
                unset($_SESSION['Message']);
            }
            
            ?>

        </ol>


        <div class="card mb-4">

            <div class="card-body">

                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="exampleInputName">FName</label>
                        <input type="text" class="form-control" id="exampleInputName" name="fname" aria-describedby=""
                            placeholder="Enter FName">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputName">LName</label>
                        <input type="text" class="form-control" id="exampleInputName" name="lname" aria-describedby=""
                            placeholder="Enter LName">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail">Email address</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="email"
                            aria-describedby="emailHelp" placeholder="Enter email">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword">New Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password"
                            placeholder="Password">
                    </div>



                    <div class="form-group">
                        <label for="exampleInputPassword">Role</label>
                        <select class="form-control" id="exampleInputPassword1" name="role_id">

                            <?php
                               while($data = mysqli_fetch_assoc($RoleOp)){
                            ?>

                            <option value="<?php echo $data['id'];?>"><?php echo $data['title'];?></option>

                            <?php }
                            ?>

                        </select>
                    </div>


                    <div class="form-group">
                        <label for="exampleInputName">Date Of Birth</label>
                        <input type="date" class="form-control" id="exampleInputName" name="date" aria-describedby="">
                    </div>


                    <div class="form-group">
                        <label for="exampleInputName">Image</label>
                        <input type="file" name="image">
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>





            </div>
        </div>
    </div>
</main>


