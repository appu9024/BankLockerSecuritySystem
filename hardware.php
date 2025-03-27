<?php


include "connection.php";

if (isset($_GET['finger_id'])) {
    $finger_id = mysqli_real_escape_string($link, $_GET['finger_id']);

    // Query to check access
    $query = "SELECT access FROM user WHERE finger_id = '$finger_id' LIMIT 1";
    $result = mysqli_query($link, $query);

    if ($result && mysqli_num_rows($result) > 0) 
    {
        $row = mysqli_fetch_assoc($result);
        $access = $row['access'];

        if ($access == '1') 
        {
            echo "%0#"; // Access granted
        } else {
            echo "%1#"; // Access denied
        }
    } else {
        echo "%1#"; // Finger ID not found, treat as access denied
    }
} else {
    echo "%1#"; // No finger_id provided, treat as access denied
}

mysqli_close($link);

?>