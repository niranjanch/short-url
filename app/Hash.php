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

    /**
     * Set the Url and Hash field values
     *
     * @param $value
     */
    public function setUrlAttribute($value)
    {
        $hash = str_random(6);

        // Check if url already exists
        if ($this->where('url', $value)->exists()) {
            return '';
        }

        // Else insert the records into the table
        $this->attributes['url']  = $value;
        $this->attributes['hash'] = $hash;
    }

    /**
     * Get the url
     *
     * @param $url
     * @return mixed
     */
    public function getUrl($url)
    {
        return $this->where('url', $url)->first();
    }

    /**
     * Get the url hash
     *
     * @param $hash
     * @return mixed
     */
    public function getHash($hash)
    {
        return $this->where('hash', $hash)->first();
    }
}