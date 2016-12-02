<?PHP

// connect to your Azure server and select database (remember you connection details are all on the azure portal
$db = new mysqli(
    "eu-cdbr-azure-north-e.cloudapp.net",
    "b1fa144aa688ff",
    "4e96e436",
    "db_pgo_cs7" );

// test our connection
if ($db->connect_errno) {
    die ('Connection Failed :'.$db->connect_error );
}

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Select all the rows in the markers table

$query = "SELECT * FROM location WHERE 1";
$result = $db->query($query);
if (!$result) {
    die('Nothing in result: ');
}

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

while ($row = $result->fetch_array()){
    // ADD TO XML DOCUMENT NODE
    $node = $dom->createElement("marker");
    $newnode = $parnode->appendChild($node);
    $newnode->setAttribute("name",$row['name']);
    $newnode->setAttribute("address", $row['address']);
    $newnode->setAttribute("lat", $row['lat']);
    $newnode->setAttribute("lng", $row['lng']);
    $newnode->setAttribute("typeID", $row['typeID']);
}

$result->close();
$db->close();

echo $dom->saveXML();

?>
<p>
    Hello World
</p>