<?php $titles = array(
	'Too Drunk, lost your number',
	'You\'ve Reached the rejection hotline...',
	'Two Beers Left',
	'You\'re not using your boobs correctly',
	'You put the lime in the coconut and shake it all up',
	'You\'re code SUCKS!',
	'Shifting paradigms...',
	'There\'s one beer left!',
	'It\'s really hard when your input is only an inch big',
	'It\'s an MVC tree in an MVC tree',
	'Balls deep in HTTP sockets',
	'I couldn\'t find a decent picture of fat models so...',
	'Oh it\'s in my crotch',
	'What happens at CakeFest... STAYS at CakeFest',
	'Angry Jose and Nice Jose',
	'Unless it\'s a video of Gabriel dancing...',
);
$title = $titles[rand(0, count($titles)-1)]; ?>
<?php echo $this->Html->image('layout/logo_header.png', array('alt'=>'CakeFest 2010')); ?>
<h1><?php echo $title;?></h1>