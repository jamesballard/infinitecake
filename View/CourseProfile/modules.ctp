<?php

echo $this->DrasticTreeMap->start('treemap','/files/ActivityTreemap.xml',1200,800);
echo $this->DrasticTreeMap->visualize('treemap');

echo $this->Form->input('color', array(
   'options' => array(
                    'Module' => 'Module',
                    'Subject' => 'Subject',
                    'Type' => 'Type'
                  ),
   'onchange' => "treemap.colorColumn([this.options[selectedIndex].value])",
   'label' => 'Colour by: ',
   'default' => 'module'
  )
);

echo $this->Form->input('groupBy', array(
   'options' => array(
                    'Module' => 'Module',
                    'Subject' => 'Subject',
                    'Type' => 'Type'
                  ),
   'onchange' => "treemap.groupByCols([this.options[selectedIndex].value])",
   'label' => 'Group by: ',
   'default' => 'subject'
  )
);

echo $this->Form->input('sizeBy', array(
   'options' => array(
                    'Total' => 'Total Activity',
                    'Users' => 'Unique Users',
                    'Views' => 'Views',
                    'Contributions' => 'Contributions'
                  ),
   'onchange' => "treemap.sizeColumn([this.options[selectedIndex].value])",
   'label' => 'Size by: ',
   'default' => 'total'
  )
);
?>
