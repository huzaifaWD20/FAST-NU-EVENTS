<?php
    include('../action.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel-registration'])) {
        $registration_id = $_POST['cancel-registration'];

        // Fetch the event_id associated with the registration
        $fetch_event_query = "SELECT event_id FROM registration WHERE reg_id = '$registration_id'";
        $fetch_event_result = mysqli_query($con, $fetch_event_query);

        if ($fetch_event_result && mysqli_num_rows($fetch_event_result) > 0) {
            $row = mysqli_fetch_assoc($fetch_event_result);
            $event_id = $row['event_id'];

            // Start a transaction
            mysqli_begin_transaction($con);

            // Delete registration from registration table
            $delete_query = "DELETE FROM registration WHERE reg_id = '$registration_id'";
            $delete_result = mysqli_query($con, $delete_query);

            if ($delete_result) {
                // Decrement the count of participants in the events table
                $decrement_query = "UPDATE events SET participants = participants - 1 WHERE event_id = '$event_id'";
                $decrement_result = mysqli_query($con, $decrement_query);

                if ($decrement_result) {
                    // Commit the transaction if both operations succeed
                    mysqli_commit($con);
                    header("Location: ../profile.php");
                    exit();
                } else {
                    // Rollback the transaction if decrementing the count fails
                    mysqli_rollback($con);
                    echo "Error decrementing participant count: " . mysqli_error($con);
                }
            } else {
                // Error deleting registration
                echo "Error deleting registration: " . mysqli_error($con);
            }
        } else {
            // No registration found or error fetching event_id
            echo "No registration found with the given ID.";
        }
    } else {
        // Invalid request
        echo "Invalid request!";
    }
?>
