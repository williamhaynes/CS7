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
    //'blog_article' => "/blog/(?'blogID'[\w\-]+)",
    //
    //scripts
    //
    'loginPage' => "/loginPage",
    'logoutPage' => "/logoutPage",
    //
    // Home Page
    //
    'home' => "/",
    //
    // Forms Page
    //
    '/Forms/clubAdminForm' => "/Forms/clubAdminForm",
    '/Forms/eventsForm' => "/Forms/eventsForm",
    '/Forms/healthAndWellbeingForm' => "/Forms/healthAndWellbeingForm",
    '/Forms/mapForm' => "/Forms/mapForm",

);
$uri = rtrim(dirname($_SERVER["SCRIPT_NAME"]), '/');
$uri = '/' . trim(str_replace($uri,
        ''
        , $_SERVER['REQUEST_URI']), '/');

$uri = urldecode($uri);

echo $_SERVER['REQUEST_URI'];
foreach ($rules as $action => $rule) {
    if (preg_match('~^' . $rule . '$~i', $uri, $params)) {
        include(INCLUDE_DIR . $action . '.php'.$params);
        exit();
    }
}
// nothing is found so handle the 404 error
include(INCLUDE_DIR . '404.php');
?>