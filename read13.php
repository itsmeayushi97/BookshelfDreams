<?php 
// include event class 
include_once 'class/Events13.php';
// create obj
$event = new Event();
$eventInfo = $event->getList();
include('templates/header.php');
?>
<script src="assets/tinymce/tinymce.min.js" referrerpolicy="origin"></script>
    <section class="showcase">
      <div class="container">
        <div class="pb-2 mt-4 mb-2 border-bottom">
          <h2>Stars Align</h2>
        </div>
        <span id="render-event-data">
         <?php if(!empty($eventInfo) && count($eventInfo)>0) { ?>
            <?php foreach($eventInfo as $key=>$element) { ?>
            <span id="dyn-<?php print $element['id'];?>">
            <div class="card gedf-card" style="margin: 5px;">
    
      <div class="card-body">
          <a class="card-link" href="#">
              <h5 class="card-title"><?php print $element['title']; ?></h5>
          </a>
          <div class="text-muted h7 mb-2"> <i class="fas fa-map-marker-alt"></i> <?php print $element['location']; ?></div>
          <p class="card-text"><?php print $element['content']; ?></p>
          <hr>
        

      </div>                    
    </div>
  </span>
          <?php } ?>
        <?php } ?>
        </span>
        <br/>
        <hr>
        <form id="dynamic-post" class="dynamic-post">
        <input type="hidden" name="action" value="create">
        <div class="row align-items-center">
          <div class="col-md-12 col-md-right">
           <div class="form-group">
              <div class="col-sm-12">          
                <input type="text" class="form-control" id="event-title" placeholder="Rating" name="title">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">          
                <input type="text" class="form-control" id="event-location" placeholder="Genre" name="location">
              </div>
            </div> 
            <div class="form-group">
              <div class="col-sm-12">
                <textarea class="form-control" id="event-content" name="content"></textarea>
              </div>
            </div>
            <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-12">
                <button type="button" class="btn btn-info float-right" id="save-event">Submit</button>
              </div>
            </div>
        </div>
      </div>
     </form>
    </div>
  </section>
<?php include('templates/footer.php');?>
<script src="assets/tinymce/custom.tinymcek13.js"></script>