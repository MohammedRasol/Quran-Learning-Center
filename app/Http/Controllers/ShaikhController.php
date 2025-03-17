<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShaikhRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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



    public function show(string $id)
    {
        $shaikh = User::findOrFail($id);
        return view("shaikhView.showShaikh", compact("shaikh"));
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
    public function update(Request $request,  $id)
    {
        $request->validate([
            "name" => "string|required|max:255",
            "last_name" => "nullable|string|max:255",
            "family_name" => "nullable|string|max:255",
            "image" => "nullable|mimes:png,jpg,jpeg,gif|max:2048",
        ]);

        $shaikh = User::findOrFail($id);
        $shaikh->name = $request->name;
        $shaikh->last_name = $request->last_name;
        $shaikh->family_name = $request->family_name;

        if ($request->has("image")) {
            if ($shaikh->image) {
                Storage::disk('public')->delete($shaikh->image);
            }
            $imagePath = $request->file("image")->store("images", "public");
            $shaikh->image = $imagePath;
        }

        $res = $shaikh->save();
        return redirect()->back()->with("success", "تم تعديل معلومات الشيخ");
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
