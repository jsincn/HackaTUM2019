<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>MyPersonalBusinessCard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="/assets/css/styles.min.css">
</head>

<body>
    <?php require "components/navbar.php"; ?>
    <div class="contact-clean">
        <form method="post" action="/paymentGateway"  enctype="multipart/form-data">
            <h2 class="text-center">Canteen Payment</h2>
            <h4> You are seated at table <?php echo $tableID; ?> </h4>
            <div class="form-group"><div style="position:relative;"><label for="takePhotoItem" class="btn btn-primary">Take a photo of your tray</label><input type="file" id="takePhotoItem" name="photo" required="true" accept="image/*;capture=camera" hidden></div></div>
            <div class="form-group"><label>Place your student card on the tray and take a photo from above. Ensure that all parts of your meal and your student card are clearly visible.</label></div>
            <input type="text" hidden name="tableID" value="<?php echo $tableID; ?>"> 
            <div class="form-group">
                <label class="form-check-label" for="formCheck-1">By paying you agree to the terms and conditions.</label>
            </div>
            <div class="form-group"><button class="btn btn-primary" type="submit">PAY</button></div>
        </form>
    </div>
    <?php require "components/footer.php"; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

</body>

</html>