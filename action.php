<?php
  $con = mysqli_connect('localhost', 'root', '', 'nu_events');
  // Check connection
  if (!$con) {
      die("Connection failed: " . mysqli_connect_error());
  }
  session_start();

  /* Set the desired isolation level for transactions */
  mysqli_autocommit($con, false);
  mysqli_query($con, "SET TRANSACTION ISOLATION LEVEL REPEATABLE READ");

  /* -------- Admin Login ------ */
  if (isset($_POST['admin'])) {
    $name = $_POST['name'];
    $psw = $_POST['psw'];
    $sql = "SELECT *  FROM admin WHERE name='$name' AND psw='$psw'";
    $run = mysqli_query($con, $sql);

    if (mysqli_num_rows($run) == 1) {
      $_SESSION['name'] = $name;
      mysqli_commit($con); // Commit changes if admin login succeeds
      header('location:../dasboard.php');
      exit();
    } 
    else {
      mysqli_rollback($con); // Rollback if admin login fails
    }
  }

  /* -------- User Registration ------ */
  if (isset($_POST['signup'])) {
      $name = $_POST['name'];
      $uname = $_POST['uname'];
      $email = $_POST['email'];
      $pno = $_POST['pno'];
      $add = $_POST['add'];
      $psw = $_POST['psw'];
      $repsw = $_POST['repsw'];
      if ($psw == $repsw) {
          $sql = "SELECT * FROM u_info WHERE uname='$uname'";
          $run = mysqli_query($con, $sql);
          if (mysqli_num_rows($run) > 0) {
              echo "<h2>USERNAME ALREADY EXIST PLEASE ENTER VALID USERNAME</h2>";
          } else {
              $sql = "INSERT INTO `u_info` (`uid`, `name`, `uname`, `email`, `pno`, `adds`, `psw`)
          VALUES (NULL, '$name', '$uname', '$email', '$pno', '$add', '$psw')";
              $run = mysqli_query($con, $sql);
              if ($run) {
                $_SESSION['uid'] = mysqli_insert_id($con);
                $_SESSION['uname'] = $uname;
                $_SESSION['urname'] = $name;
                mysqli_commit($con);
                header('location:login.php');
                exit();
              }
              else{
                mysqli_rollback($con);
              }
          }
      } else {
          echo "<h2>Password not matched</h2>";
      }
  }

  /* -------------- User Login ------ */
  if (isset($_POST['login'])) {
      $name = $_POST['name'];
      $psw = $_POST['psw'];
      $sql = "SELECT *  FROM u_info WHERE uname='$name'AND psw='$psw'";
      $run = mysqli_query($con, $sql);
      $row = mysqli_fetch_array($run);
      if (mysqli_num_rows($run) == 1) {
        $_SESSION['uname'] = $name;
        $_SESSION['uid'] = $row['uid'];
        $_SESSION['urname'] = $row['name'];
        mysqli_commit($con);
        header('location:../profile.php');
        exit();
      }
      else{
        mysqli_rollback($con);
      }
  }

  /* ----------------- Event Registration --------- */
  if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pno = $_POST['pno'];
    $eventTypeID = $_POST['eventTypeID'];
    $eventNameID = $_POST['eventNameID'];

    // Assuming user ID is stored in the session
    $userId = $_SESSION['uid'];

    // Check if the user has already registered for the selected event
    $checkQuery = "SELECT * FROM registration WHERE u_id = '$userId' AND type_id = '$eventTypeID' AND event_id = '$eventNameID'";
    $checkResult = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
      // User has already registered for this event
      echo "<script>alert('You have already registered for this event.');</script>";
    }
    else {
      // Insert the event registration data into the registrations table
      $insertQuery = "INSERT INTO registration (u_id, name, email, phoneNum, type_id, event_id)
                    VALUES ('$userId', '$name', '$email', '$pno', '$eventTypeID', '$eventNameID')";
      $run = mysqli_query($con, $insertQuery);

      if ($run) {
        // Update the participants count in the events table
        $updateParticipantsQuery = "UPDATE events SET participants = participants + 1 WHERE event_id = '$eventNameID'";
        $updateResult = mysqli_query($con, $updateParticipantsQuery);

        if ($updateResult) {
            mysqli_commit($con);
            header('location:../profile.php');
            exit();
        } else {
          // Handle the update error
          echo "Error updating participants count: " . mysqli_error($con);
          mysqli_rollback($con);
        }
      } else {
        // Handle query execution errors
        echo "Error: " . mysqli_error($con);
        mysqli_rollback($con);
      }
    }
  }

  /* ----------------- Event Creation/Addition --------- */
  if (isset($_POST['addEvent'])) {
    $name = $_POST['Eventname'];
    $description = $_POST['event-description'];
    $eventDate = $_POST['event-date'];
    $startTime = $_POST['event-start-time'];
    $endTime = $_POST['event-end-time'];
    $location = $_POST['event-location'];
    $eventType = $_POST['event-type'];
    $organizerName = $_POST['event-organizer-name'];
    $organizerEmail = $_POST['event-organizer-email'];
    $registrationDeadline = $_POST['event-registration-deadline'];
    $ticketPrice = $_POST['event-ticket-price'];

    // Assuming user ID is stored in the session
    $userId = $_SESSION['uid'];
    
    $insertQuery = "INSERT INTO events (event_title, event_price, participants, type_id, event_description, event_date, start_time, end_time, event_location, organizer_name, organizer_email, registration_deadline)
                    VALUES ('$name', '$ticketPrice', '0', '$eventType', '$description', '$eventDate', '$startTime', '$endTime', '$location', '$organizerName', '$organizerEmail', '$registrationDeadline')";
    $run = mysqli_query($con, $insertQuery);

    if ($run) {
      mysqli_commit($con);
      header('location:../dasboard.php');
      exit();
    } else {
      // Handle query execution errors
      echo "Error: " . mysqli_error($con);
      mysqli_rollback($con);
    }
  }

  /* Commit or rollback the transaction based on queries' success or failure */
  if (!mysqli_commit($con)) {
    // Rollback if commit fails
    mysqli_rollback($con);
    echo "Transaction failed!";
  }
  else {
    // Commit the transaction if everything executed successfully
    // Optionally, you can also set autocommit back to true here
    mysqli_autocommit($con, true);
  }
?>
