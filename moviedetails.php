<?php
function getMovie($time, $titles)
{
    if ($time == '6') return $titles['RC'];
    if ($time == '7') return $titles['FO'];
    if ($time == '9' || $time == '4') return $titles['AC'];
    if ($time == '3' || $time == '12') return $titles['CH'];
}

$maxPriceMon_Tue = array(
    'Adult'=>12, 'Conc'=>10, 'Child'=>8, 'FirstClass-Adult'=>25, 'FirstClass-Child'=>20, 'Beanbag'=>20, 'None'=>0
);
$maxPriceWed_Sun = array(
    'Adult'=>18, 'Conc'=>15, 'Child'=>12, 'FirstClass-Adult'=>30, 'FirstClass-Child'=>25, 'Beanbag'=>30, 'None'=>0
);
$rivPriceWed_Fri12 = array( 'Adult'=>12, 'Conc'=>10, 'Child'=>8, 'None'=>0 );
$rivPriceWed_Fri = array( 'Adult'=>18, 'Conc'=>15, 'Child'=>12, 'None'=>0 );
$rivPriceSat_Sun = array( 'Adult'=>18, 'Conc'=>15, 'Child'=>12, 'None'=>0 );
$ticketPrices = array(
        'Maxima'=>array(
            'Monday'=>array('6'=>$maxPriceMon_Tue, '9'=>$maxPriceMon_Tue),
            'Tuesday'=>array('6'=>$maxPriceMon_Tue, '9'=>$maxPriceMon_Tue),
            'Wednesday'=>array('6'=>$maxPriceWed_Sun, '9'=>$maxPriceWed_Sun),
            'Thursday'=>array('6'=>$maxPriceWed_Sun, '9'=>$maxPriceWed_Sun),
            'Friday'=>array('6'=>$maxPriceWed_Sun, '9'=>$maxPriceWed_Sun),
            'Saturday'=>array('3'=>$maxPriceWed_Sun, '6'=>$maxPriceWed_Sun, '9'=>$maxPriceWed_Sun),
            'Sunday'=>array('3'=>$maxPriceWed_Sun, '6'=>$maxPriceWed_Sun, '9'=>$maxPriceWed_Sun)
        ),
        'Rivola'=>array(
            'Wednesday'=>array('12'=>$rivPriceWed_Fri12, '7'=>$rivPriceWed_Fri),
            'Thursday'=>array('12'=>$rivPriceWed_Fri12, '7'=>$rivPriceWed_Fri),
            'Friday'=>array('12'=>$rivPriceWed_Fri12, '7'=>$rivPriceWed_Fri),
            'Saturday'=>array('4'=>$rivPriceSat_Sun, '7'=>$rivPriceSat_Sun),
            'Sunday'=>array('4'=>$rivPriceSat_Sun, '7'=>$rivPriceSat_Sun)
        )
    );
?>
