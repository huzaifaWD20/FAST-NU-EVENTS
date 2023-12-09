<?php
  include('action.php');
  if(!isset($_SESSION['name'])){
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
            <a class="nav-link js-scroll" href="#checkRegistrations">Check Registrations</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll" href="registration/addEvent.php">Add Event</a>
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

  <!--/ Section Check Registrations Star /-->
  <section id=checkRegistrations>
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="title-box text-center">
            <h3 class="title-a">
              REGISTRATIONS
            </h3>
            <p class="subtitle-a"></p>
          <div class="line-mf"></div>
        </div>
      </div>
      <!-- PHP code to fetch and display event details -->
      <?php
        $query = "SELECT e.event_id, e.event_title, e.event_price, e.participants, e.type_id, et.type_title, e.event_date, e.start_time, e.end_time, e.event_location, e.organizer_name, e.organizer_email, e.registration_deadline
                  FROM events e
                  INNER JOIN event_type et ON e.type_id = et.type_id";

        $result = mysqli_query($con, $query);

        if ($result) {
          while ($row = mysqli_fetch_assoc($result)) {
      ?>
          <div class="col-lg-4 col-md-6">
            <div class="card mb-4">
              <div class="card-body">
                <div class="row">
                  <div class="col-8">
                    <h5 class="card-title"><?php echo $row['event_title']; ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?php echo $row['type_title']; ?></h6>
                    <p class="card-text">Price: <?php echo $row['event_price']; ?></p>
                    <p class="card-text">Date: <?php echo $row['event_date']; ?></p>
                    <p class="card-text">Time: <?php echo $row['start_time'] . ' - ' . $row['end_time']; ?></p>
                    <p class="card-text">Location: <?php echo $row['event_location']; ?></p>
                    <p class="card-text">Organizer: <?php echo $row['organizer_name']; ?></p>
                    <p class="card-text">Organizer Email: <?php echo $row['organizer_email']; ?></p>
                    <p class="card-text">Registration Deadline: <?php echo $row['registration_deadline']; ?></p>
                  </div>
                  <div class="col-4">
                    <div class="counter-box text-right">
                      <div class="counter-ico">
                        <span class="ico-circle" style="background-color: #0078ff;"><i class="ion-ribbon-a"></i></span>
                      </div>
                      <div class="counter-num">
                        <p class="counter" style="color: #0078ff;"><?php echo $row['participants']; ?></p>
                        <span class="counter-text" style="color: #0078ff;">Participants</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer text-right">
                <form method="POST" action="registration/deleteEvent.php">
                  <input type="hidden" name="event_id" value="<?php echo $row['event_id']; ?>">
                  <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this event?')">Delete</button>
                </form>
              </div>
            </div>
          </div>
      <?php
          }
        } else {
            echo "Error fetching events: " . mysqli_error($con);
        }
      ?>
      <!-- End of PHP code for fetching and displaying events -->
    </div>
  </section>
  <!--/ Section Check Registrations End /-->

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
