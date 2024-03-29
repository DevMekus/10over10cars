<?php
$title = "Transactions";
include("header.php");
?>
<main class="dash-wrap theme-primary">
    <section class="sidebar-section">
        <?php include("sidebar.php");  ?>
    </section>
    <section class="content-section">
        <?php include("navbar.php");  ?>
        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title sectionSpace">
                            <h1 class="card-title">My Transactions</h1>
                            <nav class="sectionSpace" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Transactions</li>
                                </ol>
                            </nav>
                        </div>

                        <div class="sectionSpace">
                            <h2 class="card-title">Latest Transactions</h2>
                            <div class="card sectionSpace">
                                <div class="card-body">
                                    <h5>You haven't made any transactions yet </h5>
                                    <p>Make a transactions now to get a detailed information and a complete history report of your vehicle.</p>
                                    <button class="btn outline">Buy now</button>

                                    <div class="sectionSpace">
                                        <p>Get a few reports and regain the power of finding out detailed histories of cars.</p>
                                        <button class="btn outline">Check your car</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
</main>

<?php include("footer.php");  ?>