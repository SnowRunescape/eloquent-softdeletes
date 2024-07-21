<?php

namespace SnowRunescape\SoftDeletes\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use SnowRunescape\SoftDeletes\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    const STATUS = [
        'deleted' => -1,
        'inactive' => 0,
        'active' => 1,
    ];

    protected $fillable = [
        'title',
        'status',
    ];
}
