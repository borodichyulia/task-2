<?php

declare(strict_types=1);

namespace Tests\Unit;

require_once 'D:/innowise/tasks/julia.borodich/vendor/autoload.php';
include 'D:\innowise\tasks\julia.borodich\tasks\task\application\services\UsersService.php';

use application\services\UsersService;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;


class DatabaseTest extends TestCase
{
    /**
     * @test
     */
    public function testGetAllUsers()
    {
        $mockUsers = '[{"id":3061154,"name":"Miss Chandravati Guha","email":"guha_chandravati_miss@deckow.example","gender":"male","status":"inactive"},
        {"id":3061153,"name":"Aslesha Adiga DO","email":"aslesha_adiga_do@stanton.example","gender":"male","status":"active"},
        {"id":3061152,"name":"Rep. Chakravarti Panicker","email":"panicker_chakravarti_rep@jacobson.test","gender":"female","status":"active"},
        {"id":3061150,"name":"Anunay Asan","email":"asan_anunay@hahn-dickinson.test","gender":"female","status":"active"},
        {"id":3061149,"name":"Deepankar Varman","email":"varman_deepankar@schiller.example","gender":"male","status":"inactive"}]';

        $mock = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], $mockUsers),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $response = $client->request('GET', '/');

        $usersBody = $response->getBody();
        $usersContent = $usersBody->getContents();
        $users = json_decode($usersContent);


        $this->assertSame([3061154, "Miss Chandravati Guha", "guha_chandravati_miss@deckow.example", "male", "inactive"], [$users[0]->id, $users[0]->name, $users[0]->email, $users[0]->gender, $users[0]->status]);
        $this->assertSame([3061153, "Aslesha Adiga DO", "aslesha_adiga_do@stanton.example", "male", "active"], [$users[1]->id, $users[1]->name, $users[1]->email, $users[1]->gender, $users[1]->status]);
        $this->assertSame([3061152, "Rep. Chakravarti Panicker", "panicker_chakravarti_rep@jacobson.test", "female", "active"], [$users[2]->id, $users[2]->name, $users[2]->email, $users[2]->gender, $users[2]->status]);
        $this->assertSame([3061150, "Anunay Asan", "asan_anunay@hahn-dickinson.test", "female", "active"], [$users[3]->id, $users[3]->name, $users[3]->email, $users[3]->gender, $users[3]->status]);
        $this->assertSame([3061149, "Deepankar Varman", "varman_deepankar@schiller.example", "male", "inactive"], [$users[4]->id, $users[4]->name, $users[4]->email, $users[4]->gender, $users[4]->status]);
    }

    /**
     * @test
     */
    public function testAddUser()
    {
        $mockAddingUser = ["Ivan Solev", "solev@mail.ru", "male", "inactive"];

        $mock = new MockHandler([
            new Response(201),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $response = $client->request('POST', '/', [
            'form_params' => ['body' => ($mockAddingUser),],
        ]);

        $this->assertSame(201, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function testDeleteUser()
    {
        $mock = new MockHandler([
            new Response(204),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $response = $client->request('DELETE', '/');

        $this->assertSame(204, $response->getStatusCode());
    }


    /**
     * @test
     */
    public function testEditUser()
    {
        $mockEditingUser = ["id" => 3061154, "name" => "Miss Chandravati Guha", "email" => "guha_chandravati_miss@deckow.example", "gender" => "male", "status" => "inactive"];
        $mock = new MockHandler([
            new Response(200),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $response = $client->request('PUT', '/', ['json' => $mockEditingUser]);

        $this->assertSame(200, $response->getStatusCode());
    }
}
