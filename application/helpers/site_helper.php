<?php
if(!function_exists('remove_comma')) {
  function remove_comma($value) {
    return str_replace(',','',$value);
  }
}
////////////////GETA  FEILD ////////////////////////////////////////////
if(!function_exists('getAfield')) {
  function getAfield($field,$table,$cond)
  {
   $ci =& get_instance();
   $class = $ci->db->query("SELECT $field FROM $table  $cond");
   $rows=$class->num_rows();
   if($rows>0)
   {
   $class = $class->result_array();
   return $class[0][$field];
   }
   else {
     return "";
   }
  }
}

function insertInDb($table,$data)
{
  $ci =& get_instance();
  if($ci->db->insert($table, $data))
  {
    $insert_id = $ci->db->insert_id();
    return $insert_id;
  }
}
function simpleUpdate($table,$data,$coloumn="id",$val)
{
    $ci =& get_instance();
    $ci->db->where($coloumn, $val);
    if($ci->db->update($table, $data))
    {
      return 1;
    }
    else {
      return 2;
    }
}
function update($table,$data,$where)
{
  $ci =& get_instance();
  $ci->db->where($where);
  if($ci->db->update($table, $data))
  {
    return 1;
  }
  else {
    return 2;
  }
}



function checkexist($feild,$table,$cond)
{
  $ci =& get_instance();
  $class = $ci->db->query("SELECT $feild FROM $table $cond");
  $rows=$class->num_rows();
  if($rows>0)
  {
  $class = $class->result_array();
  return 1;
  }
  else {
    return 0;
  }
}
function echomsg($mes)
{
	if($mes) print("<script type=\"text/JavaScript\">alert(\"$mes\"); </script>");
}
function getDateIn_YMD($dt)
{
	$year=substr($dt,6,4);
	$month=substr($dt,3,2);
	$day=substr($dt,0,2);
	$date=$year."-".$month."-".$day;
	return($date);

}
function LoadCombo($TName,$FiledCodeName,$FieldDescName,$SelectCode,$Cond,$ordby)
{
 $ci =& get_instance();
 $sql="select ". $FiledCodeName. "," .$FieldDescName ." from ". $TName . " ". $Cond." ".$ordby;
 $query = $ci->db->query($sql);

   if ($query->num_rows() > 0)
  {
     foreach ($query->result() as $row)
     {
        $id= $row->$FiledCodeName;
        $value= $row->$FieldDescName;

        if($id==$SelectCode)
        {
          	print("<option value=$id selected=selected>$value</option>");
        }
        else {
          	print("<option value=$id >$value</option>");
        }
     }
  }

}

function secretkeyGneration($action,$string,$key="CImsdYkmPHnsfruypojkeER",$out=1)
{
  $Cipherkey="CImsdYkmPHnsfruypojkeER";
  if($key==$Cipherkey)
  {
    if(($action=="encrypt" || $action=="decrypt" ) && $string!="")
   {
     $output = false;
     $encrypt_method = "AES-256-CBC";
     $secret_key = 'cipher secret key';
     $secret_iv = 'secret cipher iv';
     // hash
     $key = hash('sha256', $secret_key);

     // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
     $iv = substr(hash('sha256', $secret_iv), 0, 16);
     if ( $action == 'encrypt' ) {
         $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
         $output = base64_encode($output);
     } else if( $action == 'decrypt' ) {
         $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
     }
     if($out==1)   print $output; else  return $output;

   }
   else
   {
         $output="Invalid paramertes";
             if($out==1)   print $output; else  return $output;
   }
  }

}

function sendSms($mobile_number,$sms_text)
{
	$sms_text = urlencode($sms_text);
	 $url = "http://sms.datagenit.com/api.php?username=cipher&password=cpakhil459&sender=CIPHER&sendto=" . $mobile_number . "&message=" . $sms_text;
	// $ch = curl_init($url);
	// curl_setopt($ch, CURLOPT_HEADER, 0);
	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	// $output = curl_exec($ch);
	// curl_close($ch);

  $res=file_get_contents($url);
  //print_r($res);
  if($res) return 1; else return 2;



}
/////////////////////////////////////////
 ?>
