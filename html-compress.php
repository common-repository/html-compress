<?php
/*
Plugin Name: html-compress
Description: Reduce html, css and js size by removing unnecessary white space from an HTML document.
Version: 0.1
Author: karrikas
Author URI: http://karrikas.com/
Author Email: karrikas@karrikas.com
License: GPL3
*/

/*
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>. 
*/

include_once 'lib/html-compress/Compress.class.php';

function wp_finish($html)
{
	return Compress::Compress($html);
}


function wp_start()
{
	ob_start('wp_finish');
}

add_action('get_header', 'wp_start');
