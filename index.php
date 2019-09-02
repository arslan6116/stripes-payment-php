<!DOCTYPE html>
<?php
// Include configuration file
require_once 'config.php';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <!-- Stripe JavaScript library -->
    <script src="https://js.stripe.com/v2/"></script>

    <!-- jQuery is used only for this example; it isn't required to use Stripe -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    
    <title>Stripe payment method integration</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="card">
            <h1 class="card-header info-color white-text text-center py-4">
                <strong>Charge <?php echo '$'.$itemPrice; ?> with Stripe</strong>
            </h1>
            <div class="py-3 pl-4">
                <!-- Product Info -->
                <p><b>Item Name:</b> <?php echo $itemName; ?></p>
                <p><b>Price:</b> <?php echo '$'.$itemPrice.' '.$currency; ?></p>
            </div>    
            <div class="card-body px-lg-5 pt-0">
                <!-- Display errors returned by createToken -->
                <div class="payment-status"></div>
                
                <!-- Payment form -->
                <form action="payment.php" method="POST" id="paymentFrm" style="color: #757575;">
                    <div class="md-form">
                        <label>NAME</label>
                        <input type="text"   class="form-control" name="name" id="name" placeholder="Enter name" required="" autofocus="">
                    </div>
                    <div class="md-form">
                        <label>EMAIL</label>
                        <input type="email"  class="form-control"  name="email" id="email" placeholder="Enter email" required="">
                    </div>
                    <div class="md-form">
                        <label>CARD NUMBER</label>
                        <input type="text"   class="form-control" name="card_number" id="card_number" placeholder="1234 1234 1234 1234" autocomplete="off" required="">
                    </div>
                    <br>
                    <div class="md-form">
                        <div class="left">
                            <div class="md-form">
                                <label>EXPIRY DATE</label>
                                <div class="col-md-12">
                                    <input type="text"   class="form-control" name="card_exp_month" id="card_exp_month" placeholder="MM" required="">
                                </div>
                                <div class="col-md-12">
                                    <input type="text"   class="form-control" name="card_exp_year" id="card_exp_year" placeholder="YYYY" required="">
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="right">
                            <div class="md-form">
                                <label>CVC CODE</label>
                                <input type="text"   class="form-control" name="card_cvc" id="card_cvc" placeholder="CVC" autocomplete="off" required="">
                            </div>
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success float-right" id="payBtn">Submit Payment</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Set your publishable key
Stripe.setPublishableKey('<?php echo STRIPE_PUBLISHABLE_KEY; ?>');

// Callback to handle the response from stripe
function stripeResponseHandler(status, response) {
    if (response.error) {
        // Enable the submit button
        $('#payBtn').removeAttr("disabled");
        // Display the errors on the form
        $(".payment-status").html('<div class="alert alert-danger">'+response.error.message+'</div>');
    } else {
        var form$ = $("#paymentFrm");
        // Get token id
        var token = response.id;
        // Insert the token into the form
        form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
        // Submit form to the server
        form$.get(0).submit();
    }
}

$(document).ready(function() {
    // On form submit
    $("#paymentFrm").submit(function() {
        // Disable the submit button to prevent repeated clicks
        $('#payBtn').attr("disabled", "disabled");
		
        // Create single-use token to charge the user
        Stripe.createToken({
            number: $('#card_number').val(),
            exp_month: $('#card_exp_month').val(),
            exp_year: $('#card_exp_year').val(),
            cvc: $('#card_cvc').val()
        }, stripeResponseHandler);
		
        // Submit from callback
        return false;
    });
});
</script>
</body>
</html>