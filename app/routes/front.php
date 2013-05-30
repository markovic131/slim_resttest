<?php

$app->get('/share', function () use ($app) {

	$app->render('share.php');
	
});

$app->get('/getCoupon', function () use ($app) {

	$app->render('coupon.php');
	
});
