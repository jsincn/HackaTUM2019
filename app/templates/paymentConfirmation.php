<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Canteen Pay</title>
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
            <h4> Please confirm your bill </h4>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Item</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['soldItems'] as $item) {
                        echo "<tr><th scope='row'>" . $item[0] . "</th><td>" . $item[1] . "</td><td>" . $item[2] . "€</td></tr>";
                    };
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Total</th>
                        <th scope="col">€<?php echo $data['total'] ?></th>
                    </tr>
                </tfoot>
            </table>
            <h4>Logged in as <?php echo $data['studentName'] ?>.</h4>
            <div><button type="button" class="btn btn-lg btn-success">Confirm</button> <button type="button" class="btn btn-lg btn-primary">Retake Photo</button></div>
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