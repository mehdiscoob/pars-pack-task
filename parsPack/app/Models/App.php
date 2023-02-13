<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class App extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'apps';
    protected $fillable = array('name', 'platform_id');

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

}
