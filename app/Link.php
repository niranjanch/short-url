<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table = 'links';

    protected $fillable = ['url'];

    /**
     * Get the hash record associated with the link.
     */
    public function hash()
    {
        return $this->hasOne('App\Hash','hash_id');
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
