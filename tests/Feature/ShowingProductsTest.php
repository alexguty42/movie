<?php

namespace Database\Factories;
use Tests\TestCase;
use App\Models\User;
use App\Models\Movie;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ShowingProductsTest extends TestCase
{

    use RefreshDatabase;

    public function testCreateMovie()
    {
        $user = User::factory()->create();

        $movieData = [
            'title' => 'Creed 3',
            'year' => 2023,
            'director' => 'Michael B Jordan',
            'genre' => 'Drama',
            'duration' => 120,
            'rating' => 9,
        ];

        Sanctum::actingAs($user);

        $response = $this->json('POST', '/api/movies', $movieData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('movies', $movieData);
    }

    public function testGetAllMovies()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->json('GET', '/api/movies');

        $response->assertStatus(200);
        $response->assertJsonCount(Movie::count());
    }

    public function testUpdateMovie()
    {
        $user = User::factory()->create();

        $movie = Movie::create([
            'title' => 'El Padrino',
            'year' => 1974,
            'director' => 'Michael Jordan',
            'genre' => 'Crimen',
            'duration' => 200,
            'rating' => 9,
        ]);

        $movieData = [
            'title' => 'La madrina',
            'year' => 1972,
            'director' => 'Francis Ford',
            'genre' => 'Comedia',
            'duration' => '120',
            'rating' => 10,
        ];

        Sanctum::actingAs($user);

        $response = $this->put("/api/movies/{$movie->id}", $movieData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('movies', $movieData);
    }



    public function testDeleteMovie()
{
    $user = User::factory()->create();

    $movie = Movie::create([
        'title' => 'Star Gordos',
        'year' => 2001,
        'director' => 'Indiana Jones',
        'genre' => 'Action',
        'duration' => 160,
        'rating' => 4,
    ]);

    Sanctum::actingAs($user);

    $response = $this->delete("/api/movies/{$movie->id}");

    $response->assertStatus(200);
    $this->assertDatabaseMissing('movies', ['id' => $movie->id]);
}

}

