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
    'logout' => "scripts/logout",
    //
    // Home Page
    //
    'home' => "/",
    //
    // Forms Page
    //
    'clubAdminForm' => "/Forms/clubAdminForm",
    'eventsForm' => "/Forms/eventsForm",
    'healthAndWellbeingForm' => "/Forms/healthAndWellbeingForm",
    'mapForm' => "/Forms/mapForm",

);
$uri = rtrim(dirname($_SERVER["SCRIPT_NAME"]), '/');
$uri = '/' . trim(str_replace($uri,
        ''
        , $_SERVER['REQUEST_URI']), '/');
$uri = urldecode($uri);
foreach ($rules as $action => $rule) {
    if (preg_match('~^' . $rule . '$~i', $uri, $params)) {
        include(INCLUDE_DIR . $action . '.php');
        exit();
    }
}
// nothing is found so handle the 404 error
include(INCLUDE_DIR . '404.php');
?>