<!DOCTYPE html>
<html>
<head>
<?= $this->Html->charset() ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= $this->fetch('title') ?></title>
<link rel="stylesheet" href="/bootstrap-theme/dist/css/bootstrap-theme.min.css">
<link href="/fontawesome/css/all.css" rel="stylesheet"> 
<!--<link rel="stylesheet" 
	href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" 
	integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" 
	crossorigin="anonymous">
-->
<style>
a { text-decoration: none; }
img {
	height: auto;
	max-width: 100%;
}
.upro,
.upro:hover,
.upro:active { color: #FFF } 
.card {
	border: 0;
}
</style>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg mb-3">
	
	<a class="navbar-brand" href="/" style="font-size: 300%; margin: -20px 0 0 20px">
		<span class="fas fa-map-marker-alt" style="color: rgba(32,87,152,1); margin:-10px 0 0 -10px; transform: rotate(90deg);"></span>
		<span class="fas fa-map-marker-alt" style="color: rgba(71,189,182,1); margin:-10px 0 0 -10px; transform: rotate(90deg);"></span>
		<span class="fas fa-map-marker-alt" style="color: rgba(229,76,59,1); margin:-10px 0 0 -10px; transform: rotate(90deg);"></span>
		<span class="fas fa-map-marker-alt" style="color: rgba(134, 33, 206,1); margin:-10px 0 0 -10px; transform: rotate(90deg);"></span>
	</a>
	<button class="navbar-toggler" 
		type="button" 
		data-toggle="collapse" 
		data-target="#navbarSupportedContent" 
		aria-controls="navbarSupportedContent" 
		aria-expanded="false" 
		aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
	<ul class="navbar-nav mr-auto">

		<?php if(!empty($active)): ?>
		<li class="nav-item">
			<a class="nav-link" href="/users/home"><?= $active->name ?></a>
		</li>
		<?php endif ?>
	<!--	<li class="nav-item">
			<a class="nav-link" href="/">About</a>
		</li>
	-->

		<?php if(!empty($active)): ?>
		<?php if($active->role_id == 5): ?>
		<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" 
			role="button" 
			data-toggle="dropdown" 
			aria-haspopup="true" 
			aria-expanded="false">
				View
		</a>
		<div class="dropdown-menu" aria-labelledby="navbarDropdown">
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
                <li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" 
			role="button" 
			data-toggle="dropdown" 
			aria-haspopup="true" 
			aria-expanded="false">
				Add
		</a>
		<div class="dropdown-menu" aria-labelledby="navbarDropdown">
			<a class="dropdown-item" href="/action-types/add">Add a Type</a>
			<a class="dropdown-item" href="/activities/add">Add an Activity</a>
			<a class="dropdown-item" href="/pathways/add">Add a Pathway</a>
			<a class="dropdown-item" href="/users/add">Add a User</a>
			<a class="dropdown-item" href="/competencies/add">Add a Competency</a>
			<a class="dropdown-item" href="/ministries/add">Add a Ministry</a>
			<a class="dropdown-item" href="/categories/add">Add a Category</a>
			<a class="dropdown-item" href="/statuses/add">Add a Status</a>
			<a class="dropdown-item" href="/tags/add">Add a Tag</a>
		</div>
		</li>
		<?php endif ?>
		<?php endif ?>
	</ul>

	<?php if(!empty($active->role_id) && $active->role_id == 5): ?>
	<form method="get" action="/activities/find" class="form-inline my-2 my-lg-0 mr-3">
		<input class="form-control mr-sm-2" type="search" placeholder="Activity Search" aria-label="Search" name="q">
		<button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
	</form>
	<?php endif ?>
</nav>
<div class="container" style="padding-bottom: 100px;">
<div class="row justify-content-md-center">
<div class="col">
<?= $this->Flash->render() ?>
<?= $this->fetch('content') ?>
</div>
</div>
</div>
<div class="container-fluid mt-3 bg-white" style="padding-top: 60px;">
<div class="row mt-3">
<div class="col-4 mt-3">
<div class="alert alert-light">
<div><img src="/img/BCID_BCPSA_rgb_pos.jpg" width="400" alt="BC Public Service Agency logo"></div>
<p>Your personal information is collected by the BC Public Service Agency in accordance with section 26(c) of the Freedom of Information and Protection of Privacy Act for the purposes of managing and administering employee development and training. If you have any questions, submit an AskMyHR request at www.gov.bc.ca/myhr/contact or call 250 952-6000.</p>
</div>
</div>
</div>
</div>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
	integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
	crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/js/bootstrap.min.js" 
	integrity="sha384-3qaqj0lc6sV/qpzrc1N5DC6i1VRn/HyX4qdPaiEFbn54VjQBEU341pvjz7Dv3n6P" 
	crossorigin="anonymous"></script>

<script>

$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});
</script>
</body>
</html>
