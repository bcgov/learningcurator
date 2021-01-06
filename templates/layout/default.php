<!DOCTYPE html>
<html lang="en">
<head>
<?= $this->Html->charset() ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title><?= $this->fetch('title') ?> | Learning Curator</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" 
		rel="stylesheet" 
		integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" 
		crossorigin="anonymous">

<link href="/node_modules/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> 

</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg sticky-top bg-dark px-4 shadow-sm">
	<a class="navbar-brand text-light" href="https://cms.learningcurator.ca">
		Curator CMS
	</a>
	<a href="/users/logout">Logout</a>
</nav>

<?= $this->fetch('content') ?>

<script src="//cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" 
		integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" 
		crossorigin="anonymous">
</script>
</body>
</html>