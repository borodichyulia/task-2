<?php

namespace application\services;

use GuzzleHttp\Client;

require_once '/var/www/vendor/autoload.php';

class UsersService
{

    public function getLastUser()
    {
        $client = new Client(['base_uri' => 'https://gorest.co.in/public/v2/users?access-token=4a49cdcc736f9c9eba255f6ebdc64b6790e7d7be060f8aa2db1e869fcd251c9b', 'curl' => [CURLOPT_SSL_VERIFYHOST => false, CURLOPT_SSL_VERIFYPEER => false,]]);
        $response = $client->request('GET');

        $usersBody = $response->getBody();
        $usersContent = $usersBody->getContents();
        $users = json_decode($usersContent);

        $lastUser = ['name' => $users[0]->name, 'email' => $users[0]->email, 'gender' => $users[0]->gender, 'status' => $users[0]->status];
        return $lastUser;
    }

    public function addUser($user)
    {
        $body = [
            "name" => $user['name'],
            "email" => $user['email'],
            "gender" => $user['gender'],
            "status" => $user['status'],
        ];
        $client = new Client(['curl' => [CURLOPT_SSL_VERIFYHOST => false, CURLOPT_SSL_VERIFYPEER => false,]]);
        $client->post('https://gorest.co.in/public/v2/users?page=1&per_page=50&access-token=4a49cdcc736f9c9eba255f6ebdc64b6790e7d7be060f8aa2db1e869fcd251c9b', ['body' => http_build_query($body)]);
    }

    public function getAllUsers()
    {
        preg_match('/\d+$/', $_SERVER['REQUEST_URI'], $matches);
        $page = isset($matches[0]) ? $matches[0] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $client = new Client(['base_uri' => 'https://gorest.co.in/public/v2/users?page=1&per_page=50&access-token=4a49cdcc736f9c9eba255f6ebdc64b6790e7d7be060f8aa2db1e869fcd251c9b', 'curl' => [CURLOPT_SSL_VERIFYHOST => false, CURLOPT_SSL_VERIFYPEER => false,]]);
        $response = $client->request('GET');

        $usersBody = $response->getBody();
        $usersContent = $usersBody->getContents();
        $users = json_decode($usersContent);

        $total_rows = count($users);
        $total_pages = ceil($total_rows / $limit);
        $arr = [];
        for ($i = $offset; $i < ($offset + 10); $i++) {
            if ($i < count($users)) {
                $row = ['id' => $users[$i]->id, 'name' => $users[$i]->name, 'email' => $users[$i]->email, 'gender' => $users[$i]->gender, 'status' => $users[$i]->status];
                array_push($arr, $row);
            }
        }
        $result = ['users' => $arr, 'pogination' => [$page, $total_pages]];
        return $result;
    }

    public function getOneUser($id)
    {
        $client = new Client(['base_uri' => "https://gorest.co.in/public/v2/users/$id?page=1&per_page=50&access-token=4a49cdcc736f9c9eba255f6ebdc64b6790e7d7be060f8aa2db1e869fcd251c9b", 'curl' => [CURLOPT_SSL_VERIFYHOST => false, CURLOPT_SSL_VERIFYPEER => false,]]);
        $response = $client->request('GET');

        $userBody = $response->getBody();
        $userContent = $userBody->getContents();
        $user = json_decode($userContent);

        $resultUser = (array)$user;

        $vars = ['user' => $resultUser];
        return $vars;
    }

    public function deleteOneUser($id)
    {
        $client = new Client(['curl' => [CURLOPT_SSL_VERIFYHOST => false, CURLOPT_SSL_VERIFYPEER => false,]]);
        $client->request('DELETE', "https://gorest.co.in/public/v2/users/$id?access-token=4a49cdcc736f9c9eba255f6ebdc64b6790e7d7be060f8aa2db1e869fcd251c9b");
    }

    public function editOneUser($id, $updatedUser)
    {
        $body = [
            "name" => $updatedUser['name'],
            "email" => $updatedUser['email'],
            "gender" => $updatedUser['gender'],
            "status" => $updatedUser['status'],
        ];
        $client = new Client(['curl' => [CURLOPT_SSL_VERIFYHOST => false, CURLOPT_SSL_VERIFYPEER => false,]]);
        $client->put("https://gorest.co.in/public/v2/users/$id?page=1&per_page=50&access-token=4a49cdcc736f9c9eba255f6ebdc64b6790e7d7be060f8aa2db1e869fcd251c9b", ['json' => $body]);
    }

    public function deleteCheckedUsers($ids)
    {
        for ($i = 0; $i < count($ids); $i++) {

            $client = new Client(['curl' => [CURLOPT_SSL_VERIFYHOST => false, CURLOPT_SSL_VERIFYPEER => false,]]);
            $client->request('DELETE', "https://gorest.co.in/public/v2/users/$ids[$i]?access-token=4a49cdcc736f9c9eba255f6ebdc64b6790e7d7be060f8aa2db1e869fcd251c9b");
        }
    }
}
