<?php

namespace Modules\Society\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Users\Entities\Users;

class Discussion extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Society\Database\factories\DiscussionFactory::new();
    }

    public function users()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function society()
    {
        return $this->belongsTo(Society::class, 'society_id');
    }
}
