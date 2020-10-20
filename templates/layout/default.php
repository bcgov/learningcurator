<!DOCTYPE html>
<html lang="en">
<head>
<?= $this->Html->charset() ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title><?= $this->fetch('title') ?> | Learning Curator</title>

<!--
<link rel="stylesheet" href="/learning-curator/bootstrap-theme/dist/css/bootstrap-theme.min.css">

Wanna go from getting a 60 on peformance in Lighthouse to a 97? 
	Stop serving the Gov Bootstrap theme and call in Bootstrap via its CDN:

-->
	
<link rel="stylesheet" 
		href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" 
		integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" 
		crossorigin="anonymous">
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css">

<link href="/learning-curator/css/home.css" rel="stylesheet"> 
<link href="/learning-curator/fontawesome/css/all.css" rel="stylesheet"> 


<!-- ****** faviconit.com favicons ****** -->
<link rel="shortcut icon" href="/learning-curator/favicon/favicon.ico">
<link rel="icon" sizes="16x16 32x32 64x64" href="/learning-curator/favicon/favicon.ico">
<link rel="icon" type="image/png" sizes="196x196" href="/learning-curator/favicon/favicon-192.png">
<link rel="icon" type="image/png" sizes="160x160" href="/learning-curator/favicon/favicon-160.png">
<link rel="icon" type="image/png" sizes="96x96" href="/learning-curator/favicon/favicon-96.png">
<link rel="icon" type="image/png" sizes="64x64" href="/learning-curator/favicon/favicon-64.png">
<link rel="icon" type="image/png" sizes="32x32" href="/learning-curator/favicon/favicon-32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/learning-curator/favicon/favicon-16.png">
<link rel="apple-touch-icon" href="/learning-curator/favicon/favicon-57.png">
<link rel="apple-touch-icon" sizes="114x114" href="/learning-curator/favicon/favicon-114.png">
<link rel="apple-touch-icon" sizes="72x72" href="/learning-curator/favicon/favicon-72.png">
<link rel="apple-touch-icon" sizes="144x144" href="/learning-curator/favicon/favicon-144.png">
<link rel="apple-touch-icon" sizes="60x60" href="/learning-curator/favicon/favicon-60.png">
<link rel="apple-touch-icon" sizes="120x120" href="/learning-curator/favicon/favicon-120.png">
<link rel="apple-touch-icon" sizes="76x76" href="/learning-curator/favicon/favicon-76.png">
<link rel="apple-touch-icon" sizes="152x152" href="/learning-curator/favicon/favicon-152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/learning-curator/favicon/favicon-180.png">
<meta name="msapplication-TileColor" content="#FFFFFF">
<meta name="msapplication-TileImage" content="/learning-curator/favicon/favicon-144.png">
<meta name="msapplication-config" content="/learning-curator/browserconfig.xml">
<!-- ****** faviconit.com favicons ****** -->


