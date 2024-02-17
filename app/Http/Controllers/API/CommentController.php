<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
        // $this->middleware('throttle:api')
        //     ->only(['store', 'update', 'destroy']);
        // $this->authorizeResource(Event::class, 'event');
    }

     public function index()
    {
        //eturn Comment::all();
        //這會將 user 的詳細資料一併取出
        return CommentResource::collection(Comment::with('user')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //新增的時候需要確保公司ID是存在的
        $comment = Comment::create([
            ...$request->validate([
                'rating' => 'required|min:1|max:10|integer',
                'comment' => 'nullable|string',
                'company_id' => 'required|exists:companies,id'
            ]),
            //'user_id' => 1,
            //'company_id' => 1,
            'user_id' => $request->user()->id,
            // 'company_id' => $request->company()->id
        ]);

        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //更新之前先確認更新者和留言者相同
        // if(Gate::denies('update-delete-comment', $comment)){
        //     abort(403, 'You cannot update this comment.');
        // }
        //上述更簡化的版本：
        $this->authorize('update-delete-comment', $comment);

        //確認留言者之後就不需要從 user 取出 id
        $comment->update(
            $request->validate([
                'rating' => 'required|min:1|max:10|integer',
                'comment' => 'nullable|string'
            ]),
            [
                //'user_id' => $request->user()->id,
            ],
        );

        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //刪除之前先確認刪除者和留言者相同
        // if(Gate::denies('update-delete-comment', $comment)){
        //     abort(403, 'You cannot delete this comment.');
        // }
        //上述更簡化的版本：
        $this->authorize('update-delete-comment', $comment);

        //$id = $comment->id;
        $comment->delete();

        // return response()->Json([
        //     'message' => 'Comment:'.$id.' deleted successfully.'
        // ]);
        return response(status: 204);
    }
}
