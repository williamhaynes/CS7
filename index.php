<?
define('INCLUDE_DIR', dirname(__FILE__) . '/inc/');
$rules = array(
    //
    //main pages
    //
    'clubPage' => "/clubPage",
    'clubsAndSocietiesPage' => "/clubsAndSocietiesPage",
    'healthAndWellbeingPage' => "/healthAndWellbeingPage",
    'mapPage' => "/mapPage",
    'clubPage' => "/clubPage/(?'clubID'[\w\-]+)",
    '/Forms/clubAdminForm' => "/clubAdminForm",
    //
    //user auth pages
    //
    'loginPage' => "/loginPage",
    'logoutPage' => "/logoutPage",
    'registerPage' => "/registerPage",
    'userDetailsPage' => "/userDetailsPage",
    //
    // Home Page
    //
    'home' => "/",
    'AdminPages/usersAdminPage' => '/usersAdminPage',
    //
    // Forms Page
    //
    //'/Forms/clubAdminForm' => "/Forms/clubAdminForm",
    '/Forms/eventsForm' => "/eventsForm",
    '/Forms/healthAndWellbeingForm' => "/healthAndWellbeingForm",
    '/Forms/mapForm' => "/mapForm",

);
$uri = rtrim(dirname($_SERVER["SCRIPT_NAME"]), '/');
$uri = '/' . trim(str_replace($uri,
        ''
        , $_SERVER['REQUEST_URI']), '/');

$uri = urldecode($uri);

//echo $_SERVER['REQUEST_URI'];
foreach ($rules as $action => $rule) {
    if (preg_match('~^' . $rule . '$~i', $uri, $params)) {
        include(INCLUDE_DIR . $action . '.php'/*.$params*/);
        exit();
    }
}
// nothing is found so handle the 404 error
include(INCLUDE_DIR . '404.php');
?>