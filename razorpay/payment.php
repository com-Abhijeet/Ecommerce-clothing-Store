<?php   
    // session_start();
    include('/xampp/htdocs/Ecommerce-Clothing-Website/functions.php');
    // $customer_name = $_SESSION['name'];
?>
<head>
<title>Payment-Page</title>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<link rel="stylesheet" href="/Ecommerce-Clothing-Website/css/bootstrap.min.css">
<link rel="stylesheet" href="/Ecommerce-Clothing-Website/css/elegant-icons.css">
<link rel="stylesheet" href="/Ecommerce-Clothing-Website/css/font-awesome.min.css.css">
<link rel="stylesheet" href="/Ecommerce-Clothing-Website/css/jquery-ui.min.css">
<link rel="stylesheet" href="/Ecommerce-Clothing-Website/css/owl.carousel.min.css">
<link rel="stylesheet" href="/Ecommerce-Clothing-Website/css/payment.css">
<link rel="stylesheet" href="/Ecommerce-Clothing-Website/css/slicknav.min.css">
<!-- <link rel="stylesheet" href="/Ecommerce-Clothing-Website/css/style.css"> -->
<link rel="stylesheet" href="/Ecommerce-Clothing-Website/css/themify-icons.css">


</head>

<?php
    include('/xampp/htdocs/Ecommerce-Clothing-Website/header.php');?>

<div class="payimg">
    <img src="https://t3.ftcdn.net/jpg/04/86/77/04/360_F_486770467_9nd0TjY0owEdwkoUCvi85VfIJQTvQFKi.jpg" alt="payment image" srcset="">
</div>

<body onload="pay_now()">
    


<form>
    <p><h1>You will be redirected to RazorPay to Complete the Payment Process ,</h1><br><h2>Press the button bellow to Continue to the Payment Page</h2></p>
    
    <input type="textbox" name="name" id="name" placeholder="Enter name" value= <?php customer_name() ?> hidden disabled > 
    <input type="button" class="site-btn place-btn" name="btn" id="btn" value="Pay Now" onclick="pay_now()"/>
    <input type="textbox" name="amt" id="amt" placeholder="Enter amt" value= <?php pay_price() ?> hidden disabled><br/><br/>
</form>

<script>
    function pay_now(){
        var name=jQuery('#name').val();
        var amt=jQuery('#amt').val();
        
         jQuery.ajax({
               type:'post',
               url:'payment_process.php',
               data:"amt="+amt+"&name="+name,
               success:function(result){
                   var options = {
                        "key": "rzp_test_PRJHfSKb87GMAG", 
                        "amount": amt*100, 
                        "currency": "INR",
                        "name": "Fashion Frenzy",
                        "description": "Test Transaction",
                        "image": "https://image.freepik.com/free-vector/logo-sample-text_355-558.jpg",
                        "handler": function (response){
                           jQuery.ajax({
                               type:'post',
                               url:'payment_process.php',
                               data:"payment_id="+response.razorpay_payment_id,
                               success:function(result){
                                   window.location.href="thank_you.php";
                               }
                           });
                        }
                    };
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
               }
           });
        
        
    }
</script>

<!-- Footer Section Begin -->
<footer class="footer-section">
    <div class="container">
        <div class="row" style="padding-bottom: 40px;">
            <div class="col-lg-3">
                <div class="footer-left">
                    <div class="footer-logo">
                        <a href="index.php"> <span>Fashion FrenzyCo.</span>
                        </a>
                    </div>
                    <ul>
                        <li>+91 9344029078</li>
                        <li>contact@fashionFrenzy.com</li>
                        <li>Bennett University</li>
                    </ul>

</footer>
</body>
