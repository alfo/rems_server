<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript">
	$(function() {
		setInterval(loadImage, 5000);
	});

	function loadImage() {
		d = new Date();
		$('#image').attr("src", "graph.php?"+d.getTime());
	}
</script>
<style type="text/css">
	body { background: black; }
	img { width: 100%; height: auto; }
</style>

<img id="image" src="graph.php">