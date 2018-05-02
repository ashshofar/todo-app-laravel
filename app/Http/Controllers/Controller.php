<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getResponse($status, $data, $message, $filter = null){
        // Handle paginate data
        if ($data != null && array_key_exists('data', $data)) {
            $response = [
                'data' => $data['data'],
                'meta' => [
                    'status'        => $status,
                    'message'       => $message,
                    'current_page'  => $data['current_page'],
                    'per_page'      => $data['per_page'],
                    'total'         => $data['total'],
                    'last_page'     => $data['last_page']
                ],
                'links' => [
                    'next' => $data['next_page_url'] != null && $filter != null ? $data['next_page_url'] . $filter : $data['next_page_url'],
                    'prev' => $data['prev_page_url'] != null && $filter != null ? $data['prev_page_url'] . $filter : $data['prev_page_url'],
                    'path' => $data['path']
                ]
            ];
        } else {
            $response = [
                'data' => $data,
                'meta' => [
                    'status' => $status,
                    'message' => $message
                ]
            ];
        }

        return response()->json($response)
            ->header('Content-Type','application/json')
            ->header('Access-Control-Allow-Origin','*')
            ->header('Access-Control-Allow-Header','X-Access-Token,X-Costumer-Access-Token')
            ->header('Access-Control-Allow-Methods','POST,GET,PUT,DELETE,OPTIONS');
    }
}
