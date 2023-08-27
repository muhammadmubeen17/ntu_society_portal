<?php

namespace Modules\Society\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Students\Entities\Students;

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
}
