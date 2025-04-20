<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!--=============== FAVICON ===============-->
   <link rel="shortcut icon" href="assets/images/planeupload.png" type="image/x-icon">

   <!--=============== REMIXICONS ===============-->
   <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">

   <!--=============== BOOTSTRAP 5 ===============-->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-3ylSxlKhIwrYhEhWJcyn+GuYfwl1R0NOYbo0DVAyU1DGlg4hToRBaaVZflfXccSk" crossorigin="anonymous">

   <!--=============== CUSTOM CSS ===============-->
   <link rel="stylesheet" href="assets/css/styles.css">

   <title>JetSetGo</title>
</head>
<body>
   <!--==================== HEADER ====================-->
   <header class="header" id="header">
    <nav class="nav container">
        <a href="" class="nav__logo">
            JetSetGo
        </a>
        <div class="nav__menu" id="nav-menu">
           <ul class="nav__list">
            <li class="nav__item">
                <a href="#home" class="nav__link active-link">Home</a>
            </li>
            <li class="nav__item">
                <a href="#about" class="nav__link">About</a>
            </li>
            <li class="nav__item">
                <a href="#popular" class="nav__link">Popular</a>
            </li>
            <li class="nav__item">
                <a href="#explore" class="nav__link">Review</a>
            </li>
            <li class="nav__item">
                <a href="login.php" class="nav__link">Login</a>
            </li>
           </ul>

           <!--Close button -->
           <div class="nav__close" id="nav-close">
           <i class="ri-close-line"></i>
           </div>
        </div>  

           <!-- Toggle button -->

           <div class="nav__toggle" id="nav-toggle">
           <i class="ri-menu-fill"></i>
           </div>
    </nav>
   </header>

   <!--==================== MAIN ====================-->
   <main class="main">
      <!--==================== HOME ====================-->
      <section class="home section" id="home">
         <img src="assets/img/home-background.jpg" alt="home image" class="home__bg">
         <div class="home__shadow"></div>

         <div class="home__container conatainer grid">
            <div class="home__data">
                <h3 class="home__subtitle">
                    Welcome to JetSetGo
                </h3>

                <h1 class="home__title">
                    Explore <br>
                    The Philippines
                </h1>

                <p class="home__description">
                JetSetGo simplifies your flight booking process with seamless payment integration,
                reliable billing, and an intuitive user interface. Experience a modern way to fly.
                </p>

                <a href="booking/booking.php" class="button">
                    Book a Flight <i class="ri-arrow-right-line"></i>
                </a>
         </div>

    <div class="home__cards grid">
        <article class="home__card">
            <img src="assets/img/home-davao.jpeg" alt="home image" class="home__card-img">
            <h3 class="home__card-title">Davao</h3>
            <div class="home__card-shadow"></div>
        </article>

        <article class="home__card">
            <img src="assets/img/home-palawan.jpeg" alt="home image" class="home__card-img">
            <h3 class="home__card-title">Palawan</h3>
            <div class="home__card-shadow"></div>
        </article>

        <article class="home__card">
            <img src="assets/img/home-cebu.jpg" alt="home image" class="home__card-img">
            <h3 class="home__card-title">Cebu</h3>
            <div class="home__card-shadow"></div>
        </article>
        
        <article class="home__card">
            <img src="assets/img/home-aklan.png" alt="home image" class="home__card-img">
            <h3 class="home__card-title">Aklan</h3>
            <div class="home__card-shadow"></div>
        </article>
    </div>
    </div>
      </section>

      <!--==================== ABOUT ====================-->
      <section class="about section" id="about">
         <div class="about__container container grid">
            <div class="about__data">
                <h2 class="section__title">
                    About JetSetGo
                </h2>
                <p class="about__description">
                At JetSetGo, we believe that booking flights should be as exciting as the journey itself. Our platform brings together cutting-edge technology, real-time flight data, and a user-friendly interface to help travelers find the best flights at the best prices. From last-minute getaways to well-planned business trips, we make flying simple and stress-free.
                </p>

                <a href="" class="button">
                    Explore JetSetGo <i class="ri-arrow-right-line"></i>
                </a>
            </div>

            <div class="about__image">
                <img src="assets/img/about-jsg.jpg" alt="about image" class="about__image">
                <div class="about__shadow"></div>
            </div>
         </div>
      </section>

      <!--==================== POPULAR ====================-->
      <section class="popular section" id="popular">
         <h2 class="section__title">
            Its More Fun 
            In The Philippines
         </h2>

         <div class="popular__container container grid">
            <article class="popular__card">
                <div class="popular__image">
                    <img src="assets/img/popular-river.jpeg" alt="popular image" class="popular__img">
                    <div class="popular__shadow"></div>
                </div>

                <h2 class="popular__title">
                Puerto Princesa Subterranean River National Park
                </h2>

                <div class="popular__location">
                <i class="ri-map-pin-line"></i>
                <span>Puerto Princesa</span>
                </div>
            </article>

            <article class="popular__card">
                <div class="popular__image">
                    <img src="assets/img/popular-rice.jpg" alt="popular image" class="popular__img">
                    <div class="popular__shadow"></div>
                </div>

                <h2 class="popular__title">
                Batad Rice Terraces
                </h2>

                <div class="popular__location">
                <i class="ri-map-pin-line"></i>
                <span>Banaue, Ifugao</span>
                </div>
            </article>

            <article class="popular__card">
                <div class="popular__image">
                    <img src="assets/img/popular-hills.jpg" alt="popular image" class="popular__img">
                    <div class="popular__shadow"></div>
                </div>

                <h2 class="popular__title">
                Chocolate Hills
                </h2>

                <div class="popular__location">
                <i class="ri-map-pin-line"></i>
                <span>Bohol</span>
                </div>
            </article>
         </div>
      </section>
      
      <!--==================== EXPLORE ====================-->
      <section class="explore section" id="explore">
         <div class="explore__container">
            <div class="explore__image">
                <img src="assets/img/explore-feedback.jpg" alt="explore image" class="explore__img">
                <div class="explore__shadow"></div>
            </div>

            <div class="explore__content container grid">
                <div class="explore__data">
                    <h2 class="section__title">
                    Seamless Booking Experience<br>
                    Highly Recommend!
                    </h2>

                    <p class="explore__description"> <br> <br>
                    I recently used JetSetGo to book a round-trip international flight, and I’m genuinely impressed. The platform is incredibly user-friendly, and everything from searching flights to making payments was smooth and straightforward. I especially appreciated the real-time updates and personalized suggestions—it felt like the system knew exactly what I was looking for!
                    What really stood out was the customer support. I had a question about my baggage allowance, and their team responded almost instantly with clear and helpful information. It’s rare to find that level of service these days.
                    JetSetGo made the whole travel planning experience stress-free and even enjoyable. I’ll definitely be using it again for future trips and recommending it to my friends and family!
                    — Sophia R., frequent traveler
                    </p>
                </div>

                <div class="explore__user">
                    <img src="assets/img/explore-perfil.jpg" alt="explore image" class="explore__perfil">
                    <span class="explore__name">Sophia R.</span>
                </div>
            </div>
         </div>
      </section>
      
      <!--==================== JOIN ====================-->
      <section class="join section">
         <div class="join__container container grid">
            <div class="join__data">
                <h2 class="section__title">
                    Your Journey <br>
                    Starts Here
                </h2>

                <p class="joine__description">
                    Get up to date with the latest bookings and deals
                    from us.
                </p>

                <form action="" class="join__form">
                    <input type="email" placeholder= "Enter your email" class="join__input">

                    <button class="join__button button">
                        Subscribe to our Newsletter <i class="ri-arrow-right-line"></i>
                    </button>
                </form>
            </div>

            <div class="join__image">
                <img src="assets/img/join-passport.jpg" alt="join image" class="join__img">
                <div class="join_shadow"></div>
            </div>
         </div>
      </section>
   </main>

   <!--==================== FOOTER ====================-->
   <footer class="footer">
      <div class="footer__container container grid">
        <div class="footer__content grid">
            <div>
                <a href="#" class="footer__logo">JetSetGo</a>

                <p class="footer__description">
                Your Gateway to Smarter Travel. 
                </p>
            </div>

            <div class="footer__data grid">
                <div>
                    <h3 class="footer__title">About</h3>

                    <ul class="footer__links">
                        <li>
                            <a href="#" class="footer__link">About Us</a>
                        </li>

                        <li>
                            <a href="#" class="footer__link">Feature</a>
                        </li>

                        <li>
                            <a href="#" class="footer__link">News & Blog</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="footer__title">Company</h3>

                    <ul class="footer__links">
                        <li>
                            <a href="#" class="footer__link">FAQs</a>
                        </li>

                        <li>
                            <a href="#" class="footer__link">History</a>
                        </li>
                        
                        <li>
                            <a href="#" class="footer__link">Testimonials</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="footer__title">Contact</h3>

                    <ul class="footer__links">
                        <li>
                            <a href="#" class="footer__link">Call Center</a>
                        </li>

                        <li>
                            <a href="#" class="footer__link">Support Center</a>
                        </li>
                        
                        <li>
                            <a href="#" class="footer__link">Contant Us</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="footer__title">Support</h3>

                    <ul class="footer__links">
                        <li>
                            <a href="#" class="footer__link">Privacy Policy</a>
                        </li>

                        <li>
                            <a href="#" class="footer__link">Terms & Services</a>
                        </li>
                        
                        <li>
                            <a href="#" class="footer__link">Payments</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer__group">
            <div class="footer__social">
                <a href="https://www.facebook.com/" target= "_black" class="footer__social-link">
                <i class="ri-facebook-fill"></i>
                </a>

                <a href="https://www.instagram.com/" target= "_black" class="footer__social-link">
                <i class="ri-instagram-line"></i>
                </a>

                <a href="https://x.com/" target= "_black" class="footer__social-link">
                <i class="ri-twitter-line"></i>
                </a>
                    
                <a href="https://www.youtube.com/" target= "_black" class="footer__social-link">
                <i class="ri-youtube-line"></i>
                </a>
            </div>

            <span class="footer__copy">
                &#169; JetSetGo 2025. All Rights Reserved
            </span>
        </div>
      </div>
   </footer>

   <!--========== SCROLL UP ==========-->
   <a href="#" class="scrollup" id="scroll-up">
   <i class="ri-arrow-up-line"></i>
   </a>

   <!--=============== SCROLLREVEAL ===============-->
   <script src=""></script>

   <!--=============== BOOTSTRAP 5 JS ===============-->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-CwETkDJMx9x43vlDEzS3lJZd0PyXZ7lPhSvs+AwkZ2vThg9uH9I9qipEki1kzjRk" crossorigin="anonymous"></script>

   <!--=============== MAIN JS ===============-->
   <script src="assets/js/main.js"></script>
</body>
</html>
