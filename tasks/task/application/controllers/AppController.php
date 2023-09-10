<?php

namespace application\controllers;

use application\core\Controller;

class AppController extends Controller
{

	/**
	 * @OA\Get(
	 *     path="/",
	 * 	   summary="Main page",
	 * 	   tags={"Users"},
	 *     @OA\Response(response="200", description="Success"),
	 *     @OA\Response(response="404", description="Not found"),
	 * )
	 */

	public function indexAction()
	{
		$a = $_SERVER['DOCUMENT_ROOT'];
		count($_GET) == 0 ? setcookie("Source", 1, time() + 86400) : setcookie("Source", $_GET['source'], time() + 86400);
		$this->view->render('Main page');
	}
}
