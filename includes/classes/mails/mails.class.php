<?php
require_once realpath(dirname(__FILE__) . '/..') .'/users/users.class.php';
class Mails
{
	
	public function getHeader($Sender)
	{
		$headers = "From: " . strip_tags($Sender) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($Sender) . "\r\n";
		$headers .= "CC: brahim@moullablad.com\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		return $headers;
	}

	public function getMessage($Sender,$Receiver,$Subject,$Text){
		$body = '<html dir="rtl">';
		$body .= '<head>';
		$body .= '<title>'.$Subject.'</title>';
		$body .= '<link rel="important stylesheet" href="chrome://messagebody/skin/messageBody.css">';
		$body .= '<meta charset="UTF-8">';
		$body .= '</head>';
		$body .= '<body>';
		$body .= '<div style="background-color:#719f19">';
		$body .= '<table width="100%"><tbody><tr><td><table width="550px" align="center"><tbody><tr><td><div style="border-radius:11px 11px 10px 10px;border:1px solid #dddddd;border-color:rgba(0,0,0,0.13);background-color:#fff"><div style="border-radius:10px 10px 0 0;font-family: \'Helvetica Neue\', Arial, sans-serif; font-size: 24px; background-color:#fff;padding:17px 20px 13px;color:#fff;font-weight:bold"><span style="font-size:18px; font: Helvetica Neue; color:#ffffff; display:inline-block; line-height:25pt; margin-right:1em; "></span></div><div style="padding:25px">';
		$body .= '<div style="font-family: \'Helvetica Heue\', Arial, sans-serif; font-size: 14px; line-height: 18px;">السلام عليكم,<br /><br />';
		$body .= $Text;
		$body .= '<br /><br /><br />شكرا,<br />فريق عمل شخصيات</div></div><div style="font-family:\'Helvetica Heue\', Arial, sans-serif;padding:15px 25px;color:#6C6C67;border-top:2px solid #dddddd; line-height: 18px;"><table width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;"><tr><td><div style="font-size:10px;color:#6C6C67;text-align:right"><p style="color:#808080;font-family: \'Helvetica Heue\', Arial, sans-serif; font-size: 12px; line-height: 18px;margin:0">شخصيات هو موقع توصل اسلامي للسنيين</p></td></tr></table></div></div></td></tr></tbody></table></td></tr></tbody></table></div></body></html>';
		return $body;

	}
	public function SendXpressMail($Sender,$Receiver,$Subject,$Text){
		$Users = new user();
		$Sender = $Users->getEmailByID($Sender);
		$Receiver = $Users->getEmailByID($Receiver);
		$headers = self::getHeader($Sender);
		$message = self::getMessage($Sender,$Receiver,$Subject,$Text);
		if(mail($Receiver,$Subject,$message,$headers))
		{
			return true;
		}else{
			return false;
		}
	}
}
?>