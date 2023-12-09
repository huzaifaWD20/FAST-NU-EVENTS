// if (isset($_POST['addEvent'])) {
  //   // Retrieve form data
  //   $name = $_POST['Eventname'];
  //   $description = $_POST['event-description'];
  //   $eventDate = $_POST['event-date'];
  //   $startTime = $_POST['event-start-time'];
  //   $endTime = $_POST['event-end-time'];
  //   $location = $_POST['event-location'];
  //   $eventType = $_POST['event-type'];
  //   $organizerName = $_POST['event-organizer-name'];
  //   $organizerEmail = $_POST['event-organizer-email'];
  //   $registrationDeadline = $_POST['event-registration-deadline'];
  //   $ticketPrice = $_POST['event-ticket-price'];

  //   // Assuming user ID is stored in the session
  //   // $userId = $_SESSION['uid'];

  //   // Check for a similar event in the database based on event name and date
  //   $checkQuery = "SELECT * FROM events WHERE event_title = '$name' AND event_date = '$eventDate'";
  //   $checkResult = mysqli_query($con, $checkQuery);

  //   if (mysqli_num_rows($checkResult) > 0) 
  //   {
  //     // A similar event already exists
  //     // Display a Bootstrap modal for confirmation
  //     echo '<div class="modal" id="confirmModal" tabindex="-1" role="dialog">
  //             <div class="modal-dialog" role="document">
  //               <div class="modal-content">
  //                   <div class="modal-header">
  //                       <h5 class="modal-title">Similar Event Found</h5>
  //                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
  //                           <span aria-hidden="true">&times;</span>
  //                       </button>
  //                   </div>
  //                   <div class="modal-body">
  //                       <p>Similar event already exists. Do you want to update the existing event or create a new one?</p>
  //                   </div>
  //                   <div class="modal-footer">
  //                       <form method="POST">
  //                           <input type="hidden" name="eventName" value="' . $name . '">
  //                           <input type="hidden" name="eventDate" value="' . $eventDate . '">
  //                           <button type="submit" name="updateEvent" class="btn btn-primary">Update Event</button>
  //                           <button type="submit" name="createNewEvent" class="btn btn-secondary" data-dismiss="modal">Create New Event</button>
  //                       </form>
  //                   </div>
  //               </div>
  //             </div>
  //           </div>';

  //     // JavaScript to display the Bootstrap modal
  //     echo '<script>
  //             $(document).ready(function(){
  //                 $("#confirmModal").modal("show");
  //             });
  //           </script>';

  //     // Handle the form submission after the modal confirmation
  //     if (isset($_POST['updateEvent'])) {
  //         // Update the existing event in the database
  //       $updateQuery = "UPDATE events SET
  //       event_price = '$ticketPrice',
  //       type_id = '$eventType',
  //       event_description = '$description',
  //       start_time = '$startTime',
  //       end_time = '$endTime',
  //       event_location = '$location',
  //       organizer_name = '$organizerName',
  //       organizer_email = '$organizerEmail',
  //       registration_deadline = '$registrationDeadline'
  //       WHERE event_title = '$name' AND event_date = '$eventDate'";

  //       $updateResult = mysqli_query($con, $updateQuery);

  //       if ($updateResult) {
  //       // Update successful - redirect or display success message
  //       header('location:../dasboard.php');
  //       exit();
  //       } else {
  //       // Handle update errors
  //       echo "Error updating event: " . mysqli_error($con);
  //       }
  //     } 
  //     elseif (isset($_POST['createNewEvent'])) {
  //         // Create a new event in the database
  //         $insertQuery = "INSERT INTO events (event_title, event_price, participants, type_id, event_description, event_date, start_time, end_time, event_location, organizer_name, organizer_email, registration_deadline)
  //                         VALUES ('$name', '$ticketPrice', '0', '$eventType', '$description', '$eventDate', '$startTime', '$endTime', '$location', '$organizerName', '$organizerEmail', '$registrationDeadline')";
  //         $insertResult = mysqli_query($con, $insertQuery);

  //         if ($insertResult) {
  //             // Event creation successful - redirect or display success message
  //             header('location:../dasboard.php');
  //             exit();
  //         } else {
  //             // Handle insertion errors
  //             echo "Error creating new event: " . mysqli_error($con);
  //         }
  //     }
  //   } 
  //   else 
  //   {
  //     // Create a new event in the database
  //     $insertQuery = "INSERT INTO events (event_title, event_price, participants, type_id, event_description, event_date, start_time, end_time, event_location, organizer_name, organizer_email, registration_deadline)
  //     VALUES ('$name', '$ticketPrice', '0', '$eventType', '$description', '$eventDate', '$startTime', '$endTime', '$location', '$organizerName', '$organizerEmail', '$registrationDeadline')";
  //     $insertResult = mysqli_query($con, $insertQuery);

  //     if ($insertResult) {
  //     // Event creation successful - redirect or display success message
  //     header('location:../dasboard.php');
  //     exit();
  //     } else {
  //     // Handle insertion errors
  //     echo "Error creating new event: " . mysqli_error($con);
  //     }
  //   }
  // }

  /*--------------------searching operation----------------------*/
  if (isset($_POST['search'])) {
    $bid=$_POST['bid'];
    $sid=$_POST['sid'];
    $date=$_POST['date'];

    switch ($sid) {
      case 'cid':
                    $sql="SELECT * FROM registration WHERE wdate='$date' AND cid='$bid' ";
                    $run=mysqli_query($con,$sql);
                  if(mysqli_num_rows($run)==0){
                      echo "<h2 class='text-center'>Not found </h2>";
                  }else{
                    $sql="SELECT * FROM catering WHERE cid='$bid'";
                    $run=mysqli_query($con,$sql);
                    $row=mysqli_fetch_array($run);
                      $name=$row['name'];
                      $price=$row['price'];
                      $type="Catering";
                      echo " <div class='row'>
            <div class='col-md-3'>
              <h3 class='text-center text-white'> $type</h3>
            </div>
            <div class='col-md-3'>
              <h3 class='text-center text-white'>$name</h3>
            </div>
            <div class='col-md-3'>
              <h3 class='text-center text-white'>$date</h3>
            </div>
            <div class='col-md-3'>
              <h3 class='text-center text-white'>$price</h3>
            </div>
          </div>";
                  }
        break;
      case 'pid':
                $sql="SELECT * FROM registration WHERE wdate='$date' AND pid='$bid' ";
                    $run=mysqli_query($con,$sql);
                  if(mysqli_num_rows($run)==0){
                      echo "<h2 class='text-center'>Not found </h2>";
                  }else{
                    $sql="SELECT * FROM photoshop WHERE pid='$bid'";
                    $run=mysqli_query($con,$sql);
                    $row=mysqli_fetch_array($run);
                      $name=$row['name'];
                      $price=$row['price'];
                      $type="Photoshop";
                      echo " <div class='row'>
            <div class='col-md-3'>
              <h3 class='text-center text-white'> $type</h3>
            </div>
            <div class='col-md-3'>
              <h3 class='text-center text-white'>$name</h3>
            </div>
            <div class='col-md-3'>
              <h3 class='text-center text-white'>$date</h3>
            </div>
            <div class='col-md-3'>
              <h3 class='text-center text-white'>$price</h3>
            </div>
          </div>";
                  }
        break;
      case 'tid':
              $sql="SELECT * FROM registration WHERE wdate='$date' AND tid='$bid' ";
                    $run=mysqli_query($con,$sql);
                  if(mysqli_num_rows($run)==0){
                      echo "<h2 class='text-center'>Not found </h2>";
                  }else{
                    $sql="SELECT * FROM theme WHERE tid='$bid'";
                    $run=mysqli_query($con,$sql);
                    $row=mysqli_fetch_array($run);
                      $name=$row['name'];
                      $price=$row['price'];
                      $type="Theme";
                      echo " <div class='row'>
            <div class='col-md-3'>
              <h3 class='text-center text-white'> $type</h3>
            </div>
            <div class='col-md-3'>
              <h3 class='text-center text-white'>$name</h3>
            </div>
            <div class='col-md-3'>
              <h3 class='text-center text-white'>$date</h3>
            </div>
            <div class='col-md-3'>
              <h3 class='text-center text-white'>$price</h3>
            </div>
          </div>";
                  }
        break;
      case 'mid':
                $sql="SELECT * FROM registration WHERE wdate='$date' AND mid='$bid' ";
                    $run=mysqli_query($con,$sql);
                  if(mysqli_num_rows($run)==0){
                      echo "<h2 class='text-center'>Not found </h2>";
                  }else{
                    $sql="SELECT * FROM music WHERE mid='$bid'";
                    $run=mysqli_query($con,$sql);
                    $row=mysqli_fetch_array($run);
                      $name=$row['name'];
                      $price=$row['price'];
                      $type="Music";
                      echo " <div class='row'>
            <div class='col-md-3'>
              <h3 class='text-center text-white'> $type</h3>
            </div>
            <div class='col-md-3'>
              <h3 class='text-center text-white'>$name</h3>
            </div>
            <div class='col-md-3'>
              <h3 class='text-center text-white'>$date</h3>
            </div>
            <div class='col-md-3'>
              <h3 class='text-center text-white'>$price</h3>
            </div>
          </div>";
                  }
        break; 
      case 'vid':
                $sql="SELECT * FROM registration WHERE wdate='$date' AND vid='$bid' ";
                    $run=mysqli_query($con,$sql);
                  if(mysqli_num_rows($run)==0){
                      echo "<h2 class='text-center'>Not found </h2>";
                  }else{
                    $sql="SELECT * FROM venue WHERE vid='$bid'";
                    $run=mysqli_query($con,$sql);
                    $row=mysqli_fetch_array($run);
                      $name=$row['name'];
                      $price=$row['price'];
                      $type="Venue";
                      echo " <div class='row'>
            <div class='col-md-3'>
              <h3 class='text-center text-white'> $type</h3>
            </div>
            <div class='col-md-3'>
              <h3 class='text-center text-white'>$name</h3>
            </div>
            <div class='col-md-3'>
              <h3 class='text-center text-white'>$date</h3>
            </div>
            <div class='col-md-3'>
              <h3 class='text-center text-white'>$price</h3>
            </div>
          </div>";
                  }
        break; 
      case 'did':
          $sql="SELECT * FROM registration WHERE wdate='$date' AND did='$bid' ";
                    $run=mysqli_query($con,$sql);
                  if(mysqli_num_rows($run)==0){
                      echo "<h2 class='text-center'>Not found </h2>";
                  }else{
                    $sql="SELECT * FROM decoration WHERE did='$bid'";
                    $run=mysqli_query($con,$sql);
                    $row=mysqli_fetch_array($run);
                      $name=$row['name'];
                      $price=$row['price'];
                      $type="Decoration";
                      echo " <div class='row'>
            <div class='col-md-3'>
              <h3 class='text-center text-white'> $type</h3>
            </div>
            <div class='col-md-3'>
              <h3 class='text-center text-white'>$name</h3>
            </div>
            <div class='col-md-3'>
              <h3 class='text-center text-white'>$date</h3>
            </div>
            <div class='col-md-3'>
              <h3 class='text-center text-white'>$price</h3>
            </div>
          </div>";
                  }
        break; 

      
      
    }
    }   

  ?>
  /*--------------------searching operation----------------------*/