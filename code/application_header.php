<!-- Admin Outer -->
<div id="adminbar-outer" class="radius-bottom">

    <!-- Adminbar -->
    <div id="adminbar" class="radius-bottom">

        <!-- Logo -->
        <a href="home.php" id="logo"><img src="img/vishak_logo.png" width="74%"/></a>

        <!-- Details -->
        <div id="details">
            <a href="javascript: void(0)" class="avatar">
                <img src="img/avatar.jpg" alt="avatar" width="36" height="36" />
            </a>
            <div class="tcenter">
                Hi <strong><? echo $_SESSION['name'] ?></strong>!<br/><? //echo date('jS F Y : h:ma'); ?>
                <span id="clock">&nbsp;</span> | <a href="javascript:callPage('home','logout')" class="alightred">Logout</a> 	
            </div>
        </div>
        <!-- END Details -->

        <!-- Widgets -->
        <div id="widgets">
<?php /* Removed to support internet explorer*/ ?>
            <!-- Widget menu -->
            <ul id="widget-menu">
               

                <li style="display:none">

                    <!-- Link for Twitter widget -->
                    <a href="javascript: void(0)" class="w-link"><img src="img/w-icon-twitter.png" alt="Twitter" /></a>

                    <!-- Popup for Twitter widget -->
                    <div class="widget">
                        <div class="w-top"></div>
                        <div class="w-content">

                            <!-- Twitter sub navigation -->
                            <ul id="w-tabs-twitter" class="widget-sub-nav">
                                <li class="active"><a href="#w-tabs-twitter-update-status" class="nav2">What's Up?</a></li>
                                <li><a id="load-twitter-updates" href="#w-tabs-twitter-recent-updates" class="nav2">Recent Updates</a></li>
                            </ul>
                            <!-- END Twitter sub navigation -->

                            <!-- Twitter tabs content -->
                            
                            <!-- Update status tab -->
                            <div id="w-tabs-twitter-update-status">

                                <div id="twitter-status-update">
                                    <div class="msg-info">Type and watch the textarea auto expand :)</div>
                                </div>

                                <form action="javascript: void(0)" method="post" name="t-form" id="t-form" class="clearfix">
                                    <textarea name="t-twitter-status" id="t-twitter-status" class="elastic" cols="43" rows="1"></textarea>
                               
                           
                                </form>

                            </div>
                            <!-- END Update status tab -->

                           

                        </div>
                        <div class="w-bottom"></div>
                    </div>
                    <!-- END Popup for Twitter widget -->

                </li>    
            </ul>
            <!-- END Widget menu -->
<?php /* */ ?>
        </div>
        <!-- END Widgets -->

    </div>
    <!-- END Adminbar -->

</div>
<!-- END Admin Outer -->
