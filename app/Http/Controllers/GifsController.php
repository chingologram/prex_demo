<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GPH\Api\DefaultApi;
use Exception;

class GifsController extends Controller
{
    private DefaultApi $api_instance;

    public function __construct()
    {
        $this->api_instance = new DefaultApi();
    }
    //
    public function search(Request $request) {
        try {
            $gifs = [];
            $result = $this->api_instance->gifsSearchGet(
                env('GIPHY_API_KEY'),
                $request->input('query'),
                $request->input('limit'),
                $request->input('offset'),
                "G",
                "ES",
                "json");
            foreach ($result->getData() as $g) {
                $gifs[]= [
                    'url' => $g['url'],
                    'id' => $g['id']
                ];
            }
            return response()->json(['results' => $gifs ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'There was an error searching GIFs'], 500);
        }
    }

    public function findById(Request $request) {
        try {
            $gif = $this->api_instance->gifsGifIdGet(env('GIPHY_API_KEY'), $request->input('gif_id'));
            if (!$gif) {
                return response()->json([
                    'error' => 'Could not find GIF'
                ], 404);
            }
            return response()->json([
                'id' => $gif->getData()['id'],
                'url' => $gif->getData()['url']
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => 'There was an error searching GIFs'], 500);
        }
    }

    public function favorite(Request $request) {
        $request->user()->saveFavorite($request->input('alias'), $request->input('gif_id'));
        return response()->json([ 'success' => true ], 200);
    }
}
