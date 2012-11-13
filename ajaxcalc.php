<?php
   session_start();

   if(isset($_SESSION['result'])){
       $result = $_SESSION['result'];
   }
   else{
       $result = 0;
   }
 
   if(isset($_SESSION['operator'])){
       $operator = $_SESSION['operator'];
   }
   else{
       $operator = '';
   }

   if(isset($_SESSION['operand'])){
       $operand = $_SESSION['operand'];
   }
   else{
       $operand = 0;
   } 
 
   if(isset($_SESSION['isNum'])){
       $isNum = $_SESSION['isNum'];
   }
   else{
       $isNum = '';
   } 
  
   $input =  $_POST['name'];
   $out   =  $_POST['out'];
   if( $out == '0.' ) {
      $result = 0;
   }

   if (eregi("[0-9]",$input))
   {
      $input = $result*10 + (int)$input;
      echo $input;
      $_SESSION['result'] = $input;
      $_SESSION['isNum'] = 'Y'; 
  }
   elseif( $input == '+' || $input == '-' || $input == '*' || $input == '/' ){
      $_SESSION['operator'] = $input; 
      $_SESSION['result'] = 0;
      $_SESSION['isNum'] = ''; 

      if ($isNum == 'Y'){ 
         $_SESSION['operand'] = $result; 
         echo $result;
      }
      else{
         echo $operand;
      } 
   }
   elseif( $input == '='){
      if( $isNum == 'Y' ){
        switch($operator){
          case '':
             break;
          case '+':
             $result = $result + $operand;
             break;
          case '-':
             $result = $operand - $result;
             break;
          case '*':
             $result = $operand * $result;
             break;
          case '/':
             $result = $operand / $result;
             break;
        }

        echo $result;        
        $_SESSION['result'] = 0;
        $_SESSION['operand'] = $result; 
        $_SESSION['operator'] = ''; 
        $_SESSION['isNum'] = ''; 
      }
      else{
        echo $operand;        
        $_SESSION['operator'] = ''; 
        $_SESSION['isNum'] = ''; 
      }
   }
   else
   {  echo "0.";
      $_SESSION['result'] = 0; 
      $_SESSION['operator'] = ''; 
      $_SESSION['operand'] = 0; 
      $_SESSION['isNum'] = ''; 
   }  
?>
