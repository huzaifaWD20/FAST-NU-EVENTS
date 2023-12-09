<?php
include('../action.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];

    // Start transaction
    mysqli_begin_transaction($con);

    // Fetch event details including the event date
    $event_query = "SELECT event_date FROM events WHERE event_id = $event_id FOR UPDATE";
    $event_result = mysqli_query($con, $event_query);

    if ($event_result && mysqli_num_rows($event_result) > 0) {
        $event_data = mysqli_fetch_assoc($event_result);
        $event_date = strtotime($event_data['event_date']);
        $current_date = strtotime(date('Y-m-d'));

        // Check if the event date has passed
        if ($current_date > $event_date) {
            // Backup registrations
            $backup_query = "INSERT INTO registrations_backup SELECT * FROM registration WHERE event_id = $event_id";
            $backup_result = mysqli_query($con, $backup_query);

            if ($backup_result) {
                // Delete registrations
                $delete_registrations_query = "DELETE FROM registration WHERE event_id = $event_id";
                $delete_registrations_result = mysqli_query($con, $delete_registrations_query);

                if ($delete_registrations_result) {
                    // Delete event
                    $delete_event_query = "DELETE FROM events WHERE event_id = $event_id";
                    $delete_event_result = mysqli_query($con, $delete_event_query);

                    if ($delete_event_result) {
                        // Commit transaction if everything succeeds
                        mysqli_commit($con);
                        header("Location: ../dasboard.php");
                        exit();
                    } else {
                        // Rollback transaction if deleting event fails
                        mysqli_rollback($con);
                        echo "Error deleting event: " . mysqli_error($con);
                    }
                } else {
                    // Rollback transaction if deleting registrations fails
                    mysqli_rollback($con);
                    echo "Error deleting registrations: " . mysqli_error($con);
                }
            } else {
                // Rollback transaction if backup fails
                mysqli_rollback($con);
                echo "Error backing up registrations: " . mysqli_error($con);
            }
        } 
        else 
        {
            // Event date has not passed
            // Ask for confirmation before proceeding with the deletion
            echo '<script>
                    if(confirm("The event date has not passed yet. Do you still want to proceed with deleting the event?")) {
                        // User clicked OK in the confirmation dialog
                        // Proceed with deleting the event
                        window.location.replace("confirmDeleteEvent.php?confirm_delete=true&event_id='.$event_id.'");
                    } else {
                        // User clicked Cancel in the confirmation dialog
                        // Redirect back to dashboard
                        window.location.replace("../dasboard.php");
                    }
                </script>';
        }
    } 
    else {
        // No event found or error in fetching event data
        header("Location: ../dashboard.php");
        exit();
    }
}
?>

DELIMITER // this thing is done programmatically in above by running an insert into query for registrations_backup(line 22)

CREATE TRIGGER delete_event_trigger
AFTER DELETE ON events
FOR EACH ROW
BEGIN
    DECLARE event_id INT;

    -- Get the deleted event ID
    SET event_id = OLD.event_id;

    -- Backup registrations related to the deleted event
    INSERT INTO registrations_backup (event_id, u_id, name, email, phoneNum, type_id)
    SELECT event_id, u_id, name, email, phoneNum, type_id
    FROM registration
    WHERE event_id = event_id;

    -- Delete registrations related to the deleted event
    DELETE FROM registration WHERE event_id = event_id;
END;
//

DELIMITER ;
