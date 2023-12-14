<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goal extends Model
{
    use HasFactory;
    use SoftDeletes, CascadeSoftDeletes;
    protected $cascadeDeletes = ['studyBlocks', 'schedules'];
    protected $dates = ['deleted_at'];
    protected $fillable = ['user_id', 'type', 'test_date', 'content_to_study'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function studyBlocks()
    {
        return $this->hasMany(StudyBlock::class);
    }
}
