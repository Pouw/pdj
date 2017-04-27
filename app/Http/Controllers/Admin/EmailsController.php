<?php

namespace App\Http\Controllers\Admin;

use App\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailsController extends Controller
{

	public function index() {
		return view('admin.mails', []);
	}

	public function preview() {
		$user = Auth::user();
		return view('emails.schedule', ['registration' => $user->registration]);
	}

	public function sendSchedule() {

	}

	public function sendScheduleEmail() {
		$user = Auth::user();
		$reg = $user->registration;
		Mail::send('emails.schedule', [], function ($m) use ($reg) {
			$m->to($reg->user->email, $reg->user->name)
				->subject('Prague Rainbow Spring - Schedule');
		});
	}

	public function send(Request $request) {
		$this->validate($request, [
			'states' => 'required',
			'content' => 'required',
			'title' => 'required',
		]);
		$title = $request->get('title');
		$content = $request->get('content');

		$sportId = $request->get('sport_id');
		$states = $request->get('states');
		$regs = Registration::whereIn('state', $states);
		if (!empty($sportId)) {
			$regs->whereHas('sports', function ($query) use ($sportId) {
				$query->where('sport_id', '=', $sportId);
			});
		}
		foreach ($regs->get() as $reg) {
			$data = [
				'content' => $content,
				'registration' => $reg,
			];
			Mail::send('emails.content', $data, function ($m) use ($reg, $title) {
				$m->to($reg->user->email, $reg->user->name)
					->subject($title);
			});
		}
		$request->session()->flash('alert-success', $regs->count() . ' has been sent.');
		return redirect('/admin/mails');
	}

}
