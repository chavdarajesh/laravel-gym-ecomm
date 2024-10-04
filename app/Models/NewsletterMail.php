<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsletterMail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'newsletter_content_id', 'email','newsletter_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function content()
    {
        return $this->belongsTo(NewsletterContent::class, 'newsletter_content_id');
    }
}
