<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShaikhRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ShaikhController extends Controller
{
    public function index()
    {
        $shaikhs = User::where("role", 2)->get();
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
        $user = new User();
        $user->role = 2; // 2== SHAIKH
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->family_name = $request->family_name;
        $user->user_name = User::generateUniqueUsername();
        if ($request->has("image")) {
            $imagePath = $request->file("image")->store("images", "public");
            $user->image = $imagePath;
        }
        $user->password = $request->password;
        $res = $user->save();
        return redirect()->back()->with("success", "Data Saved");
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
