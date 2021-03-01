<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * Get All Comments.
     *
     * @return void
     */
    public function getAll(Request $request)
    {
        $client = new \GuzzleHttp\Client();

        $response = $client->get('https://jsonplaceholder.typicode.com/comments');

        $fomattedData = $this->responseFormatter(json_decode($response->getBody()));

        return json_encode($fomattedData);
    }

    /**
     * Search Query.
     *
     * @return void
     */
    public function search(Request $request)
    {
        $allComments = $this->getAll($request);
        $filteredArray = [];

        if ($allComments != '') {
            $commentArray = json_decode($allComments);
            foreach ($commentArray as $key => $value) {
                foreach ($request->all() as $parakey => $parameters) {
                    if (isset($value->$parakey) && $parameters == $value->$parakey) {
                        array_push($filteredArray, $value);
                        break;
                    }
                }
            }
        }

        return json_encode($filteredArray);
    }

    /**
     * Formatting all Comments function.
     *
     * @return void
     */
    private function responseFormatter(array $responseData)
    {
        $responseArray = [];
        $count = 0;
        $responseArray['total_number_of_comments'] = 0;
        if (!empty($responseData)) {
            foreach ($responseData as $key => $value) {
                ++$count;

                $comments['post_id'] = $value->postId ?? '';
                $comments['post_title'] = $value->name ?? '';
                $comments['post_body'] = $value->body ?? '';
                array_push($responseArray, $comments);
            }
        }
        $responseArray['total_number_of_comments'] = $count;

        return $responseArray;
    }
}
