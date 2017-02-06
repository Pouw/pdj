<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;
use App\Country;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Sport;
use App\RegistrationSportDisciplines;

class PersonalController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index(Request $request) {
		$user = Auth::user();

		$data = [
			'user' => $user,
            'currencies' => Currency::all(),
            'countries' => Country::orderBy('name')->get(),
		];
		return view('personal', $data);
	}

	public function save(Request $request) {
		$countryId = intval($request->get('country_id'));
		$currencyId = intval($request->get('currency_id'));
        $validator = $this->getValidationFactory()->make($request->all(), []);
		if ($currencyId === Currency::CZK && $countryId !== Country::CZECHIA) {
			$validator->errors()->add('currency_id', "You can pay in EUR only.");
			$this->throwValidationException($request, $validator);
		}
		if ($request->get('is_member') === '1' && $currencyId !== Currency::CZK) {
			$validator->errors()->add('checkbox', "You can't be an Alceco member and pay in EUR.");
			$this->throwValidationException($request, $validator);
		}

		$user = Auth::user();
        $user->is_member = $request->get('is_member');
        $user->currency_id = $request->get('currency_id');
        $user->country_id = $request->get('country_id');
        $user->city = $request->get('city');
        $user->save();

		return redirect('/registration');
	}

}
