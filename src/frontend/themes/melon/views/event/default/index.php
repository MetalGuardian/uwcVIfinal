<?php
/**
 * Author: metal
 * Email: metal
 */
/**
 * @var $dataProvider
 */
?>
<div class="container">
	<div class="row">
		<div class="[ col-xs-12 col-sm-offset-2 col-sm-8 ]">
<?php $this->widget(\front\components\ListView::getClassName(),
	array(
		'dataProvider' => $dataProvider,
		'itemView' => '_view',
		'itemsTagName' => 'ul',
		'itemsCssClass' =>  'event-list',
		'template' => '{items} {pager}',
		'enablePagination' => true,
	)
);
?>
			</div>
		</div>
	</div>
