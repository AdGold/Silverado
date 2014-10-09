<div class="cinema" data-ng-if="cinema=='Maxima'">
	<div class="left">
		<div class="tiltLeft">
			<br>
			<?php 
			for ($row = 0; $row < 4; $row++) {
				for ($i=1; $i < 6; $i++) { 
					$seat = "'" . chr(3-$row+69) . "0" . $i . "'"; ?>
					<div data-ng-class="seatClasses[cinema][<?php echo $seat;?>]" data-ng-click="seatClick(<?php echo $seat;?>)"></div>
				<?php } ?>
				<br class="clear">
			<?php } ?>
		</div>
	</div>
	<div class="centre">
		<?php 
		for ($row = 0; $row < 3; $row++) {
			for ($i=6; $i < 10; $i++) { 
				$seat = "'" . chr(2-$row+69) . "0" . $i . "'"; ?>
				<div data-ng-class="seatClasses[cinema][<?php echo $seat;?>]" data-ng-click="seatClick(<?php echo $seat;?>)"></div>
			<?php if ($i == 7) { ?>
				<div class="nseat"></div>
			<?php }} ?>
			<br class="clear">
		<?php } ?>
	</div>
	<div class="right">
		<div class="tiltRight">
			<br>
			<?php 
			for ($row = 0; $row < 4; $row++) {
				for ($i=10; $i < 15; $i++) { 
					$seat = "'" . chr(3-$row+69) . $i . "'"; ?>
					<div data-ng-class="seatClasses[cinema][<?php echo $seat;?>]" data-ng-click="seatClick(<?php echo $seat;?>)"></div>
				<?php } ?>
				<br class="clear">
			<?php } ?>
		</div>
	</div>
	<br class="clear">
	<div class="bottom">
		<div class="bseat"></div>
		<div class="bseat"></div>
		<div class="bseat"></div>
		<div class="bseat"></div>
		<div data-ng-class="seatClasses[cinema]['D02']" data-ng-click="seatClick('D02')"></div>
		<div data-ng-class="seatClasses[cinema]['D03']" data-ng-click="seatClick('D03')"></div>
		<br class="clear">

		<div class="bseat"></div>
		<div class="bseat"></div>
		<div class="nseat"></div>
		<div data-ng-class="seatClasses[cinema]['D01']" data-ng-click="seatClick('D01')"></div>
		<div class="bseat"></div>
		<div class="bseat"></div>
		<div class="bseat"></div>
		<div data-ng-class="seatClasses[cinema]['D04']" data-ng-click="seatClick('D04')"></div>
		<br class="clear">

		<div class="bseat"></div>
		<div class="bseat"></div>
		<div data-ng-class="seatClasses[cinema]['C01']" data-ng-click="seatClick('C01')"></div>
		<div data-ng-class="seatClasses[cinema]['C02']" data-ng-click="seatClick('C02')"></div>
		<div class="bseat"></div>
		<div class="bseat"></div>
		<div data-ng-class="seatClasses[cinema]['C03']" data-ng-click="seatClick('C03')"></div>
		<div data-ng-class="seatClasses[cinema]['C04']" data-ng-click="seatClick('C04')"></div>
		<br class="clear">

		<div class="bseat"></div>
		<div class="bseat"></div>
		<div class="nseat"></div>
		<div data-ng-class="seatClasses[cinema]['B01']" data-ng-click="seatClick('B01')"></div>
		<div class="bseat"></div>
		<div data-ng-class="seatClasses[cinema]['B02']" data-ng-click="seatClick('B02')"></div>
		<div class="bseat"></div>
		<div data-ng-class="seatClasses[cinema]['B03']" data-ng-click="seatClick('B03')"></div>
		<br class="clear">

		<div class="bseat"></div>
		<div class="bseat"></div>
		<div class="bseat"></div>
		<div class="bseat"></div>
		<div data-ng-class="seatClasses[cinema]['A01']" data-ng-click="seatClick('A01')"></div>
		<div data-ng-class="seatClasses[cinema]['A02']" data-ng-click="seatClick('A02')"></div>
	</div>
	<!--<div class="screenM">Screen (Cinema Maxima)</div>-->
</div>



<br class="clear">
<br class="clear">
<br class="clear">
<br class="clear">


<div class="cinema" data-ng-if="cinema=='Rivola'">
	<?php 
	for ($row = 0; $row < 4; $row++) {
		for ($i=1; $i < 11; $i++) { 
			$seat = "'" . chr(3-$row+65) . sprintf("%02d",$i) . "'"; ?>
			<div data-ng-class="seatClasses[cinema][<?php echo $seat;?>]" data-ng-click="seatClick(<?php echo $seat;?>)"></div>
		<?php if ($i == 5) { ?>
			<div class="nseat"></div>
			<div class="nseat"></div>
		<?php }} ?>
		<br class="clear">
	<?php } ?>

<!--<div class="screenR">Screen (Cinema Rivola)</div>-->
</div>