<?php

namespace App\Services;

use Exception;
use GuzzleHttp;
use Illuminate\Support\Facades\Log;

class Request
{
    protected static $credentials;

    public static function sendRequest(array $options = [], array $headers = [], array $body = [], array $query = [])
    {
        if (! empty($body)) {
            $content_length = ['Content-Length' => strlen(json_encode($body))];
        } else {
            $content_length = [];
            $body = [];
        }

        $client = new GuzzleHttp\Client();

        $merge_headers = array_merge(
            self::$credentials,
            [
                'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
                'Host' => env('URL_PAGSEGURO').'transactions',
            ],
            $content_length,
            $headers
        );

        $response = null;

        try {
            Log::info('Envio de Request');

            Log::debug(json_encode(array_merge(
                $options,
                $merge_headers,
                $body,
                $query
            ), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        } catch (Exception | GuzzleHttp\Exception\RequestException $e) {
            Log::error('Request error: ', [$e]);
        }

        Log::info('Response de Request: '.$response);

        return $response;
    }
}
