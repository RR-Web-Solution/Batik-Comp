<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'email', 'phone', 'subject', 'message'])]
#[Hidden([])]
class ContactMessage extends Model
{
    protected static function booted(): void
    {
        static::saving(function (ContactMessage $message) {
            $message->is_read = $message->is_read ?? false;
        });
    }
}
