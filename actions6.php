<?php
// include event class 
include_once 'class/Events6.php';
// create obj
$event = new Event();
// post method
$post = $_POST;
// define array
$json = array();	
// create record in database
if(!empty($post['action']) && $post['action']=="create") {
	$event->setTitle($post['title']);
	$event->setLocation($post['location']);
	$event->setContent($post['content']);
	$status = $event->create();
	if(!empty($status)){
		$json['msg'] = 'success';
		$json['task_id'] = $status;
	} else {
		$json['msg'] = 'failed';
		$json['task_id'] = '';
	}
	header('Content-Type: application/json');	
	echo '<div class="card gedf-card" style="margin: 5px;" id="dyn-'.$status.'">
      <div class="card-body">
          <a class="card-link" href="#">
              <h5 class="card-title">'.$post['title'].'</h5>
          </a>
          <div class="text-muted h7 mb-2"> <i class="fas fa-map-marker-alt"></i> '.$post['location'].'</div>
          <p class="card-text">'.$post['content'].'</p>
          <hr>
          <p class="card-text float-right">
            <button type="submit" class="btn btn-sm btn-outline-secondary update-event" data-ueventid="'.$status.'">Edit</button>
            <button type="submit" class="btn btn-sm btn-outline-secondary delete-event" data-deventid="'.$status.'">Delete</button>
          </p>
      </div>                    
    </div>';
}
// update record in database
if(!empty($post['action']) && $post['action']=="fetch_event") {
	$event->setEventID($post['event_id']);
	$fetchEvent = $event->getEvent();
	header('Content-Type: application/json');
	echo '<form id="dynamic-post-'.$post['event_id'].'" class="dynamic-post">
	<input type="hidden" name="action" value="update">
		<input type="hidden" name="event_id" value="'.$fetchEvent['id'].'">
        <div class="row align-items-center">
          <div class="col-md-12 col-md-right">
           <div class="form-group">
              <div class="col-sm-12">          
                <input type="text" class="form-control" id="event-title" placeholder="Title" name="title" value="'.$fetchEvent['title'].'">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">          
                <input type="text" class="form-control" id="event-location" placeholder="Location" name="location" value="'.$fetchEvent['location'].'">
              </div>
            </div> 
            <div class="form-group">
              <div class="col-sm-12">
                <textarea class="form-control" id="event-content'.$fetchEvent['id'].'" name="content">'.$fetchEvent['content'].'</textarea>
              </div>
            </div>
            <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-12">
                <button type="button" class="btn btn-info float-right save-update" data-seventid="'.$fetchEvent['id'].'">Submit</button>
              </div>
            </div>
        </div>
      </div>
      </form>';
  }

// update record in database
if(!empty($post['action']) && $post['action']=="update") {
	$event->setEventID($post['event_id']);
	$event->setTitle($post['title']);
	$event->setLocation($post['location']);
	$event->setContent($post['content']);
	$status = $event->update();
	if(!empty($status)){
		$json['msg'] = 'success';
	} else {
		$json['msg'] = 'failed';
	}
	header('Content-Type: application/json');	
	echo '<div class="card gedf-card" style="margin: 5px;" id="dyn-'.$post['event_id'].'">
      <div class="card-body">
          <a class="card-link" href="#">
              <h5 class="card-title">'.$post['title'].'</h5>
          </a>
          <div class="text-muted h7 mb-2"> <i class="fas fa-map-marker-alt"></i> '.$post['location'].'</div>
          <p class="card-text">'.$post['content'].'</p>
          <hr>
          <p class="card-text float-right">
            <button type="submit" class="btn btn-sm btn-outline-secondary update-event" data-ueventid="'.$post['event_id'].'">Edit</button>
            <button type="submit" class="btn btn-sm btn-outline-secondary delete-event" data-deventid="'.$post['event_id'].'">Delete</button>
          </p>
      </div>                    
    </div>';
}

// delete record from database
if(!empty($post['action']) && $post['action']=="delete") {
	$event->setEventID($post['event_id']);
	$status = $event->delete();
	if(!empty($status)){
		$json['msg'] = 'success';
	} else {
		$json['msg'] = 'failed';
	}
	header('Content-Type: application/json');	
	echo json_encode($json);	
}

?>