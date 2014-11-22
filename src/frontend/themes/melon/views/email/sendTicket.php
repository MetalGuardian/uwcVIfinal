<?php
/**
 * Author: metal
 * Email: metal
 */
/**
 * @var \event\models\EventOrder $model
 */
?>
You order ticket on your site {siteName}!

You can download your ticket <?= CHtml::link('here', au($model->getTicketUrl())); ?>
