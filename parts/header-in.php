<?php
    echo 
    "<header>
    <nav class='navbar navbar-inverse navbar navbar-fixed-top container-fluid' id='header-in' style='min-height: 50px;'>
    <div class='navbar-header' style='z-index:199;'>
        <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#asst-navbar' id='asst-navbar-tog'>
            <span class='icon-bar'></span>
            <span class='icon-bar'></span>
            <span class='icon-bar'></span>
        </button>
    </div>
    <div class='collapse navbar-collapse' id='asst-navbar' style='z-index:99;'>
        <ul class='nav navbar-nav navbar-men' id='asst-navbar-men' style=''>
            <li class='sidenav-men-item activemenitem' id='alldev1'><a><span class='glyphicon glyphicon-folder-close'></span> All Devices </a></li>
            <li id='alldev-sub1' class='sidenavsubmen' style=''>
                <ul class='sidenav-men'>
                    <li class='sidenav-men-item sidenav-sub-item' id='asgndev1' style='padding-top:100px;'><a><br><span class='fas fa-cookie'></span> Assigned Devices</a></li>
                    <li class='sidenav-men-item sidenav-sub-item' id='unasgndev1'><a><br><span class='fas fa-cookie-bite'></span> Unassigned Devices</a></li>
    <!--            <li class='sidenav-men-item'><a>Sub Item 3</a></li>  -->
                </ul>
            </li>
            <li class='sidenav-men-item' id='devusers1'><a><span class='fas fa-users'></span> All Users</a></li>
            <li class='sidenav-men-item' id='newdev1'><a><span class='glyphicon glyphicon-plus-sign'></span> Add New Device</a></li>
            <li class='sidenav-men-item' id='dashbrd1'><a><span class='glyphicon glyphicon-chevron-left'></span> Back to Dashboard</a></li>
        </ul>
    </div>
    </nav>
    </header>";
?>