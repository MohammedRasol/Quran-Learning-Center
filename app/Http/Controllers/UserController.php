<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShaikhRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route as FacadesRoute;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shaikhs = User::where("role", 1)->get();
        return view("shaikhView.shaikhList", compact("shaikhs"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("shaikhView.addShaikh");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShaikhRequest $request)
    {
    
    }
 

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function isShaikh()
    {
        $route = request()->path(); // check route to assign role
        if ($route == "shaikh")
            return true;
    }
}
