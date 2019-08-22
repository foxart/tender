<?php
/****
* NAME:    dburl.inc.php
* TEAM:    COMODO WEB TEAM
* VERSION: 1.0.0 - release
* DATE:    01-02-2012
* PURPOSE: Managing the DB connections
*/
class DBUrl
{
	private $db_conn;
	private $lastError;
	private $user = 'uip2geo';
	private $pass = 'Iso3Ogle';
	private $db = 'ip2geo';
	private $host = 'csql84';
	private $port = '5432';
	public function __construct()
	{
		try{
			$this->db_conn = new PDO("pgsql:host=". $this->host .";port=". $this->port .";dbname=". $this->db, $this->user, $this->pass);
		} catch (PDOException $e) {
			$this->lastError = $e->getMessage();
			return -1;
		}
	}
	public function ip2geo( $ip){
		$sql = "SELECT country FROM geo2ip WHERE :ip BETWEEN begin_ip AND end_ip LIMIT 1;";
		$ret = '';
		try{
			if( !$this->db_conn) return -1;
			$stmt = $this->db_conn->prepare($sql);
			$stmt->bindParam(':ip', $ip, PdoInterface::PARAM_STR, strlen($ip));
			$stmt->execute();
			$ret = $stmt->fetchColumn();
			return $ret;
		}catch(PDOException $e){
			return $e->getMessage();	
		}catch(Exception $err){
			return -2;
		}
	}
	public function getId($url)
	{
		$sql = 'SELECT id FROM urlid WHERE url=:url;';
		$ret = '';
		try{
			if( !$this->db_conn) return -1;
			$stmt = $this->db_conn->prepare($sql);
			$stmt->bindParam(':url', $url, PdoInterface::PARAM_STR, strlen($url));
			$stmt->execute();
			$ret = $stmt->fetchColumn();
			if($ret == false) 
			{
				if($this->insertId($url) == true)
				{
					$stmt->execute(array($url));
					return $stmt->fetchColumn();
				}else{
					return '00';
				}	
			}
			return $ret;
		}catch(PDOException $e){
			return $e->getMessage();	
		}catch(Exception $err){
			return -2;
		}
	}
	public function getURL($id)
	{
		$sql = "SELECT url FROM urlid WHERE id=:urlId";
		try{
			if( !$this->db_conn) return -1;
			$stmt = $this->db_conn->prepare($sql);
			$stmt->bindParam(':urlId', $id, PdoInterface::PARAM_STR, strlen($id));
			$stmt->execute();
			return $stmt->fetchColumn();
		}catch(PDOException $e){
			return $e->getMessage();	
		}
	}
	public function getError(){
		return $this->lastError;
	}
	private function insertId($url)
	{
		$sql = "INSERT INTO urlid(url) VALUES (?);";	
		try{
			if( !$this->db_conn) return -1;
			$stmt = $this->db_conn->prepare($sql);
			$stmt->bindParam(1, $url, PdoInterface::PARAM_STR, strlen($url));
			$stmt->execute();
		}catch(PDOException $e){
			$this->lastError = $e->getMessage();
			return -2;
		}
		return true;
	}
}
?>