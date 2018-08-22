<?php
/************************
* Render templtates
* @param array $data
************************/

function render($template, $data = array())
{
	// Updated the render function for more robustness
    $dirlevel = '';
    if(isset($data["levelup"]))
        $levelup = (int) $data["levelup"];
    else
        $levelup = 1;   // Default level

    for($i = 0; $i < $levelup; $i++)
        $dirlevel = $dirlevel . '../';

    $path = $dirlevel . 'templates/' . $template . '.php';

    if (file_exists($path))
    {
        extract($data);
        require($path);
    }
}

// Function for Connecting to database
function connect_db()
{
	// Including database config file
	include("db_config.php");

	if($host == '' || $db_user == '' || $db_pass == '')
		die("ERROR: Database configuration is wrong.");

	if(($conn = mysqli_connect($host, $db_user, $db_pass, $db_name)) === false)
		die('<span style="color: red;">ERROR:</span> Connection failed: ' . mysqli_connect_error($conn));
	else
		return $conn;
}

function validate_form_data($conn, $data)
{
	$data = trim( stripcslashes( htmlspecialchars( strip_tags( str_replace( array('(', ')', '/', '\\'), '', $data)), ENT_QUOTES)));
	return mysqli_real_escape_string($conn, $data);
}

// function for cheking string is number or not
function is_num($num)
{
    $len = strlen($num);
    for($i = 0; $i < $len; $i++)
    {
        if(intval($num[$i]) == 0)
            if(!ctype_digit($num[$i]))
                return false;
    }
    return true;
}

// function for request is ajax or not
// if it's ajax then returns true else
// false
function is_ajax_request()
{
    return isset($_SERVER["HTTP_X_REQUESTED_WITH"]) &&
        $_SERVER["HTTP_X_REQUESTED_WITH"] == 'XMLHttpRequest';
}

function log_request()
{
	if(!isset($_COOKIE["PHPSESSID"]))
	{
		//@ sign is used to supress the php notice.
		@session_start();
		//Redirecting the user to the current page to get the cookie of first timer user
		header('Location: ', $HOME_PAGE . $_SERVER["REQUEST_URI"]);
		return;
		//echo $_COOKIE["PHPSESSID"];
	}
	$sessid = $_COOKIE["PHPSESSID"];
	$conn = connect_db();
	if (!$conn)
	{
		die('Not connected : ' . mysql_error());
	}
	$db_selected = mysql_select_db('styliano', $conn);
	if (!$db_selected)
	{
		die ('Can\'t use styliano : ' . mysql_error());
	}
	$sql = sprintf("INSERT INTO request_logs(Page, UserAgent, SessionId, ReqDate, ReqTime)
		VALUES('%s', '%s', '%s', CURDATE(), CURTIME())", mysql_real_escape_string($_SERVER["PHP_SELF"]),
		mysql_real_escape_string($_SERVER["HTTP_USER_AGENT"]), mysql_real_escape_string($sessid));
	$rs = @mysql_query($sql);
}
?>
