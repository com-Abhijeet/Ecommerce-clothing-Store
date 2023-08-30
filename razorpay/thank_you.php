<?php 
error_reporting(E_ERROR | E_PARSE);
session_start();
include('db.php');

    $db=mysqli_connect('localhost','root','','threaderz_store');
    $c_id = $_SESSION['customer_email'];

    $query = "select * from customer where customer_email= '$c_id'";

    $run_query = mysqli_query($con, $query);


    $get_query = mysqli_fetch_array($run_query);

    $custom_id = $get_query['customer_id'];

    
    $get_items = "select * from cart where c_id = '$c_id'";
    $run_items = mysqli_query($db, $get_items);

    while ($row_items = mysqli_fetch_array($run_items)) {
        $p_id = $row_items['products_id'];
        $pro_qty = $row_items['qty'];
        $pro_name = $row_items['product_title'];

        $get_item = "select * from products where products_id = '$p_id'";
        $run_item = mysqli_query($db, $get_item);


        while ($row_item = mysqli_fetch_array($run_item)) {

            $pro_price = $row_item['product_price'];

            $total_q += $pro_qty;
            $pro_total_p = $pro_price * $pro_qty;
        }

        $final_price += $pro_total_p;
    }
    $order = "insert into orders (order_qty, order_price,p_id, c_id, date) values ('$total_q','$final_price','$p_idx','$custom_id',NOW())";

    $run_order = mysqli_query($con, $order);
    $cart_clear = "delete from cart where c_id = '$c_id'";
    $run_clear = mysqli_query($con, $cart_clear);

    

    // $pro_name = "select product_title from products where products_id = '$p_id'";
    // $get_pro_name = mysqli_query($db, $pro_name);
    // $row_pro_name = mysqli_fetch_array($get_pro_name);
    // $pro_title = $row_pro_name['product_title'];
    echo $pro_name;

    
// MAIL SENDER
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '/xampp/htdocs/w10/phpmailer/PHPMailer-master/src/Exception.php'; 
    require '/xampp/htdocs/w10/phpmailer/PHPMailer-master/src/PHPMailer.php'; 
    require '/xampp/htdocs/w10/phpmailer/PHPMailer-master/src/SMTP.php';


   $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'carefashionFrenzy@gmail.com';
    $mail->Password = 'ovcwytcjywjqhtci';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('carefashionFrenzy@gmail.com');
    $mail->addAddress($c_id);
    
    $mail->isHTML(true);
    $mail->Subject = 'Hello';
    $mail->Body = 'Order Confirmed for RS '. $pro_price ." for the product " . $pro_title ;

    if($mail->send()){
        echo "Email sent";
    }else{
        echo "Error occured";
    }
    echo "MY LORD ITS WORKING";

    echo "<script>alert('Order Placed. Thankyou for Shopping')</script>";
    // echo "<script>window.open('account.php?orders','_self')</script>";
    echo "<script>window.open('/Ecommerce-Clothing-Website/account.php?orders','_self')</script>";

    



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status</title>
</head>
<body>
    <h1>Payment Complete</h1>
    <h2>Thank you for shopping with us. Your payment was successful.</h2>
    <button > <a href="/Ecommerce-Clothing-Website/index.php">Continue Shopping</a> </button>
</body>
</html>