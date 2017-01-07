<?php
// 파일명을 수정합니다.
$type = $_REQUEST["type"];
$table_name = $_REQUEST["table_name"];
// $cur_dir = getcwd();
// $dst_dir = chdir("../files/$table_name");
$relativepath = "../files/$table_name";
$realpath = realpath($relativepath);
if ( $handle = opendir($realpath) ) {
	// echo "Directory handle: $handle <BR>";
	// echo "현재 디렉터리 : $realpath<br/>";
	// echo "현재 디렉터리의 파일목록 <HR>";
	while ( false !== ( $file = readdir($handle) )) { 
		$path_parts = pathinfo($file);
		// echo "dirname : $path_parts[dirname] <br/>";
		// echo "basename : $path_parts[basename] <br/>";
		// echo "filename : $path_parts[filename] <br/>";
		// echo "extension : $path_parts[extension] <br/>";
		$regExp = '/\.jpeg/i';
		$finalWord = '.jpg';
		$output = $path_parts["basename"];
		while(preg_match($regExp, $output)){
			$output = preg_replace($regExp, $finalWord, $output);
			rename($realpath."/".$path_parts["basename"], $realpath."/".$output);
			// echo "output : $output <br/>";
		}
	}
	closedir($handle); 
}
echo '<script>alert("수정완료");</script>';
?>
