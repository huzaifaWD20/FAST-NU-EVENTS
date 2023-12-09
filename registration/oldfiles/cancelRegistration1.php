<?php

include('../action.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel-registration'])) {
    $registration_id = $_POST['cancel-registration'];

    // Fetch registration details to be backed up
    $fetch_registration_query = "SELECT * FROM registration WHERE reg_id = '$registration_id'";
    $fetch_registration_result = mysqli_query($con, $fetch_registration_query);
    
    if ($fetch_registration_result && mysqli_num_rows($fetch_registration_result) > 0) {
        $registration_data = mysqli_fetch_assoc($fetch_registration_result);
        
        // Backup the registration into backup_registrations table
        $backup_query = "INSERT INTO registrations_backup (reg_id, event_id, u_id, name, email, phoneNum, type_id) VALUES (
            '{$registration_data['reg_id']}',
            '{$registration_data['event_id']}',
            '{$registration_data['u_id']}',
            '{$registration_data['name']}',
            '{$registration_data['email']}',
            '{$registration_data['phoneNum']}',
            '{$registration_data['type_id']}'
        )";
        $backup_result = mysqli_query($con, $backup_query);

        if ($backup_result) {
            // Delete registration from registration table
            $delete_query = "DELETE FROM registration WHERE reg_id = '$registration_id'";
            $delete_result = mysqli_query($con, $delete_query);

            if ($delete_result) {
                // Decrement the number of participants in the events table
                $event_id = $registration_data['event_id'];
                $decrement_query = "UPDATE events SET participants = participants - 1 WHERE event_id = '$event_id'";
                $decrement_result = mysqli_query($con, $decrement_query);

                if ($decrement_result) {
                    // Redirect back to the page with the registered events list
                    header("Location: ../profile.php");
                    exit();
                } else {
                    // Error decrementing participants
                    echo "Error decrementing participants: " . mysqli_error($con);
                }
            } else {
                // Error deleting registration
                echo "Error deleting registration: " . mysqli_error($con);
            }
        } else {
            // Error backing up registration
            echo "Error backing up registration: " . mysqli_error($con);
        }
    } else {
        // No registration found
        echo "No registration found with the given ID.";
    }
} else {
    // Invalid request
    echo "Invalid request!";
}
?>
