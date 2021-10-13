<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use SoftDeletes;

    public $table = 'medias';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'issue_id',
        'path',
        'filename',
        'type',
        'size',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function issue()
    {
        return $this->belongsTo(Issue::class, 'issue_id');
    }
}