<?php

/**
 * Ocular
 *
 * A layout system inspired by the Rails system.
 *
 * @package		Ocular Layout Library
 * @author		Lonnie Ezell
 * @copyright	Copyright (c) 2007, Lonnie Ezell
 * @license		http://creativecommons.org/licenses/LGPL/2.1/
 * @link			http://ocular.googlecode.com
 * @version		0.20
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Ocular Assets Compiler
 *
 * Handles compiling javascript and stylesheet resources into a single
 * file for page display performance reasons.
 *
 * This file is automatically called by the javascript_input_tag and
 * stylesheet_link_tag functions.
 *
 * @package   Ocular Layout Library
 * @subpackage	Assets
 * @category	Controllers
 * @author		Lonnie Ezell
 */

// ------------------------------------------------------------------------

class Assets extends Controller {

/**
 * Assets Class Constructor
 *
 * Loads the Ocular config file.
 *
 * @return  null
 */
function Assets() {
  parent::Controller();

  // Make our Ocular config file available.
  $this->config->load('ocular');
}

// ------------------------------------------------------------------------

/**
 * Index
 *
 * Blocks direct access to the script.
 *
 * @access	public
 * @return  null
 */
function index() { echo 'This path cannot be accessed directly.'; }

// ------------------------------------------------------------------------

/**
 * Stylesheets
 *
 * Takes a series of filenames in the uri, checks to see if they're valid files,
 * and concatenates them into a single file, which is then returned.
 *
 * @access	public
 * @return  string that is the compilation of all stylesheets. 
 */
function stylesheets() {
  // Get our list of files from the uri
  $segments = $this->uri->segment_array();
  
  // Our file contents holder. This aggregates everything into one file.
  $file = '';
  
  foreach ($segments as $segment) {
    $filepath = "./" . $this->config->item('OCU_stylesheet_path') . $segment . ".css";
    if (file_exists($filepath) ) {
      $file .= file_get_contents($filepath);
    }
  }
  echo header('Content-type: text/css');
  echo $file;
}

// ------------------------------------------------------------------------


/**
 * Javascripts
 *
 * Takes a series of filenames in the uri, checks to see if they're valid files,
 * and concatenates them into a single file, which is then returned.
 *
 * @access	public
 * @return  string that is the compilation of all javascripts. 
 */
 
function javascripts() {
  // Get our list of files from the uri
  $segments = $this->uri->segment_array();

  // Our file contents holder. This aggregates everything into one file.
  $file = '';

  foreach ($segments as $segment) {
    $filepath = "./" . $this->config->item('OCU_javascript_path') . $segment . ".js";
    if (file_exists($filepath) ) {
      $file .= file_get_contents($filepath);
    }
  }
  echo header('Content-type: text/javascript');
  echo $file;
}

// ------------------------------------------------------------------------

}

?>
