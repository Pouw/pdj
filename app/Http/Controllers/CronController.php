<?php

namespace App\Http\Controllers;

use App\EmailQueue;
use Illuminate\Support\Facades\Mail;

class CronController extends Controller {

	public function email() {
    	$q = EmailQueue::whereSent(0)->limit(10)->get();

		foreach ($q as $item) {
			$user = $item->user;
			echo $user->email . "<br>\n";
			Mail::send('emails.schedule', [], function ($m) use ($user) {
				$m->to($user->email, $user->name)
					->subject('Prague Rainbow Spring - Schedule');
			});
			$item->sent = 1;
			$item->save();
		}
	}

}
