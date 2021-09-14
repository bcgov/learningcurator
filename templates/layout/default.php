<?php
$this->loadHelper('Authentication.Identity');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?= $this->Html->charset() ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title><?= $this->fetch('title') ?> | Learning Curator</title>
	
<link rel="stylesheet" 
		href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" 
		integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" 
		crossorigin="anonymous">

<link href="/css/curator.css" rel="stylesheet"> 

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">


<!-- ****** faviconit.com favicons ****** -->
<link rel="shortcut icon" href="/favicon/favicon.ico">
<link rel="icon" sizes="16x16 32x32 64x64" href="/favicon/favicon.ico">
<link rel="icon" type="image/png" sizes="196x196" href="/favicon/favicon-192.png">
<link rel="icon" type="image/png" sizes="160x160" href="/favicon/favicon-160.png">
<link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96.png">
<link rel="icon" type="image/png" sizes="64x64" href="/favicon/favicon-64.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16.png">
<link rel="apple-touch-icon" href="/favicon/favicon-57.png">
<link rel="apple-touch-icon" sizes="114x114" href="/favicon/favicon-114.png">
<link rel="apple-touch-icon" sizes="72x72" href="/favicon/favicon-72.png">
<link rel="apple-touch-icon" sizes="144x144" href="/favicon/favicon-144.png">
<link rel="apple-touch-icon" sizes="60x60" href="/favicon/favicon-60.png">
<link rel="apple-touch-icon" sizes="120x120" href="/favicon/favicon-120.png">
<link rel="apple-touch-icon" sizes="76x76" href="/favicon/favicon-76.png">
<link rel="apple-touch-icon" sizes="152x152" href="/favicon/favicon-152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/favicon/favicon-180.png">
<meta name="msapplication-TileColor" content="#FFFFFF">
<meta name="msapplication-TileImage" content="/favicon/favicon-144.png">
<meta name="msapplication-config" content="/browserconfig.xml">
<!-- ****** faviconit.com favicons ****** -->


</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg bg-white shadow-sm">
	<a class="navbar-brand" href="/">
		<img alt="Logo" height="50" src="/img/curator-rings-logo.svg" width="50">
		Learning Curator
	</a>
	<?php if(!empty($active)): ?>
	<button class="navbar-toggler " 
		type="button" 
		data-toggle="collapse" 
		data-target="#navbarSupportedContent" 
		aria-controls="navbarSupportedContent" 
		aria-expanded="false" 
		aria-label="Toggle navigation">
			<i class="bi bi-justify"></i>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
	<ul class="navbar-nav mr-auto">
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Profile
		</a>
		<div class="dropdown-menu" aria-labelledby="navbarDropdown">
			<a class="dropdown-item" href="/profile">Your Pathways</a>
			<a class="dropdown-item" href="/profile/claims">Your Claims</a>
			<a class="dropdown-item" href="/profile/reports">Your Reports</a>
			<div class="dropdown-divider"></div>
			<?php echo $this->User->logout('Logout',['class'=>'dropdown-item']) ?>
		</div>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="/categories/index">Topics</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="/questions">FAQ</a>
	</li>

	<?php if($this->Identity->get('role') == 'superuser' || $this->Identity->get('role') == 'curator'): ?>
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="adminDropdown" 
			role="button" 
			data-toggle="dropdown" 
			aria-haspopup="true" 
			aria-expanded="false">
				View
		</a>
		<div class="dropdown-menu" aria-labelledby="adminDropdown">
			<a class="dropdown-item" href="/reports">All Reports</a>
			<a class="dropdown-item" href="/users/index">All Users</a>
			<a class="dropdown-item" href="/pathways">All Pathways</a>
			<a class="dropdown-item" href="/activity-types">Activity Types</a>
			<a class="dropdown-item" href="/activities">All Activities</a>
			<a class="dropdown-item" href="/competencies">All Competencies</a>
			<a class="dropdown-item" href="/ministries">All Ministries</a>
			<a class="dropdown-item" href="/categories">All Categories</a>
			<a class="dropdown-item" href="/statuses">All Statuses</a>
			<a class="dropdown-item" href="/tags">All Tags</a>
			
		</div>
		</li>
		<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="adminAddDropdown" 
			role="button" 
			data-toggle="dropdown" 
			aria-haspopup="true" 
			aria-expanded="false">
				New
		</a>
		<div class="dropdown-menu" aria-labelledby="adminAddDropdown">
			<a class="dropdown-item" href="/categories/add">New Topic Area</a>	
		</div>
		</li>
		<?php endif ?>
	</ul>
	<form method="get" action="/activities/find" class="form-inline my-2 my-lg-0 mr-3">
		<input class="form-control mr-sm-2" type="search" placeholder="Activity Search" aria-label="Search" name="search">
		<button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
	</form>

	 </div><!-- /endof .collapse navbar-collapse -->
	 <?php endif ?>
</nav>


<?= $this->fetch('content') ?>




<div class="container-fluid bg-white py-3">
<div class="row mt-3 justify-content-md-center">
<div class="col-md-8 col-lg-4 mt-3">

	<div class="p-3 m-3 bg-white shadow-sm text-center text-uppercase">
		<span style="color:#999">Brought to you by</span><br>
		<a href="https://learningcentre.gww.gov.bc.ca/" target="_blank" rel="noopener">
			<img height="100" src="/img/lc-logo-wordmark-300x100.png" width="300" alt="Learning Centre logo">
		</a>
	</div>
	<div class="p-3 m-3 bg-white shadow-sm">
	<div><img height="127" src="/img/BCID_BCPSA_rgb_pos.png" width="400" alt="BC Public Service Agency logo"></div>
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