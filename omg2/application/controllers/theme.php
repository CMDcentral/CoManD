<?
class Theme extends CI_Controller {

	function __construct() {
	 parent::__construct();
	}

	function index() {
		$this->edit();
	}

	function edit() {
	 $file = $this->input->get('file');
	 $data['title'] = "Template Editor";
	 $data['files'] = $this->_filelist();
	 $data['themes'] = $this->_themelist();
	 $data['filename'] = $file;
	 $data['contents'] = file_get_contents($file);
	 $this->layout->view('theme/edit', $data);
	}

	function _filelist() {
	 $dir = getcwd().get_theme_path();
	 $files = $this->getFilesFromDir($dir);
	 return $files;
	}

	function _themelist() {
	 $dir = getcwd()."/themes/";
	 $handle = opendir($dir);
	 while (false !== ($file = readdir($handle))) {
		if ($file != "." && $file != "..")
			$theme[$file] = $file;
	 }
	 return $theme;
	}

	function save() {
	 $filename = $this->input->post('filename');
	 $contents = $this->input->post('contents');
	 if ($filename != "") {
 	 $myFile = $filename;
	 $fh = fopen($myFile, 'w') or die("can't open file");
	 fwrite($fh, $contents);
	 fclose($fh);
	 message("File updated successfully", "message");
	 }
	 $this->db->where('key', 'theme');
	 $data['value'] = $this->input->post('theme');
	 $this->db->update('settings', $data);
	 redirect(ref());
	}


	function getFilesFromDir($dir) {
	  $files = array();
	  if ($handle = opendir($dir)) {
	    while (false !== ($file = readdir($handle))) {
	        if ($file != "." && $file != ".." && !strpos($dir, "images") && !strpos($dir, "js") ) {
	            if(is_dir($dir.'/'.$file)) {
	                $dir2 = $dir.'/'.$file;
	                $files[] = $this->getFilesFromDir($dir2);
	            }
	            else {
	              $files[] = $dir.'/'.$file;
	            }
	        }
	    }
	    closedir($handle);
	  }
	  return array_flatten($files);
	} 

}
?>
