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
    // Crear un usuario para autenticar
    $user = User::factory()->create();

    // Crear una película para eliminar
    $movie = Movie::create([
        'title' => 'Star Gordos',
        'year' => 2001,
        'director' => 'Indiana Jones',
        'genre' => 'Action',
        'duration' => 160,
        'rating' => 4,
    ]);

    // Autenticar el usuario
    Sanctum::actingAs($user);

    // Eliminar la película
    $response = $this->delete("/api/movies/{$movie->id}");

    // Verificar que se haya eliminado correctamente
    $response->assertStatus(200);
    $this->assertDatabaseMissing('movies', ['id' => $movie->id]);
}

}

/*
curl  -d '{"title":"Chucky", "year":2020,"director":"michael jackson","genre":"horror","duration":120,"rating":6}' -H "Content-Type: application/json" -X POST http://localhost:8000/api/movies
*/
