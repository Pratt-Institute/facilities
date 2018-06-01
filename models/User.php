<?php

namespace app\models;

use Yii;
use yii\web\Session;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
    public $credsOkay = false;

    private static $users = [
		// 	'100' => [
		// 		'id' => '100',
		// 		'username' => 'admin',
		// 		'password' => 'admin',
		// 		'authKey' => 'test100key',
		// 		'accessToken' => '100-token',
		// 	],
		// 	'101' => [
		// 		'id' => '101',
		// 		'username' => 'demo',
		// 		'password' => 'demo',
		// 		'authKey' => 'test101key',
		// 		'accessToken' => '101-token',
		// 	],

		'111' => [
			'id' => '111',
			'username' => ADMIN_USER,
			'password' => ADMIN_PASS,
			'authKey' => 'test111key',
			'accessToken' => '111-token',
		],

    ];

	// 	public function __construct(){
	//
	// 		self::doLdapAuth();
	// 		parent::__construct();
	//
	// 	}

	public static function doLdapAuth() {

		//echo '<br>doLdapAuth';
		//die();

		$session = Yii::$app->session;

		$username = $session->get('username');
		$password = $session->get('password');

		//echo '<br>creds ' . $username . ' ' . $password;

		if ($username=='' || $password=='') {
			return null;
		}

		$ldapconn = ldap_connect(LDAPHOST, LDAPPORT) or die('Could not connect to $ldaphost');

		if ($ldapconn) {

			$ldapbind = ldap_bind($ldapconn, LDAPUSER, LDAPPASS);

			if ($ldapbind) {

				$dn = LDAPBASE;
				$filter="(|(mail=".$username."))";
				$justthese = array('dn', 'ou', 'sn', 'givenname', 'mail');
				//$justthese = array('dn');
				$sr=ldap_search($ldapconn, $dn, $filter);
				$info = ldap_get_entries($ldapconn, $sr);

				if ($info[0]['ou'][0] == 'Interactive Services') {

					if ($userbind = ldap_bind($ldapconn, $info[0]['dn'], $password)) {

						$arr['id']			= '102';
						$arr['username']	= $username;
						$arr['password']	= $password;
						$arr['authKey']		= 'test102key';
						$arr['accessToken']	= '102-token';

						array_push(self::$users,$arr);

						$session->set('userArray', self::$users);

						//echo "<pre>";
						//print_r(self::$users);
						//echo "</pre>";
						//die();

						return true;

					} else {
						return null;
					}

				} else {
					return null;
				}

			} else {
				echo "LDAP bind failed...";
			}
		}

		return null;
	}


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
    	//self::doLdapAuth();
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
    	//self::doLdapAuth();
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    //public static function findByUsername($username)
    public static function findByUsername($username)
    {
    	//self::doLdapAuth();
    	foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
				return new static($user);
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
    	//return true;
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
    	//return true;
        return $this->password === $password;
    }
}
