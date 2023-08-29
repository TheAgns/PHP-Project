<?php require_once('../private/initalize.php');?>
<?php $page_title = "Login";?>
<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: index.php");
}
?>

  <?php include(SHARED_PATH . '/loginHeader.php')?>
    <div class="container">
        <?php
        if (isset($_POST["login"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];
            require_once (PRIVATE_PATH . '/database.php');
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($user) {
                if (password_verify($password, $user["password"])) {
                    session_start();
                    $_SESSION["user"] = "yes";
                    header("Location: index.php");
                    die();
                } else {
                    echo "<div class='alert alert-danger'>Password does not match</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Email does not match</div>";
            }
        }
        ?>
        <form action="index.php" method="post" id="loginForm">
            <div class="form-group">
                <input type="email" placeholder="Enter Email:" name="email" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Enter Password:" name="password" class="form-control">
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>
        <div><p>Not registered yet <a href="register/index.php">Register Here</a></p></div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("loginForm").addEventListener("submit", function(event) {
                const emailInput = document.querySelector("[name='email']");
                const passwordInput = document.querySelector("[name='password']");
                
                if (emailInput.value.trim() === "" || passwordInput.value.trim() === "") {
                    event.preventDefault();
                    alert("Both email and password are required.");
                }
            });
        });
    </script>
<?php include(SHARED_PATH . '/footer.php') ?>
