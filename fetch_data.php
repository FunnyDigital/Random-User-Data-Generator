<?php
$servername = "localhost"; // Update if necessary
$username = "patrickc_patrick"; // Your MySQL username
$password = ".Kingkaveli1"; // Your MySQL password
$dbname = "patrickc_patrickdb"; // The database you created
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// List of 21+ African countries where MTN operates or has operated
$countries = [
    'Nigeria', 'Ghana', 'South Africa', 'Uganda', 'Ivory Coast', 'Cameroon', 'Benin', 'Congo-Brazzaville',
    'Rwanda', 'Zambia', 'Swaziland', 'Liberia', 'Guinea-Bissau', 'Guinea', 'Botswana', 'Sudan', 'South Sudan',
    'Syria', 'Yemen', 'Afghanistan', 'Iran'
];

// List of MTN products and services
$products = [
    'Airtime Recharge', 'Data Bundle', 'Mobile Money', 'SIM Card', 'Device Sales', 'MTN TV', 'Value Added Services',
    'International Roaming', 'Business Solutions', 'SMS Bundle', 'Caller Tune', 'Internet Modem', 'Fibre Broadband'
];

// Function to generate random MTN store sales data with occasional missing fields
function generateRandomStoreData($countries, $products) {
    // 10% chance to leave a field empty
    $missing = function($value) {
        return (rand(1, 10) === 1) ? null : $value;
    };

    $country = $missing($countries[array_rand($countries)]);
    $product = $missing($products[array_rand($products)]);
    $sale_amount = $missing(rand(100, 100000)); // Random sales amount in local currency
    // Random date in the last 2 years
    $timestamp = mt_rand(strtotime('-2 years'), time());
    $sale_date = $missing(date('Y-m-d', $timestamp));

    return [
        'country' => $country,
        'product' => $product,
        'sale_amount' => $sale_amount,
        'sale_date' => $sale_date
    ];
}

// Insert new store sales data into the database
$storeData = generateRandomStoreData($countries, $products);
$sql = "INSERT INTO mtn_store_sales (country, product, sale_amount, sale_date) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("ssis", $storeData['country'], $storeData['product'], $storeData['sale_amount'], $storeData['sale_date']);
if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}

// Fetch all store sales data to return
$result = $conn->query("SELECT * FROM mtn_store_sales ORDER BY created_at DESC");
$sales = [];
while ($row = $result->fetch_assoc()) {
    $sales[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($sales);
?>