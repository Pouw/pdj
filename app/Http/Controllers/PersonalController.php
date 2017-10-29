<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;
use App\Country;

class PersonalController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function index(Request $request) {
		$data = [
			'user' => $request->user(),
			'currencies' => Currency::all(),
			'countries' => Country::orderBy('name')->get(),
			'isSinglePage' => $this->isSinglePage($request),
		];
		return view('personal', $data);
	}

	public function saveNext(Request $request) {
		$this->save($request);
		return redirect('/registration');
	}

	public function saveSingle(Request $request) {
		$this->save($request);
		$request->session()->flash('alert-success', 'Your personal has been save.');
		return redirect('/');
	}

	public function save(Request $request) {
		$countryId = intval($request->get('country_id'));
		$currencyId = intval($request->get('currency_id'));

		$rules = [
			'birthdate' => 'required|date|before:-6 years',
		];
		if ($countryId !== Country::CZECHIA) {
			$rules['currency_id'] = 'in:' . Currency::EUR;
		}
		if ($request->get('is_member') === '1' && $currencyId !== Currency::CZK) {
			$rules['is_member'] = 'in:0';
		}

		$request->validate($rules,[
			'currency_id.in' => "You can pay in EUR only.",
			'is_member.in' => "You can't be an Alceco member and pay in EUR.",
		]);

		$user = $request->user();
		$user->name = $request->get('name');
		$user->birthdate = $request->get('birthdate');
		$user->is_member = $request->get('is_member');
		$user->currency_id = $request->get('currency_id');
		$user->country_id = $request->get('country_id');
		$user->city = $request->get('city');
		$user->save();

		return redirect('/registration');
	}

}
