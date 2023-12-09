<?php
   include('../action.php');
   if (!isset($_SESSION['uid'])) {
       header('location:../index.php');
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Event Registration</title>

    <!-- Favicons -->
    <link href="../../img/NUlogo.png" rel="icon">
    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/forms.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
    <?php
        // Establish your database connection here
        $connection = mysqli_connect("localhost", "root", "", "nu_events");
        // Check connection
        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Check if event_id is present in the URL
        if (isset($_GET['event_id'])) {
            // User clicked "Register" from the events section, prefill event details
            $eventId = $_GET['event_id'];
            // Fetch user details based on the user's session (Assuming user details are in a 'users' table)
            $userId = $_SESSION['uid'];

            $userDetailsQuery = "SELECT name, email, pno FROM u_info WHERE uid = $userId";
            $userDetailsResult = mysqli_query($connection, $userDetailsQuery);

            // Fetch event details based on event_id and pre-fill the form
            $eventDetailsQuery = "SELECT e.event_title, et.type_title, et.type_id
                                    FROM events e
                                    INNER JOIN event_type et ON e.type_id = et.type_id
                                    WHERE e.event_id = $eventId";
            $eventDetailsResult = mysqli_query($connection, $eventDetailsQuery);

            if (($eventDetailsResult && mysqli_num_rows($eventDetailsResult) > 0) && ($userDetailsResult && mysqli_num_rows($userDetailsResult) > 0)) {
                $userRow = mysqli_fetch_assoc($userDetailsResult);
                $eventRow = mysqli_fetch_assoc($eventDetailsResult);
                $eventName = $eventRow['event_title'];
                $eventType = $eventRow['type_title'];
                $eventTypeId = $eventRow['type_id'];
                $userName = $userRow['name'];
                $userEmail = $userRow['email'];
                $userPhone = $userRow['pno'];


                // Display registration form with pre-filled event details
                ?>
                <div class="main">
                    <section class="signup">
                        <div class="container">
                            <div class="signup-content">
                                <form method="POST" id="signup-form" class="signup-form">
                                    <h2 class="form-title">Registration</h2>
                                    <div class="form-group">
                                        <input type="text" class="form-input" name="name" id="name" placeholder="Your Name" required value="<?php echo $userName; ?>" />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-input" name="pno" id="pno" placeholder="Phone Number" required value="<?php echo $userPhone; ?>" />
                                    </div>
                                    <div class="form-group">
                                        <input type="email" class="form-input" name="email" id="email" placeholder="Email" required value="<?php echo $userEmail; ?>" />
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-input" name="eventType" id="eventType" value="<?php echo $eventType; ?>" data-type-id="<?php echo $eventTypeId; ?>" readonly/>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-input" name="eventName" id="eventName" value="<?php echo $eventName; ?>" data-event-id="<?php echo $eventId; ?>" readonly/>
                                    </div>
                                    <input type="hidden" name="eventTypeID" id="hiddenEventType" value="<?php echo $eventTypeId; ?>">
                                    <input type="hidden" name="eventNameID" id="hiddenEventName" value="<?php echo $eventId; ?>">
                                    <div class="form-group">
                                        <input type="submit" name="submit" id="submit" class="form-submit" value="Register" style="cursor: pointer;"/>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
                <?php
            }
        }
        // Close the database connection
        mysqli_close($connection);
    ?>
    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    
    <script src="js/main.js"></script>
</body>
</html>