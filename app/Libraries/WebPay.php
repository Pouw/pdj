<?php

namespace App\Libraries;


use App\Currency;

class WebPay {

	public static function isDebug() {
		if (getenv('WEBPAY_DEBUG') === 'false') {
			return false;
		}
		return true;
	}

	public static function getMySignature(): Signature {
		if (self::isDebug()) {
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
		if (self::isDebug()) {
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
		if (self::isDebug()) {
			return 'https://test.3dsecure.gpwebpay.com/pgw/order.do';
		}
		return 'https://3dsecure.gpwebpay.com/pgw/order.do';
	}

	public static function getCurrency(int $currencyId): int {
		$czk = 203;
		$eur = 978;
		return $currencyId === Currency::CZK ? $czk : $eur;
	}

}
