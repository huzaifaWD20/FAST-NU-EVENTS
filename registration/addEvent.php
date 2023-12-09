<?php
   include('../action.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Event</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/forms.css">
</head>
<body>
    <div class="main">
        <section class="signup add-event">
            <div class="container">
                <div class="signup-content">
                    <form method="POST" id="signup-form" class="signup-form add-event-form">
                        <h2 class="form-title">Create Event</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-input" name="Eventname" id="Eventname" placeholder="Event Title" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea class="form-input" name="event-description" id="description" placeholder="Event Description" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="event-date">Date</label>
                                    <input type="date" class="form-input" name="event-date" id="event-date" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="start-time">Start Time</label>
                                    <input type="time" class="form-input" name="event-start-time" id="start-time" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="end-time">End Time</label>
                                    <input type="time" class="form-input" name="event-end-time" id="end-time" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-input" name="event-location" id="location" placeholder="Location/Venue: Address" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php
                                // Fetch event types from the database
                                $query = "SELECT type_id, type_title FROM event_type";
                                $result = mysqli_query($con, $query);
                            ?>
                            <!-- HTML form -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-input" name="event-type" id="event-type" required>
                                        <option value="" disabled selected>Select Event Type</option>
                                        <?php
                                            // Loop through the fetched event types to populate options
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<option value="' . $row['type_id'] . '">' . $row['type_title'] . '</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-input" name="event-organizer-name" id="organizer-name" placeholder="Organizer's Name" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="email" class="form-input" name="event-organizer-email" id="organizer-email" placeholder="Organizer's Email" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="registration-deadline">Registration Deadline</label>
                                    <input type="date" class="form-input" name="event-registration-deadline" id="registration-deadline" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-input" name="event-ticket-price" id="ticket-price" placeholder="Ticket Price" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="submit" name="addEvent" id="submit" class="form-submit" value="Create Event"/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>