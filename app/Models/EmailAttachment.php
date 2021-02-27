<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EmailAttachment extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['email_id', 'file_name', 'file_path'];
    protected $appends = ['url'];

    function email()
    {
        return $this->belongsTo(Email::class);
    }

    public function getUrlAttribute()
    {
        return Storage::disk('public')->url($this->file_name);
    }
}
