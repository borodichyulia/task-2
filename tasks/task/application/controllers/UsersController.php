<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="Users API", version="0.1")
 */

class UsersController extends Controller
{
	/**
	 * @OA\Get(
	 *     path="/users/new",
	 * 	   summary="Method to get added user",
	 * 	   tags={"Users"},
	 *     @OA\Response(response="200", description="Success"),
	 *     @OA\Response(response="404", description="Not found"),
	 * )
	 */

	public function newAction()
	{
		$vars = $_COOKIE["Source"] == 1 ? $this->model->getLastUser() : $this->service->getLastUser();
		$this->view->render('New user', $vars);
	}

	/**
	 * @OA\Post(
	 *     path="/users/addUser",
	 * 	   summary="Method to add new user in database",
	 * 	   tags={"Users"},
	 *     @OA\RequestBody(
	 *         @OA\MediaType(
	 *             mediaType="application/json",
	 *             @OA\Schema(
	 *                 @OA\Property(
	 *                     property="id",
	 *                     type="integer"
	 *                 ),
	 *                 @OA\Property(
	 *                     property="name",
	 *                     type="string"
	 *                 ),
	 *                 @OA\Property(
	 *                     property="email",
	 *                     type="string"
	 *                 ),
	 * 				   @OA\Property(
	 *                     property="status",
	 *                     type="string"
	 *                 ),
	 * 				   @OA\Property(
	 *                     property="gender",
	 *                     type="string"
	 *                 ),
	 *                 example={"id": "2543", "name": "Petya Ivanov", "email": "petya123@mail.ru", "status": "active", "gender": "male"}
	 *             )
	 *         )
	 *     ),
	 *     @OA\Response(response="200", description="Success"),
	 *     @OA\Response(response="404", description="Not found"),
	 * )
	 */

	public function addUserAction()
	{
		$body = file_get_contents('php://input');
		$jsonData = json_decode($body);
		$addedUser = ['email' => $jsonData->email, 'name' => $jsonData->name, 'gender' => $jsonData->gender, 'status' => $jsonData->status];
		$_COOKIE["Source"] == 1 ? $this->model->addUser($addedUser) : $this->service->addUser($addedUser);
	}

	/**
	 * @OA\Get(
	 *     path="/users/create",
	 * 	   summary="Method to add data of user in form",
	 * 	   tags={"Users"},
	 *     @OA\Response(response="200", description="Success"),
	 *     @OA\Response(response="404", description="Not found"),
	 * )
	 */

	public function createAction()
	{
		$this->view->render('Create user');
	}

	/**
	 * @OA\Get(
	 *     path="/users",
	 * 	   summary="Method to get all users",
	 * 	   tags={"Users"},
	 *     @OA\Response(response="200", description="Success"),
	 *     @OA\Response(response="404", description="Not found"),
	 * )
	 */

	public function getAllAction()
	{
		$vars = $_COOKIE["Source"] == 1 ? $vars = $this->model->getAllUsers() : $this->service->getAllUsers();
		$this->view->render('Get user', $vars);
	}

	/**
	 * @OA\Get(
	 *     path="/users/{userId}",
	 * 	   summary="Method to get one user by id",
	 * 	   tags={"Users"},
	 * 	   @OA\Parameter(
	 * 	   		name="id",
	 * 	   		in="path",
	 *     		required=true,
	 *     		description="The id passed to get selected user",
	 * 			@OA\Schema(type="string"), 
	 * 		    @OA\Examples(example="int", value="1", summary="An int value."), 	
	 * 	   ),
	 *     @OA\Response(response="200", description="Success"),
	 *     @OA\Response(response="404", description="Not found"),
	 * )
	 */

	public function getOneAction()
	{
		preg_match('/\d+$/', $_SERVER['REQUEST_URI'], $matches);
		$userId = $matches[0];
		$vars = $_COOKIE["Source"] == 1 ? $this->model->getOneUser($userId) : $this->service->getOneUser($userId);
		$this->view->render('Get one user', $vars);
	}

	/**
	 * @OA\Delete(
	 *     path="/users/{userId}",
	 * 	   summary="Method to delete one user by id",
	 * 	   tags={"Users"},
	 * 	   @OA\Parameter(
	 * 	   		name="id",
	 * 	   		in="path",
	 *     		required=true,
	 *     		description="The id passed to delete selected user",
	 * 			@OA\Schema(type="string"), 
	 * 		    @OA\Examples(example="int", value="1", summary="An int value."), 	
	 * 	   ),
	 *     @OA\Response(response="200", description="Success"),
	 *     @OA\Response(response="404", description="Not found"),
	 * )
	 */

	public function deleteUserAction()
	{
		preg_match('/\d+$/', $_SERVER['REQUEST_URI'], $matches);
		$userId = $matches[0];
		$_COOKIE["Source"] == 1 ? $this->model->deleteOneUser($userId) : $this->service->deleteOneUser($userId);
	}

	/**
	 * @OA\Get(
	 *     path="/users/edit/{userId}",
	 * 	   summary="Method to edit data of one user by id",
	 * 	   tags={"Users"},
	 * 	   @OA\Parameter(
	 * 	   		name="id",
	 * 	   		in="path",
	 *     		required=true,
	 *     		description="The id passed to edit data of selected user",
	 * 			@OA\Schema(type="string"), 
	 * 		    @OA\Examples(example="int", value="1", summary="An int value."), 	
	 * 	   ),
	 *     @OA\Response(response="200", description="Success"),
	 *     @OA\Response(response="404", description="Not found"),
	 * )
	 */

	public function editUserAction()
	{
		preg_match('/\d+/', $_SERVER['REQUEST_URI'], $matches);
		$userId = $matches[0];
		$vars = $_COOKIE["Source"] == 1 ? $this->model->getOneUser($userId) : $this->service->getOneUser($userId);
		$this->view->render('Edit user', $vars);
	}

	/**
	 * @OA\Put(
	 *     path="/users/{userId}",
	 * 	   summary="Method to update data of one user by id in database",
	 * 	   tags={"Users"},
	 * 	   @OA\Parameter(
	 * 	   		name="id",
	 * 	   		in="path",
	 *     		required=true,
	 *     		description="The id passed to update selected user in database",
	 * 			@OA\Schema(type="string"), 
	 * 		    @OA\Examples(example="int", value="1", summary="An int value."), 	
	 * 	   ),
	 *     @OA\Response(response="200", description="Success"),
	 *     @OA\Response(response="404", description="Not found"),
	 * )
	 */

	public function updateUserAction()
	{
		$body = file_get_contents('php://input');
		$jsonData = json_decode($body);

		$updatedUser = ['email' => $jsonData->email, 'name' => $jsonData->name, 'gender' => $jsonData->gender, 'status' => $jsonData->status];

		if (empty($updatedUser['email']) || empty($updatedUser['name']) || empty($updatedUser['gender']) || empty($updatedUser['status'])) {
			View::errorCode(400);
		} else {
			preg_match('/\d+/', $_SERVER['REQUEST_URI'], $matches);
			$userId = $matches[0];
			$_COOKIE["Source"] == 1 ? $this->model->editOneUser($userId, $updatedUser) : $this->service->editOneUser($userId, $updatedUser);
		}
	}

	public function deleteCheckedAction()
	{
		$body = file_get_contents('php://input');
		$jsonData = json_decode($body);
		$usersIds = $jsonData->usersIds;
		$_COOKIE["Source"] == 1 ? $this->model->deleteCheckedUsers($usersIds) : $this->service->deleteCheckedUsers($usersIds);
	}
}
