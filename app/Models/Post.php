<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'body',
        'user_id',
    ];

    public function likedBy(User $user) {
        return $this->likes->contains('user_id', $user->id); //Contains is collection method "WHERE user_id=..."
    }

    // Using PostPolicy instead
    // public function ownedBy(User $user) {
    //     return $user->id === $this->user_id; //Compare user sent with acctual user of post
    // }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }
}
