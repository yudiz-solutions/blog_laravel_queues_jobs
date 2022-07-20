<?php

namespace App\Http\Controllers;

use App\Jobs\PostMailJob;
use App\Mail\CreatePost;
use App\Models\Post;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->input());
        $rules = [
            'title' => 'required|min:5',
            'description' => 'required|max:250|min:10',
        ];
        $is_validate = Validator::make($request->all(), $rules);
        if ($is_validate->fails()) {
            return redirect()->back()->with("danger", $is_validate->errors()->first());
        }
        $post_data =  Post::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);


        //send email to user not use the queue and jobs 
        // try {
        //     $user_data = User::all();
        //     foreach ($user_data as $key => $user_d) {
        //         Mail::to($user_d->email)->send(new CreatePost($user_d, $post_data));
        //     }
        // } catch (Exception $e) {
        //     return redirect()->back()->with("danger", $e->getMessage());
        // }
        // return redirect()->back()->with('success', "Mail Send Successfully");


        // send email when post create using the queue and jobs
        //start the php artisan queue:work
        try {
            $user_data = User::all();
            // dispatch(new PostMailJob($user_data, $post_data))->delay(now()->addSeconds(6));
            PostMailJob::dispatch($user_data, $post_data)->delay(now()->addSeconds(5));
        } catch (Exception $e) {
            return redirect()->back()->with("danger", $e->getMessage());
        }
        return redirect()->back()->with('success', "Mail Will Be Send");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
