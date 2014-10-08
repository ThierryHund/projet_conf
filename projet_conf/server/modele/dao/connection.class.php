
<?php
class Connection {
	private static $connection = false;
	private static $host = "localhost";
	private static $dbname = "projet_conf";
	private static $user = "admin";
	private static $pwd = "admin";
	public static function get() {
		if (self::$connection == false) {
			
			self::$connection = new PDO ( 'mysql:host=' . self::$host . ';dbname=' . self::$dbname, self::$user, self::$pwd, array (
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
					PDO::ATTR_CASE => 'SET lc_time_names = \'fr_FR\''
			) );
			
			return self::$connection;
		} else
			return self::$connection;
	}
	public static function informations() {
		return self::$host . " " . self::$dbname . " " . self::$user . "\n";
	}
}
