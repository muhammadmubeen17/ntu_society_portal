<?php

namespace Modules\Society\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Users\Entities\Users;

class FormResponse extends Model
{
    use HasFactory;

    protected $fillable = ['status'];
    
    protected static function newFactory()
    {
        return \Modules\Society\Database\factories\FormResponseFactory::new();
    }

    public function users()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function society()
    {
        return $this->belongsTo(Society::class, 'society_id');
    }

    public function forms()
    {
        return $this->belongsTo(SocietyForms::class, 'form_id');
    }
}
