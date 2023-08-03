<?php
if($_GET['type'] == 2) {
	$type = "T-Shirt"; //t-shirt
} elseif($_GET['type'] == 8) {
	$type = "Hat"; //hat
} elseif($_GET['type'] == 11) {
	$type = "Shirt";
} elseif($_GET['type'] == 12) {
	$type = "Pants";
} elseif($_GET['type'] == 17) {
	$type = "Head";
} elseif($_GET['type'] == 18) {
	$type = "Face";
} elseif($_GET['type'] == 19) {
	$type = "Gear";
} elseif($_GET['type'] == 28) {
	$type = "Right Arm";
} elseif($_GET['type'] == 29) {
	$type = "Left Arm";
} elseif($_GET['type'] == 30) {
	$type = "Left Leg";
} elseif($_GET['type'] == 31) {
	$type = "Right Leg";
} elseif($_GET['type'] == 32) {
	$type = "Package";
} elseif($_GET['type'] == 41) {
	$type = "Hair Accessory";
} elseif($_GET['type'] == 42) {
	$type = "Face Accessory";
} elseif($_GET['type'] == 43) {
	$type = "Neck Accessory";
} elseif($_GET['type'] == 44) {
	$type = "Shoulder Accessory";
} elseif($_GET['type'] == 45) {
	$type = "Front Accessory";
} elseif($_GET['type'] == 46) {
	$type = "Back Accessory";
} elseif($_GET['type'] == 47) {
	$type = "Waist Accessory";
} else {
	$type = "?";
}
echo json_encode(array('Type' => $type));
?>