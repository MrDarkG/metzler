<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;
    protected $primary="id";
    protected $fillable=[
    	"user_id",
        "content",
        "title",
        "picture"
    ];
    public function user($value='')
    {
    	return $this->belongsTo(User::class,"user_id");
    }
    public function user_info($value='')
    {
        return $this->hasOne(User_profile::class,"id","user_id");
    }
}
