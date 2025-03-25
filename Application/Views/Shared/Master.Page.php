<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title><?php echo $Title; ?></title>
		<meta name="application-name" content="<?php echo $Application; ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link async rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link async href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" type="text/css">

		<link rel="shortcut icon" href="<?php echo $View->SharedImagesContext('favicon.ico'); ?>" type="image/ico" />

		<?php $View->Partial('meta'); ?>

		<link href="<?php echo $View->SharedStylesContext('app.css'); ?>" rel="stylesheet" media="screen">
		<?php $View->Partial('styles'); ?>
		<?php $View->Partial('head'); ?>
	</head>
	<body>

		<?php $View->Partial('body'); ?>

		<script src="<?php echo $View->PublicVendorContext('Dandelion/dandelion.js'); ?>"></script>
		<script src="<?php echo $View->PublicVendorContext('Dandelion/dandelion.mvc.js'); ?>"></script>

		<script src="<?php echo $View->ScriptsContext('app.js'); ?>"></script>
		<?php $View->Partial('scripts'); ?>
	</body>
</html>