<?php
function calculate($result,$opt,$opnum){
        switch($opt){
          case '':
             break;
          case '+':
             $result = $result + $opnum;
             break;
          case '-':
             $result = $opnum - $result;
             break;
          case '*':
             $result = $opnum * $result;
             break;
          case '/':
             $result = $opnum / $result;
             break;
         }
	return $result;
}

function showresult($arr){
     echo json_encode($arr); 
}

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


  $g_array = array("Num"=>0,"MR"=>'N');
//-------------------------------------------


   $input =  $_POST['name'];
   $out   =  $_POST['out'];
   if( $out == '0.' ) {
      $g_result = 0;
   }

   if (eregi("[0-9]$",$input))
   {
      if( $g_dec == 0 ){
        $g_result = $g_result*10 + (int)$input;
      }
      else{
        $g_result = $g_result + (int)$input / pow(10,$g_dec);
        $g_dec++;
      }

      $g_array["Num"] = $g_result;
      showresult($g_array);

      $g_isNum  = 'Y'; 
  }
  elseif( $input == '.' ){
      $g_array["Num"] = $g_result;
      showresult($g_array);
      
      if( $g_dec == 0 ){
        $g_dec = 1;
      }  
      $g_isNum = 'Y';
  }
  elseif( $input == 'CE'){
      $g_result = 0;
      $g_dec = 0;

      $g_array["Num"] = $g_result;
      showresult($g_array);

      $g_isNum = 'Y';
  }
  elseif( $input == '+/-'){
      if($g_isNum == 'Y'){
        $g_result = $g_result * (-1);
        $g_array["Num"] = $g_result;
      }
      else{
        $g_opnum = $g_opnum * (-1);
        $g_array["Num"] = $g_opnum;
      }

      showresult($g_array);
  }
  elseif( $input == 'sqrt'){
      if($g_isNum == 'Y'){
        $g_result = sqrt($g_result);
        $g_array["Num"] = $g_result;
      }
      else{
        $g_opnum = sqrt($g_opnum);
        $g_array["Num"] = $g_opnum;
      }

      showresult($g_array);
  }
  elseif( $input == '1/x'){
      if($g_isNum == 'Y'){
        $g_result = 1 / $g_result;
        $g_array["Num"] = $g_result;
      }
      else{
        $g_opnum = 1 / $g_opnum;
        $g_array["Num"] = $g_opnum;
      }
      showresult($g_array);
  }
  elseif( $input == '%'){
      if($g_isNum == 'Y'){
        $g_result = $g_opnum * $g_result/100;
        $g_array["Num"] = $g_result;
      }
      else{
        $g_opnum = $g_opnum * $g_opnum/100;
        $g_array["Num"] = $g_opnum;
      }
      showresult($g_array);
  }
  elseif( $input == 'Back'){
      if( $g_dec == 0 ){
        $g_result = $g_result / 10;
        if( $g_result > 0){
           $g_result = floor($g_result);
	} 
	else{
           $g_result = ceil($g_result);
	}
      }
      else{
        $g_dec = $g_dec - 1; //$g_dec is next decimal number
	$g_result = $g_result * pow(10, $g_dec-1); 
        if( $g_result > 0){
           $g_result = floor($g_result);
	} 
	else{
           $g_result = ceil($g_result);
	}
	$g_result = $g_result / pow(10, $g_dec-1);
	if($g_dec==1)$g_dec=0;  // when back to integer, delet point as well
      }  

      $g_array["Num"] = $g_result;
      showresult($g_array);

      $g_isNum = 'Y';
  }
  elseif( $input == '+' || $input == '-' || $input == '*' || $input == '/' ){
      if ($g_isNum == 'Y'){ 
	 if($g_opt != '')$g_result = calculate($g_result,$g_opt,$g_opnum);
         $g_opnum = $g_result; 
         $g_array["Num"] = $g_result;
      }
      else{
         $g_array["Num"] = $g_opnum;
      } 

      showresult($g_array);
      $g_opt = $input; 
      $g_result = 0;
      $g_isNum = ''; 
      $g_dec = 0;
   }
   elseif( $input == '='){
     if( $g_isNum == 'Y' ){
        $g_result = calculate($g_result,$g_opt,$g_opnum);
        $g_array["Num"] = $g_result;
        $g_opnum = $g_result;        
        $g_result = 0;
      }
      else{
        $g_array["Num"] = $g_opnum;
      }
      
      showresult($g_array);
      $g_opt = ''; 
      $g_isNum = ''; 
      $g_dec = 0;
   }
   else
   {  
      
      $g_array["Num"] = "0.";
      showresult($g_array);
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
