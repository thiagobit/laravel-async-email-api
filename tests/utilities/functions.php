<?php

use App\Models\Email;
use App\Models\EmailAttachment;
use \Illuminate\Contracts\Filesystem\FileNotFoundException;
use \Illuminate\Support\Facades\Storage;

/**
 * Creates an Email record
 *
 * @param bool $withAttachments
 * @param array $attributes
 * @return array
 */
function createEmail($withAttachments = true, $attributes = []) : array
{
    $email = Email::factory()->create($attributes);

    $aEmail = ['email' => $email->email, 'subject' => $email->subject, 'body' => $email->body];
    $aEmailAttachment = ['attachments' => []];

    if ($withAttachments) {
        $emailAttachment = EmailAttachment::factory()->create(['email_id' => $email]);
        $aEmailAttachment = ['attachments' => [['name' => $emailAttachment->file_name, 'file' => $emailAttachment->file_path]]];
    }

    return array_merge($aEmail, $aEmailAttachment);
}

/**
 * Generates an Email structure
 *
 * @param array $attributes
 * @param bool $withAttachments
 * @return array
 * @throws FileNotFoundException
 */
function rawEmail($withAttachments = true, $attributes = []) : array
{
    $aEmail = Email::factory()->raw($attributes);
    $aEmailAttachments = ($withAttachments) ? rawEmailAttachment($attributes) : ['attachments' => []];

    return array_merge($aEmail, $aEmailAttachments);
}

/**
 * Generates an EmailAttachment structure
 *
 * @param array $attributes
 * @return array[][]
 * @throws FileNotFoundException
 */
function rawEmailAttachment($attributes = []) : array
{
    $fileName = (isset($attributes['name'])) ? $attributes['name'] : 'test.jpg';
    $fileBase64 = (isset($attributes['file'])) ? base64_encode($attributes['file']) : base64_encode(Storage::disk('local')->get($fileName));

    return ['attachments' => [['name' => $fileName, 'file' => $fileBase64]]];
}
