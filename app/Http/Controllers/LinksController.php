<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LinkCreateRequest;
use App\Link;

class LinksController extends Controller
{
    protected $link;

    /**
     * LinksController constructor.
     */
    public function __construct()
    {
        $this->link = new Link();
    }

    /**
     * Display home page
     *
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Redirect to the intended Url
     *
     * @param $hash
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function redirect($hash)
    {
        // If url does not exist
        if (!$link = $this->link->getHash($hash)) {
            // Show 404 page
            abort(404);
        }

        // Else redirect to url
        return redirect($link->url);
    }

    /**
     * Create shortened url or get the record if already exist
     *
     * @param LinkCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveLink(LinkCreateRequest $request)
    {
        // Check if the url already exist
        if ($data = $this->link->getUrl($request->get('url')))
        {
            $hash = $data->hash->first()->hash;
        }
        else
        {
            // Else create a new record
            $hash = $this->link->saveUrlAttribute($request->get('url'));
        }

        // Redirect back to home page with the hashed shrot url
        return response()->json(['shortUrl' => route('home').'/'.$hash], 200);
    }
}
