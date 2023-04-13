<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    public function index()
{
    if (Auth::check()) {
        $movie = Movie::all();
        return response()->json($movie);
    }

    return response()->json(['message' => 'Unauthorized'], 401);
}



    public function store(Request $request)
    {
        if (Auth::check()) {
        $movie = new Movie();

        $movie->title = $request->title;
        $movie->year = $request->year;
        $movie->director = $request->director;
        $movie->genre = $request->genre;
        $movie->duration = $request->duration;
        $movie->rating = $request->rating;

        $movie->save();

        return response()->json([
            'message' => 'Movie created successfully',
            'data' => $movie
        ], 201);
        }

        return response()->json(['message' => 'Unauthorized'], 401);

    }

    public function show($id)
    {
        if (Auth::check()) {
        return Movie::where('id', $id)->get();
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function update(Request $request, Movie $movie)
    {
        if (Auth::check()) {
        $movie->update($request->all());

        return response()->json([
            'message' => 'Movie updated successfully',
            'data' => $movie
        ]);
    }
        return response()->json(['message' => 'Unauthorized'], 401);
    }


    public function destroy($id)
    {
        if (Auth::check()) {
            $movie = Movie::find($id);

            if ($movie) {
                $movie->delete();
                return response()->json([
                    'message' => 'Movie destroyed successfully',
                    'data' => $movie
                ]);
            }

            return response()->json(['message' => 'Movie not found'], 404);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }


}
