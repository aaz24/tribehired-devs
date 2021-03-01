<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Get Individual Post.
     *
     * @return void
     */
    public function get(Request $request, int $post_id)
    {
        $client = new \GuzzleHttp\Client();

        $responseData = $client->get('https://jsonplaceholder.typicode.com/posts/'.$post_id);

        return $responseData->getBody();
    }

    /** Get All Posts.
     *
     * @return void
     */
    public function getAll(Request $request)
    {
        $client = new \GuzzleHttp\Client();

        $response = $client->get('https://jsonplaceholder.typicode.com/posts');

        return $response->getBody();
    }
}
