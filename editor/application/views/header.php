<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<meta name="author" content="Szabo Gergely">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<title>Home</title>
	<base href="<?= base_url(); ?>"/>

	<!-- STYLES -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.2/css/bootstrap.min.css"
		  integrity="sha512-b2QcS5SsA8tZodcDtGRELiGv5SaKSk1vDHDaQRda0htPYWZ6046lr3kJ5bAAQdpV2mmA/4v0wQF9MyU6/pDIAg==" crossorigin="anonymous" referrerpolicy="no-referrer"/>

	<!-- SCRIPTS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
			crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.2/js/bootstrap.min.js"
			integrity="sha512-WW8/jxkELe2CAiE4LvQfwm1rajOS8PHasCCx+knHG0gBHt8EXxS6T6tJRTGuDQVnluuAvMxWF4j8SNFDKceLFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<!-- /STYLES -->

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
			aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
				<a class="nav-link" href="<?= site_url(); ?>">Naptár</a>
			</li>
			<li class="nav-item active">
				<a class="nav-link" href="<?= site_url("basic"); ?>">Alapadatok</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?= site_url("init"); ?>">ReStart</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?= site_url("export"); ?>">Export</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="<?= site_url("debug"); ?>">debug</a>
			</li>
		</ul>
	</div>
</nav>
<!-- WRAPPER ALL -->

