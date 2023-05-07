
<section id="sidebar">
    <a href="#" class="brand">
        <i class='bx bxs-smile'></i>
        <span class="text"><?=$_ENV['APP_NAME']?></span>
    </a>
    <ul class="side-menu top">
        <li class="<?=(getFile($file_name)=='home')? 'active': ''?>">
            <a href="<?php echo base_url(); ?>home">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li class="<?=(getFile($file_name)=='user/listar')? 'active': ''?>">
            <a href="<?php echo base_url(); ?>user/listar">
                <i class='bx bxs-shopping-bag-alt'></i>
                <span class="text">Usuarios</span>
            </a>
        </li>
        <li class="<?=(getFile($file_name)=='procesos/listar' || getFile($file_name)=='procesos/consultas')? 'active': ''?>">
            <a href="<?php echo base_url(); ?>procesos/listar">
                <i class='bx bxs-shopping-bag-alt'></i>
                <span class="text">Procesos</span>
            </a>
        </li>
        <li>
            <a href="#">
                <i class='bx bxs-doughnut-chart'></i>
                <span class="text">Analytics</span>
            </a>
        </li>        
    </ul>
    <ul class="side-menu">
        <li>
            <a href="#">
                <i class='bx bxs-cog'></i>
                <span class="text">Settings</span>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url(); ?>logout" class="logout">
                <i class='bx bxs-log-out-circle'></i>
                <span class="text">Logout</span>
            </a>
        </li>
    </ul>
</section>