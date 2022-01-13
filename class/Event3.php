<?php
/**
 * @package Event class
 *
 * @author TechArise Team
 *
 * @email  info@techarise.com
 *   
 */

// include connection class
include("DBConnection3.php");
// Event
class Event 
{
    protected $db;
    private $_eventID;
    private $_title;
    private $_location;
    private $_content;

    public function setEventID($eventID) {
        $this->_eventID = $eventID;
    }
    public function setTitle($title) {
        $this->_title = $title;
    }
    public function setLocation($location) {
        $this->_location = $location;
    }
    public function setContent($content) {
        $this->_content = $content;
    }
    
    // __construct
    public function __construct() {
        $this->db = new DBConnection();
        $this->db = $this->db->returnConnection();
    }

    // create record in database
    public function create() {
		try {
    		$sql = 'INSERT INTO event3 (title, location, content)  VALUES (:title, :location, :content)';
    		$data = [
			    'title' => $this->_title,
                'location' => $this->_location,
			    'content' => $this->_content,
			];
	    	$stmt = $this->db->prepare($sql);
	    	$stmt->execute($data);
			$status = $this->db->lastInsertId();
            return $status;

		} catch (Exception $err) {
    		die("Oh noes! There's an error in the query! ".$err);
		}

    }

    // update record in database
    public function update() {
        try {
		    $sql = "UPDATE event3 SET title=:title, location=:location, content=:content WHERE id=:event_id";
		    $data = [
			    'title' => $this->_title,
                'location' => $this->_location,
                'content' => $this->_content,
                'event_id' => $this->_eventID,
			];
			$stmt = $this->db->prepare($sql);
			$stmt->execute($data);
			$status = $stmt->rowCount();
            return $status;
		} catch (Exception $err) {
			die("Oh noes! There's an error in the query! " . $err);
		}
    }
   
    // get records from database
    public function getList() {
    	try {
    		$sql = "SELECT id, title, location, content, created_date FROM event3";
		    $stmt = $this->db->prepare($sql);
		    $stmt->execute();
		    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
		} catch (Exception $err) {
		    die("Oh noes! There's an error in the query! " . $err);
		}
    }
    // 
    public function getEvent() {
        try {
            $sql = "SELECT id, title, location, content, created_date FROM event3 WHERE id=:event_id";
            $stmt = $this->db->prepare($sql);
            $data = [
                'event_id' => $this->_eventID
            ];
            $stmt->execute($data);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            die("Oh noes! There's an error in the query!");
        }
    }

    // delete record from database
    public function delete() {
    	try {
	    	$sql = "DELETE FROM event3 WHERE id=:event_id";
		    $stmt = $this->db->prepare($sql);
		    $data = [
		    	'event_id' => $this->_eventID
			];
	    	$stmt->execute($data);
            $status = $stmt->rowCount();
            return $status;
	    } catch (Exception $err) {
		    die("Oh noes! There's an error in the query! " . $err);
		}
    }


}
?>