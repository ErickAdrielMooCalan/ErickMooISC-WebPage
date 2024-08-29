<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'include/head.php';?>
    <link rel='stylesheet' type='text/css' media='screen' href='styles/style_create_client.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='styles/style_create_client_mobile.css'>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a account</title>
</head>
<body>
    <?php include 'include/header.php';?>

    <section class="main_width section_1_create_client">
        <div class="form_container">
            <div class="icons_container">
                <i class="fa-solid fa-user-plus create_new_client"></i>
            </div>

            <form action="validate_create_client.php" method="POST" class="login_form">

            </form>
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