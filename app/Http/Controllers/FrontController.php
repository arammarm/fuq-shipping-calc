<?php

namespace App\Http\Controllers;

use App\Helpers\StampHelper;
use App\Models\CalculatorShipping;
use App\Models\Config;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {

        $agreement = Config::where('key', 'agreement')->first();

        return view('welcome', compact('agreement'));
    }


    public function shippingFormSubmit()
    {

        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits_between:10,15',
            'address' => 'required',
            'weight' => 'required|numeric',
        ]);

        CalculatorShipping::create([
            'name' => request()->input('name'),
            'email' => request()->input('email'),
            'phone' => request()->input('phone'),
            'address' => request()->input('address'),
            'weight' => request()->input('weight')
        ]);

        return redirect()->back();
    }


    public function test()
    {
    
    
        $stamp = new StampHelper();

        $stamp->get();
    
    }
}
