<?php
$title = "Transaction";
include("header.php");
include("navbar.php");
?>

<body>
    <main class="container">
        <div class="row">
            <div class="col-sm-12">
                <nav class="sectionSpace" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="./index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Transactions</li>
                    </ol>
                </nav>
                <div class="sectionSpace">
                    <h1 class="card-title">Transactions</h1>
                    <div class="card sectionSpace">
                        <div class="card-body">
                            <h5>You haven't made any transactions yet </h5>
                            <p>Make a transactions now to get a detailed information and a complete history report of your vehicle.</p>

                            <div class="sectionSpace">
                                <p>Get a few reports and regain the power of finding out detailed histories of cars.</p>
                                <button class="btn outline">Check your car</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card sectionSpace">
                    <div class="card-body">
                        <h5>You need a Car? </h5>
                        <p>Get a few reports and regain the power of finding out detailed histories of cars.</p>
                        <button class="btn outline">Buy now</button>


                    </div>
                </div>

                <?php include("footer-links.php");  ?>
            </div>
        </div>
    </main>
    <?php include("footer.php");  ?>