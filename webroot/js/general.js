$(document).ready(function(){
	$('.ajax').live('click', function(){
		$this = $(this);
		if ($this.attr('rel')) {
			$($this.attr('rel')).load($this.attr('href'));
		} else {
			$this.prettyPhoto();
		}
	});
});