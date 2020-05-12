<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\post;
use App\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($user_id)
    {
        //
        if (auth()->user()->id != $user_id){
            abort(403);
        }
        $user = User::findOrFail($user_id);
        return view ('users.posts.create',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $user_id)
    {
        //
        if (auth()->user()->id != $user_id){
            abort(403);
        }
        $this->validate($request,[
            'story'=>'required|string'
        ]);
        $user = User::findOrFail($user_id);
        $post = new post();
        $post->story = $request->story;
        $user->posts()->save($post);

        return redirect()->route('users.show',[$user_id]);
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($user_id, $id)
    {
        //
        if (auth()->user()->id != $user_id){
            abort(403);
        }
        $user = User::findOrFail($user_id);
        $post = $user->posts()->findOrFail($id);

        return view('users.posts.edit',compact('user','post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $user_id, $id)
    {
        //
        if (auth()->user()->id != $user_id){
            abort(403);
        }
        $this->validate($request,[
            'story'=>'string'
        ]);
        $user = User::findOrFail($user_id);
        $post = $user->posts()->findOrFail($id);
        $post->user_id = $user_id;
        $post->story = $request->story;
        $post->save();

        return redirect()->route('users.show',['user_id']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($user_id, $id)
    {
        //
        if (auth()->user()->id != $user_id){
            abort(403);
        }
        $user = User::findOrFail($user_id);
        $post = $user->posts()->findOrFail($id);
        $post->delete();

        return redirect()->route('users.show',[$user_id]);
    }
}
