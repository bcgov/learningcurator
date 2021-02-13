<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Step $step
 */


?>
<div class="container-fluid linear">
<div class="row justify-content-md-center">
<div class="col-md-8">

<div class="card">

<?php 
if ( strpos($_SERVER['HTTP_USER_AGENT'], 'rv:11.0')     !== false
&& strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0;')!== false): ?>
<h1>Almost Any Other Browser Will Do</h1>
<div class="alert alert-warning mb-3 fade show">
	You appear to be using Internet Explorer as your browser. 
	To see the intended user experience, read below.

</div>
<?php else: ?>
<h1>IE11 Is No Fun</h1>
<h2>But don't worry, you're not using it!</h2>
<?php endif ?>
<p>As of July 2020, our government-issued computer systems have Internet Explorer 11 (IE11) configured 
as the default browser. This is for a variety of operational and licensing requirements, but IE 11 does not 
provide the required feature-set for a positive, modern web browsing experience. While it is set as the 
default, <strong>IE11 is not your only option</strong>. In the (hopefully) not-too-distant-future, Microsoft's
next-generation browser named "Microsoft Edge" will be the recommended default; but you don't have to wait! 
Edge is already installed on your machine, and you can indeed set it as your default! 
<strong>You're allowed to switch!</strong></p>
<p<strong>To be clear:</strong> if you are using IE11, <em>you're not missing out on any vital features!</em> 
Yet. You will not see certain interface niceties such as animations between screens or progress bars that 
follow you as you scroll down a page. But you can still use this resource in IE 11 and use its full feature set. 
It just won't be as fun :)</p>
<p>If you make the switch, you will likely find that many random errors and issues you had with other 
websites will simply go away!</p>
<div><a href="https://www.microsoft.com/en-ca/microsoft-365/windows/end-of-ie-support" 
		rel="noopener" 
		target="_blank" 
		class="btn btn-block btn-light mb-3">Read Microsoft's IE 11 Message</a>
</div>
<h2>Set Edge As Your Default</h2>
<p>To set Edge as your default and thus be able to take advantage of modern web technologies, 
simply hit your Windows key, start typing "default" and choose "Default Apps" from the results;
scroll down in the settings screen until you see "Web browser," then click on "Internet Explorer."
A list of other browsers that you have installed on your system will appear, including "Microsoft Edge."
Choose Edge from the list, and now that's your default browser for everything.</p>
<h2>Other Browsers</h2>
<ul class="list-group">
<li class="list-group-item"><a href="https://google.com/chrome" rel="noopener" target="_blank">Google Chrome</a> 
(be careful not to sign in to your person Google Account 
when using this browser on work computers)</li>
<li class="list-group-item"><a href="https://getfirefox.com" rel="noopener" target="_blank">Mozilla Firefox</a></li>
<li class="list-group-item">Your mobile device! The Learning Curator is optimized to work on your mobile device</li>
</ul>
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
