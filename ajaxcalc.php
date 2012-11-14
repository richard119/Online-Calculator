<?php
   session_start();

//------- initial global variant ---------------------
   if(isset($_SESSION['result'])){       // current value
       $g_result = $_SESSION['result'];
   }
   else{
       $g_result = 0;
   }
 
   if(isset($_SESSION['operator'])){    // operator: + - * /
       $g_opt = $_SESSION['operator'];
   }
   else{
       $g_opt = '';
   }

   if(isset($_SESSION['operand'])){    // last time value
       $g_opnum = $_SESSION['operand'];
   }
   else{
       $g_opnum = 0;
   } 
 
   if(isset($_SESSION['isNum'])){      // last button is Number?
       $g_isNum = $_SESSION['isNum'];
   }
   else{
       $g_isNum = '';
   } 
  
   if(isset($_SESSION['decimal'])){   // decimal number
       $g_dec = $_SESSION['decimal'];
   }
   else{
       $g_dec = 0;
   } 
//-------------------------------------------

   $input =  $_POST['name'];
   $out   =  $_POST['out'];
   if( $out == '0.' ) {
      $g_result = 0;
   }

   if (eregi("[0-9]",$input))
   {
      if( $g_dec == 0 ){
        $g_result = $g_result*10 + (int)$input;
      }
      else{
        $g_result = $g_result + (int)$input / pow(10,$g_dec);
        $g_dec++;
      }
      echo $g_result;

      $g_isNum  = 'Y'; 
  }
  elseif( $input == '.' ){
      echo $g_result;
      $g_dec = 1;
      $g_isNum = 'Y';
  }
  elseif( $input == '+' || $input == '-' || $input == '*' || $input == '/' ){
      if ($g_isNum == 'Y'){ 
         $g_opnum = $g_result; 
         echo $g_result;
      }
      else{
         echo $g_opnum;
      } 

      $g_opt = $input; 
      $g_result = 0;
      $g_isNum = ''; 
      $g_dec = 0;
   }
   elseif( $input == '='){
     if( $g_isNum == 'Y' ){
        switch($g_opt){
          case '':
             break;
          case '+':
             $g_result = $g_result + $g_opnum;
             break;
          case '-':
             $g_result = $g_opnum - $g_result;
             break;
          case '*':
             $g_result = $g_opnum * $g_result;
             break;
          case '/':
             $g_result = $g_opnum / $g_result;
             break;
        }

        echo $g_result;
        $g_opnum = $g_result;        
        $g_result = 0;

      }
      else{
        echo $g_opnum;        
      }
      
      $g_opt = ''; 
      $g_isNum = ''; 
      $g_dec = 0;
   }
   else
   {  echo "0.";
      $g_result = 0;
      $g_opt = '';
      $g_opnum = 0;
      $g_isNum = '';
      $g_dec = 0;
   }  


   $_SESSION['result'] = $g_result; 
   $_SESSION['operator'] = $g_opt; 
   $_SESSION['operand'] = $g_opnum; 
   $_SESSION['isNum'] = $g_isNum; 
   $_SESSION['decimal'] = $g_dec;
?>
