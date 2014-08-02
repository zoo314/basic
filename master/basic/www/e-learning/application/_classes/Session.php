<?php

/**
  * Session
  *
  * Some basics for PHP session
  *
  * @author  Laurent B. aka  MonkeyTime
  *
  * @license wtfpl 		http://www.wtfpl.net/
  *
  */
class Session {

	private static $_ssid;
	private static $_config;
	const SALT = 'HaisD|g#hyVRN=2%f!04C:q,5By67c=X';

	private function __construct() {}
	private function __clone() {}

	/**
	  * start
	  *
	  * session start
	  *
	  * @return void
	  *
	  */
	public static function start() {
		
		session_start();

		self::$_ssid = md5((session_id()|SID) . self::SALT);
	}
	
	/**
	  * set
	  *
	  * set the $_SESSION['session'], usage @ credential only
	  *
	  * @return void
	  *
	  */
	public static function set() {

		$_SESSION['session'] = self::$_ssid;
	}
	
	/**
	  * get
	  *
	  * get the $_SESSION['session']
	  *
	  * @return string 	The $_SESSION['session']
	  *
	  */
	public static function get() {

		return isset($_SESSION['session']) ? $_SESSION['session'] : '';
	}
	
	/**
	  * is_valid
	  *
	  * verify if the session is valid
	  *
	  * @param string 	The current $_SESSION['session']
	  *
	  * @return bool 	True on success, false on failure
	  *
	  */
	public static function is_valid($sess = '') {
		
		return ($sess != '' and self::get() === $sess);
	}
	
	/**
	  * close
	  *
	  * session write close
	  *
	  * @return void
	  *
	  */
	public static function close() {

		session_write_close();
	}
	
	/**
	  * destroy
	  *
	  * destroy the session
	  *
	  * @return void
	  *
	  */
	public static function destroy() {
		
		$_SESSION = array();
		(unset)self::$_ssid;
		session_destroy();
	}
	
	/**
	  * regen
	  *
	  * regen the session id
	  *
	  * @return void
	  *
	  */
    public static function regen() {
		
        session_regenerate_id(true);
    }
	
	/**
	  * tokenize
	  *
	  * method to add a token to a form
	  *
	  * <code>
	  * $token = Session::tokenize('form1', 300); //validity 5 minutes
	  * <input type="hidden" name="myToken1" value="<?php echo $token; ?>" />
	  * </code>
	  *
	  * @param string 	The prefix for the current form (anti conflict for $_SESSION keys for each form)
	  * @param int 		The TTL where the token is valid (in second)
	  *
	  * @return string 	The generated token
	  *
	  */
	public static function tokenize($prefix, $ttl) {
		
		$token = md5(uniqid(mt_rand(), true));
		$_SESSION[$prefix.'Token'] = $token;
		$_SESSION[$prefix.'Timer'] = time() + $ttl;

		return $token;
	}
	
	/**
	  * tokenIsValid
	  *
	  * method to verify the token posted with the form
	  *
	  * <code>
	  * if(Session::tokenIsValid('form1', $_POST['myToken1'])) {
	  *     //ok
	  * }
	  * </code>
	  *
	  * @param string 	The prefix for the current form
	  * @param string 	The token posted
	  *
	  * @return bool 	True on success, false on failure
	  *
	  */
	public static function tokenIsValid($prefix, $tokenpost) {
		
		if (isset($_SESSION[$prefix.'Token']) and ($_SESSION[$prefix.'Token'] === $tokenpost) and isset($_SESSION[$prefix.'Timer']) and ($_SESSION[$prefix.'Timer'] > time())) {
			
			unset($_SESSION[$prefix.'Token'], $_SESSION[$prefix.'Timer']);
			
			return true;
		}
		
		unset($_SESSION[$prefix.'Token'], $_SESSION[$prefix.'Timer']);

		return false;
	}
}