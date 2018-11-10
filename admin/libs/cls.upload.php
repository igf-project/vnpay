<?php
class CLS_UPLOAD{
	var $file_name=NULL;
	var $file_type=NULL;
	var $file_size=NULL;
	var $file_error=NULL;
	var $array_type=array('image/jpg','image/jpeg','image/gif','image/png','image/x-png','application/x-shockwave-flash',
	'audio/x-ms-wma','audio/mpeg3','video/avi','application/octet-stream','video/x-ms-wmv','text/plain','application/rar',
	'application/pdf','application/vnd.ms-excel','application/octet-stream','application/msword','text/html',
	'application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/vnd.ms-powerpoint',
	'application/vnd.openxmlformats-officedocument.presentationml.presentation','');

	var $max_size=10000000; // 10MB
	var $_path="";
	
	function CLS_UPLOAD(){}
	function setType($array){
		$this->$array_type=$array;
	}
	function setMaxSize($maxsize){
		$this->$max_size=$maxsize;
	}
	function setPath($path){
		$this->_path=$path;
	}
	function checkType(){
		//echo $this->file_type;
		if(in_array($this->file_type,$this->array_type))
			return true;
		else
			die('die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">File nguồn không tồn tại hoặc không phải định dạng cho phép !. Lỗi tại Image->checkType() for '.$this->file_type.'")');
	}
	function checkSize(){
		if($this->file_size < $this->max_size)
			return true;
		else
			die('die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">File nguồn không quá lớn so với kích thước cho phép!. Lỗi tại Image->checkSize()");');
	}
	function checkError(){
		if($this->file_error==0)
			return true;
		else
			die('die("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">Có lỗi trong quá trình truyền file!. Lỗi tại Image->checkError()'.$this->file_error.'");');
	}
	function checkExistFile(){
		if(file_exists($this->_path.$this->file_name))
			return true;
		else
			return false;
	}
    function rand_string( $length ) {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $size = strlen( $chars );
        $str='';
        for( $i = 0; $i < $length; $i++ ) {
            $str .= $chars[ rand( 0, $size - 1 ) ];
        }
        return $str;
    }
    function renameExit($filename){
        if(file_exists($this->_path.$this->file_name)){
            $temp = explode(".",$filename);
            $newfilename = $temp[0].'_'.$this->rand_string(3).'.'.$temp[1];
            return $newfilename;
        }
        else
            return $filename;
    }
	function NewFile(){
		$this->file_name=date("dnYhis").$this->file_name;
	}
	function SaveFile(){
		move_uploaded_file($this->file_temp,$this->_path.$this->file_name);
	}
	function UploadFile($filename,$patch=''){
		$this->file_name=$_FILES[$filename]["name"];
		$this->file_type=$_FILES[$filename]["type"];
		$this->file_size=$_FILES[$filename]["size"];
		$this->file_error=$_FILES[$filename]["error"];
		$this->file_temp=$_FILES[$filename]["tmp_name"];
        if($patch){
            $this->setPath($patch);
        }
		$this->checkError();
		$this->checkType();
		$this->checkSize();
		$this->file_name=$this->renameExit($this->file_name);
		$this->checkExistFile();

		$this->SaveFile();
		$file=$this->file_name;
		return $file;
	}
    function UploadFileRename($filename,$patch=''){
        $this->file_name=$_FILES[$filename]["name"][0];
        $this->file_type=$_FILES[$filename]["type"][0];
        $this->file_size=$_FILES[$filename]["size"][0];
        $this->file_error=$_FILES[$filename]["error"][0];
        $this->file_temp=$_FILES[$filename]["tmp_name"][0];
        $this->setPath($patch);
        $this->checkError();
        $this->checkType();
        $this->checkSize();
        $this->file_name=$this->renameExit($this->file_name);
        $this->SaveFile();
        $file=$this->file_name;
        return $file;
    }
    function UploadFiles($filename,$patch=''){
        $this->file_name=$_FILES[$filename]["name"][0];
        $this->file_type=$_FILES[$filename]["type"][0];
        $this->file_size=$_FILES[$filename]["size"][0];
        $this->file_error=$_FILES[$filename]["error"][0];
        $this->file_temp=$_FILES[$filename]["tmp_name"][0];
        $this->setPath($patch);
        $this->checkError();
        $this->checkType();
        $this->checkSize();
        $this->checkExistFile();
        $this->SaveFile();
        /*$file=$this->_path.$this->file_name;*/
        $file=$this->file_name;
        return $file;
    }

	function SaveDoc($path){
		move_uploaded_file($this->file_temp,$path);
	}
	function UploadFileDoc($filename,$path=''){
		$this->file_name=$_FILES[$filename]["name"];
		$this->file_type=$_FILES[$filename]["type"]; //echo $_FILES[$filename]["type"]; die;
		$this->file_size=$_FILES[$filename]["size"];
		$this->file_error=$_FILES[$filename]["error"];
		$this->file_temp=$_FILES[$filename]["tmp_name"];

		$this->checkError();
		$this->checkType();
		$this->checkSize();
		$this->checkExistFile();
		$this->SaveDoc($path);
	   	return $file;
	}
}
?>