<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsletterContent extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'content',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function mails()
    {
        return $this->hasMany(NewsletterMail::class, 'newsletter_content_id');
    }
}
