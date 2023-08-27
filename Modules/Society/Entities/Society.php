<?php

namespace Modules\Society\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Staff\Entities\Staff;
use Modules\Students\Entities\Students;

class Society extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Society\Database\factories\SocietyFactory::new();
    }

    public function convener()
    {
        return $this->belongsTo(Staff::class, 'convener_id');
    }

    public function president()
    {
        return $this->belongsTo(Students::class, 'president_id');
    }

    public function members()
    {
        return $this->hasMany(SocietyMembers::class);
    }

    public function societyForm()
    {
        return $this->hasOne(SocietyForms::class);
    }

}