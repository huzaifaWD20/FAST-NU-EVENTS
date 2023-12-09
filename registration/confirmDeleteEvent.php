<?php
include('../action.php');

if (isset($_GET['confirm_delete']) && $_GET['confirm_delete'] == 'true' && isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];
    // Start transaction
    mysqli_begin_transaction($con);

     // Delete event
     $delete_event_query = "DELETE FROM events WHERE event_id = $event_id";
     $delete_event_result = mysqli_query($con, $delete_event_query);

    if ($delete_event_result) {
        // Commit transaction if event deletion succeeds
        mysqli_commit($con);
        header("Location: ../dasboard.php");
        exit();
    } 
    else {
        // Rollback transaction if deleting event fails
        mysqli_rollback($con);
        echo "Error deleting event: " . mysqli_error($con);
    }
}