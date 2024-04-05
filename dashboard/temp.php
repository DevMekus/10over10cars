<?php
$title = "Settings";
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
                            <nav class="sectionSpace" style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="./index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Settings</li>
                                </ol>
                            </nav>
                        </div>

                        <div class="sectionSpace">
                            <h2 class="card-title">Account Settings</h2>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae repudiandae rem sint repellat. Tempora quod tempore debitis sapiente fuga magnam quae, temporibus totam placeat quisquam, provident beatae ipsa dolorem eius facere sint dignissimos voluptatibus amet. Provident amet possimus ipsa inventore.
                            </p>

                            <div class="card sectionSpace">
                                <div class="card-body">
                                    <h5>Edit your personal data</h5>
                                    <p>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic optio impedit distinctio maxime. Voluptates, earum voluptatum nisi harum alias beatae est, atque sit facere excepturi placeat, magni reprehenderit dicta nulla?
                                    </p>
                                    <div class="row account-setting">
                                        <div class="col-sm-4">
                                            <form>
                                                <div class="form-wrap">
                                                    <label>Email address</label>
                                                    <input type="email" class="form-item" placeholder="You@email.com" required />
                                                </div>
                                                <div class="form-wrap">
                                                    <label>First Name</label>
                                                    <input type="text" class="form-item" placeholder="John" required />
                                                </div>
                                                <div class="form-wrap">
                                                    <label>Last Name</label>
                                                    <input type="text" class="form-item" placeholder="Doe" required />
                                                </div>
                                                <div class="form-wrap">
                                                    <label>Phone</label>
                                                    <input type="text" class="form-item" placeholder="+234-37**" required />
                                                </div>

                                                <div class="form-wraps sectionSpace">
                                                    <button class="btn primary">Save Settings</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="card-bodys">
                                                <h2 class="card-title text-centers">Will you like to get a <span class="orange">FREE</span>
                                                    Vehicle History Report?</h2>
                                                <p class="text-centers">Refer and get a free Vehicle History Report. It’s that easy. Every time a user purchases their first report using your referral link, you get a free vehicle history report. This is our way of saying thank you for telling people about our services.
                                                </p>
                                                <div class="sectionSpace flex space-between gap_10">
                                                    <input type="text" placeholder="Enter VIN Number" class="outline-input fullwidth" value="www.facebook.com/GDJ73632" />
                                                    <button class="btn primary pill">Copy</button>
                                                </div>
                                                <div class="sectionSpace">
                                                    <h5 class="card-title text-centers"> SHARE WITH SOCIAL</h5>
                                                    <div class="sectionSpace fullwidth flex gap_10 align-center">
                                                        <a class="#" class="social-link">
                                                            <span class="fab fa-facebook icon"></span>
                                                        </a>
                                                        <a class="#" class="social-link">
                                                            <span class="fab fa-instagram icon"></span>
                                                        </a>
                                                        <a class="#" class="social-link">
                                                            <span class="fab fa-twitter icon"></span>
                                                        </a>
                                                        <a class="#" class="social-link">
                                                            <span class="fab fa-youtube icon"></span>
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="card-plaina sectionSpace">
                                <div class="card-body">
                                    <h5>Edit your personal data</h5>
                                    <div class="row account-setting">
                                        <div class="col-sm-4">
                                            <form>
                                                <div class="form-wrap">
                                                    <label>Email address</label>
                                                    <input type="email" class="form-item" placeholder="You@email.com" required />
                                                </div>
                                                <div class="form-wrap">
                                                    <label>First Name</label>
                                                    <input type="text" class="form-item" placeholder="John" required />
                                                </div>
                                                <div class="form-wrap">
                                                    <label>Last Name</label>
                                                    <input type="text" class="form-item" placeholder="Doe" required />
                                                </div>
                                                <div class="form-wrap">
                                                    <label>Phone</label>
                                                    <input type="text" class="form-item" placeholder="+234-37**" required />
                                                </div>

                                                <div class="form-wrap">
                                                    <button class="btn pill primary">Save Settings</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="card-bodys">
                                                <h2 class="card-title text-centers">Will you like to get a <span class="orange">FREE</span>
                                                    Vehicle History Report?</h2>
                                                <p class="text-centers">Refer and get a free Vehicle History Report. It’s that easy. Every time a user purchases their first report using your referral link, you get a free vehicle history report. This is our way of saying thank you for telling people about our services.


                                                </p>
                                                <div class="sectionSpace flex space-between gap_10">
                                                    <input type="text" placeholder="Enter VIN Number" class="outline-input fullwidth" value="www.facebook.com/GDJ73632" />
                                                    <button class="btn primary pill">Copy</button>
                                                </div>
                                                <div class="sectionSpace">
                                                    <h5 class="card-title text-centers"> SHARE WITH SOCIAL</h5>
                                                    <div class="sectionSpace fullwidth flex gap_10 align-center">
                                                        <a class="#" class="social-link">
                                                            <span class="fab fa-facebook icon"></span>
                                                        </a>
                                                        <a class="#" class="social-link">
                                                            <span class="fab fa-instagram icon"></span>
                                                        </a>
                                                        <a class="#" class="social-link">
                                                            <span class="fab fa-twitter icon"></span>
                                                        </a>
                                                        <a class="#" class="social-link">
                                                            <span class="fab fa-youtube icon"></span>
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php include("footer.php");  ?>
    </section>
</main>