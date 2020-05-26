<?php

namespace App\Http\Controllers;

use App\TopicComment;
use App\Traits\ForumTraits;
use App\Http\Resources\Topics\TopicComment as TopicCommentResources;
use Illuminate\Http\Request;

class TopicCommentController extends Controller
{
    use ForumTraits;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->topic) {
            $comments = TopicComment::where('topic_id', $request->topic)->orderByDesc('created_at')->get();
        } else {
            $comments = TopicComment::all()->sortByDesc('created_at');
        }

        foreach ($comments as $comment) {
            $comment->author_data = $this->getAuthor($comment->author_id);
        }

        return TopicCommentResources::collection($comments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $comment = new TopicComment;
        $comment->author_id = $request->user_id;
        $comment->topic_id = $request->topic_id;
        $comment->body = $request->body;
        $comment->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TopicComment  $topicComment
     * @return \Illuminate\Http\Response
     */
    public function show(TopicComment $topicComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TopicComment  $topicComment
     * @return \Illuminate\Http\Response
     */
    public function edit(TopicComment $topicComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TopicComment  $topicComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TopicComment $topicComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TopicComment  $topicComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(TopicComment $topicComment)
    {
        //
    }
}
