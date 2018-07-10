<a href="#" class="scrollup"><i class="fa fa-chevron-circle-up fa-3x"></i></a>

 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url() ?>public/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>public/js/bootstrapValidator.min.js"></script>
    <script src="<?php echo base_url() ?>public/js/jquery.plugin.js"></script>
	<script src="<?php echo base_url() ?>public/js/jquery.realperson.js"></script>
    <script src="<?php echo base_url() ?>public/js/jquery.noty.js"></script>
    <script src="<?php echo base_url() ?>public/js/typeahead.bundle.js"></script>
    <script src="<?php echo base_url() ?>public/js/ichapps-custom.js"></script>
    
    <script>
	autoPlayYouTubeModal();

	  //FUNCTION TO GET AND AUTO PLAY YOUTUBE VIDEO FROM DATATAG
	  function autoPlayYouTubeModal() {
		  var trigger = $("body").find('[data-toggle="modal"]');
		  trigger.click(function () {
			  var theModal = $(this).data("target"),
				  videoSRC = $(this).attr("data-theVideo"),
				  videoSRCauto = videoSRC + "?autoplay=1";
			  $(theModal + ' iframe').attr('src', videoSRCauto);
			  $(theModal + ' button.close').click(function () {
				  $(theModal + ' iframe').attr('src', videoSRC);
			  });
		  });
	  }
	  
	  $( "#cstm-sts-cnt h4" ).each(function() {
		  var h4val = $.trim($(this).text().toLowerCase());
		  
		 var newString = h4val.replace(/[^A-Z0-9]+/ig, "_");
		 
		  $(this).before('<div class="cstm-vis-hid" id="'+newString+'">newString</div>');
		  
		  $('#trms .list').append('<li><a class="jumper" href="#'+newString+'"><i class="fa fa-square-o"></i> '+$(this).text()+'</a></li>')
		  
		  //alert(newString);
	  });
	   $(".jumper").on("click", function( e ) {

        e.preventDefault();

        $("body, html").animate({ 
            scrollTop: $( $(this).attr('href') ).offset().top 
        }, 600);

   	 });
	</script>
  </body>
</html>
