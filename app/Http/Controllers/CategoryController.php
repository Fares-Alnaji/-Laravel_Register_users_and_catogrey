<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $data = category::all();
        $data = Category::with('user')->get();
        return response()->view('cms.category.user', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = User::all();
        return response()->view('cms.category.creat', ['users' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = validator($request->all(), [
            'title' => 'required|string|min:3|max:30',
            'info' => 'required|string|min:3|max:150',
            'user_id' => 'required|numeric|exists:users,id',
            'active' => 'required|boolean',
        ]);

        if(!$validator->fails()){

            $category = new Category();
            $category->title = $request->input('title');
            $category->info = $request->input('info');
            $category->user_id = $request->input('user_id');
            $category->active = $request->input('active');
            $isSaved = $category->save();

            return response()->json(
            [
                'message' => $isSaved ?  "Category saved successfully" : "Failed to save category",
                'icon' => $isSaved ?  'success' : 'error',
            ],
            $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST
        );
        }else {
            return response()->json(['message' => $validator->getMessageBag()->first() , 'icon' => 'error'], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $users = User::all();
        $category = category::findOrFail($id);
        return response()->view('cms.category.edit', ['category' => $category, 'users' => $users]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = Validator($request->all(), [
            'title' => 'required|string|min:3|max:30',
            'info' => 'required|string|min:3|max:150',
            'user_id' => 'required|numeric|exists:users,id',
            'active' => 'required|boolean',
        ]);

        if (!$validator->fails()) {
            //
            $category = Category::findOrFail($id);
            $category->title = $request->input('title');
            $category->info = $request->input('info');
            $category->user_id = $request->input('user_id');
            $category->active = $request->input('active');
            $isSaved = $category->save();
            return response()->json(
                [
                    'message' => $isSaved ? "Category saved successfully" : "Failed to save category",
                    'icon' => $isSaved ? 'success' : 'error',
                ],
                $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
            );
        } else {
            //
            return response()->json(['message' => $validator->getMessageBag()->first(), 'icon' => 'error'], Response::HTTP_BAD_REQUEST);
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $deleteCount = Category::destroy($id);
        $deleted = $deleteCount == 1;
        return response()->json(
            ['message' => $deleted ? "Deleted successfully" : "Delete failed!"],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
