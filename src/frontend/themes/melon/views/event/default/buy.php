<?php
/**
 * Author: metal
 * Email: metal
 */
/**
 * @var \event\controllers\DefaultController $this
 * @var \event\models\Event $model
 * @var \event\models\EventOrder $buy
 * @var $step
 */
?>
<div class="container">
	<div class="row">
		<div class="[ col-xs-12 col-sm-offset-2 col-sm-8 ]">
			<ul class="event-list">
				<li>
					<time datetime="2014-07-20">
						<span class="day"><?= $model->getDate(); ?></span>
						<span class="month"><?= $model->getMonth(); ?></span>
						<span class="year"><?= $model->getYear(); ?></span>
						<span class="time"><?= $model->getTime(); ?></span>
					</time>
					<?= \fileProcessor\helpers\FPM::image($model->image_id, 'event', 'widget', $model->label); ?>
					<div class="info">
						<h2 class="title"><?= $model->label; ?></h2>
						<p class="desc"><?= $model->place; ?></p>
						<ul>
							<li><a href="<?= nu($model->getPageUrl()); ?>"><span class="fa fa-globe"></span> to event</a></li>
						</ul>
					</div>
				</li>
			</ul>
		</div>
	</div>
</div>

<?= CHtml::beginForm($model->getBuyPageUrl()); ?>
<div class="container">
	<?= CHtml::errorSummary($buy); ?>
	<table id="cart" class="table table-hover table-condensed">
		<thead>
		<tr>
			<th style="width:20%">Product</th>
			<th style="width:10%">Name</th>
			<th style="width:8%">Email</th>
			<th style="width:10%"></th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td data-th="Product">
				<div class="row">
					<div class="col-sm-10">
						<?= CHtml::activeDropDownList($buy, 'ticket_id', $model->getTickets(), array('prompt' => 'select ticket')); ?>
					</div>
				</div>
			</td>
			<td data-th="Name">
				<div class="row">
					<div class="col-sm-10">
						<?= CHtml::activeTextField($buy, 'name'); ?>
					</div>
				</div>
			</td>
			<td data-th="Email">
				<div class="row">
					<div class="col-sm-10">
						<?= CHtml::activeTextField($buy, 'email'); ?>
					</div>
				</div>
			</td>
			<td class="actions" data-th="">
				<?php /*<button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
				<button class="btn btn-info btn-sm"><i class="fa fa-plus"></i></button>*/ ?>
			</td>
		</tr>
		</tbody>
		<tfoot>
		<tr>
			<td><a href="<?= nu($model->getPageUrl()); ?>" class="btn btn-warning"><i class="fa fa-angle-left"></i> Back to event</a></td>
			<td colspan="2" class="hidden-xs">
				Promo code:
				<?= CHtml::activeTextField($buy, 'promo_code'); ?>
				<?= $buy->discount ? 'Discount: $' . $buy->discount : null; ?>
			</td>
			<td class="hidden-xs text-center"><strong><?= $buy->real_price ? 'Total $' . $buy->real_price : null; ?></strong></td>
			<td class="select-step<?= $step; ?>"><input type="submit" class="btn btn-success btn-block" value="Checkout" /></td>
		</tr>
		</tfoot>
	</table>
</div>


<div id="login-overlay" class="modal-dialog order-step<?= $step; ?>">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			<h4 class="modal-title" id="myModalLabel">Order tickets</h4>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-xs-12">
					<div class="well">
							<div class="form-group">
								<label for="username" class="control-label">Card holder name</label>
								<?= CHtml::activeTextField($buy, 'card_name', array('class' => 'form-control')); ?>
								<span class="help-block"></span>
							</div>
							<div class="form-group">
								<label for="password" class="control-label">Card</label>
								<?= CHtml::activeTextField($buy, 'card_code', array('class' => 'form-control')); ?>
								<span class="help-block"></span>
							</div>
							<button type="submit" class="btn btn-success btn-block">Order</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?= CHtml::endForm(); ?>
