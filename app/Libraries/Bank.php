<?php

namespace App\Libraries;

use OndraKoupil\Csob\Config;
use OndraKoupil\Csob\Client;
use OndraKoupil\Csob\GatewayUrl;
use OndraKoupil\Csob\Payment;

class Bank {

	static public function getBankClient() {
		$config = new Config(
			'M1E3CB1201', // My Merchant ID
			base_path('cert') . DIRECTORY_SEPARATOR . 'rsa_M1E3CB1201.key', // path/to/my/private/key/file.key
			base_path('cert') . DIRECTORY_SEPARATOR . 'mips_platebnibrana.csob.cz.pub', // path/to/bank/public/key.pub
			'Rainbow Prague Spring', // My shop name

			// Adresa, kam se mají zákazníci vracet poté, co zaplatí
			$_SERVER['APP_URL'] . '/payment/return',

			// URL adresa API - výchozí je adresa testovacího (integračního) prostředí,
			// až budete připraveni přepnout se na ostré rozhraní, sem zadáte
			// adresu ostrého API.
			GatewayUrl::PRODUCTION_LATEST
		);

		$client = new Client($config);
		return $client;
	}

	static public function createPayment() {
		return new Payment();
	}

}
