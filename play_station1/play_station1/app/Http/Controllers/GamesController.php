<?php

namespace App\Http\Controllers;

use App\Models\Games;
use Illuminate\Http\Request;

class GamesController extends Controller
{
   public function index()
   {
       $games = Games::all();
       return response()->json([
           'message' => 'Successfully fetched games',
           'data' => $games
       ], 200);
   }

   public function store(Request $request)
{
    $validatedData = $request->validate([
        'name_games' => 'required|string',
        'genre_games' => 'required|string',
        'price' => 'required|numeric',
        'image' => 'nullable|string',
    ]);

    $game = Games::create($validatedData);

    return response()->json([
        'message' => 'Game successfully created',
        'data' => $game
    ], 201);
}

   public function show(Games $game)
   {
       return response()->json([
           'message' => 'Successfully fetched game',
           'data' => $game
       ], 200);
   }

   public function update(Request $request, Games $game)
   {
       $game->update($request->all());
       return response()->json([
           'message' => 'Game successfully updated',
           'data' => $game
       ], 200);
   }

   public function destroy(Games $game)
   {
       $game->delete();
       return response()->json([
           'message' => 'Game successfully deleted'
       ], 200);
   }
}