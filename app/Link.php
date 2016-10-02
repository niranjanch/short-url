<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Hash;

class Link extends Model
{
    protected $table = 'links';

    protected $fillable = ['url'];

    /**
     * Get the hash record associated with the link.
     */
    public function hash()
    {
        return $this->hasOne('App\Hash');
    }

    /**
     * Set the Url and Hash field values and save to tables
     * Check hash string is exists in table and save long and short url 
     *
     * @param $value
     * @return $hash return the string
     */
    public function saveUrlAttribute($value)
    {

         do
        {
            $hash = str_random(6);
            $hash_code = $this->getHash($hash);
        }
        while(!empty($hash_code));
        
        $this->attributes['url']  = $value;
        $this->save();

        $hashes = $this->hash ?: new Hash;
        $hashes->hash = $hash;

        $this->hash()->save($hashes);

        return $hash;
    }

    /**
     * Get the url
     *
     * @param $url
     * @return mixed
     */
    public function getUrl($url)
    {
        return $this->where('url', $url)->with('hash')->first();
    }

    /**
     * Get the url hash
     *
     * @param $hash
     * @return mixed
     */
    public function getHash($hash)
    {
        return $this->whereHas('hash', function($q) use ($hash){
                $q->where('hash', $hash);
            })->first();
    }
}
