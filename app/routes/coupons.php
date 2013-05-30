<?php 

//use RedBean_Facade as R;

$app->get('/', function () use ($app) {

	$app->render('app.php');

});

/**
 * Get all or one Coupon
 */
$app->get('/coupons(/:id)', function ($id = '') use ($app) {

	$data['success'] = 0;
	$data['errors'] = array();

	if('' !== $id)
	{
		$data['coupons'] = getOne($id);

		if($data['coupons'])
		{
			$data['success'] = 1;
		}
	}
	else
	{
		$data['coupons'] = getAll();

		if($data['coupons'])
		{
			$data['success'] = 1;
		}
	}

	header('Content-Type: application/json');
	echo json_encode($data);
    exit;
});

/**
 * Show coupon create form
 */
// $app->get('/coupons/create', function () use ($app) {

//     $app->render('coupons/create.php');

// });

/**
 * Create new coupon
 */
// $app->post('/coupons/create', function () use ($app) {

// 	if(create($_POST))
// 	{
// 		$app->redirect('coupons');
// 	}

// });

/////////////////////////////////////////////////////
// ----------------------------------------------- //
/////////////////////////////////////////////////////

// function getAll()
// {
// 	return R::getAll("SELECT * FROM ght_coupons");
// }

// function getOne($id = '')
// {
// 	return R::getRow("SELECT * FROM ght_coupons WHERE id = ? LIMIT 1", array($id));
// }

// function create($data = array())
// {
// 	return R::exec("INSERT INTO ght_coupons (coupon_code) 
// 		VALUES (?)",
// 		array($data['coupon_code']));
// }

// function delete($id = false)
// {
// 	return R::exec("DELETE FROM ght_coupons WHERE id = ?",array($id));
// }