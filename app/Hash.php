<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hash extends Model
{
    protected $table = 'hashes';

    protected $fillable = ['hash'];

    /**
     * Get the link that owns the hash.
     */
    public function link()
    {
        return $this->belongsTo('App\Link');
    }

}