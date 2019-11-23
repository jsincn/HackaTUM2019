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


        <form>
            <h2 class="text-center">Canteen Payment</h2>
            <h4>Previous transactions</h4>
            <div class="form-group mb-2">
                <label for="staticEmail2">StudentID</label>
                <input type="text" readonly class="form-control" placeholder="12345678">
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
                        <th scope="col"></th>
                        <th scope="col">Total</th>
                        <th scope="col">€<?php echo $data['total'] ?></th>
                    </tr>
                </tfoot>
            </table>
        </form>

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