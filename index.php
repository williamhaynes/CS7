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
    'Forms/clubAdminForm' => "/clubPage/(?'clubID'[\w\-]+)/clubAdminForm",
    'Forms/healthAndWellbeingForm' => "/healthAndWellbeingForm/(?'itemID'[\w\-]+)",
    'Forms/createHealthAndWellbeingForm' => "/createHealthAndWellbeingForm",
    'Forms/createMapForm' => "/createMapForm",
    'Forms/editMapForm' => "/editMapForm/(?'locationID'[\w\-]+)",
    'Forms/deleteMapForm' => "/deleteMapForm/(?'locationID'[\w\-]+)",
    'Forms/verifyHealthAndWellbeingForm' => "/verifyHealthAndWellbeingForm/",
    '/Forms/eventsForm' => "/eventsForm",
    //verifyHealthAndWellbeingForm/{$itemID}
    'scripts/commentBox' => "/commentBox",
    'scripts/commentToDatabase' => "/commentToDatabase",
    '/fileUploadPageClubMedia' => "/fileUploadPageClubMedia",
    'scripts/uploadClubMedia' => "/uploadClubMedia",
    'scripts/viewUploads' => "/viewUploads",
    //'/scripts/locations' => "/locations",
    //
    //user auth pages
    //
    'checkImageFile' => "/checkImageFile",
    'loginPage' => "/loginPage",
    'logoutPage' => "/logoutPage",
    'registerPage' => "/registerPage",
    'userDetailsPage' => "/userDetailsPage/(?'userID'[\w\-]+)",
    //
    // Home Page
    //
    'homePage' => "/",
    'AdminPages/usersAdminPage' => '/usersAdminPage',
    'AdminPages/healthAndWellBeingAdminPage' => '/healthAndWellBeingAdminPage',
    'AdminPages/mapAdminPage' => '/mapAdminPage',
    'verifyHealthAndWellbeingForm' => "/verifyHealthAndWellbeingForm/(?'itemID'[\w\-]+)",
    //
    // Forms Page
    //
    //'/Forms/clubAdminForm' => "/Forms/clubAdminForm",
    'Forms/eventsForm' => "/Forms/eventsForm",
    //'/Forms/healthAndWellbeingForm' => "/Forms/healthAndWellbeingForm",
    'Forms/createClubForm' => "/Forms/createClubForm",


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