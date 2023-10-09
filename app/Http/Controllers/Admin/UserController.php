<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserGCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $name = $request->name;
        $surname = $request->surname;
        $email = $request->email;

        $users = User::whereTypeUser(2)->orderBy("id", "desc")->paginate(10);

        return response()->json([
            "users" => UserGCollection::make($users),
            "links" => [
                "pages" => $users->lastPage(),
                "current_page" => $users->currentPage(),
                "arr_pages" => range(1, $users->lastPage())
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $password = '12345678';

        if($request->hasFile("imagen")){
            $path = Storage::putFile("users", $request->file("imagen"));
            $request->request->add(["avatar" => $path]);
        }
        $request->request->add([
            "password" => bcrypt($password),
            "type_user" => 2,
        ]);

        $user = User::create($request->all());

        return response()->json([
            "message" => 200,
            "message_text" => "USUARIO REGISTRADO CORRECTAMENTE",
            'user' => $user
        ]);
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
        $user = User::findOrFile($id);

        if($request->hasFile("imagen")){

            if($user->avatar){
                Storage::delete($user->avatar);
            }

            $path = Storage::putFile("users", $request->file("imagen"));
            $request->request->add(["avatar" => $path]);
        }

        $request->request->add([
            "password" => bcrypt($request->password),
        ]);


        $user->update($request->all());

        return response()->json([
            "message" => 200,
            "message_text" => "USUARIO ACTUALIZADO CORRECTAMENTE",
            'user' => $user
        ]);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFile($id);

        $user->delete();

        return response()->json([
            "message" => 200,
            "message_text" => "USUARIO ELIMINADO CORRECTAMENTE"
        ]);
    }
}
