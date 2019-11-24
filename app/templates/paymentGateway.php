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

    <div class="contact-clean">

            <h2 class="text-center">Canteen Payment</h2>
            <h4 class="text-center">Your payment is processing</h4>
            <h4 class="text-center"><img src="/assets/img/801.gif" width="auto"></h4>
           
    </div>
    <?php require "components/footer.php"; ?>

    <form hidden method="post" action="/payConfirm" id="form">
        <?php foreach ($data['recognized'] as $key => $quantity) {
            echo "<input type='text' name='" . $key . "' value='" . $quantity . "'>";
        };
        echo "<input type='text' name='id' value='" . $data['user'] . "'>";
        ?>
    </form>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#form').submit();
        })
    </script>
</body>

</html>