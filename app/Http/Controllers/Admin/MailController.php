<?php

namespace App\Http\Controllers\Admin;

use App\Mail;
use App\MailQueue;
use App\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MailController extends Controller {

	public function index() {
		return view('admin.mail.index');
	}

	public function add() {
		return view('admin.mail.add');
	}

	public function addSave(Request $request) {
		$this->validate($request, [
			'content' => 'required',
			'title' => 'required',
		]);

		$mail = new Mail();
		$mail->title = $request->get('title');
		$mail->content = $request->get('content');
		$mail->user_id = Auth::user()->id;
		$mail->saveOrFail();

		$tournamentId = $request->get('tournament_id');
		$sportId = $request->get('sport_id');
		$states = $request->get('states');
		$r = new Registration;
		if (!empty($tournamentId)) {
			$r = $r->where('tournament_id', $tournamentId);
		}
		if (!empty($states)) {
			$r = $r->where('state', $states);
		}
		$r = $r->groupBy('user_id');

		$userIds = [];
		foreach ($r->get() as $registration) {
			foreach ($registration->registrationItems as $ri) {
				if ($ri->tournamentItem->item_id == $sportId || empty($sportId)) {
					$userIds[] = $registration->user_id;
				}
			}
		}
		$userIds = array_unique($userIds);
		foreach ($userIds as $userId) {
			$mq = new MailQueue();
			$mq->user_id = $userId;
			$mq->mail_id = $mail->id;
			$mq->save();
		}
		$request->session()->flash('alert-success', count($userIds) . ' mail has been added to queue.');
		return redirect('/admin/mail');
	}

	public function stop(Request $request, int $mailId) {
		$mail = Mail::findOrFail($mailId);
		$mail->status_id = 2;
		$mail->saveOrFail();
		$request->session()->flash('alert-success', "Sending mail ID: $mailId has stopped.");
		return redirect('/admin/mail');
	}

}
