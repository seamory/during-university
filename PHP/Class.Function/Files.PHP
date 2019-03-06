<?php
CLASS FILES
{
	private $FILES;
	private $FILE_SIZE;
	private $FILE_TYPE;
	private $FILE_DIR;
	private $UPLOAD_ERROR;
	private $UPLOAD_FILES;
	
	function __construct($fileSize, $fileType, $fileDir)
	{
		$this -> FILE_SIZE = $fileSize * 1024 * 1024;	//UNIT : MB;
		$this -> FILE_TYPE = $fileType;
		$this -> FILE_DIR = $fileDir;
	}
	
	/*
	 *	return the setting of class Files;
	 *	return array;
	 */
	function OutUploadSetting()
	{
		$array['size'] = $this -> FILE_SIZE;
		$array['type'] = $this -> FILE_TYPE;
		$array['dir'] = $this -> FILE_DIR;
		return $array;
	}
	
	/*	
	 *	Get the file(s)
	 */
	function GetFile($files)
	{
		$this -> FILES = $files;
	}
	
	/*	
	 *	return the information of upload files when you not get the attribute of the form
	 *	return array or string;
	 *
	 */
	function OutAllFileInformation()
	{
		$files = $this -> FILES;
		$i = 0;
		if(isset($files) && $files){
			foreach($files as $filesArray){
				if(is_array($filesArray['error']) || sizeof($filesArray['error']) > 1){
					foreach($filesArray['error'] as $key => $val){
						if($val == 0){
							$FILES[$i]['name'] = $filesArray['name'][$key];
							$FILES[$i]['type'] = $filesArray['type'][$key];
							$FILES[$i]['tmp_name'] = $filesArray['tmp_name'][$key];
							$FILES[$i]['size'] = $filesArray['size'][$key];
							$i++;
						}
					}
				}else{
					if($filesArray['error'] == 0){
						$FILES[$i]['name'] = $filesArray['name'];
						$FILES[$i]['type'] = $filesArray['type'];
						$FILES[$i]['tmp_name'] = $filesArray['tmp_name'];
						$FILES[$i]['size'] = $filesArray['size'];
						$i++;
					}
				}
			}
			return $FILES;
		}else{
			return('FILE(S) NOT EXIST!');
		}
	}
	
	/*	
	 *	return the information of upload files when you get the attribute of the form
	 *	return array or string;
	 *
	 */
	function OutTargetFileInformation()
	{
		$filesArray = $this -> FILES;
		$i = 0;
		if(isset($filesArray) && $filesArray){
			if(is_array($filesArray['error']) || sizeof($filesArray['error']) > 1){
				foreach($filesArray['error'] as $key => $val){
					if($val == 0){
						$FILES[$i]['name'] = $filesArray['name'][$key];
						$FILES[$i]['type'] = $filesArray['type'][$key];
						$FILES[$i]['tmp_name'] = $filesArray['tmp_name'][$key];
						$FILES[$i]['size'] = $filesArray['size'][$key];
						$i++;
					}
				}
			}else{
				if($filesArray['error'] == 0){
					$FILES[$i]['name'] = $filesArray['name'];
					$FILES[$i]['type'] = $filesArray['type'];
					$FILES[$i]['tmp_name'] = $filesArray['tmp_name'];
					$FILES[$i]['size'] = $filesArray['size'];
					$i++;
				}
			}
			return $FILES;
		}else{
			return('FILE(S) NOT EXIST!');
		}
	}
	/*	
	 *	Process the upload files when you not get the attribute of the form
	 *	return void
	 *	error 
	 *	0x001	beyond the size
	 * 	0x002	illegal extened file name
	 *	0x003	illegal upload method
	 *	0x004	upload file error
	 *	0x005 	move file failed
	 */
	function ProcessAllUploadFile()
	{
		$files = $this -> FILES;
		$i = 0;
		$j = 0;
		foreach($files as $filesArray){
			if(sizeof($filesArray['error']) > 1 || is_array($filesArray['error'])){
				foreach($filesArray['error'] as $key => $val){
					if($val == 0){
						if(is_uploaded_file($filesArray['tmp_name'][$key])){
							if(!$this -> FILE_TYPE || in_array(array_pop(explode('.',$filesArray['name'][$key])),$this -> FILE_TYPE)){
								if($filesArray['size'][$key] <= $this -> FILE_SIZE){
									$path = $this -> FILE_DIR . '/' . mb_convert_encoding($filesArray['name'][$key],'GBK','UTF-8');
									if(move_uploaded_file($filesArray['tmp_name'][$key], $path)){
										$saveFilesList[$i]['name'] = $filesArray['name'][$key];
										$saveFilesList[$i]['error'] = 0x000;
									}else{
										$saveFilesList[$i]['name'] = $filesArray['name'][$key];
										$saveFilesList[$i]['error'] = 0x005;
									}
								}else{
									$saveFilesList[$i]['name'] = $filesArray['name'][$key];
									$saveFilesList[$i]['error'] = 0x001;
								}
							}else{
								$saveFilesList[$i]['name'] = $filesArray['name'][$key];
								$saveFilesList[$i]['error'] = 0x002;
							}
						}else{
							$saveFilesList[$i]['name'] = $filesArray['name'][$key];
							$saveFilesList[$i]['error'] = 0x003;
						}
					}else{
						$this -> UPLOAD_ERROR[$j]['name'] = $filesArray['name'][$key];
						$this -> UPLOAD_ERROR[$j]['error'] = $val;
					}
					$i++;
					$j++;
				}
			}else{
				if($filesArray['error'] == 0){
					if(is_uploaded_file($filesArray['tmp_name'])){
						if(!$this -> FILE_TYPE || in_array(array_pop(explode('.',$filesArray['name'])),$this ->FILE_TYPE)){
							if($filesArray['size'] <= $this -> FILE_SIZE){
								$path = $this -> FILE_DIR . '/' . mb_convert_encoding($filesArray['name'],'GBK','UTF-8');
								if(move_uploaded_file($filesArray['tmp_name'], $path)){
									$saveFilesList[$i]['name'] = $filesArray['name'];
									$saveFilesList[$i]['error'] = 0x000;
								}else{
									$saveFilesList[$i]['name'] = $filesArray['name'];
									$saveFilesList[$i]['error'] = 0x005;
								}
							}else{
								$saveFilesList[$i]['name'] = $filesArray['name'];
								$saveFilesList[$i]['error'] = 0x001;
							}
						}else{
							$saveFilesList[$i]['name'] = $filesArray['name'];
							$saveFilesList[$i]['error'] = 0x002;
						}
					}else{
						$saveFilesList[$i]['name'] = $filesArray['name'];
						$saveFilesList[$i]['error'] = 0x003;
					}
				}else{
					print_r($filesArray['name']);
					$this -> UPLOAD_ERROR[$j]['name'] = $filesArray['name'];
					$this -> UPLOAD_ERROR[$j]['error'] = $filesArray['error'];
				}
				$i++;
				$j++;
			}
		}
		$this -> UPLOAD_FILES = $saveFilesList;
	}
	
	/*
	 *	Process the upload files when you get the attribute of the form
	 *	return void;
	 *	
	 */
	function ProcessTargetUploadFile()
	{
		$filesArray = $this -> FILES;
		$i = 0;
		$j = 0;
		if(is_array($filesArray['error']) || sizeof($filesArray['error']) > 1){
			foreach($filesArray['error'] as $key => $val){
				if($val == 0){
					if(is_uploaded_file($filesArray['tmp_name'][$key])){
						if(!$this -> FILE_TYPE || in_array(array_pop(explode('.',$filesArray['name'][$key])),$this -> FILE_TYPE)){
							if($filesArray['size'][$key] <= $this -> FILE_SIZE){
								$path = $this -> FILE_DIR . '/' . mb_convert_encoding($filesArray['name'][$key],'GBK','UTF-8');
								if(move_uploaded_file($filesArray['tmp_name'][$key], $path)){
									$saveFilesList[$i]['name'] = $filesArray['name'][$key];
									$saveFilesList[$i]['error'] = 0x000;
								}else{
									$saveFilesList[$i]['name'] = $filesArray['name'][$key];
									$saveFilesList[$i]['error'] = 0x005;
								}
							}else{
								$saveFilesList[$i]['name'] = $filesArray['name'][$key];
								$saveFilesList[$i]['error'] = 0x001;
							}
						}else{
							$saveFilesList[$i]['name'] = $filesArray['name'][$key];
							$saveFilesList[$i]['error'] = 0x002;
						}
					}else{
						$saveFilesList[$i]['name'] = $filesArray['name'][$key];
						$saveFilesList[$i]['error'] = 0x003;
					}
				}else{
					$this -> UPLOAD_ERROR[$j]['name'] = $filesArray['name'][$key];
					$this -> UPLOAD_ERROR[$j]['error'] = $val;
				}
				$i++;
				$j++;
			}
		}else{
			if($filesArray['error'] == 0){
				if(is_uploaded_file($filesArray['tmp_name'])){
					if(!$this -> FILE_TYPE || in_array(array_pop(explode('.',$filesArray['name'])),$this ->FILE_TYPE)){
						if($filesArray['size'] <= $this -> FILE_SIZE){
							$path = $this -> FILE_DIR . '/' . mb_convert_encoding($filesArray['name'],'GBK','UTF-8');
							if(move_uploaded_file($filesArray['tmp_name'], $path)){
								$saveFilesList[$i]['name'] = $filesArray['name'];
								$saveFilesList[$i]['error'] = 0x000;
							}else{
								$saveFilesList[$i]['name'] = $filesArray['name'];
								$saveFilesList[$i]['error'] = 0x005;
							}
						}else{
							$saveFilesList[$i]['name'] = $filesArray['name'];
							$saveFilesList[$i]['error'] = 0x001;
						}
					}else{
						$saveFilesList[$i]['name'] = $filesArray['name'];
						$saveFilesList[$i]['error'] = 0x002;
					}
				}else{
					$saveFilesList[$i]['name'] = $filesArray['name'];
					$saveFilesList[$i]['error'] = 0x003;
				}
			}else{
				print_r($filesArray['name']);
				$this -> UPLOAD_ERROR[$j]['name'] = $filesArray['name'];
				$this -> UPLOAD_ERROR[$j]['error'] = $filesArray['error'];
			}
			$i++;
			$j++;
		}
		$this -> UPLOAD_FILES = $saveFilesList;
	}
	
	/*
	 *	return the upload result
	 *	return array : upload(array), upload_error(array)
	 */
	function ReturnUploadResult(){
		$array['upload'] = $this -> UPLOAD_FILES;
		$array['upload_error'] = $this-> UPLOAD_ERROR;
		return $array;
	}
}
?>