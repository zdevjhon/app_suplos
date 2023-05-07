
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once './src/Views/includes/head.php';
    ?>
</head>

<body>
    <!-- SIDEBAR -->
    <?php
    include_once './src/Views/includes/menu.php';
    ?>
    <!-- SIDEBAR -->

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <?php
        include_once './src/Views/includes/navbar.php';
        ?>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="container-fluid">

                
                <div class="head-title">
                    <div class="left">
                        <h1>Dashboard</h1>
                        <ul class="breadcrumb">
                            <li>
                                <a href="#">Dashboard</a>
                            </li>
                            <li><i class='bx bx-chevron-right'></i></li>
                            <li>
                                <a class="active" href="#">Home</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <?php
    include_once './src/Views/includes/footer.php';
    ?>

</body>

</html>

