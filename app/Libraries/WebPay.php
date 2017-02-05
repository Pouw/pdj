<?php

namespace App\Libraries;


class WebPay {

	public static function getMySignature(): Signature {
		$isDebug = getenv('WEBPAY_DEBUG');
		if ($isDebug) {
			$publicKey = 'test-public.pem';
			$passPhrase = getenv('WEBPAY_PASS_DEBUG');
			$privateKey = 'test-private.pem';
		} else {
			$publicKey = 'prod-public.pem';
			$passPhrase = getenv('WEBPAY_PASS');
			$privateKey = 'prod-private.pem';
		}
		return new Signature($publicKey, $passPhrase, $privateKey);
	}

	public static function getBankSignature(): Signature {
		$isDebug = getenv('WEBPAY_DEBUG');
		if ($isDebug) {
			$publicKey = 'muzo.signing_test.pem';
			$passPhrase = getenv('WEBPAY_PASS_DEBUG');
			$privateKey = 'test-private.pem';
		} else {
			$publicKey = 'muzo.signing_prod.pem';
			$passPhrase = getenv('WEBPAY_PASS');
			$privateKey = 'prod-private.pem';
		}
		return new Signature($publicKey, $passPhrase, $privateKey);
	}

	public static function getBankUrl(): string {
		$isDebug = getenv('WEBPAY_DEBUG');
		if ($isDebug) {
			return getenv('WEBPAY_URL_DEBUG');
		}
		return getenv('WEBPAY_URL');
	}

}
