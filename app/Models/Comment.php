<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    public $table = 'comments';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'issue_id',
        'author_id',
        'comment_text',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function issue()
    {
        return $this->belongsTo(Issue::class, 'issue_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}