<?php
$title = "Report";
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
                        <li class="breadcrumb-item active" aria-current="page">Reports</li>
                    </ol>
                </nav>

                <div class="sectionSpace">
                    <h1 class="card-title">Latest Reports</h1>
                    <div class="card sectionSpace">
                        <div class="card-body">
                            <h5>Have you noticed it? You are out of reports.</h5>
                            <p>Get a few reports and regain the power of finding out detailed histories of cars.</p>
                            <button class="btn outline">Check your car</button>
                        </div>
                    </div>
                </div>
                <div class="card sectionSpace">
                    <div class="card-body">
                        <h5>Report theft</h5>
                        <p>
                            One of the functions of <?php echo $site_name;  ?> is to protect the properties of citizens. This service is created for members of the public to report their stolen and yet to be recovered vehicles.
                        </p>
                        <a href="./report-theft.php" class="btn outline">Report theft</a>
                    </div>
                </div>

                <?php include("footer-links.php");  ?>
            </div>
        </div>
    </main>
    <?php include("footer.php");  ?>