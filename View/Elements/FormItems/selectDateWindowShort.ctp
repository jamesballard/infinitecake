<?php
echo $this->Form->input('daterange', array(
    'options' => array(
    		'-1 day' => '1 day',
    		'-3 days' => '3 days',
    		'-5 days' => '3 days',
    		'-1 week' => '1 week',
    		'-2 weeks' => '2 weeks',
    		'-3 weeks' => '3 weeks',
    		'-1 month' => '1 month',
    		'-3 months' => '3 months',
    		'-6 months' => '6 months',
    		'-1 year' => '1 year'
    	),
    'default' => '-3 days'
));
?>