<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issue extends Model
{
    use SoftDeletes;

    public $table = 'issues';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'category_id',
        'author_id',
        'issue_id',
        'title',
        'content',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'issue_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function medias()
    {
        return $this->hasMany(Media::class, 'issue_id', 'id');
    }

    public function scopeFilterIssues($query)
    {
        $query
            ->when(request()->input('category'), function ($query) {
                $query->whereHas('category', function ($query) {
                    $query->whereId(request()->input('category'));
                });
            })
            ->when(request()->input('status'), function ($query) {
                $query->whereHas('status', function ($query) {
                    $query->whereId(request()->input('status'));
                });
            });
    }

    public function sendCommentNotification($comment)
    {
        $users = User::where(function ($q) {
            $q->whereHas('roles', function ($q) {
                return $q->where('title', 'customer');
            })
                ->where(function ($q) {
                    $q->whereHas('comments', function ($q) {
                        return $q->whereIssueId($this->id);
                    })
                        ->orWhereHas('issues', function ($q) {
                            return $q->whereId($this->id);
                        });
                });
        })
            ->get();
        // $notification = new CommentEmailNotification($comment);

        // Notification::send($users, $notification);
        // if($comment->user_id && $this->author_email)
        // {
        //     Notification::route('mail', $this->author_email)->notify($notification);
        // }
    }
}