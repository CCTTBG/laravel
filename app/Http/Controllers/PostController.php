<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Group;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::all();
        $query = Post::with('groups');

        if (auth()->check()) {

            $myGroupId = auth()->user()->group_id;

            $query->where(function ($q) use ($myGroupId) {
                $q->whereDoesntHave('groups') // 전체 공개
                ->orWhereHas('groups', function ($q2) use ($myGroupId) {
                    $q2->where('groups.id', $myGroupId);
                });
            });
        } else {
            $query->whereDoesntHave('groups');
        }

        $posts = $query
            ->orderByDesc('is_notice')  // ✅ 공지 먼저
            ->orderByDesc('created_at')
            ->get();

        return view('posts.index', compact('posts', 'groups'));
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
            'comment' => 'required|max:500',
            'groups' => 'nullable|array',
            'groups.*' => 'integer|exists:groups,id',
        ]);

        $post = Post::create([
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'comment' => $request->comment,
            'is_notice' => $request->boolean('is_notice'), // 공지 기능까지 하면 추가
        ]);
        $post->groups()->sync($request->input('groups', []));

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
