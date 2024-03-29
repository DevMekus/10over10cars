<nav class="navbar navbar-expand-lg nav-container  theme-primary">
    <div class="container">
        <a class="navbar-brand" href="../index.php"><?php echo $site_name; ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse fullwidth flex flex-end" id="navbarSupportedContent">

            <form class="d-flex" role="search">
                <?php echo $btn =  $title == "Login" ? '
                <div class="authbtn  flex gap_10 align-center">
                    <label class="form-label whiteColor">Don\'t have an account?</label>
                    <a href="./signup.php" class="btn outline btn-sm nav-btn">Sign up</a>
                </div> '
                    :
                    '<div class="authbtn  flex gap_10 align-center">
                    <label class="form-label whiteColor">Already have an account?</label>
                    <a href="./login.php" class="btn outline btn-sm nav-btn">Sign in</a>
                </div>'
                ?>
            </form>

        </div>
    </div>
</nav>