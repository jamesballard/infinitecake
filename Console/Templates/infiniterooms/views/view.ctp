<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<div class="<?php echo $pluralVar; ?> view">
<h2 class="pull-left"><?php echo "<?php  echo __('{$singularHumanName}'); ?>"; ?></h2>
<?php echo "<?php echo \$this->element('Buttons/action', array(
        'id' => \${$singularVar}['{$modelClass}']['{$primaryKey}'],
        'customer_id' => 1,
        'current_user' => \$current_user,
        'delete' => false,
        'offset' => true
    ));
    ?>";
?>
    <dl class="dl-horizontal">
<?php
foreach ($fields as $field) {
	$isKey = false;
	if (!empty($associations['belongsTo'])) {
		foreach ($associations['belongsTo'] as $alias => $details) {
			if ($field === $details['foreignKey']) {
				$isKey = true;
				echo "\t\t<dt><?php echo __('" . Inflector::humanize(Inflector::underscore($alias)) . "'); ?></dt>\n";
				echo "\t\t<dd class=\"clearfix\">\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t\t&nbsp;\n\t\t</dd>\n";
				break;
			}
		}
	}
	if ($isKey !== true) {
		echo "\t\t<dt><?php echo __('" . Inflector::humanize($field) . "'); ?></dt>\n";
		echo "\t\t<dd class=\"clearfix\">\n\t\t\t<?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>\n\t\t\t&nbsp;\n\t\t</dd>\n";
	}
}
?>
<?php
if (!empty($associations['hasOne'])) :
	foreach ($associations['hasOne'] as $alias => $details): ?>
	<dt><?php echo "<?php echo __('Related " . Inflector::humanize($details['controller']) . "'); ?>"; ?></dt>
	<?php echo "<?php if (!empty(\${$singularVar}['{$alias}'])): ?>\n";
        echo "\t\t<dd><?php echo \$this->Html->link(__('" . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?></li>\n";
    ?>
	<?php echo "<?php endif; ?>\n"; ?>
	<?php
	endforeach;
endif;
if (empty($associations['hasMany'])) {
	$associations['hasMany'] = array();
}
if (empty($associations['hasAndBelongsToMany'])) {
	$associations['hasAndBelongsToMany'] = array();
}
$relations = array_merge($associations['hasMany'], $associations['hasAndBelongsToMany']);
$i = 0;
foreach ($relations as $alias => $details):
	$otherSingularVar = Inflector::variable($alias);
	$otherPluralHumanName = Inflector::humanize($details['controller']);
	?>
    <?php echo "<?php if (!empty(\${$singularVar}['{$alias}'])): ?>\n"; ?>
    <dt><?php echo "<?php echo __('Related " . $otherPluralHumanName . "'); ?>"; ?></dt>
        <dd class="clearfix">
            <ul>
<?php
echo "\t<?php
		foreach (\${$singularVar}['{$alias}'] as \${$otherSingularVar}): ?>\n";
		echo "\t\t<li>\n";
			echo "\t\t\t\t<?php echo \$this->Html->link(\${$otherSingularVar}['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$otherSingularVar}['{$details['primaryKey']}'])); ?>\n";
		echo "\t\t</li>\n";
    echo "\t<?php endforeach; ?>\n";
?>
            </ul>
        </dd>
<?php echo "<?php endif; ?>\n\n"; ?>
<?php endforeach; ?>
    </dl>
</div>
