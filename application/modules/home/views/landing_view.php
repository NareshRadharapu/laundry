
<style>

</style>

    <div id="ichapps-custom-landing-topbar">
    	<div class="container">
        <div class="row">
        	<div class="col-md-12">
            <div class="pull-right">
       		 <ul class="list-inline ichapps-custom-margin-bottom-none" id="ichapps-custom-landing-user-links">
             
             <?php if(isset($UserFirstName) && $UserFirstName!='') { ?>
             <li>Hi <strong><?php echo $UserFirstName." ".$UserLastName ?></strong></li>
             <li><a href="<?php echo base_url() ?>logout.html">Logout</a></li>
             <?php } else { ?>
             
              <li class="ichapps-custom-tooltip" data-toggle="tooltip" data-placement="bottom" title="If not a member Join us here"><a href="<?php base_url() ?>join.html">Join Now</a></li> |
              <li class="ichapps-custom-tooltip" data-toggle="tooltip" data-placement="bottom" title="Already a member Sign in here"><a href="<?php base_url() ?>login.html">Sign In</a></li>
              <?php } ?>
           	 </ul>
             </div>
            </div>
        </div>
        </div>
    </div>
    
 <div id="cstm-work-link" data-toggle="modal" data-target="#videoModal" data-theVideo="http://www.youtube.com/embed/HiIXO7FCEmg"><i class="fa fa-video-camera"></i> <span class="hidden-sm hidden-xs">About &nbsp;ICHAPPS &nbsp;</span></div>     
    <div class="container" id="ichapps-custom-landing-main">
        <div class="row">
        	<div class="col-md-12 text-center">
            	<div class="ichapps-custom-margin-top-thirty" id="ichapps-custom-landing-logo"><img src="<?php echo base_url() ?>public/images/logo/logo.png" align="ICH-APPS" class=""></div>
                <div> An International Health Care and Pharmaceutical Applications.</div>
            </div>
        </div>
        
        <div class="row">
        	<div class="col-md-6 col-md-offset-3" id="ichapps-custom-google-custom-search">
            	<script>
				  (function() {
					var cx = '012129101284493678780:tqxmsap6rsi';
					var gcse = document.createElement('script');
					gcse.type = 'text/javascript';
					gcse.async = true;
					gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
						'//www.google.com/cse/cse.js?cx=' + cx;
					var s = document.getElementsByTagName('script')[0];
					s.parentNode.insertBefore(gcse, s);
				  })();
				</script>
				<gcse:search></gcse:search>
            </div>
        </div>
        
        <div class="row">
        	<div class="col-md-5 col-md-offset-1">
            	<a href="<?php echo ICHAPPS_HEALTHCARE_SUBDOMAIN ?>" class="ichapps-custom-landing-link">
                <div class="ichapps-custom-landing-img-div ichapps-custom-margin-top-thirty">
                <img src="<?php echo base_url() ?>public/images/landing/ichapp-health-care.jpg" alt="ICH-APPS-LANDING-HEALTH-CARE" class="img-responsive">
                <div>Health Care</div>
                </div>
                </a>
            </div>
            <div class="col-md-5">
            	<a href="<?php echo ICHAPPS_PHARAMACEUTICAL_SUBDOMAIN ?>" class="ichapps-custom-landing-link">
            	<div class="ichapps-custom-landing-img-div ichapps-custom-margin-top-thirty">
                <img src="<?php echo base_url() ?>public/images/landing/ichapp-pharmaceutical.jpg" alt="ICH-APPS-LANDING-PHARMACEUTICAL" class="img-responsive">
                <div>Pharamaceutical</div>
                </div>
                </a>
            </div>
        </div>
        
        <div class="row">
        	<div class="col-md-4 col-md-offset-4">
            	<a href="<?php base_url() ?>contactus.html">
                <div class="ichapps-custom-margin-top-thirty text-center ichapps-custom-tooltip" id="ichapps-custom-landing-conatct-link"  data-toggle="tooltip" data-placement="top" title="Need any assistance? Click me">Contact Us</div>
                </a>
            </div>
        </div>
    
    </div>
    
    
    <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <div>
                    <iframe width="100%" height="350" src=""></iframe>
                </div>
            </div>
        </div>
    </div>
	</div>
    
  