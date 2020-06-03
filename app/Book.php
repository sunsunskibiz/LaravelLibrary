<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author_id'
    ];

    public function path()
    {
        return '/books/'. $this->id;
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function setAuthorIdAttribute($author)
    {
        $this->attributes['author_id'] = Author::firstOrCreate([
            'name' => $author
        ])->id;
    }

    public function checkOut($user)
    {
        $this->reservations()->create([
            'user_id' => $user->id,
            'checked_out_at' => now()
        ]);
    }

    public function checkIn($user)
    {
        $this->reservations()->where('user_id', $user->id)
            ->whereNull('checked_in_at')
            ->whereNotNull('checked_out_at')
            ->firstOrFail()
            ->update(['checked_in_at' => now()]);
    }
}
