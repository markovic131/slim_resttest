<?php
//////////////////////////////////////////////////////////////////////
// ------------ CONSTANTS and CONFIGS (export outside) ------------ //
//////////////////////////////////////////////////////////////////////

define('DBHOST', 'localhost');
define('USERNAME', 'root');
define('PASSWORD', 'root');
define('DB', 'gh_fbcoupons');

$appConfig = array(
    'debug'          => true,
    'templates.path' => '../app/templates'
);

if($appConfig['debug']){
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

// Composer autoloader
require '../vendor/autoload.php';

//Instantiate Slim application object
$app = new \Slim\Slim();

$app->config($appConfig);

//////////////////////////////////////
// ------------ ROUTES ------------ //
//////////////////////////////////////

$app->get('/', function () use ($app) {
    $app->render('app.php');
});

$app->get('/sharePage', function () use ($app) {
    $app->render('share.php');
});

$app->get('/getCoupon', function () use ($app) {
    $app->render('coupon.php'); 
});

$app->get('/coupons', 'getCoupons');
$app->post('/coupons', 'createCoupon');
$app->get('/coupons/:id', 'getCoupon');

$app->run();

/////////////////////////////////////////
// ------------ FUNCTIONS ------------ //
/////////////////////////////////////////

/**
 * Get all coupons
 * @return JSON
 */
function getCoupons()
{
    $sql = "SELECT * FROM ght_coupons";
    try {
        $db = DBH();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $db = null;
    } catch(PDOException $e) {
        $data['errors'] = $e->getMessage();
    }

    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
/**
 * Get a coupon by provided $id
 * @param  integer $id
 * @return JSON
 */
function getCoupon($id = 0)
{   
    $sql = "SELECT * FROM ght_coupons WHERE id=:id";
    try {
        $db = DBH();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $data = $stmt->fetchObject();
        $db = null;
    } catch(PDOException $e) {
        $data['errors'] = $e->getMessage();
    }

    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
/**
 * Create a coupon
 * @return JSON
 */
function createCoupon()
{
    $sql = "INSERT INTO ght_coupons(coupon_code) VALUES(:coupon_code)";
    try {
        $db = DBH();
        $stmt = $db->prepare($sql);
        $stmt->execute(array(':coupon_code' => $_POST['coupon_code']));
        $data['success'] = $stmt->rowCount();
        $db = null;
    } catch(PDOException $e) {
        $data['error'] = $e->getMessage();
    }

    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
/**
 * Establish PDO database connection
 * @return Database Handle
 */
function DBH() 
{
    $dbh = new PDO('mysql:host='.DBHOST.';dbname='.DB, USERNAME, PASSWORD);

    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $dbh;
}