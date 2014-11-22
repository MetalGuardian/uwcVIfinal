<?php
/**
 * Author: metal
 * Email: metal
 */
/**
 * @var \event\widgets\latestEvent\LatestEvent $this
 * @var \event\models\Event[] $models
 */
?>
<div class="container">
	<div class="row">
		<div class="[ col-xs-12 col-sm-offset-2 col-sm-8 ]">
			<ul class="event-list">
				<?php foreach ($models as $data) : ?>
				<li>
					<time datetime="2014-07-20">
						<span class="day"><?= $data->getDate(); ?></span>
						<span class="month"><?= $data->getMonth(); ?></span>
						<span class="year"><?= $data->getYear(); ?></span>
						<span class="time"><?= $data->getTime(); ?></span>
					</time>
					<?= \fileProcessor\helpers\FPM::image($data->image_id, 'event', 'widget', $data->label); ?>
					<div class="info">
						<h2 class="title"><?= $data->label; ?></h2>
						<p class="desc"><?= $data->place; ?></p>
						<ul>
							<li style="width:50%;"><a href="<?= nu($data->getPageUrl()); ?>"><span class="fa fa-globe"></span> to event</a></li>
							<li style="width:50%;"><a href="<?= nu($data->getBuyPageUrl()); ?>"><span class="fa fa-money"></span> $39.99</a></li>
						</ul>
					</div>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>
