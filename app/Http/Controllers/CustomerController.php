<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerModel;
use App\Models\PackageModel;

class CustomerController extends Controller
{
    public function index(){
        return view('customer.customerform',[
            'packages' => PackageModel::all(),
        ]);
    }

    public function store(Request $request)
    {
        CustomerModel::create($this->validation());
        return redirect()->route('customer.form')->with('succsess', 'add successfully');
    }

    public function validation()
    {
        return request()->validate([
            'package_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'nid' => 'required',
            'address' => 'required',
        ]);
    }
}
