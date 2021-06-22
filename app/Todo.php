<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Carbon\Carbon;

class Todo extends Model
{
    protected $fillable = [
            'user_id',
            'text',
            'ischecked',
            'isdone'
    ];

    public function users()
    {
      return $this->belongTo('App\User', 'user_id', 'id');
    }
}
