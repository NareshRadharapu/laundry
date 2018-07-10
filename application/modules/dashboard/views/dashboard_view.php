 
    <?php $session_id = $this->session->userdata('logged_ichapps');?>		
		<div id="alert_dboard" style="display:none;" data-noty-options="{&quot;text&quot;:&quot; Hi Your Last Login IP : <?php echo $session_id['userlip'];?> on  <?php echo dateformat($session_id['userldate']);?> from <?php echo $session_id['userlbwr'];?>&quot;,&quot;layout&quot;:&quot;top&quot;,&quot;type&quot;:&quot;information&quot;}" class="btn btn-primary noty"></div>

<div id="ichapps-custom-user-start-page">
  	<div id="ichapps-custom-user-header">
    	<div class="container">
        <div class="row">
        	<div class="col-md-4">
            	<div class="ichapps-custom-user-start-header">
                	<a href="<?php base_url(); ?>home.html"><img src="<?php base_url(); ?>public/images/logo/logo.png" alt="ICHAPPS-LOGO"></a>
                </div>
            </div>
            <div class="col-md-8">
             <div class="ichapps-custom-header-main-text visible-lg visible-md">An International Health Care and Pharmaceutical Applications.</div>
            </div>
        </div>
        </div>
    </div>
    <div id="ichapps-custom-dashboard-main">
    
    
    	<div class="container">
        	<div class="row">
                	<div class="col-md-8 col-md-offset-2">
                    <?php $userdata=userflnamedata(); extract($userdata); ?>
                   		<h3>Hi <span><?php echo $UserFirstName." ".$UserLastName ?></span> !</h3>
                        <div class="text-center" id="ichapps-custom-dashboard-info">
                         <p>Welcome to the world of <strong>ICHAPPS.COM</strong></p>
                         <p>Our team working on Design Your Dashbaord.</p>
                         <figure><img src="<?php base_url(); ?>public/images/dashboard/paintbrush.jpg" width="200" alt="Bashboard-Paint" class="img-reponsive"></figure>
                         <p>Sorry for the inconvenience.</p>
                         <p><a href="<?php base_url(); ?>logout.html" class="ichapps-custom-a-text-decoration ichapps-custom-tooltip" data-toggle="tooltip" data-placement="bottom" title="Click me to logout"> Logout <i class="glyphicon glyphicon-log-out"></i></a>
                                </p>
                        </div>
                    </div>
        	</div>
        </div>
    
    
    
    
    
    	
    </div>
    <div id="ichapps-custom-user-bottom" class="text-center">
    
    		<div class="container">
            	<div class="row">
                	<div class="col-md-12">
                    	<ul class="list-inline">
                        	<li><a href="#">About ICHApps</a></li>
                        </ul>
                    </div>
                    <div class="col-md-12 hidden-xs">
                    	<ul class="list-inline ichapps-custom-user-bottom-links">
                        	<li><a href="#">Wholesalers</a></li> | 
                            <li><a href="#">Manufacturers</a></li> |
                            <li><a href="#">Trade Shows</a></li> |
                            <li><a href="#">Contact Us</a></li>
                        </ul>
                    </div>
                    <div class="col-md-12 hidden-xs">
                    	<ul class="list-inline ichapps-custom-user-bottom-links">
                        	<li><a href="#">Terms of Use</a></li> | 
                            <li><a href="#">Privacy Policy</a></li> |
                            <li><a href="#">Advertise With Us</a></li> |
                            <li><a href="#">Testimonials</a></li>
                        </ul>
                    </div>
                </div>
            </div>
    
    </div>
  	</div>
   