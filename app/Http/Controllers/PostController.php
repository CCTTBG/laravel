<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //기본 조회 페이지
        $posts=Post::orderBy('created_at')->get();
        return view('posts.index',compact('posts'));
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
        //등록
       $request->validate([
            'comment'=>'required|max:500'
       ]);

       Post::create([
           'name' => auth()->user()->name,
           'email' => auth()->user()->email,
           'comment' => $request->comment,
       ]);
        return redirect()->route('posts.index')
            ->with('success', '등록 완료!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if ($post->email !== auth()->user()->email) {
            abort(403, '본인 글만 수정할 수 있습니다.');
        }

        $validated = $request->validate([
            'comment'=>'required|max:500'
        ]);

        $post->update([
            'comment' => $request->comment,
            // name/email은 수정 못하게 고정하는 게 안전
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ]);
        return redirect()->route('posts.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->email !== auth()->user()->email) {
            abort(403, '본인 글만 수정할 수 있습니다.');
        }
        $post -> delete();
        return redirect()->route('posts.index');
    }
}
