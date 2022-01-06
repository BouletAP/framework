<?php use \BouletAP\Framework\Views; ?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>

    <meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
	<?php foreach(Views::$header_custom_before as $lineBefore): ?>
		<?php echo $lineBefore; ?>
	<?php endforeach; ?>

	<?php foreach(Views::$extra_metas as $meta): ?>
		<meta name="<?php $meta['name']; ?>" content="<?php $meta['content']; ?>" />
	<?php endforeach; ?>

	<?php foreach(Views::$stylesheets as $url): ?>
    	<link rel="stylesheet" href="<?php echo $url; ?>">
	<?php endforeach; ?>

	<?php foreach(Views::$scripts_head as $url): ?>
		<script type="text/javascript"  src="<?php echo $url; ?>"></script>
	<?php endforeach; ?>

	<?php foreach(Views::$header_custom_after as $lineAfter): ?>
		<?php echo $lineAfter; ?>
	<?php endforeach; ?>
	
</head>

<body class="<?php echo Views::$body_classes; ?>">
      
    <?php echo Views::$content; ?>

    <?php foreach(Views::$scripts_footer as $url): ?>
        <script type="text/javascript"  src="<?php echo $url; ?>"></script>
    <?php endforeach; ?>
</body>
</html>
              