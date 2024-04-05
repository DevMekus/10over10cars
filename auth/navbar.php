<div class="top">
    <a class="navbar-brand" href="../index.php">
        <img src="../assets/logo/logo-black-edit.jpg" class="img-fluid logo-img" alt="logo" /></a>
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