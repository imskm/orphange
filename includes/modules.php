<?php
/***************************************
* Product Image upload.
***************************************/
function upload_file($fName, $upfName, $fPath, $fExt)
{
    $tmpFile = $_FILES[$fName]["tmp_name"];
    $file_path = $fPath . $upfName . "." . $fExt;		// Leading and trailing '/' must be included in the calling script
    $errors = array();
    ///////////////////////////////////
    ///////////////////////////////////
    // Image Compression is required
    // here
    //////////////////////////////////


	// For debugging purpose
	//print_r($_FILES[$fName]);
	//echo '<br>';
	//print_r($_FILES[$fName]["tmp_name"]);
	//echo '<br>';
	//echo $tmpFile;
	//echo '<br>';
	//echo $file_path;

    if(empty($errors) == true)
	{
		return move_uploaded_file($tmpFile, $file_path);
	}
    else
	{
		return false;
	}
}

function date_diff_year($largeDate, $smallDate)
{
	// NEED impprovement
	$interval = date_diff(date_create($smallDate), date_create($largeDate));
	return intval(intval($interval->format('%a')) / 365);
}

?>
