<?php

function SendMail_v1($to,$sub,$data,$view)
{
//echo "$to,$sub,$data,$view";
	$ci =& get_instance();
	$ci->load->library('email');
	$msg = $ci->load->view('email/header',$data,true);
	$msg .= $ci->load->view($view,$data,true);
	$msg .= $ci->load->view('email/footer',$data,true);
	$config['protocol']='smtp';
	// $config['smtp_host']='smtp.googlemail.com';

	$config['smtp_host']='ssl://smtp.gmail.com';
	$config['smtp_port']='465';
	$config['smtp_timeout']='30';
	$config['smtp_user']='arunradhakrishnan40@gmail.com';
	// $config['smtp_pass']='$a1r2u3n$';
	$config['smtp_pass']='$a1r2u3n$';
	$config['charset']='utf-8';
	$config['newline']="\r\n";
	$config['wordwrap'] = TRUE;
	$config['mailtype'] = 'html';
	$ci->email->initialize($config);
	$ci->email->from('info@citymedicines.com',"City Medicines");
	$ci->email->to($to);
	$ci->email->subject($sub);
	$ci->email->message($msg);
	$x =  $ci->email->send();
		$d = $ci->email->print_debugger();
	//	print_r($d);
	if(!$x){
		$d = $ci->email->print_debugger();
		log_message('error', 'Switching to normal mail,SMTP mail failed :'.$d);
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: City Medicines<info@citymedicines.com>" ;
		return @mail($to,$sub,$msg,$headers);
	}
	return $x;
}
// function mailto_ar($to,$sub,$msg)
// {
// }

function SendMail_v2($to,$sub,$data,$view)
{
	 $message="";
	 $subject = $sub;
	 $headers = "From: MOBITRADOS <info@ciphertechnologies.co.in>". "\r\n";
	 //$headers .= "CC: akhilaptvm@gmail.com\r\n";
	 $headers .= "MIME-Version: 1.0\r\n";
	 $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	 $msg = $ci->load->view('email/header',$data,true);
 	 $msg .= $ci->load->view($view,$data,true);
 	 $msg .= $ci->load->view('email/footer',$data,true);
	 $message.=$msg;
	 $mail=	mail($to, $subject, $message, $headers);

	 if($mail)
	 {
	    return 1;
	 }
	 else
	 {
	     return 0;
	 }

}

function SendMail($to,$sub,$data,$view)
{

  $ci =& get_instance();
	$ci->load->library('email');
	$msg = $ci->load->view('email/header',$data,true);
	$msg .= $ci->load->view($view,$data,true);
	$msg .= $ci->load->view('email/footer',$data,true);
	$config['protocol']='smtp';
	// $config['smtp_host']='smtp.googlemail.com';

	$config['smtp_host']='mail.ciphertechnologies.co.in';
	$config['smtp_port']='26';  // 465 for ssl
	$config['smtp_timeout']='30';
	$config['smtp_user']='info@ciphertechnologies.co.in';
	$config['smtp_pass']='akhil@cipher#l';
	$config['charset']='utf-8';
	$config['newline']="\r\n";
	$config['wordwrap'] = TRUE;
	$config['mailtype'] = 'html';
	$ci->email->initialize($config);
	$ci->email->from('info@ciphertechnologies.co.in',"MOBITRADOS");
	$ci->email->to($to);
	$ci->email->subject($sub);
	$ci->email->message($msg);
	$x =  $ci->email->send();
	$d = $ci->email->print_debugger();
	print_r($d);
    return $x;

}
?>
