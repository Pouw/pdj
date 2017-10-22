<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Discipline;
use App\Note;
use App\Payments;
use App\Price;
use App\Registration;
use App\RegistrationSport;
use App\Item;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('admin');
	}

	public function index(Request $request)
	{
		$user = Auth::user();
		$data = [
			'user' => $user,
		];
		return view('admin', $data);
	}

	public function registrations(Request $request) {
		$sportId = intval($request->get('sport_id'));
		$states = (array) $request->get('states');
		$service = $request->get('service');
		$data = [
			'sportId' => $sportId,
			'states' => $states,
			'service' => $service,
		];

		if (!empty($states) || !empty($service) || !empty($sportId)) {
			$sportRegistrations = new \App\RegistrationSport();
			if (!empty($states) || !empty($service)) {
				$sportRegistrations = $sportRegistrations->whereHas('registration', function ($query) use ($states, $service) {
					if (!empty($states)) {
						$query->whereIn('registrations.state', $states);
					}
					if ($service === 'concert') {
						$query->where('registrations.concert', '>', 0);
					} elseif ($service === 'brunch') {
						$query->where('registrations.brunch', '>', 0);
					} elseif ($service === 'hosted_housing') {
						$query->where('registrations.hosted_housing', '>', 0);
					} elseif ($service === 'outreach_support') {
						$query->where('registrations.outreach_support', '>', 0);
					} elseif ($service === 'outreach_request') {
						$query->where('registrations.outreach_request', '>', 0);
					}
				});
			}
			if (!empty($sportId)) {
				$sportRegistrations = $sportRegistrations->whereSportId($sportId);
			};
			$data['sportRegistrations'] = $sportRegistrations->groupBy('registration_id')->get();
		}

		return view('admin.registrations', $data);
	}

	public function registration(Request $request) {
		$id = $request->get('id');
		$registration = Registration::findOrFail($id);
		$data = [
			'registration' => $registration,
			'user' => $registration->user,
			'price' => new Price(),
		];
		return view('admin.registration', $data);
	}

	public function registrationSave(Request $request) {
		$id = $request->get('id');
		$registration = Registration::findOrFail($id);
		$registration->state = $request->get('state');
		$registration->save();

		$request->session()->flash('alert-success', 'Data has been saved.');
		return back();
	}

	public function users(Request $request) {
		$countryId = $request->get('country_id');
		$name = $request->get('name');
		$users = new User();
		if ($countryId) {
			$users = $users->whereCountryId($countryId);
		}
		if ($name) {
			$users = $users->where('name', 'LIKE', "%$name%");
		}

		$data = [
			'name' => $name,
			'countryId' => $countryId,
			'users' => $users->get(),
		];
		return view('admin.users', $data);
	}

	public function payments(Request $request) {
		$data = [
			'payments' => Payments::get(),
		];
		return view('admin.payments', $data);
	}

	public function paymentAdd(Request $request) {
		$id = $request->get('id');
		$registration = Registration::findOrFail($id);

		$amount = $request->get('amount');
		$amount = (int) str_replace(' ', '', $amount);
		$currencyId = (int) $request->get('currency_id');

		Payments::insert([
			'state' => Payments::PAID,
			'registration_id' => $id,
			'amount' => $amount,
			'currency_id' => $currencyId,
			'user_id' => Auth::user()->id,
		]);

		if ($request->get('set_paid') === '1') {
			$registration->state = Registration::PAID;
			$registration->save();
		}
		if ($request->get('send_mail') === '1') {
			$data = [
				'registration' => $registration,
				'amount' => $amount,
				'currencyId' => $currencyId,
			];
			Mail::send('emails.payment', $data, function ($m) use ($registration) {
				$m->to($registration->user->email, $registration->user->name)
					->bcc('form@praguerainbow.eu')
					->subject('Prague Rainbow Spring - Payment Confirmation');
			});
		}
		$request->session()->flash('alert-success', 'Data has been saved.');
		return back();
	}

	public function noteAdd(Request $request) {
		Note::insert([
			'registration_id' => $request->get('registration_id'),
			'content' => $request->get('content'),
			'user_id' => Auth::user()->id,
		]);

		$request->session()->flash('alert-success', 'Data has been saved.');
		return back();
	}

	public function mailTest() {
		$user = Auth::user();
		Mail::send('emails.test', ['user' => $user], function ($m) use ($user) {
			$m->to($user->email, $user->name)->subject('Your Reminder!');
		});
	}

	public function exports(Request $request) {
		return view('admin.exports');
	}

	public function fixPaid() {
		$payments = Payments::where('bank_status', 7)->get();
		foreach($payments as $payment) {
			$reg = $payment->registration;
			if ($reg->state == Registration::NEW) {
				dump($reg->id);
				$reg->state = Registration::PAID;
				$reg->save();
			}
		}
	}

	public function export(Request $request) {
		$ext = $request->get('ext');
		$excel = \App::make('excel');
		$excel->create('pdj', function($excel) {
			$excel->setTitle('PDJ');
			$excel->sheet('All', function($sheet) {
				$sheet->appendRow([
					'id',
					'paid',
					'name',
					'email',
					'birthdate',
					'member',
					'country',
					'city',
					'HH',
					'HH from',
					'HH to',
					'outreach support',
					'outreach request',
					'note',
					'internal note',
					'registration for',
				]);
				$regs = Registration::whereIn('state', [Registration::PAID, Registration::NEW])->get();
				$i = 1;
				foreach ($regs as $reg) {
					$i++;
					$outreachSupport = '';
					if ($reg->outreach_support) {
						if ($reg->user->currency_id == Currency::EUR) {
							$outreachSupport = 5 * $reg->outreach_support . ' EUR';
						} else {
							$outreachSupport = 50 * $reg->outreach_support . ' CZK';
						}
					}
					$sheet->appendRow([
						$reg->id,
						$reg->state == Registration::PAID ? 'yes' : 'no',
						$reg->user->name,
						$reg->user->email,
						$reg->user->birthdate,
						$reg->user->is_member ? 'yes' : 'no',
						$reg->user->country_id ? $reg->user->country->name : '',
						$reg->user->city,
						$reg->hosted_housing ? 'yes' : 'no',
						$reg->hosted_housing ? $reg->hh_from : '',
						$reg->hosted_housing ? $reg->hh_to : '',
						$outreachSupport,
						$reg->outreach_request ? 'yes' : 'no',
						$reg->note,
						$reg->notes->implode('content', "\n"),
						$reg->sports->implode('sport.name', "\n")
					]);
					$sheet->getCell('A' . $i)->getHyperlink()->setUrl('https://registration.praguerainbow.eu/admin/registration?id=' . $reg->id);
				}
				$sheet->setAutoFilter();
			});


			$sports = Item::get();
			foreach ($sports as $sport) {
				$excel->sheet($sport->name, function ($sheet) use ($sport) {
					$head = ['id', 'paid', 'user', 'brunch', 'concert'];
					if ($sport->id == Item::VOLLEYBALL) {
						$head[] = 'club';
						$head[] = 'team';
						$head[] = 'level';
					} elseif ($sport->id == Item::BEACH_VOLLEYBALL) {
						$head[] = 'primary';
						$head[] = 'team';
						$head[] = 'level';
						$head[] = 'level alternative';
					} elseif ($sport->id == Item::SOCCER) {
						$head[] = 'team';
					} elseif ($sport->id == Item::SWIMMING) {
						$head[] = 'birthdate';
						$head[] = 'club';
						$head[] = 'captain';
						$disciplines =  Discipline::whereSportId($sport->id)->orderBy('sort_key')->get();
						foreach ($disciplines as $discipline) {
							$head[] = $discipline->name;
						}
					} elseif ($sport->id == Item::RUNNING) {
						$head[] = 'primary';
						$head[] = 'distance';
					} elseif ($sport->id == Item::BADMINTON) {
						$head[] = 'singles';
						$head[] = 'doubles';
						$head[] = 'partner';
						$head[] = 'need partner';
					}
					$head[] = 'note';
					$sheet->appendRow($head);
					$regs = \App\RegistrationSport::whereSportId($sport->id)->whereHas('registration', function ($query) {
						$query->whereIn('state', [Registration::PAID, Registration::NEW]);
					})->get();
					$i = 1;
					foreach ($regs as $reg) {
						$i++;
						$row = [
							$reg->registration->id,
							$reg->registration->state == Registration::PAID ? 'yes' : 'no',
							$reg->registration->user->name,
							$reg->registration->brunch ? 'yes' : 'no',
							$reg->registration->concert ? 'yes' : 'no',
						];
						if ($sport->id == Item::VOLLEYBALL) {
							$row[] = $reg->club;
							$row[] = $reg->team_id ? $reg->team->name : '';
							$row[] = $reg->team_id ? $reg->team->level->name : '';
						} elseif ($sport->id == Item::BEACH_VOLLEYBALL) {
							$row[] = RegistrationSport::whereRegistrationId($reg->registration_id)->count() === 1 ? 'yes': 'no';
							$row[] = $reg->team_name;
							$row[] = $reg->level_id	 ? $reg->level->name : '';
							$row[] = $reg->alt_level_id ? $reg->altLevel->name : '';
						} elseif ($sport->id == Item::SOCCER) {
							$row[] = $reg->team_id ? $reg->team->name : '';
						} elseif ($sport->id == Item::SWIMMING) {
							$row[] = $reg->registration->user->birthdate;
							$row[] = $reg->club;
							$row[] = $reg->captain;
							$dics = $reg->disciplines;
							foreach ($disciplines as $discipline) {
								foreach ($dics as $dis) {
									if ($discipline->id == $dis->discipline_id) {
										$row[] = $dis->time ? $dis->time : '???';
										continue 2;
									}
								}
								$row[] = '';
							}
						} elseif ($sport->id == Item::RUNNING) {
							$row[] = RegistrationSport::whereRegistrationId($reg->registration_id)->count() === 1 ? 'yes': 'no';
							foreach ($reg->disciplines as $discipline) {
								$row[] = $discipline->discipline->name;
							}
						} elseif ($sport->id == Item::BADMINTON) {
							$row[] = $reg->level_id	 ? $reg->level->name : '';
							$row[] = $reg->alt_level_id ? $reg->altLevel->name : '';
							$row[] = $reg->team_name;
							$row[] = $reg->find_partner ? 'yes' : 'no';
						}
						$row[] = $reg->registration->note;
						$sheet->appendRow($row);
						$sheet->getCell('A' . $i)->getHyperlink()->setUrl('https://registration.praguerainbow.eu/admin/registration?id=' . $reg->registration->id);
					}

					$sheet->setAutoFilter();
				});
			}
		})->download($ext);
	}

}
