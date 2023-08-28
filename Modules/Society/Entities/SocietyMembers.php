<?php

namespace Modules\Society\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Students\Entities\Students;
use Modules\Users\Entities\Users;

class SocietyMembers extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Society\Database\factories\SocietyMembersFactory::new();
    }

    public function student()
    {
        return $this->belongsTo(Students::class);
    }

    public function user()
    {
        return $this->belongsTo(Users::class);
    }
}
