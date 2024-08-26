<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'include/head.php'; ?>
    <title>Welcome to Erick Moo ISC</title>
</head>
<body>

<?php include 'include/header.php';?>

    <section class="slider_main">
        <div class="splide">
            <div class="splide__track">
                <ul class="splide__list">
                    <li class="splide__slide">
                        <div class="text_on_slide">
                            <h4>Hi there, welcome to "Erick Moo ISC" my personal website</h4>
                        </div>
                        <video autoplay muted loop>
                            <source src="videos/slider_dots.mp4" type="video/mp4">
                        </video>
                    </li>
                    <li class="splide__slide">
                        <div class="text_on_slide">
                            <h4>Here you can find some interesting facts about my daily life and my development skills</h4>
                        </div>
                        <img src="images/content/slide_2.jpg" alt="">
                    </li>
                    <li class="splide__slide">
                        <div class="text_on_slide">
                            <h4>Every day I try to learn something new to apply in the development of new projects.</h4>
                        </div>
                        <img src="images/content/slide_3.jpg" alt="">
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <section class="main_title_container main_width">
        <h3 class="main_title">Skills at Work</h3>
    </section>

    <section class="main_width section_1">
        <article class="main_skill_container wow animate__animated animate__fadeInUp">

            <p class="skill_title">Web page development</p>

            <div class="skill_container_icon">
                <i class="fa-solid fa-globe"></i>
            </div>

            <p class="skill_info">Develop web pages in relation to client needs.</p>

            <a href="" class="button_see_more">See more</a>
        </article>

        <article class="main_skill_container wow animate__animated animate__fadeInUp">

            <p class="skill_title">Database administrator</p>

            <div class="skill_container_icon">
                <i class="fa-solid fa-database"></i>
            </div>

            <p class="skill_info">Design and management of relational data.</p>

            <a href="" class="button_see_more">See more</a>
        </article>

        <article class="main_skill_container wow animate__animated animate__fadeInUp">

            <p class="skill_title">Support and maintenance.</p>

            <div class="skill_container_icon">
                <i class="fa-solid fa-screwdriver"></i>
            </div>

            <p class="skill_info">Configuration and maintenance for PCs.</p>

            <a href="" class="button_see_more">See more</a>
        </article>
    </section>

    <section class="main_title_container main_width">
        <h5 class="main_title">Importance of Web Development</h5>
    </section>

    <section class="main_width section_2">
        <div class="left_section_2">
            <figure>
                <img src="images/content/section_2_image1.jpg" alt="">
            </figure>
            <figure>
                <img src="images/content/section_2_image2.png" alt="">
            </figure>

        </div>

        <div class="right_section_2">

            <p>Good web development is crucial for any business or project because a website is the digital face of the brand. Having a website allows companies to reach a wider audience, increase their visibility and offer their services or products at any time of the day. Additionally, a well-developed website improves the user experience, making navigation intuitive, fast and engaging, which can increase customer satisfaction.</p>

            <p>It is essential to develop the website according to the client's needs because each business is unique. Custom web development ensures that the page reflects the brand identity, offering the specific functionalities that users require and is optimized for its target audience. This not only improves the effectiveness of the page, but also strengthens the relationship between the company and its customers, demonstrating that the company understands and adapts to their needs.</p>

        </div>
    </section>

    <section class="main_title_container main_width">
        <h5 class="main_title">Importance of database administration and design.</h5>
    </section>

    <section class="main_width section_3">
        <div class="left_section_3">
            <p>Database administration is essential for the efficient and secure management of information in an organization. Good management ensures that data is available, reliable, and protected from loss or unauthorized access. This is vital to making informed decisions, complying with regulations, and maintaining business operations.</p>

            <p>A good design optimizes performance, makes data easy to access and update, and minimizes redundancies. Proper design ensures that the database is scalable, flexible, and can adapt to future business needs without compromising its integrity.</p>
        </div>

        <div class="right_section_3">
            <figure>
                <img src="images/content/section_3_image1.jpeg" alt="">
            </figure>
            <figure>
                <img src="images/content/section_3_image2.png" alt="">
            </figure>

        </div>

    </section>

    <section class="main_title_container main_width">
        <h5 class="main_title">Importance of preventive and corrective maintenance</h5>
    </section>

    <section class="main_width section_4">
        <div class="left_section_4">
            <figure>
                <img src="images/content/section_4_image1.jpg" alt="">
            </figure>
            <figure>
                <img src="images/content/section_4_image2.jpg" alt="">
            </figure>

        </div>

        <div class="right_section_4">
            <p>Preventive and corrective maintenance on computer equipment is essential to ensure its optimal functioning and prolong its useful life. Preventive maintenance involves performing regular actions, such as cleaning components, updating software, and checking hardware, to prevent failures before they occur. This helps reduce the risk of outages, improves performance, and prevents costly long-term damage.</p>

            <p>On the other hand, corrective maintenance focuses on solving problems when they have already arisen, such as hardware repairs or the reinstallation of operating systems. Acting quickly in these cases minimizes downtime, reduces negative impact on operations, and ensures equipment is back up and running efficiently as soon as possible. Both types of maintenance are vital to maintaining the reliability and productivity of computer systems.</p>
        </div>
    </section>
</body>

<?php include 'include/footer.php'; ?>

<script>
    new WOW().init();

    document.querySelector('.menu_button').addEventListener('click', function() {
    document.querySelector('.menu_nav').classList.toggle('active');
    });

    var splide = new Splide( '.splide', {type: 'loop', autoplay: false, interval: '2000'} );
    splide.mount();
</script>

</html>