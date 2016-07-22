<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

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
 * @version		0.25
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Ocular Layout Helpers
 *
 * @package   Ocular Layout Library
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Lonnie Ezell	
 */

// ------------------------------------------------------------------------

/**
 * Render Partial View
 *
 * Renders a view file into another view. This is intended to be called
 * from a view file.
 *
 * @access	public
 * @return  null
 */

function render_partial($partial = NULL) {
  // Do we have a partial to render?
  if (empty($partial) || (!is_string($partial)) ) { return false; }
  
  // Show the page.
  $obj = &get_instance();
  // Do we have a path specified?
  $loc = strchr($partial, "/");
  if ($loc ) {
    // Replace the last / with /_
    $newLoc = substr_replace($loc, "_", 1, 0 );
    $partial = str_replace($loc, $newLoc, $partial);
    // Show the view
    $obj->load->view($obj->config->item('OCU_template_dir') . "/" .$partial);
  } else {
    // It's in the same directory!
    $obj->load->view(get_active_controller() . '/_' . $partial);
  }
}

// ------------------------------------------------------------------------

/**
* Stylesheet Link Tag
*
* Returns a stylesheet link tag for the sources passed as arguments.
* If no extension is supplied, ".css" is automatically appended.
*
* If no argument is present, it will provide a link to 'application.css'
*
* Media types can be specified by prepending a colon to the media type.
* ie: stylesheet_link_tag("global.css", ":print");
*
* @access    public
* @return    string
*/
function stylesheet_link_tag( ) {
  // Our stylesheet tag
  $tag = '';
  $media ='all';
  
  // Do we have any arguments?
  if ( func_num_args() == 0 ) {
    // No arguments. Return link to 'application.css'.
    $args = ocular::_default_stylesheets();
  }
  
  if (empty($args)) {
    // Get our arguments from the parameters
    $args = func_get_args();
  }

  // Loop through each, adding to stylesheet string
  foreach ($args as $arg) {
      // Is it a media tag?
      if ( stripos($arg, ":") === false ) {
          // Add our tag to the list.
        if (!empty($tag)) { $tag .= "/"; }
        $tag .= $arg;
      } else {
          // It's a media tag.
          $arg = trim($arg, ":");
          $media = $arg;
      }
  }
  
  $CI=& get_instance();
  $module = '';
  if ($CI->config->item('OCU_is_module')) { $module .= "/ocular"; }
  
  return '<link rel="stylesheet" type="text/css" href="'.site_url().$module.'/assets/stylesheets/' .	$tag . '" media="' . $media . '" />' . "\n";
}

// ------------------------------------------------------------------------

/**
 * Javascript Include Tag
 *
 * Returns a javascript include link tag for the sources passed as arguments.
 * If no extension is supplied, ".js" is automatically appended.
 *
 * If no argument is present, it will provide a link to the defaults from the
 * config file.
 *
 * @access	public
 * @return	string
 */
function javascript_include_tag() {
  // Our javascript tag
  $tag = '';

  // Do we have any arguments?
  if ( func_num_args() == 0 ) {
    // No arguments. Return link to the defaults.
    $args = ocular::_default_javascripts();
  }

  if (empty($args)) {
    // Get our arguments from the parameters
    $args = func_get_args();
  }

  // Loop through each, adding to stylesheet string
  foreach ($args as $arg) {
    // Add our tag to the list.
    if (!empty($tag)) { $tag .= "/"; }
    $tag .= $arg; 
  }
	
  $CI=& get_instance();
  $module = '';
  if ($CI->config->item('OCU_is_module')) { $module .= "/ocular"; }
  return '<script type="text/javascript" src="'.site_url().$module.'/assets/javascripts/' . $tag . '"></script>' . "\n";
}

// ------------------------------------------------------------------------

/**
 * Image Tag
 *
 * Returns a link to an image from the string passed into the function.
 *
 * @access	public
 * @param		string - the name of the image (including extension)
 * @return	string
 */
function image_tag($name='')
{
	if (!empty($name)) {
		$CI =& get_instance();
		return $CI->config->item('OCU_images_path') . $name;
	}
	
	return '';
}

// ------------------------------------------------------------------------


/**
 * Get current controller
 *
 * Returns the name of the current controller.
 *
 * @access	public
 * @return	string
 */
 
function get_active_controller($get_path = FALSE)
{
  $CI =& get_instance();
  $RTR =& load_class('Router');
    
  $controller = $RTR->fetch_class();
    
  if($get_path)
  {
    $controller = $RTR->fetch_directory() . $CI->config->item('OCU_layout_dir') . $controller;
  }
    
  return $controller;
} 

// ------------------------------------------------------------------------

/**
 * Get current function
 *
 * Returns the name of the current function.
 *
 * @access	public
 * @return	string
 */

function get_active_function()
{
  $RTR =& load_class('Router');
   
  return  $RTR->fetch_method();
} 

// ------------------------------------------------------------------------

?>
