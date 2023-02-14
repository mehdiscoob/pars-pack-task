<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpiredLog extends Model
{
    use HasFactory,SoftDeletes;
    protected $table="expired_logs";
    protected $fillable=['counter'];
}
