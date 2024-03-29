<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Gastro Pay</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="/assets/css/styles.min.css">
</head>

<body>
<?php require "components/navbar.php"; ?>
    <div class="contact-clean" style="align:center">
        <div class="card" style="margin: auto">
            <div class="card-body">
                <h2 class="text-center">Canteen Payment</h2>
                <h4> Payment confirmed </h4>
                <h5><small>Logged in as <?php echo $data['studentName'] ?>.</small></h5>
                <h3>Your remaining balance is <?php echo $data['balance']; ?>€. </h3>
                <br>
                <button type="button" class="btn btn-danger">Call a staff member</button>

            </div>
        </div>
    </div>
    <?php require "components/footer.php"; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

</body>

</html>