<?php
/**
 * Get demo list to install
 *
 * @return array
 */
function gid_demo_list() {
	/**
	 * return list array:
	 *      name: Demo Name
	 *      thumbnail: Demo thumbnail url
	 *      preview: Link demo preview
	 *      dir: Directory demo data
	 *      theme: theme name
	 *      callback: function callback
	 */
	return apply_filters( 'gid_demo_list', array() );
}