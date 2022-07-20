<?php

namespace App\Jobs;

use App\Mail\CreatePost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PostMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $user_data;
    public $post_data;
    public function __construct($user_data, $post_data)
    {
        //
        $this->user_data = $user_data;
        $this->post_data = $post_data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // dd($this->user_data);

        foreach ($this->user_data as $key => $user_d) {
            Mail::to($user_d->email)->send(new CreatePost($user_d, $this->post_data));
        }
    }
}
