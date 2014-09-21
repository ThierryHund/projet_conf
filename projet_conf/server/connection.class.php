
<?php
class Connection {
	private static $connection = false;
	private static $host = "localhost";
	private static $dbname = "_projet_carte";
	private static $user = "tyery1";
	private static $pwd = "t061276yy";
	public static function get() {
		if (self::$connection == false) {
			
			self::$connection = new PDO ( 'mysql:host=' . self::$host . ';dbname=' . self::$dbname, self::$user, self::$pwd, array (
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'' 
			) );
			
			return self::$connection;
		} else
			return self::$connection;
	}
	public static function informations() {
		return self::$host . " " . self::$dbname . " " . self::$user . "\n";
	}
}