</head>
<body class="" data-spy="scroll" data-target="#stepnav" data-offset="110">
<?php 
if ( strpos($_SERVER['HTTP_USER_AGENT'], 'rv:11.0')     !== false
&& strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0;')!== false): ?>
<div class="alert alert-warning mb-0 fade show">
	You appear to be using Internet Explorer as your browser. 
	To see the intended user experience, please access this site using 
	<em><a href="/learning-curator/pages/anybrowser">any modern browser</a></em>.
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<?php endif ?>
<nav class="navbar navbar-expand-lg sticky-top bg-white">
	
	<a class="navbar-brand" href="/learning-curator/" style="margin: 0 0 0 20px">
	<img class="animate__animated animate__rotateIn" alt="Logo" height="50" src="/learning-curator/img/curator-rings-logo.svg" width="50">
		Learning Curator
	</a>

	<button class="navbar-toggler " 
		type="button" 
		data-toggle="collapse" 
		data-target="#navbarSupportedContent" 
		aria-controls="navbarSupportedContent" 
		aria-expanded="false" 
		aria-label="Toggle navigation">
		<i class="fas fa-bars"></i>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
	<ul class="navbar-nav mr-auto">
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="pathwaysDropdown" 
			role="button" 
			data-toggle="dropdown" 
			aria-haspopup="true" 
			aria-expanded="false">
				Your Profile
		</a>
		<div class="dropdown-menu" aria-labelledby="pathwaysDropdown">
			<a class="dropdown-item" href="/learning-curator/users/pathways">Pathways</a>
			<a class="dropdown-item" href="/learning-curator/users/bookmarks">Bookmarks</a>
			<a class="dropdown-item" href="/learning-curator/users/claimed">Claimed</a>
			<a class="dropdown-item" href="/learning-curator/users/reports">Reports</a>
		</div>
		</li>
		<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="pathwaysDropdown" 
			role="button" 
			data-toggle="dropdown" 
			aria-haspopup="true" 
			aria-expanded="false">
				All Topics
		</a>
		<div class="dropdown-menu" aria-labelledby="pathwaysDropdown">
			<a class="dropdown-item" href="/learning-curator/categories/view/1">Leadership</a>
			<a class="dropdown-item" href="/learning-curator/categories/view/3">Diversity &amp; Inclusion</a>
			<a class="dropdown-item" href="/learning-curator/categories/view/2">Role Specific</a>
		</div>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="/learning-curator/activities">Latest</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="/learning-curator/pages/howto">How To Use</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="/learning-curator/pages/faq">FAQ</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="/learning-curator/activities/contribute">Contribute</a>
		</li>	
		<?php if(!empty($active)): ?>
		<?php if($active->role_id == 5): ?>
		<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="adminDropdown" 
			role="button" 
			data-toggle="dropdown" 
			aria-haspopup="true" 
			aria-expanded="false">
				View
		</a>
		<div class="dropdown-menu" aria-labelledby="adminDropdown">
			<a class="dropdown-item" href="/learning-curator/pathways">All Pathways</a>
			<a class="dropdown-item" href="/learning-curator/activity-types">Activity Types</a>
			<a class="dropdown-item" href="/learning-curator/activities">All Activities</a>
			<a class="dropdown-item" href="/learning-curator/users/list">All Users</a>
			<a class="dropdown-item" href="/learning-curator/competencies">All Competencies</a>
			<a class="dropdown-item" href="/learning-curator/ministries">All Ministries</a>
			<a class="dropdown-item" href="/learning-curator/categories">All Categories</a>
			<a class="dropdown-item" href="/learning-curator/statuses">All Statuses</a>
			<a class="dropdown-item" href="/learning-curator/tags">All Tags</a>
			
		</div>
		</li>
		<?php endif ?>
		<?php if($active->role_id == 5 || $active->role_id == 2): ?>
        <li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="adminAddDropdown" 
			role="button" 
			data-toggle="dropdown" 
			aria-haspopup="true" 
			aria-expanded="false">
				Add
		</a>
		<div class="dropdown-menu" aria-labelledby="adminAddDropdown">
			<a class="dropdown-item" href="/learning-curator/categories/add">Add a Category</a>
			<a class="dropdown-item" href="/learning-curator/topics/add">Add a Topic</a>
			<a class="dropdown-item" href="/learning-curator/pathways/add">Add a Pathway</a>
			<a class="dropdown-item" href="/learning-curator/activities/add">Add an Activity</a>
			<a class="dropdown-item" href="/learning-curator/tags/add">Add a Tag</a>
			<?php if($active->role_id == 5): ?>
			<a class="dropdown-item" href="/learning-curator/activity-types/add">Add a Type</a>
			<a class="dropdown-item" href="/learning-curator/users/add">Add a User</a>
			<a class="dropdown-item" href="/learning-curator/competencies/add">Add a Competency</a>
			<a class="dropdown-item" href="/learning-curator/ministries/add">Add a Ministry</a>
			<a class="dropdown-item" href="/learning-curator/statuses/add">Add a Status</a>
			<?php endif ?>
		</div>
		</li>
		<?php endif ?>
		<?php endif ?>
	</ul>

	<form method="get" action="/learning-curator/activities/find" class="form-inline my-2 my-lg-0 mr-3">
		<input class="form-control mr-sm-2" type="search" placeholder="Activity Search" aria-label="Search" name="q">
		<button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
	</form>

	</div> <!-- /endof .collapse navbar-collapse -->
</nav>
<div class="container" style="padding-top: 60px;">
<div class="row">
<div class="col">

<?= $this->fetch('content') ?>
</div>
</div>
</div>

<div class="container-fluid bg-white" style="padding-top: 60px;">
<div class="row mt-3">
<div class="col-md-5 mt-3">
<div class="p-3">
	<div><img src="/learning-curator/img/BCID_BCPSA_rgb_pos.jpg" width="400" alt="BC Public Service Agency logo"></div>
	<p>Your personal information is collected by the BC Public Service Agency in accordance with 
		section 26(c) of the Freedom of Information and Protection of Privacy Act for the purposes 
		of managing and administering employee development and training. If you have any questions, 
		submit an AskMyHR request at 
			<a href="https://www.gov.bc.ca/myhr/contact" target="_blank" rel="noopener">
				www.gov.bc.ca/myhr/contact
			</a> 
		or call 250-952-6000.</p>
</div>
</div>
</div>
</div>

</body>
</html>