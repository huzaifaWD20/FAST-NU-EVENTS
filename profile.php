<?php
  include('action.php');
  if(!isset($_SESSION['uname'])){
    header('location:index.php');
  } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>FAST NU EVENTS</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="img/NUlogo.png" rel="icon">

  <!-- Bootstrap CSS File -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="lib/animate/animate.min.css" rel="stylesheet">
  <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
  <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="css/style.css" rel="stylesheet">
</head>

<body id="page-top">

  <!--/ Nav Star /-->
  <nav class="navbar navbar-b navbar-trans navbar-expand-md fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll" href="#page-top">FAST NU EVENTS</a>
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarDefault"
        aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <div class="navbar-collapse collapse justify-content-end" id="navbarDefault">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link js-scroll active" href="#home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll" href="#events">Events</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll" href="#registeredEvents"><?php echo $_SESSION['urname']; ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll" href="registration/logout.php">Log out</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!--/ Nav End /-->

  <!--/ Intro Skew Star /-->
  <div id="home" class="intro route bg-image" style="background-image: url(img/universityBackgroundimg.jpg)">
    <div class="overlay-itro"></div>
    <div class="intro-content display-table">
      <div class="table-cell">
        <div class="container">
          <!--<p class="display-6 color-d">Hello, world!</p>-->
          <h1 class="intro-title mb-4">FAST NU EVENTS</h1>
          <p class="intro-subtitle"><span class="text-slider-items">GET NOTIFIED OF THE BEST EVENTS HAPPENING IN FAST KHI CAMPUS</span><strong class="text-slider"></strong></p>
          <!-- <p class="pt-3"><a class="btn btn-primary btn js-scroll px-4" href="#about" role="button">Learn More</a></p> -->
        </div>
      </div>
    </div>
  </div>
  <!--/ Intro Skew End /-->

  <!--/ Section Events Start /-->
  <section id="events" class="services-mf route">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="title-box text-center">
            <h3 class="title-a">EVENTS</h3>
            <p class="subtitle-a"></p>
            <div class="line-mf"></div>
          </div>
        </div>
      </div>
      <div class="row justify-content-start mb-3 pb-3">
          <div class="col-md-7 heading-section">
              <h2>Book Your Favorite Event</h2>
          </div>
      </div>

      <?php
        // Establish your database connection here
        $connection = mysqli_connect("localhost", "root", "", "nu_events");
        // Check connection
        if (!$connection) {
          die("Connection failed: " . mysqli_connect_error());
        }
        // Assuming you have a valid database connection $connection
        // Fetch event types from the database
        $eventTypesQuery = "SELECT * FROM event_type";
        $eventTypesResult = mysqli_query($connection, $eventTypesQuery);

        if ($eventTypesResult && mysqli_num_rows($eventTypesResult) > 0) {
            while ($typeRow = mysqli_fetch_assoc($eventTypesResult)) {
                $typeId = $typeRow['type_id'];
                $typeTitle = $typeRow['type_title'];

                // Display accordions for each event type
                echo "
                <div class='row pb-3'>
                    <div class='col-md-12'>
                        <div id='accordion$typeId'>
                            <div class='card'>
                                <div class='card-header' id='heading$typeId'>
                                    <button class='btn btn-link' data-toggle='collapse' data-target='#collapse$typeId' aria-expanded='false' aria-controls='collapse$typeId'>
                                        $typeTitle
                                    </button>
                                </div>
                                <div id='collapse$typeId' class='collapse' aria-labelledby='heading$typeId' data-parent='#accordion$typeId'>
                                    <div class='card-body'>
                                        <div class='row'>";

                // Fetch events for this event type
                $eventsQuery = "SELECT * FROM events WHERE type_id = $typeId";
                $eventsResult = mysqli_query($connection, $eventsQuery);

                if ($eventsResult && mysqli_num_rows($eventsResult) > 0) {
                    while ($eventRow = mysqli_fetch_assoc($eventsResult)) {
                        // Extract event details
                        $eventId = $eventRow['event_id'];
                        $eventTitle = $eventRow['event_title'];
                        $eventPrice = $eventRow['event_price'];
                        $eventTypeId = $eventRow['type_id'];
                        $eventDescription = $eventRow['event_description'];
                        $eventDate = $eventRow['event_date'];
                        $startTime = $eventRow['start_time'];
                        $endTime = $eventRow['end_time'];
                        $eventLocation = $eventRow['event_location'];
                        $organizerName = $eventRow['organizer_name'];
                        $organizerEmail = $eventRow['organizer_email'];
                        $registrationDeadline = $eventRow['registration_deadline'];

                        // Fetch type title from event_type table
                        $eventTypeQuery = "SELECT type_title FROM event_type WHERE type_id = $eventTypeId";
                        $eventTypeResult = mysqli_query($connection, $eventTypeQuery);
                        $eventTypeRow = mysqli_fetch_assoc($eventTypeResult);
                        $eventTypeTitle = $eventTypeRow['type_title'];
                        ?>
                          <div class='col-lg-12 col-md-12 col-sm-12 mb-3'>
                            <div class='card event-horizontal'>
                              <div class='card-body'>
                                  <h5 class='card-title'><a href='#' class='text-dark font-weight-bold'><?php echo $eventTitle; ?></a></h5>
                                  <p class='card-text'>Type: <?php echo $eventTypeTitle; ?></p>
                                  <p class='card-text'>Price: <?php echo $eventPrice; ?> RS</p>
                                  <p class='card-text'>Description: <?php echo $eventDescription; ?></p>
                                  <p class='card-text'>Date: <?php echo $eventDate; ?></p>
                                  <p class='card-text'>Time: <?php echo $startTime . ' - ' . $endTime; ?></p>
                                  <p class='card-text'>Location: <?php echo $eventLocation; ?></p>
                                <p class='card-text'>Organizer: <?php echo $organizerName; ?></p>
                                <p class='card-text'>Organizer Email: <?php echo $organizerEmail; ?></p>
                                <p class='card-text'>Registration Deadline: <?php echo $registrationDeadline; ?></p>
                                <hr>
                                <?php
                                  // Check if the user is logged in
                                  if (isset($_SESSION['uid'])) {
                                    // Assuming you have a valid database connection $connection
                                    // Extract event details
                                    $eventId = $eventRow['event_id'];

                                    // Check if the user has already registered for this event
                                    $registrationQuery = "SELECT * FROM registration WHERE u_id = {$_SESSION['uid']} AND event_id = $eventId";
                                    $registrationResult = mysqli_query($connection, $registrationQuery);

                                    if ($registrationResult && mysqli_num_rows($registrationResult) > 0) {
                                        // User already registered, disable the registration button
                                        echo '<p class="bottom-area d-flex">
                                                <span class="ml-auto">
                                                    <button class="btn btn-primary" disabled>Already Registered</button>
                                                </span>
                                              </p>';
                                    } else {
                                        // User not registered, show registration button
                                        echo '<p class="bottom-area d-flex">
                                                <span class="ml-auto">
                                                    <a href="registration/registration.php?event_id=' . $eventId . '" class="btn btn-primary">Register</a>
                                                </span>
                                              </p>';
                                    }
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                        <?php
                    }
                } 
                else {
                  echo "<p>No events found for this type.</p>";
                }
                echo "
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";
            }
        } else {
            echo "<p>No event types found.</p>";
        }
      ?>
    </div>
  </section>
  <!--/ Section Events End /-->

  <!--/ Section Registered Event Start /-->
  <section id="registeredEvents">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="title-box text-center">
            <h3 class="title-a">
              REGISTERED EVENTS
            </h3>
            <p class="subtitle-a"></p>
            <div class="line-mf"></div>
          </div>
        </div>
      </div>
    <?php
      // Assuming you have a user ID stored in the session
      $userId = $_SESSION['uid'];

      // Query to retrieve registered events for the user
      $query = "SELECT r.reg_id, r.name, r.email, r.phoneNum, et.type_title AS event_type_name, e.event_title
                FROM registration r
                INNER JOIN event_type et ON r.type_id = et.type_id
                INNER JOIN events e ON r.event_id = e.event_id
                WHERE r.u_id = '$userId'";

      $result = mysqli_query($con, $query);
      if ($result) {
          if (mysqli_num_rows($result) > 0) {
              echo '
              <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                      <thead>
                          <tr>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Phone Number</th>
                              <th>Event Type</th>
                              <th>Event Title</th>
                              <th></th>
                          </tr>
                      </thead>
                      <tbody>';

              while ($row = mysqli_fetch_assoc($result)) {
                  echo '<tr>';
                  echo '<td>' . $row['name'] . '</td>';
                  echo '<td>' . $row['email'] . '</td>';
                  echo '<td>' . $row['phoneNum'] . '</td>';
                  echo '<td>' . $row['event_type_name'] . '</td>';
                  echo '<td>' . $row['event_title'] . '</td>';
                  echo '<td>
                          <form method="POST" action="registration/cancelRegistration.php">
                              <input type="hidden" name="cancel-registration" value="' . $row['reg_id'] . '">
                              <button type="submit" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to cancel this registration?\')">Cancel Registration</button>
                          </form>
                        </td>';
                  echo '</tr>';
              }

              echo '
                      </tbody>
                  </table>
              </div>';
          } else {
              echo '<p>No registered events found for this user.</p>';
          }
      } else {
          echo '<p>Error fetching registered events: ' . mysqli_error($con) . '</p>';
      }
    ?>
    </div>
  </section>
  <!--/ Section Registered Event End /-->

  <!--/ Section Registered Event Start /-->
  <section id="PreviousregisteredEvents">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="title-box text-center">
            <h3 class="title-a">
              PREVIOUS REGISTRATIONS
            </h3>
            <p class="subtitle-a"></p>
            <div class="line-mf"></div>
          </div>
        </div>
      </div>
    <?php
      // Assuming you have a user ID stored in the session
      $userId = $_SESSION['uid'];

      // Query to retrieve registered events for the user
      $query = "SELECT rb.reg_id, rb.name, rb.email, rb.phoneNum, et.type_title AS event_type_name, e.event_title
                FROM registrations_backup rb
                INNER JOIN event_type et ON rb.type_id = et.type_id
                INNER JOIN events e ON rb.event_id = e.event_id
                WHERE rb.u_id = '$userId'";

      $result = mysqli_query($con, $query);
      if ($result) {
          if (mysqli_num_rows($result) > 0) {
              echo '
              <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                      <thead>
                          <tr>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Phone Number</th>
                              <th>Event Type</th>
                              <th>Event Title</th>
                          </tr>
                      </thead>
                      <tbody>';

              while ($row = mysqli_fetch_assoc($result)) {
                  echo '<tr>';
                  echo '<td>' . $row['name'] . '</td>';
                  echo '<td>' . $row['email'] . '</td>';
                  echo '<td>' . $row['phoneNum'] . '</td>';
                  echo '<td>' . $row['event_type_name'] . '</td>';
                  echo '<td>' . $row['event_title'] . '</td>';
                  echo '</tr>';
              }
              echo '
                      </tbody>
                  </table>
              </div>';
          } else {
              echo '<p>No previous registered events found for this user.</p>';
          }
      } else {
          echo '<p>Error fetching previous registered events: ' . mysqli_error($con) . '</p>';
      }
    ?>
    </div>
  </section>
  <!--/ Section Registered Event End /-->

   
  <!-- <div class="section-counter paralax-mf bg-image" style="background-image: url(img/wed.jpg)">
    <div class="overlay-mf"></div>
    <div class="container">
      <div class="row">
        <div class="col-sm-3 col-lg-3">
          <div class="counter-box counter-box pt-4 pt-md-0">
            <div class="counter-ico">
              <span class="ico-circle"><i class="ion-checkmark-round"></i></span>
            </div>
            <div class="counter-num">
              <p class="counter">450</p>
              <span class="counter-text">WORKS COMPLETED</span>
            </div>
          </div>
        </div>
        <div class="col-sm-3 col-lg-3">
          <div class="counter-box pt-4 pt-md-0">
            <div class="counter-ico">
              <span class="ico-circle"><i class="ion-ios-calendar-outline"></i></span>
            </div>
            <div class="counter-num">
              <p class="counter">3</p>
              <span class="counter-text">YEARS OF EXPERIENCE</span>
            </div>
          </div>
        </div>
        <div class="col-sm-3 col-lg-3">
          <div class="counter-box pt-4 pt-md-0">
            <div class="counter-ico">
              <span class="ico-circle"><i class="ion-ios-people"></i></span>
            </div>
            <div class="counter-num">
              <p class="counter">550</p>
              <span class="counter-text">TOTAL CLIENTS</span>
            </div>
          </div>
        </div>
        <div class="col-sm-3 col-lg-3">
          <div class="counter-box pt-4 pt-md-0">
            <div class="counter-ico">
              <span class="ico-circle"><i class="ion-ribbon-a"></i></span>
            </div>
            <div class="counter-num">
              <p class="counter">36</p>
              <span class="counter-text">AWARD WON</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> -->


  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>

  <!-- JavaScript Libraries -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/jquery/jquery-migrate.min.js"></script>
  <script src="lib/popper/popper.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <script src="lib/easing/easing.min.js"></script>
  <script src="lib/counterup/jquery.waypoints.min.js"></script>
  <script src="lib/counterup/jquery.counterup.js"></script>
  <script src="lib/owlcarousel/owl.carousel.min.js"></script>
  <script src="lib/lightbox/js/lightbox.min.js"></script>
  <script src="lib/typed/typed.min.js"></script>
  <!-- Contact Form JavaScript File -->
  <script src="contactform/contactform.js"></script>

  <!-- Template Main Javascript File -->
  <script src="js/main.js"></script>

</body>
</html>
