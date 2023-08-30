<?php

// Set the default page number
$page = 1;

// Check if the page number is specified in the URL
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
   $page = (int)$_GET['page'];
}

// Connect to database
$conn = mysqli_connect("localhost", "root", "", "threaderz_store");


// Check if a status update form was submitted
if (isset($_POST['update_status'])) {
   $order_id = $_POST['order_id'];
   $new_status = $_POST['new_status'];
   
   // Update the status in the orders table
   $sql_update = "UPDATE orders SET status = '$new_status' WHERE order_id = $order_id";
   mysqli_query($conn, $sql_update);
}

// Calculate the offset
$offset = ($page - 1) * 30;

// Query to retrieve orders from database
$sql = "SELECT orders.*, products.product_title, products.product_img1 FROM orders
        INNER JOIN products ON orders.p_id = products.products_id 
        ORDER BY date DESC LIMIT 30 OFFSET $offset";

$result = mysqli_query($conn, $sql);

// Display the orders in a table
echo "<form method=\"post\" name='update_status'>";
echo "<table>";
echo "<thead>";
echo "<tr><th>Order ID</th><th>Customer Name</th><th>Product Name</th><th>Product Image</th><th>Order Date</th><th>Status</th><th>Update Status</th></tr>";
echo "</thead>";
echo "<tbody>";

while ($row = mysqli_fetch_assoc($result)) {
   echo "<tr>";
   echo "<td>" . $row['order_id'] . "</td>";
   $o_id = $row['order_id'];
   
   // Query to retrieve customer name from customer table
   $customer_id = $row['c_id'];
   $sql2 = "SELECT customer_name FROM customer WHERE customer_id = $customer_id";
   $result2 = mysqli_query($conn, $sql2);
   
   // Check if query returned any rows
   if (mysqli_num_rows($result2) > 0) {
      // Fetch the first row of the result set
      $row2 = mysqli_fetch_assoc($result2);
      echo "<td>" . $row2['customer_name'] . "</td>";
   } else {
      echo "<td></td>";
   }
   
   echo "<td>" . $row['product_title'] . "</td>";
   echo "<td><img src=\"" . $row['product_img1'] . "\" width=\"50\" height=\"50\"></td>";
   echo "<td>" . $row['date'] . "</td>";
   echo "<td>" . $row['status'] . "</td>";
   
   // Add status update buttons
   echo "<td>";
   echo "<input type=\"text\" name=\"order_id\" value=\"" . $row['order_id'] . "\" >";
   echo "<select name=\"new_status\">";
   echo "<option value=\"confirmed\">Confirmed</option>";
   echo "<option value=\"out for delivery\">Out for Delivery</option>";
   echo "<option value=\"completed\">Completed</option>";
   echo "</select>";
   echo "<button type=\"submit\" name=\"update_status\">Update</button>";
   echo "</td>";
   
   echo "</tr>";
}

echo "</tbody>";
echo "</table>";
echo "</form>";


// Display pagination links
$sql3 = "SELECT COUNT(*) AS total FROM orders";
$result3 = mysqli_query($conn, $sql3);
$row3 = mysqli_fetch_assoc($result3);
$total_orders = $row3['total'];
$total_pages = ceil($total_orders / 30);

echo "<div>";
echo "<p>Showing " . ($offset + 1) . " to " . ($offset + mysqli_num_rows($result)) . " of " . $total_orders . " orders</p>";

if ($total_pages > 1) {
    echo "<ul>";
    for ($i = 1; $i <= $total_pages; $i++) {
    echo "<li>";
    if ($i == $page) {
    echo "<span>$i</span>";
    } else {
    echo "<a href='admin_orders.php?page=$i'>$i</a>";
    }
    echo "</li>";
    }
    echo "</ul>";
    }
    
    echo "</div>";
    
    // Close the database connection
    mysqli_close($conn);
    
    ?>
    
    </body>
    </html>
