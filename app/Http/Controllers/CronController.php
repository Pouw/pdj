<?php

namespace App\Http\Controllers;

use App\EmailQueue;
use Illuminate\Support\Facades\Mail;

class CronController extends Controller {

	public function email() {
		$total = 0;
    	$q = EmailQueue::whereSent(0)->limit(2)->get();

		foreach ($q as $item) {
			$user = $item->user;
			echo $user->email . "<br>\n";
			Mail::send('emails.schedule', [], function ($m) use ($user) {
				$m->to($user->email, $user->name)
					->attach(resource_path('files/pdf-test.pdf'), [
						'as' => 'prs-2018-schedule.pdf',
						'mime' => 'application/pdf',
					])
					->subject('Prague Rainbow Spring - Schedule');
			});
			$item->sent = 1;
			$item->save();
			$total++;
		}
		echo "TOTAL: $total<br>\n";
	}

}
