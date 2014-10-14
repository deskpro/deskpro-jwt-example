<?php
/**
 * Represents an auth system that is external to DeskPRO
 */
class AuthSystem
{
	private $users;


	public function __construct()
	{
		session_start();

		$_SESSION['authenticated'] = isset($_SESSION['authenticated']) ? $_SESSION['authenticated'] : false;
		$_SESSION['user']          = isset($_SESSION['user']) ? $_SESSION['user'] : null;

		$this->users = array(
			array(
				'id'    => '1',
				'user'  => 'cp',
				'pass'  => 'user1',
				'name'  => 'CP',
				'email' => 'cp@cp.com'
			),
			array(
				'id'    => '2',
				'user'  => 'cn',
				'pass'  => 'user2',
				'name'  => 'CN',
				'email' => 'cn@cn.com'
			),
			array(
				'id'    => '3',
				'user'  => 'ct',
				'pass'  => 'user3',
				'name'  => 'CT',
				'email' => 'ct@ct.com'
			),
			array(
				'id'    => '4',
				'user'  => 'maxim',
				'pass'  => 'user4',
				'name'  => 'MAXIM',
				'email' => 'max@im.com'
			),
			array(
				'id'    => '5',
				'user'  => 'user',
				'pass'  => 'user',
				'name'  => 'Some User',
				'email' => 'user@user.com'
			),
			array(
				'id'    => '6',
				'user'  => 'admin',
				'pass'  => 'admin',
				'name'  => 'Admin User',
				'email' => 'admin@admin.com'
			)
		);
	}


	public function login($username, $password)
	{
		foreach ($this->users as $user_data) {
			if ($user_data['user'] == $username && $user_data['pass'] == $password) {
				$this->authenticate($user_data);
				return;
			}
		}
		$this->logout();
	}


	protected function authenticate(array $user_data)
	{
		$_SESSION['authenticated'] = true;
		$_SESSION['user']          = $user_data;
	}


	public function logout()
	{
		$_SESSION['authenticated'] = false;
		$_SESSION['user']          = null;
	}


	public function isAuthenticated()
	{
		return $_SESSION['authenticated'];
	}


	public function getUser()
	{
		return $_SESSION['user'];
	}


}
