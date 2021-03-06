<?php
	error_reporting(E_ERROR | E_WARNING | E_PARSE);

	header('Content-Type: text/html; charset=utf-8');

	define('MOBILE_VERSION', true);

	require_once "../config.php";
	require_once "mobile-functions.php";

	require_once "functions.php";
	require_once "sessions.php";
	require_once "version.php";
	require_once "db-prefs.php";

	$link = db_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	init_connection($link);

	login_sequence($link, true);

	$op = $_REQUEST["op"];

	switch ($op) {
	case "toggleMarked":
		$cmode = db_escape_string($_REQUEST["mark"]);
		$id = db_escape_string($_REQUEST["id"]);

		markArticlesById($link, array($id), $cmode);
		break;
	case "togglePublished":
		$cmode = db_escape_string($_REQUEST["pub"]);
		$id = db_escape_string($_REQUEST["id"]);

		publishArticlesById($link, array($id), $cmode);
		break;
	case "toggleUnread":
		$cmode = db_escape_string($_REQUEST["unread"]);
		$id = db_escape_string($_REQUEST["id"]);

		catchupArticlesById($link, array($id), $cmode);
		break;

	case "setPref":
		$id = db_escape_string($_REQUEST["id"]);
		$value = db_escape_string($_REQUEST["to"]);
		mobile_set_pref($link, $id, $value);
		print_r($_SESSION);
		break;
	default:
		print json_encode(array("error", "UNKNOWN_METHOD"));
		break;
	}
?>

