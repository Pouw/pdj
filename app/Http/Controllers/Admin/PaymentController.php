<?php
namespace App\Http\Controllers\Admin;

use App\Libraries\Bank;
use Illuminate\Http\Request;
use App\Payments;

class PaymentController extends Controller {

	public function list(Request $request) {
		$data = [
			'payments' => Payments::orderByDesc('created_at')->get(),
		];
		return view('admin.payment.list', $data);
	}

	public function test() {
		$client = Bank::getBankClient();
		try {
//			dump($client->testPostConnection());
//			dump('OK');
			echo "<pre>";
			// See https://github.com/csob/paymentgateway/wiki/eAPI-v1-CZ#user-content-%C5%BDivotn%C3%AD-cyklus-transakce-
			$bankStatuses = [
				3, // Platba zrušena
				5, // Platba odvolána
				6, // Platba zamítnuta
				8, // Platba zúčtována
				10, // Platba vrácena
			];
			$bankStatuses = implode(', ', $bankStatuses);
			$payments = Payments::whereNotNull('pay_id')->whereRaw('(bank_status NOT IN (' . $bankStatuses . ') OR bank_status IS NULL)')->get();
			echo 'Checking ' . $payments->count() . ' payments:' . "\n";
			foreach ($payments as $payment) {
				$status = $client->paymentStatus($payment->pay_id);
				if ($payment->bank_status == $status) {
					echo 'Same ' . $payment->id . ' - ' . $status . ' : ' . $payment->state . "\n";
				} else {
					echo 'Change ' . $payment->id . ' - ' . $payment->bank_status . ' => ' . $status . ' : ' . $payment->state . "\n";
					$payment->bank_status = $status;
					$payment->save();
				}
			}
		} catch (\Exception $e) {
			echo "Something went wrong: " . $e->getMessage();
		}
	}


}
