<?php
echo $this->Form->input('daterange', array(
    'options' => array(
    		'-1 day' => '1 day',
    		'-1 week' => '1 week',
    		'-1 month' => '1 month',
    		'-3 months' => '3 months',
    		'-6 months' => '6 months',
    		'-1 year' => '1 year',
    		'-2 years' => '2 years',
    		'-3 years' => '3 years',
    		'-4 years' => '4 years',
    		'-5 years' => '5 years',
    	),
    'default' => '-2 years'
));
?>