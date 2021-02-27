<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendEmailRequest;
use App\Jobs\SendEmail;
use App\Models\Email;
use App\Models\EmailAttachment;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emails = Email::with('attachments')->get();

        // manipulating to return as expected (couldn't do it in Eloquent because of my custom url field)
        $emails = $emails->map(function ($email) {
            return [
                'email' => $email->email,
                'subject' => $email->subject,
                'body' => $email->body,
                'attachments' => $email->attachments->map(function ($attachment) {
                    return ['url' => $attachment->url];
                })
            ];
        });

        return response($emails);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(SendEmailRequest $request)
    {
        foreach ($request['emails'] as $email) {
            $attachments = null;

            // handling attachments
            foreach ($email['attachments'] as $attachment) {
                Storage::disk('public')->put($attachment['name'], base64_decode($attachment['file']));

                $attachments[] = [
                    'file_name' => $attachment['name'],
                    'file_path' => Storage::disk('public')->path($attachment['name'])
                ];
            }

            // sending email to queue
            SendEmail::dispatch($email['email'], $email['subject'], $email['body'], $attachments);

            $mEmail = Email::create(Arr::only($email, ['email', 'subject', 'body']));

            if ($attachments) {
                foreach ($attachments as $attachment) {
                    EmailAttachment::create([
                        'email_id'  => $mEmail->id,
                        'file_name' => $attachment['file_name'],
                        'file_path' => $attachment['file_path']
                    ]);
                }
            }

            //if ($attachments) EmailAttachment::create(['email_id' => $iEmail->id, ...$attachments]);
        }
    }
}
