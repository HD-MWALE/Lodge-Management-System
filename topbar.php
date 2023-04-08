<body>
    <style>
        .topbar-no{
            color: #FFD700;
        }
        .topbar-no:hover{
            color: #FFF;
        }
    </style>
    <!-- Header Section Start -->
    <header id="header">
        <a href="index.php?page=home" class="logo"><img src="./assets/img/logo.png" alt="logo"><strong style="color: #FFD700;"> NGALIYA LODGE</strong></a>
        <div class="phone"><i class="fa fa-phone"></i><a class="topbar-no" href="tel:+265993979170">+265 99 397 9170</a></div>
        <div class="mobile-menu-btn"><i class="fa fa-bars"></i></div>
        <nav class="main-menu top-menu">
            <ul>
                <li class="<?php echo !isset($_GET['page']) ? 'active' : '' ?><?php echo isset($_GET['page']) && $_GET['page'] == 'home' ? 'active' : '' ?>"><a href="index.php?page=home">Home</a></li>
                <li class="<?php echo isset($_GET['page']) && $_GET['page'] == 'about' ? 'active' : '' ?>"><a href="index.php?page=about">About Us</a></li>
                <li class="<?php echo isset($_GET['page']) && $_GET['page'] == 'room' ? 'active' : '' ?>"><a href="index.php?page=our-rooms">Rooms</a></li>
                <li class="<?php echo isset($_GET['page']) && $_GET['page'] == 'amenities' ? 'active' : '' ?>"><a href="index.php?page=amenities">Amenities</a></li>
                <?php if(isset($_SESSION['login_customer_id'])): ?>
                    <li class="<?php echo isset($_GET['page']) && $_GET['page'] == 'booking' ? 'active' : '' ?>"><a href="index.php?page=booking">Booking</a></li>
                <?php else: ?>
                <li class="<?php echo isset($_GET['page']) && $_GET['page'] == 'login' ? 'active' : '' ?>"><a href="index.php?page=login">Login</a></li>
                <?php endif ?>
                <?php if(isset($_SESSION['login_customer_id'])): ?>
                    <li class="<?php echo isset($_GET['page']) && $_GET['page'] == 'booking_details' ? 'active' : '' ?>"><a href="index.php?page=booking_details">Booking Details</a></li>
                    <li class="<?php echo isset($_GET['page']) && $_GET['page'] == 'logout' ? 'active' : '' ?>"><a href="index.php?page=logout">Logout</a></li>
                <?php endif ?>
            </ul>
        </nav>
    </header>
    <!-- Header Section End -->