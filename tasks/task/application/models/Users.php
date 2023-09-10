<?php

namespace application\models;

use application\core\Model;

class Users extends Model
{
    public function addUser($user)
    {
        $email = $user['email'];
        $name = $user['name'];
        $gender = $user['gender'];
        $status = $user['status'];

        $this->db->query("INSERT INTO users (email, name, gender, status) VALUES ('$email', '$name', '$gender', '$status')");
    }

    public function getLastUser()
    {
        $lastUser = $this->db->query("SELECT * FROM users WHERE id=(SELECT MAX(id) FROM users)");
        $result = mysqli_fetch_array($lastUser, MYSQLI_ASSOC);
        return $result;
    }

    public function getAllUsers()
    {
        preg_match('/\d+$/', $_SERVER['REQUEST_URI'], $matches);
        $page = isset($matches[0]) ? $matches[0] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $countOfElements = $this->db->query("SELECT COUNT(*) FROM users");
        $total_rows = mysqli_fetch_array($countOfElements)[0];
        $total_pages = ceil($total_rows / $limit);

        $users = $this->db->query("SELECT * FROM users LIMIT $limit OFFSET $offset");
        $arr = [];
        while ($row = mysqli_fetch_array($users, MYSQLI_ASSOC)) {
            array_push($arr, $row);
        }

        $result = ['users' => $arr, 'pogination' => [$page, $total_pages]];
        return $result;
    }

    public function getOneUser($id)
    {
        $user = $this->db->query("SELECT * FROM users WHERE id=$id");
        $resultUser = mysqli_fetch_array($user, MYSQLI_ASSOC);
        $vars = ['user' => $resultUser];
        return $vars;
    }

    public function deleteOneUser($id)
    {
        $user = $this->db->query("DELETE FROM users WHERE id=$id");
        return $user;
    }

    public function editOneUser($id, $updatedUser)
    {
        $email = $updatedUser['email'];
        $name = $updatedUser['name'];
        $gender = $updatedUser['gender'];
        $status = $updatedUser['status'];

        $user = $this->db->query("UPDATE users SET email = '$email', name = '$name', gender = '$gender', status = '$status' WHERE id = $id");
        return $user;
    }

    public function deleteCheckedUsers($ids)
    {
        $idsToString = implode(",", $ids);
        $users = $this->db->query("DELETE FROM users WHERE id IN ($idsToString)");
        return $users;
    }
    public function kit($arg)
    {
        $a = $this->db->doSomething($arg);
        return $a;
    }
}
