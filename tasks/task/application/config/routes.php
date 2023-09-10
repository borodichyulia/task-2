<?php

return [
	'(\?source=\d+)?' => [
		'controller' => 'app',
		'action' => 'index',
		'method' => 'GET',
	],

	'users/addUser' => [
		'controller' => 'users',
		'action' => 'addUser',
		'method' => 'POST',
	],

	'users/new' => [
		'controller' => 'users',
		'action' => 'new',
		'method' => 'GET',
	],


	'users/create' => [
		'controller' => 'users',
		'action' => 'create',
		'method' => 'GET',
	],

	'users(\?page=\d+)?' => [
		'controller' => 'users',
		'action' => 'getAll',
		'method' => 'GET',
	],
	'users\/\d+' => [
		'controller' => 'users',
		'action' => 'getOne',
		'method' => 'GET',
	],
	'users\/\d{1,200}' => [
		'controller' => 'users',
		'action' => 'deleteUser',
		'method' => 'DELETE',
	],
	'users/edit\/\d+' => [
		'controller' => 'users',
		'action' => 'editUser',
		'method' => 'GET',
	],
	'users\/\d{1,201}' => [
		'controller' => 'users',
		'action' => 'updateUser',
		'method' => 'PUT',
	],
	'users/delete' => [
		'controller' => 'users',
		'action' => 'deleteChecked',
		'method' => 'DELETE',
	],

];
