<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Thumb2 extends CI_Controller {

	protected $_ciDir;
	protected $_cacheDir;
	protected $_cacheKey;
	protected $_cacheFile;
	protected $_file;
	protected $_width;
	protected $_height;
	protected $_crop;

	public function __construct()
	{
		parent::__construct();

		$this->config->load('thumb');
		$config = $this->config->item('thumb');

		$this->_ciDir		= $config['ciDir'];
		$this->_cacheDir	= $_SERVER['DOCUMENT_ROOT'] . $config['cacheDir'];
		$this->_width		= $config['width'];
		$this->_height		= $config['height'];
		$this->_crop		= $config['crop'];
	}
	
	public function view()
	{
		$uri = $this->uri->segment_array();
		$params = $this->uri->uri_to_assoc();

		if (!isset($params['src'])) $this->_error('No image supplied');

		$params = array_slice($params, 0, array_search('src', array_keys($params)), true); //Just get the params we're interested in

		if (!isset($params['w'])) $params['w'] = $this->_width;
		if (!isset($params['h'])) $params['h'] = $this->_height;
		if (!isset($params['c'])) $params['c'] = $this->_crop;

		$params['src'] = str_replace('../', '', $this->_ciDir . implode('/', array_slice($uri, array_search('src', $uri))));

		$this->_cacheKey = md5(implode('_', $params)); //Create the filename for the cached image
		$this->_cacheFile = $this->_cacheDir . '/' . $this->_cacheKey; //The path to the cached image
		$this->_file =  $_SERVER['DOCUMENT_ROOT'] . $params['src']; //The path to the source image

		if (!file_exists($this->_file)) $this->_error('Source image does not exist');

		if (!is_dir($this->_cacheDir)) mkdir($this->_cacheDir, 0755); //Check for cache directory

		if (!file_exists($this->_cacheFile) || filemtime($this->_file) > filemtime($this->_cacheFile))
		{
			//Create cached image
			$cacheFile = $this->_create_image($params['w'], $params['h'], (boolean) $params['c']);
		}

		//Get some image properties
		$img = getimagesize($this->_cacheFile);

		//Serve image
		header ('Content-Type: ' . $img['mime']);
		header ('Accept-Ranges: bytes');
		header ('Last-Modified: ' . filemtime($this->_cacheFile));
		header ('Content-Length: ' . filesize($this->_cacheFile));
		header ('Cache-Control: max-age=9999, must-revalidate');

		readfile ($this->_cacheFile);

		exit();
	}

	/**
	 * Check for a valid image mime type
	 *
	 * @param string $mime The image mime type
	 * @return bool
	 */
	protected function _valid_src_mime_type($mime)
	{
		if (preg_match("/jpg|jpeg|gif|png/i", $mime)) return true;

		return false;
	}

	/**
	 * Display an error message and quit the script
	 *
	 * @param string $error
	 */
	protected function _error($error)
	{
	    header('HTTP/1.1 400 Bad Request');
	    
		die($error);
	}

	/**
	 * Resize and crop or scale an image
	 *
	 * @param int		$srcWidth		The desired width of the new image
	 * @param int		$srcHeight		The desired height of the new image
	 * @param bool		$crop			Whether to crop or scale the image
	 * @return bool
	 */
	protected function _create_image($newWidth, $newHeight, $crop)
	{
		//Get some image properties
		$src = getimagesize($this->_file);
		$srcWidth = $src[0];
		$srcHeight = $src[1];

		//Prevent silly dimensions
		if ($newWidth  > $srcWidth)  $newWidth  = $srcWidth;
		if ($newHeight > $srcHeight) $newHeight = $srcHeight;

		if (!$this->_valid_src_mime_type($src['mime'])) $this->_error('Source is not an image');

		//We'll be using the CI image library
		$this->load->library('image_lib');
		ini_set('memory_limit', '128M');

		//If new dimensions are larger than current, do nothing
        if ($newWidth >= $srcWidth && $newHeight >= $srcHeight) return;

		$srcRatio = $srcWidth / $srcHeight;
		$newRatio = $newWidth / $newHeight;

		//Create a copy
		copy($this->_file, $this->_cacheFile);

		//Do we need to crop the image?
        if ($srcRatio != $newRatio && $crop == true)
		{
			//Work out which way to crop
			$cmpX = $srcWidth / $newWidth;
			$cmpY = $srcHeight / $newHeight;

			if ($cmpX > $cmpY)
			{
				$divider = $srcRatio / $newRatio;

				//Maintain height
				$config['width'] = floor($srcWidth / $divider);
				$config['x_axis'] = floor(($srcWidth - $config['width']) / 2);

				$config['height'] = $srcHeight;
				$config['y_axis'] = 0;
			}
			else
			{
				$divider = $newRatio / $srcRatio;
				
				//Maintain width
				$config['height'] = floor($srcHeight / $divider);
				$config['y_axis'] = floor(($srcHeight - $config['height']) / 2);

				$config['width'] = $srcWidth;
				$config['x_axis'] = 0;
			}

			$config['source_image'] = $this->_cacheFile;
           		$config['maintain_ratio'] = false;

			$this->image_lib->initialize($config);

			//Crop the image
			if (!$this->image_lib->crop()) $this->_error($this->image_lib->display_errors());

			$this->image_lib->clear();
		}

		$config = array();

		//Set up the new image properties
		$config['source_image'] = $this->_cacheFile;
		$config['width'] = $newWidth;
		$config['height'] = $newHeight;

		$this->image_lib->initialize($config);

		//Resize the image
		if (!$this->image_lib->resize()) $this->_error($this->image_lib->display_errors());

		$this->image_lib->clear();

		//The image is ready!
		return true;
	}
}

/* End of file thumb.php */
/* Location: ./application/controllers/thumb.php */
