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
    <nav class="navbar navbar-light navbar-expand-md navigation-clean-button">
        <div class="container"><a class="navbar-brand" href="#">Canteen Pay</a><button data-toggle="collapse"
                class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span
                    class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav mr-auto">
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#">About</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#">My transactions</a></li>
                    <li class="nav-item" role="presentation"><a class="nav-link" href="#">Admin</a></li>
                    <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" data-toggle="dropdown"
                            aria-expanded="false" href="#">Help</a>
                        <div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation"
                                href="#">FAQ</a><a class="dropdown-item" role="presentation" href="#">Email Support</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
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
    <div class="footer-basic">
        <footer>
            <div class="social"><a href="#"><i class="icon ion-social-instagram"></i></a><a href="#"><i
                        class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-facebook"></i></a>
            </div>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Home</a></li>
                <li class="list-inline-item"><a href="#">Services</a></li>
                <li class="list-inline-item"><a href="#">About</a></li>
                <li class="list-inline-item"><a href="#">Terms</a></li>
                <li class="list-inline-item"><a href="#">Report Abuse</a></li>
                <li class="list-inline-item"></li>
            </ul>
            <p class="copyright">Jakob Steimle © 2019</p>
        </footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

</body>

</html>