<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Platform extends Model
{
    use HasFactory,SoftDeletes;
    protected $table="platforms";
    protected $fillable = array('name');

    public function apps()
    {
        return $this->hasMany(App::class);
    }
}
