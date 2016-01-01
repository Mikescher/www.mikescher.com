<?php

class SendMailForm extends CFormModel {
	public $name;
	public $email;
	public $header;
	public $message;


	public function rules()
	{
		return array(
			array('name, email, header, message', 'required'),
			array('name', 		'length', 'min'=>3, 'max'=>128),
			array('email', 		'length', 'min'=>5, 'max'=>128),
			array('header', 	'length', 'min'=>0, 'max'=>200),
			array('message', 	'length', 'min'=>1, 'max'=>20000),
		);
	}

	public function send() {
		$Software = getenv("SERVER_SOFTWARE");
		$ip = getenv("REMOTE_ADDR");
		$date = date('Y-m-d G:i:s');
		$Browser = $_SERVER['HTTP_USER_AGENT'];

		$empfaenger = "kundenservice@mikescher.de";
		$betreff = "Neue Mail für Mikescher.com vom Typ Kontaktformular ($this->header)";
		$text =
"
Name: $this->name

Typ : Kontaktformular

IP: $ip

Datum: $date

E-Mail: $this->email

Software: $Software

Browser: $Browser

Header: $this->header

Text: $this->message
";

		if (! (empty($name) && empty($textin) && empty($typ) && empty($link) && empty($email)) )
		{
			return mail($empfaenger, $betreff, $text,"From: Mikescher <spamcatcher@mikescher.de>");
		}
		else
		{
			return false;
		}
	}
} 