<?php

namespace App\Http\Controllers\Admin;


use App\Registration;

class RegistrationController extends Controller
{

	public function log($id) {
		$reg = Registration::findOrFail($id);
		foreach ($reg->logs as $log) {
			$log->data = json_decode($log->content);
		}
		return view('admin.registration.log', ['logs' => $reg->logs]);
	}

}
