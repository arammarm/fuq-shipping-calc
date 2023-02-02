<?php

namespace App\Http\Controllers;

use App\Models\Config;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function configIndex()
    {
        $agreement = Config::where('key', 'agreement')->first();

        return view('config', compact('agreement'));
    }

    public function configSave()
    {
        $content = request()->input('agreement');

        Config::updateOrInsert(['key' => 'agreement'], ['content' => $content, 'type' => 'text']);

        return redirect()->back()->with(['status' => 'Agreement is successfully saved']);
    }
}
