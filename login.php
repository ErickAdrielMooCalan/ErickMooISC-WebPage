<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'include/head.php';?>
    <link rel='stylesheet' type='text/css' media='screen' href='styles/style_login.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='styles/style_login_mobile.css'>
    <title>Login</title>
</head>
<body>
    <?php include 'include/header.php';?>

    <section class="main_width section_1_login">
        <div class="buttoms_login_container">
            <i class="fa-solid fa-users icon_user_type"></i>
            <a href="login_client.php" class="client_buttom">Client</a>
            <a href="" class="admin_buttom">Administrator</a>
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