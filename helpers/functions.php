<?php 

function Clean($input){

     return  trim(strip_tags(stripslashes($input)));
}


  function Validate($input,$flag,$length = 6){

    $status = true;

     switch ($flag) {
         case 1:
             if (empty($input)) {
                $status = false;
             }
             break;
      
        case 2: 
         if (!filter_var($input, FILTER_VALIDATE_EMAIL)){
            $status = false;
         } 
          break;


        case 3: 
           if (strlen($input) < $length){
               $status = false;
           }  
           break;
 

        case 4: 
         if (!filter_var($input, FILTER_VALIDATE_INT)){
            $status = false;
         } 
          break;    



          case 5: 
           if(!preg_match('/^01[0-2,5][0-9]{8}$/',$input)){
               $status = false;
           }  
           break;  




           case 6: 
              if(!preg_match('/^[a-zA-Z\s]*$/',$input)){
                 $status = false;
              }
              break;


            case 7: 
            $allowedExt = ['png','jpg','jpeg']; 
                 if(!in_array($input,$allowedExt)){
                    $status = false;
                 }
            break;

     }

     return $status;

  }



   function Messages($Message){
    foreach ($Message as $key => $value) {
            # code...
            echo '* ' . $key . ' : ' . $value . '<br>';
            
        }

   }




?>