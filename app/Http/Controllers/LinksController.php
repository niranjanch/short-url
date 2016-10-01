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
        // $this->link = new Link();
        return '123';
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
        if ($data = $this->link->getUrl($request->get('url'))) {
            // Redirect back to home page and display the hashed url
            return redirect()
                ->back()
                ->with('link', $data->hash)
                ->with('success', 'A shortened URL is available.');
        }

        // Else create a new record
        $this->link->url = $request->get('url');
        $this->link->save();

        // Redirect back to home page with the hashed url
        return redirect()
            ->back()
            ->with('link', $this->link->hash)
            ->with('success', 'URL has been shortened.');

           return response()->json(['responseText' => 'Success!'], 200)
    }
}
