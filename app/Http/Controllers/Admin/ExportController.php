<?php

namespace App\Http\Controllers\Admin;

use App\Discipline;
use App\Item;
use App\Registration;
use App\RegistrationItem;
use App\Tournament;
use Illuminate\Http\Request;

class ExportController extends Controller {

	public function index(Request $request) {
		return view('admin.exports');
	}

	public function export(Request $request) {
		$ext = $request->get('ext');
		$excel = \App::make('excel');

		$excel->create('pdj', function($excel) {

			$tournamentId = $this->getTournamentId();
			$regs = Registration::whereIn('state', [Registration::PAID, Registration::NEW])->where('tournament_id', $tournamentId)->get();

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
				$tournamentId = $this->getTournamentId();
				$regs = Registration::whereIn('state', [Registration::PAID, Registration::NEW])->where('tournament_id', $tournamentId)->get();
				$i = 1;
				foreach ($regs as $reg) {
					$i++;
					$outreachSupport = '';
					if ($reg->outreach_support) {
//						if ($reg->user->currency_id == Currency::EUR) {
//							$outreachSupport = 5 * $reg->outreach_support . ' EUR';
//						} else {
//							$outreachSupport = 50 * $reg->outreach_support . ' CZK';
//						}
					}
					$sports = [];
					foreach ($reg->registrationItems as $ri) {
						$sports[] = $ri->tournamentItem->item->name;
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
						implode("\n", $sports),
					]);
					$sheet->getCell('A' . $i)->getHyperlink()->setUrl('https://registration.praguerainbow.eu/admin/registration/id/' . $reg->id);
				}
				$sheet->setAutoFilter();
			});

			$tournamentId = $this->getTournamentId();
			$tournament = Tournament::findOrFail($tournamentId);
			foreach ($tournament->items as $item) {
				$excel->sheet($item->name, function ($sheet) use ($item, $regs) {
					$head = [
						'id',
						'paid',
						'user',
//						'brunch',
//						'concert'
					];
					if ($item->id == Item::VOLLEYBALL) {
						$head[] = 'club';
						$head[] = 'team';
						$head[] = 'level';
					} elseif ($item->id == Item::BEACH_VOLLEYBALL) {
						$head[] = 'primary';
						$head[] = 'team';
						$head[] = 'level';
						$head[] = 'level alternative';
					} elseif ($item->id == Item::SOCCER) {
						$head[] = 'team';
					} elseif ($item->id == Item::SWIMMING) {
						$head[] = 'birthdate';
						$head[] = 'club';
						$head[] = 'captain';
						foreach ($item->disciplines as $discipline) {
							$head[] = $discipline->name;
						}
					} elseif ($item->id == Item::RUNNING) {
						$head[] = 'primary';
						$head[] = 'distance';
					} elseif ($item->id == Item::BADMINTON) {
						$head[] = 'singles';
						$head[] = 'doubles';
						$head[] = 'partner';
						$head[] = 'need partner';
					}
					$head[] = 'note';
					$sheet->appendRow($head);
					$tournamentItemId = $item->pivot->id;
//					$regs = RegistrationItem::where('tournament_item_id', $tournamentItemId)->whereHas('registration', function ($query) {
//						$query->whereIn('state', [Registration::PAID, Registration::NEW]);
//					})->get();
//					$regs = RegistrationItem::where('tournament_item_id', $tournamentItemId)->get();
					$i = 1;
					foreach ($regs as $reg) {
						/**
						 * @var RegistrationItem $registrationItem
						 */
						$registrationItem = null;
						foreach ($reg->registrationItems as $_registrationItem)  {
							if ($_registrationItem->tournament_item_id == $tournamentItemId) {
								$registrationItem = $_registrationItem;
							}
						}
						if (!isset($registrationItem)) {
							continue;
						}

						$i++;
						$row = [
							$reg->id,
							$reg->state == Registration::PAID ? 'yes' : 'no',
							$reg->user->name,
//							$reg->brunch ? 'yes' : 'no',
//							$reg->concert ? 'yes' : 'no',
						];
						if ($item->id == Item::VOLLEYBALL) {
							$row[] = $registrationItem->club;
							$row[] = $registrationItem->team_id ? $registrationItem->team->name : '';
							$row[] = $registrationItem->team_id ? $registrationItem->team->level->name : '';
						} elseif ($item->id == Item::BEACH_VOLLEYBALL) {
							$row[] = $reg->registrationItems->count() === 1 ? 'yes': 'no';
							$row[] = $registrationItem->team_name;
							$row[] = $registrationItem->level_id ? $registrationItem->level->name : '';
							$row[] = $registrationItem->alt_level_id ? $registrationItem->altLevel->name : '';
						} elseif ($item->id == Item::SOCCER) {
							$row[] = $registrationItem->team_id ? $registrationItem->team->name : '';
						} elseif ($item->id == Item::SWIMMING) {
							$row[] = $registrationItem->registration->user->birthdate;
							$row[] = $registrationItem->club;
							$row[] = $registrationItem->captain;
							$dics = $registrationItem->disciplines;
//							dd($dics);
							foreach ($item->disciplines as $discipline) {
								foreach ($dics as $dis) {
									if ($discipline->id == $dis->discipline_id) {
										$row[] = $dis->time ?? '???';
										continue 2;
									}
								}
								$row[] = '';
							}
						} elseif ($item->id == Item::RUNNING) {
							$row[] = $reg->registrationItems->count() === 1 ? 'yes': 'no';
							foreach ($registrationItem->disciplines as $discipline) {
								$row[] = $discipline->discipline->name;
							}
						} elseif ($item->id == Item::BADMINTON) {
							$row[] = $registrationItem->level_id ? $registrationItem->level->name : '';
							$row[] = $registrationItem->alt_level_id ? $registrationItem->altLevel->name : '';
							$row[] = $registrationItem->team_name;
							$row[] = $registrationItem->find_partner ? 'yes' : 'no';
						}
						$row[] = $reg->note;
						$sheet->appendRow($row);
						$sheet->getCell('A' . $i)->getHyperlink()->setUrl('https://registration.praguerainbow.eu/admin/registration/id/' . $reg->id);
					}

					$sheet->setAutoFilter();
				});
			}
		})->download($ext);
	}

}
