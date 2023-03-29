<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $data = DB::table('users')->get();
        //$data = DB::select('SELECT * FROM users');
        //$data = User::all();
        $data = User::withCount('categories')->get();
        return response()->view('cms.users.user' , ['users' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.users.creat');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string|min:3|max:40|alpha',
            'user_email' => 'required|email|unique:users,email',
            'user_address' => 'nullable|string|min:3|max:45',
            'user_image' => 'required',
            'user_password' => [
                'required', 'string',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                   // ->uncompromised()
            ]
        ]
        );

        //
        $user = new User();
        $user->name = $request->input('user_name');
        $user->email = $request->input('user_email');
       $user->address = $request->input('user_address');
        $user->password = Hash::make($request->input('user_password'));

        if ($request->hasFile('user_image')) {
            $file = $request->file('user_image');
            $imageName = time() . '_image_' . $user->name . '.' . $file->getClientOriginalExtension();
            $file->storeAs('users', $imageName, ['disk' => 'public']);
            $user->image = "users/" . $imageName;
        }

        $saved = $user->save();
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::find($id);
        return response()->view('cms.users.edit' , ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'user_name' => 'required|string|min:3|max:40|alpha',
            'user_email' => 'required|email|unique:users,email,'.$id,
            'user_address' => 'nullable|string|min:3|max:45',
            'user_password' => [
                'required', 'string',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                   // ->uncompromised()
            ]
        ]
        );

        //
        $user = User::findOrFail($id);
        $user->name = $request->input('user_name');
        $user->email = $request->input('user_email');
       $user->address = $request->input('user_address');
        $user->password = Hash::make($request->input('user_password'));

        $saved = $user->save();
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::findOrFail($id);
        $deleted = $user->delete();
        if ($deleted) {
            Storage::delete($user->image);
        }
        if ($deleted) {
            return redirect()->back();
        }
    }
}
