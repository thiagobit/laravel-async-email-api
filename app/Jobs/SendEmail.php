<?php

namespace App\Jobs;

use App\Mail\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $to;
    private $subject;
    private $body;
    private $attachments;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to, $subject, $body, $attachments = null)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->body = $body;
        $this->attachments = $attachments;
    }

    public function tags()
    {
        return ['email'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('emails.blank', ['content' => $this->body], function($message) {
            $message->to($this->to)
                ->subject($this->subject);

            if ($this->attachments) {
                foreach ($this->attachments as $attachment) {
                    $message->attach($attachment['file_path']);
                }
            }
        });
    }
}
