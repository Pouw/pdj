<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Sport;
use App\Level;
use App\Regs;
use App\RegSport;

class SportController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index(Request $request)
	{
		$sports = Sport::orderBy('name')->get();
		return view('sport', ['sports' => $sports]);
	}

	protected function sports(Request $request) {
        $sportIds = $request->get('sports');
        $user = Auth::user();

        $reg = Regs::whereUserId($user->id);
        if ($reg->count() === 0) {
			$item = ['user_id' => $user->id];
			$regId = Regs::insertGetId($item);
		} else {
			$regId = $reg->first()->id;
        }
        dump($regId);

        if ($sportIds) {
            foreach ($sportIds as $sportId) {
                $item = [
          		    'reg_id' => $regId,
                    'sport_id' => $sportId,
                ];
                $regSport = RegSport::where($item);
                if ($regSport->count() === 0) {
                    $regSport->insert($item);
                }
            }
            RegSport::where('reg_id', $regId)
                ->whereNotIn('sport_id', $sportIds)
                ->delete();
        } else {
            RegSport::where('reg_id', $regId)->delete();
        }

        $regSports = RegSport::whereRegId($regId);
        dump($regSports->get());
//        $regSports->update();

		return view('sports', [
			'regSports' => $regSports,
			'sports' => Sport::whereIn('id', $sportIds)->get(),
			'levels' => Level::all(),
		]);
	}

}
