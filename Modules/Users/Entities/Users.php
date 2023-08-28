<?php

namespace Modules\Users\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Staff\Entities\Staff;
use Modules\Students\Entities\Students;

class Users extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Users\Database\factories\UsersFactory::new();
    }

    public function student()
    {
        return $this->belongsTo(Students::class, 'student_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
