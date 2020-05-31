<!DOCTYPE html>
<html lang="en">
<head>
<?= $this->Html->charset() ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= $this->fetch('title') ?></title>

<link rel="stylesheet" href="/bootstrap-theme/dist/css/bootstrap-theme.min.css">

<!--
	Wanna go from getting a 60 on peformance in Lighthouse to a 97? 
	Stop serving the Gov Bootstrap theme and call in Bootstrap via its CDN: 
	<link rel="stylesheet" 
			href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" 
			integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" 
			crossorigin="anonymous">
-->

<link href="/css/home.css" rel="stylesheet"> 
<link href="/fontawesome/css/all.css" rel="stylesheet"> 

</head>
<body class="bg-light" data-spy="scroll" data-target="#stepnav" data-offset="110">

<nav class="navbar navbar-expand-lg" style="background-color: #FFF;">
	
	<a class="navbar-brand" href="/" style="margin: 0 0 0 20px">
	<img alt="" height="50" src="/img/curator-rings-logo.png" width="50">
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

		<li class="nav-item">
			<a class="nav-link" href="/users/home">Your Profile</a>
		</li>

		<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="pathwaysDropdown" 
			role="button" 
			data-toggle="dropdown" 
			aria-haspopup="true" 
			aria-expanded="false">
				Pathways
		</a>
		<div class="dropdown-menu" aria-labelledby="pathwaysDropdown">
			<a class="dropdown-item" href="/categories/view/1">Leading Self</a>
			<a class="dropdown-item" href="/categories/view/2">Leading Others</a>
			<a class="dropdown-item" href="/categories/view/3">Leading Organizations</a>
		</div>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="/activities">Latest</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="/pages/faq">FAQ</a>
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
			<a class="dropdown-item" href="/pathways">All Pathways</a>
			<a class="dropdown-item" href="/activity-types">Activity Types</a>
			<a class="dropdown-item" href="/activities">All Activities</a>
			<a class="dropdown-item" href="/users">All Users</a>
			<a class="dropdown-item" href="/competencies">All Competencies</a>
			<a class="dropdown-item" href="/ministries">All Ministries</a>
			<a class="dropdown-item" href="/categories">All Categories</a>
			<a class="dropdown-item" href="/statuses">All Statuses</a>
			<a class="dropdown-item" href="/tags">All Tags</a>
			
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
			<a class="dropdown-item" href="/pathways/add">Add a Pathway</a>
			<a class="dropdown-item" href="/activities/add">Add an Activity</a>
			<!--<a class="dropdown-item" href="/activity-types/add">Add a Type</a>-->
			<a class="dropdown-item" href="/tags/add">Add a Tag</a>
			<!--<a class="dropdown-item" href="/users/add">Add a User</a>
			<a class="dropdown-item" href="/competencies/add">Add a Competency</a>
			<a class="dropdown-item" href="/ministries/add">Add a Ministry</a>
			<a class="dropdown-item" href="/categories/add">Add a Category</a>
			<a class="dropdown-item" href="/statuses/add">Add a Status</a>-->
			
		</div>
		</li>
		<?php endif ?>
		<?php endif ?>
	</ul>

	<form method="get" action="/activities/find" class="form-inline my-2 my-lg-0 mr-3">
		<input class="form-control mr-sm-2" type="search" placeholder="Activity Search" aria-label="Search" name="q">
		<button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
	</form>

	</div> <!-- /endof .collapse navbar-collapse -->
</nav>

<?= $this->fetch('content') ?>


<div class="container-fluid mt-3 bg-white" style="padding-top: 60px;">
<div class="row mt-3">
<div class="col-md-5 mt-3">
<div class="alert alert-light">
	<div><img src="/img/BCID_BCPSA_rgb_pos.jpg" width="400" alt="BC Public Service Agency logo"></div>
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