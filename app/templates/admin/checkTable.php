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


        <form action="/admin/check" action="GET">
            <h2 class="text-center">Canteen Payment Administration</h2>
            <h4>Check Tables</h4>
            <h4><small>Check all transactions for a given table in the last hour.</small></h4>
            <div class="form-group mb-2">
                <label for="staticEmail2">Table ID</label>
                <input type="text" class="form-control" name="table_id" placeholder="506010">
            </div>
            <button type="submit" class="btn btn-primary">Check transactions</button>
            <br>
            <br>
            <table class="table" style="display:block; overflow-x : scroll;">
                <thead>
                    <tr>
                        <th scope="col">Meal ID</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Student ID</th>
                        <th scope="col">Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['transactions'] as $item) {
                        echo "<tr><th scope='row'>" . $item[0] . "</th><td>" . $item[4] . "€</td><td>" . $item[1] . "</td><td>" . $item[2]->format('Y-m-d H:i:s') . "</td></tr>";
                    };
                    ?>
                </tbody>
            </table>
        </form>

    </div>
    
    <?php require "components/footer.php"; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

</body>

</html>