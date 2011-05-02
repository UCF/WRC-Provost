<?php
/*
Template Name Posts: Diane Chase
*/
?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<!--[if IE]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<style>article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section {display: block;}</style>
		<![endif]-->
		
		<title><?php the_title()?></title>
		<?php thematic_create_contenttype();?>
		<meta name="description" content="Updates from the Office of the Provost at the University of Central Florida.">
		<link rel='stylesheet' type='text/css' href='http://universityheader.ucf.edu/bar/css/bar.css' media='all' />
		<link rel="shortcut icon" href="<?=PROVOST_IMG_URL?>/favicon.ico">
		<?php thematic_create_stylesheet();?>
	</head>
	<!--[if IE 7 ]><body class="ie7 ie"><![endif]-->
	<!--[if IE 8 ]><body class="ie8 ie"><![endif]-->
	<!--[if IE 9 ]><body class="ie9 ie"><![endif]-->
	<!--[if (gt IE 9)|!(IE)]><!--><body><!--<![endif]-->
		<?php the_post();?>
		<div id="updates">
			<div id="header">
				<h1>Provost&#146;s Update</h1>
				<div class="end"><!-- --></div>
			</div>
			
			<div id="content">
				
				<?php the_content();?>
				
				<p>Sincerely,</p>
				<img src="<?=PROVOST_IMG_URL?>/signature-chase.gif" alt="signature" />
				<br>Diane Z. Chase, Ph.D.
				<br>Interim Provost and Vice President
			</div>
			
			<div id="sidebar">
				<div class="date"><?=date('l, F j, Y', strtotime($post->post_title))?></div>
				<div id="contact">
					<h2><a href="#">Contact&nbsp;the&nbsp;Provost</a></h2>
					<a id="feedback" href="#">For questions or comments</a>
				</div>
			</div>
			<div class="end"><!-- --></div>
			
			<div id="footer">
				<ul>
					<li class="first">University of Central Florida</li>
					<li>&bull; 4000 Central Florida Blvd</li>
					<li>&bull; Orlando, FL 32816-0065</li>
				</ul>
				<div class="end"><!-- --></div>
				<a href="http://provost.ucf.edu">http://provost.ucf.edu</a>
			</div>
		</div>
		
		<!-- Footer Scripts -->
		<script src="http://universityheader.ucf.edu/bar/js/university-header.js" type="text/javascript" charset="utf-8"></script>
	</body>
</html>