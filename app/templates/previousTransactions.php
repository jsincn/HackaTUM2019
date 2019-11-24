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


        <form>
            <h2 class="text-center">Canteen Payment</h2>
            <h4>Previous transactions</h4>
            <div class="form-group mb-2">
                <label for="staticEmail2">StudentID</label>
                <input type="text" class="form-control" name="id" placeholder="12345678">
            </div>
            <button type="submit" class="btn btn-primary">Check transactions</button>
            <br>
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Place</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['transactions'] as $item) {
                        echo "<tr><th scope='row'>" . $item[0] . "</th><td>" . $item[1] . "€</td><td>" . $item[2] . "</td></tr>";
                    };
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col">Total</th>
                        
                        <th scope="col">€<?php echo $data['total'] ?></th>
                        <th scope="col"></th>
                    </tr>
                    <tr>
                        
                        <th scope="col">Remaining Balance</th>
                        
                        <th scope="col">€<?php echo $data['total'] ?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </form>

    </div>
    
    <?php require "components/footer.php"; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

</body>

</html>