<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'include/head.php';?>
    <link rel='stylesheet' type='text/css' media='screen' href='styles/style_login_client.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='styles/style_login_client_mobile.css'>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Client</title>
</head>
<body>
    <?php include 'include/header.php';?>

    <section class="main_width section_1_login_client">
        <div class="form_container">

            <div class="icons_container">
                <i class="fa-solid fa-user key_user_icon"></i>
            </div>

            <form action="validate_login_client.php" method="POST" class="login_form">
                <div class="form_group">
                    <label for="email_client">Email</label>
                    <input type="email" id="email_client" name="email_client" required placeholder="Type your email">
                </div>

                <div class="form_group">
                    <label for="password_client">Password</label>
                    <input type="password" id="password_client" name="password_client" required placeholder="Type your password">
                </div>

                <button type="submit" class="login_client_buttom">Login</button>
            </form>

            <div class="info_create_client">
                <p>Create a totally free account now</p>
                <a href="create_client.php" class="create_client_buttom">Sign up</a>

            </div>
        </div>
    </section>

</body>

<script>
    new WOW().init();

    document.querySelector('.menu_button').addEventListener('click', function() {
    document.querySelector('.menu_nav').classList.toggle('active');
    });

    var splide = new Splide( '.splide', {type: 'loop', autoplay: false, interval: '2000'} );
    splide.mount();
</script>

<?php include 'include/footer.php'; ?>

</html>