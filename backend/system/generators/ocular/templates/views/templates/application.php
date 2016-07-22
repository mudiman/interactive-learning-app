<html>
<head>
	<title><?= $page_title ?></title>
	<?= stylesheet_link_tag(); ?>
</head>
<body>
	
    <?= $this->ocular->yield(); ?>
	
</body>
</html>
