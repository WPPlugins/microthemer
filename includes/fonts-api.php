<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Microthemer Fonts API</title>
<?php
// ensure non-cached js
$time = time();
$results_per_page = 7;
// get page num
if (isset($_GET['page'])) {
	$page = htmlentities(intval($_GET['page']));
} else {
	$page = 1;
}
// determine start and end
$start = ($page-1)*$results_per_page;
$end = $start+$results_per_page;

// get sort order
if (isset($_GET['order'])) {
	$order = htmlentities($_GET['order']);
} else {
	$order = 'popularity';
}

$selected = 'selected="selected"';
?>

<style>
	.google-fonts.content-box {
		background:#fff;
		font-family: Arial, Helvetica, sans-serif;
		border:0;
		margin:0;
	}
	.google-fonts .inner-box {
		padding:3px 10px;
	}

	#controls {
		float:left;
		width:200px;
		overflow:hidden;
		padding-top:5px;
	}
	#page-arrows {
		overflow:hidden;
		margin-top:15px;
	}
	#page-arrows a {
		display:inline-block;
		font-size:12px;
		padding-bottom:5px;
		text-decoration:none;
	}
	#prev-page {
		float:left;
	}
	#next-page {
		float:right;
		padding-right:10px;
	}
	#pagination {

		overflow:hidden;
	}
	#pagination ul {
		margin:0;
		padding:0;
		list-style:none;
	}
	#pagination li {
		float:left;
		width:25px;
		margin:0 5px 5px 0;
		border:1px solid #ddd;
		background:#F8F8F8;
		text-align:center;
		font-size:12px;
	}
	#pagination a,
	#pagination span {
		display:block;
		padding:5px 0;
		text-decoration:none;
	}
	#pagination span {
		font-weight:bold;
		background:#222222;
		color:#fff;
	}

	#output ul {
		list-style:none;
		line-height:1.2;
		margin:0 10px 0 220px;
		padding:0;
	}
	#output li {
		border-bottom:1px solid #ddd;
		margin-bottom:5px;
		padding-bottom:10px;
		text-align:right;
	}
	#output li.last {
		border-bottom:0;
		margin-bottom:0;
		padding-bottom:0;
	}
	#output .font {
		font-size:28px;
		color:#222222;
		text-align:left;
		padding-bottom:7px;
	}
	#output .font-name {
		display:block;
		float:left;
		text-align:left;
		font-size:12px;
		font-weight:bold;
		padding-top:4px;
	}
	#output span.link {
		color: #21759B;
		cursor:pointer;
	}
	#output span.link:hover {
		color: #DB6A69;
	}
	#output .font-variants span {
		font-size:12px;
	}
	#output .variant.active {
		font-weight:bold;
	}
</style>
<link id="google-fonts" rel="stylesheet" type="text/css" href=""/>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js" type="text/javascript"></script>

<!-- todo get jQuery reference from parent window, and cache fonts data, so MT doesn't need internet connection -->
<script src="../js-min/fonts.js?v=<?php echo $time; ?>" type="text/javascript"></script>
</head>

<body>

<span id='page-num' rel='<?php echo $page; ?>'></span>
<span id='results-per-page' rel='<?php echo $results_per_page; ?>'></span>
<span id='sort-order' rel='<?php echo $order; ?>'></span>
<span id='start-slice' rel='<?php echo $start; ?>'></span>
<span id='end-slice' rel='<?php echo $end; ?>'></span>

<div class='content-box google-fonts'>

		<div class="inner-box">

		<div id="controls">

			<label for="order">Sort By:</label>
			<select id="order" name="order">
				<option value="popularity" <?php if ($order == 'popularity') echo $selected; ?>>Popularity</option>
				<option value="trending" <?php if ($order == 'trending') echo $selected; ?>>Trending</option>
				<option value="alpha" <?php if ($order == 'alpha') echo $selected; ?>>Alphabetical</option>
				<option value="date" <?php if ($order == 'date') echo $selected; ?>>Date Added</option>
				<option value="style" <?php if ($order == 'style') echo $selected; ?>>Number of Styles</option>
			</select>

			<!--<label for="preview-text">Preview Text:</label>
			<select id="preview-text" name="preview_text">
				<option value="Grumpy wizards make toxic brew for the evil Queen and Jack.">Grumpy wizards make ...</option>
				<option value="The quick brown fox jumps over the lazy dog.">The quick brown fox ...</option>
				<option value="AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz 0123456789">AaBbCcDdEeFfGgHhIiJj...</option>
			</select>-->

			<!--<label for="font-size">Font Size:</label> <input id="font-size" type="text" name="font_size" />px-->

			<div id="page-arrows">
			<?php
			if ($page != 1) {
				?>
				<a href="?page=<?php echo $page-1; ?>&order=<?php echo $order; ?>" id="prev-page">&laquo; Previous</a>
				<?php
			}
			?>
			<a href="?page=<?php echo $page+1; ?>&order=<?php echo $order; ?>" id="next-page">Next &raquo;</a>
			</div>
			<div id="pagination"></div>
		</div>

		<div id="output"></div>

		</div>
	</div>

</body>
</html>
