<?php

namespace App\Services;

use Throwable;
use Illuminate\Support\Facades\Http;

class Bitly
{
    public static function createShortLink($object)
    {
        try {
            [ 'link' => $link, 'title' => $title ] = $object;

            $response =  Http::accept('application/json')
            ->withToken(env('BITLY_ACCESS_TOKEN'))
            ->post('https://api-ssl.bitly.com/v4/bitlinks', [
                "domain" => "bit.ly",
                "long_url" => $link,
                'title' => $title,
                'group_guid' => null,
            ]);

            $body = $response->json();

            return [
                'success' => true,
                'id' => $body['id'],
                'link' => $body['link'],
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public static function updateShortLink($id, $object)
    {
        try {
            [ 'link' => $link, 'title' => $title ] = $object;

            $response =  Http::accept('application/json')
                ->withToken(env('BITLY_ACCESS_TOKEN'))
                ->patch('https://api-ssl.bitly.com/v4/bitlinks/' . $id, [
                    "domain" => "bit.ly",
                    "long_url" => $link,
                    'title' => $title,
                    'archived' => false
                ]);

            $body = $response->json();

            return [
                'success' => true,
                'id' => $body['id'],
                'link' => $body['link'],
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public static function deleteShortLink($id)
    {
        try {
            $response =  Http::accept('application/json')
                ->withToken(env('BITLY_ACCESS_TOKEN'))
                ->delete('https://api-ssl.bitly.com/v4/bitlinks/' . $id);

            if($response->status() !== 200){
                throw new Throwable('Something went wrong');
            }

            return [
                'success' => true,
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}
