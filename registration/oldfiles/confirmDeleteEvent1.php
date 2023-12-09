<?php
include('../action.php');

if (isset($_GET['confirm_delete']) && $_GET['confirm_delete'] == 'true' && isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Event date has passed, proceed with backup and deletion
    $backup_query = "INSERT INTO registrations_backup SELECT * FROM registration WHERE event_id = $event_id";
    $backup_result = mysqli_query($con, $backup_query);

    if ($backup_result) {
        $delete_registrations_query = "DELETE FROM registration WHERE event_id = $event_id";
        $delete_registrations_result = mysqli_query($con, $delete_registrations_query);

        if ($delete_registrations_result) {
            $delete_event_query = "DELETE FROM events WHERE event_id = $event_id";
            $delete_event_result = mysqli_query($con, $delete_event_query);

            if ($delete_event_result) {
                // Event deleted successfully
                // Redirect back to dashboard or perform any other action
                header("Location: ../dasboard.php");
                exit();
            } else {
                // Error occurred while deleting event
                echo "Error deleting event: " . mysqli_error($con);
            }
        } else {
            // Error occurred while deleting registrations
            echo "Error deleting registrations: " . mysqli_error($con);
        }
    } else {
        // Error occurred while backing up registrations
        echo "Error backing up registrations: " . mysqli_error($con);
    }
} else {
    // Invalid request or missing parameters
    echo "Invalid request or missing parameters.";
    // Redirect back to dashboard or perform any other action
    header("Location: ../dasboard.php");
    exit();
}
?>
