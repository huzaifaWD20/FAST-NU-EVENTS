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

  <!--/ Nav Start /-->
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
            <a class="nav-link js-scroll" href="#contact">Contact</a>
          </li>
           <li class="nav-item">
            <a class="nav-link js-scroll" href="registration/admin.php">Admin</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll" href="registration/login.php">Log In</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!--/ Nav End /-->

  <!--/ Intro Skew Start /-->
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
                                      <p class='bottom-area d-flex'>
                                          <span class='ml-auto'><a href="registration/login.php" class='btn btn-primary'>Register</a></span>
                                      </p>
                                  </div>
                              </div>
                          </div>
                          <?php
                      }
                  } else {
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

  <!-- <div class="section-counter paralax-mf bg-image" style="background-image: url(img/universityBackgroundimg.jpg)">
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
  
  <!--/ Section Contact-Footer Star /-->
  <section class="paralax-mf footer-paralax bg-image sect-mt4 route" style="background-image: url(img/universityBackgroundimg.jpg)">
    <div class="overlay-mf"></div>
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="contact-mf">
            <div id="contact" class="box-shadow-full">
              <div class="row">
                <div class="col-md-6">
                  <div class="title-box-2 pt-4 pt-md-0">
                    <h5 class="title-left">
                      Get in Touch
                    </h5>
                  </div>
                  <div class="more-info">
                    <p class="lead">
                      FAST MAIN CAMPUS - KHI
                     </p>
                    <ul class="list-ico">
                      <li><span class="ion-ios-location"></span>Bhains Colony</li>
                      <li><span class="ion-ios-telephone"></span>+92123456789</li>
                      <li><span class="ion-email"></span>nuces.khi@nu.edu.pk</li>
                    </ul>
                  </div>
                  <div class="socials">
                    <ul>
                      <li><a href=""><span class="ico-circle"><i class="ion-social-facebook"></i></span></a></li>
                      <li><a href=""><span class="ico-circle"><i class="ion-social-instagram"></i></span></a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="copyright-box">
              <p class="copyright">&copy; Copyright <strong>FAST NU EVENTS</strong>. All Rights Reserved</p>
              <div class="credits">
                Designed by <a href="#">ME</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </section>
  <!--/ Section Contact-footer End /-->

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
