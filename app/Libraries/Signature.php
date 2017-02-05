<?php

namespace App\Libraries;


class Signature {

	private $privateKey;
	private $privateKeyPassword;
	private $publicKey;

	public function __construct($publicKey, $privateKeyPassword, $privateKey)
	{
		$path = base_path('cert') . DIRECTORY_SEPARATOR;
		$privateKey = $path . $privateKey;
		$publicKey = $path . $publicKey;

		$fp = fopen($privateKey, 'r');
		$this->privateKey = fread($fp, filesize($privateKey));
		fclose($fp);
		$this->privateKeyPassword = $privateKeyPassword;

		$fp = fopen($publicKey, 'r');
		$this->publicKey = fread($fp, filesize($publicKey));
		fclose($fp);
	}

	function sign($text){
		$publicKeyOd = openssl_get_privatekey($this->privateKey, $this->privateKeyPassword);
		openssl_sign($text, $signature, $publicKeyOd);
		$signature = base64_encode($signature);
		openssl_free_key($publicKeyOd);
		return $signature;
	}

	function verify($text, $signature){
		$publicKeyOd = openssl_get_publickey($this->publicKey);
		$signature = base64_decode($signature);
		$result = openssl_verify($text, $signature, $publicKeyOd);
		openssl_free_key($publicKeyOd);
		return $result == 1;
	}

}
