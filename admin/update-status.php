<?php
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connect to database
    $conn = mysqli_connect("localhost", "root", "", "threaderz_store");

    // Check if the order ID and new status are set
    if (isset($_POST['order_id'], $_POST['new_status'])) {
        $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
        $new_status = mysqli_real_escape_string($conn, $_POST['new_status']);
        echo $order_id;

        // Update the status in the orders table
        $sql_update = "UPDATE orders SET status = '$new_status' WHERE order_id = $order_id";
        if (mysqli_query($conn, $sql_update)) {
            // Redirect back to the orders page
            header("Location: view-orders.php");
            exit;
        } else {
            echo "Error updating order status: " . mysqli_error($conn);
        }
    } else {
        echo "Invalid request.";
    }

    // Close database connection
    mysqli_close($conn);
}
?>
