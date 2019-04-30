<?php

namespace App\Http\Controllers;

use App\Mail;
use App\MailQueue;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail as Mailer;

class CronController extends Controller {

	public function mailQueueSend() {
		$mails = Mail::whereStatusId(1)->whereDone(0);
		echo "mail_id,user_id,mail\n";
		foreach ($mails->get() as $mail) {
			$before5Minutes = Carbon::now()->subMinutes(5);
			if ($before5Minutes->greaterThan($mail->created_at)) {
				$queue = $mail->queue()->whereSent(0)->limit(2)->get();
				if ($queue->count() > 0) {
					foreach ($queue as $mq) {
						echo "{$mail->id},{$mq->user->id},{$mq->user->email}\n";
						$mail->sendTo($mq->user, $mail->is_default_header_footer);
						$mq->sent = 1;
						$mq->save();
					}
				} else {
					$mail->done = 1;
					$mail->save();
				}
			} else {
				if (!$mail->sent_author) {
					$mail->sendTo($mail->user, $mail->is_default_header_footer);
					$mail->sent_author = 1;
					$mail->save();
				}
			}
		}

	}

	public function _email() {
		$total = 0;
    	$q = MailQueue::whereSent(0)->limit(2)->get();

		foreach ($q as $item) {
			$user = $item->user;
			echo $user->email . "<br>\n";
			Mailer::send('emails.schedule', [], function ($m) use ($user) {
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
