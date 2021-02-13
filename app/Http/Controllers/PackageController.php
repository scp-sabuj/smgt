<?php

namespace App\Http\Controllers;

use App\Models\PackageModel;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        return view('admin.package', [
            'packages' => PackageModel::all(),
        ]);
    }


    public function store(Request $request)
    {
        PackageModel::create($this->validation());
        return redirect()->route('package')->with('succsess', 'add successfully');
    }


    public function update(Request $request)
    {
        PackageModel::find($request->id)->update($this->validation());
        return redirect()->route('package')->with('succsessedit', 'update successfully');
    }

    public function delete($id)
    {
        PackageModel::find($id)->Delete();
        return redirect()->route('package')->with('succsessdelete', 'delete successfully');
    }


    public function validation()
    {
        return request()->validate([
            'package_title' => 'required',
            'package_speed' => 'required',
            'package_price' => 'required',
            'package_discription' => 'required',
        ]);
    }
}
