<?php
$title = "Vin Decoder";
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
                        <li class="breadcrumb-item active" aria-current="page">Vin Decoder</li>
                    </ol>
                </nav>
                <div class="sectionSpace">
                    <h1 class="card-title text-center">VIN Decoder & Lookup</h1>
                    <p class="text-center sectionSpace">Decode Your Vehicle Identification Number for Free. Check out some answers to common questions and get started with our VIN decoder service!</p>
                </div>
                <section class="section">
                    <div class="card fullwidth">
                        <div class="card-body">
                            <div class="section-titles">
                                <h3 class="card-title text-center">Check your car and <span class="orange">save thousands of dollars</span></h3>
                            </div>
                            <div class="input-wrap border-bottom-primary pad-default sectionSpace">
                                <input type="text" placeholder="ENTER YOUR VIN NUMBER" class="fullwidth border-bottom-primary" />
                                <button class="btn primary">CHECK VIN </button>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="card sectionSpace">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <p class="text-justify">
                                    Do you want to learn about how a vehicle was equipped from the factory? Are you curious about where and when your car was built? If you want to learn more about a vehicle, whether it’s something you own, or something you want to buy, all you need to do is use our free VIN lookup tool.
                                </p>

                                <div class="sectionSpace">
                                    <div class="card-plain">
                                        <div class="card-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col"></th>
                                                        <th scope="col"></th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">Basic Report Cost:</th>
                                                        <td>Free</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">VIN Database:</th>
                                                        <td>500M+</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Car-On-Sale Photos:</th>
                                                        <td> Up to 100</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Full Report:</th>
                                                        <td> Extensive History</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="sectionSpace">
                                    <h3 class="card-title">What is a VIN Number (Vehicle Identification Number)?</h3>
                                    <p class="sectionSpace text-justify">
                                        The Vehicle Identification Number is a unique code issued to every new vehicle. These codes were first used in the early 1950s to help companies identify the vehicles that came off of the assembly lines. In 1981, the National Highway Traffic Safety Administration (NHTSA) standardized the format of this code, using a 17 character format. This code does not use the letters “Q”, “I” or “O” to avoid confusion with the numbers “0” and “1”. The vehicle identification number includes information about where and when a vehicle was built, its configuration, and its serial number.
                                    </p>
                                </div>
                                <div class="sectionSpace">
                                    <h3 class="card-title">How Do I Find My Vehicle`s VIN Number?</h3>
                                    <p class="sectionSpace text-justify">
                                        This code identifies more than the serial number and model. It also contains information about safety equipment, trim levels and more. This can tell you more information about a vehicle than you’ll usually get from a sales listing. Since VINs are unique to each vehicle, it’s also used to identify cars on official documents:
                                    </p>
                                    <ul>
                                        <li>It’s used by manufacturers to track recalls. Looking up this number lets you find out about recalls for the vehicle, and if the required repairs were made.</li>
                                        <li>It identifies vehicles in police records, including theft and accident reports.</li>
                                        <li>Insurance companies issue policies based on this number.</li>
                                        <li>Financial institutions use the number to identify vehicles on paperwork. This makes it easy to track outstanding liens.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php include("footer-links.php");  ?>
            </div>
        </div>
    </main>
    <?php include("footer.php");  ?>