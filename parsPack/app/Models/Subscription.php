<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'subscriptions';
    protected $fillable = array('status', 'app_id', 'user_id', 'token');

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
