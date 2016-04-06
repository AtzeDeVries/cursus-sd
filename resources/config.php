<?php
###############################
## ResourceSpace
## Local Configuration Script
###############################

# All custom settings should be entered in this file.
# Options may be copied from config.default.php and configured here.

# MySQL database settings
$mysql_server = 'localhost';
$mysql_username = 'root';
$mysql_password = 'root';
$mysql_db = 'resourcespace';

$mysql_bin_path = '/usr/bin';

# Base URL of the installation
$baseurl = 'http://floating-ip';

# Email settings
$email_from = 'aut@naturalis.nl';
$email_notify = 'aut@naturalis.nl';

$spider_password = 'test';
$scramble_key = 'test';

$api_scramble_key = 'test';

# Paths
$imagemagick_path = '/usr/bin';
$ghostscript_path = '/usr/bin';
$ffmpeg_path = '/usr/bin';
$exiftool_path = '/usr/bin';
$antiword_path = '/usr/bin';
$pdftotext_path = '/usr/bin';


#Design Changes
$slimheader=true;



/*

New Installation Defaults
-------------------------

The following configuration options are set for new installations only.
This provides a mechanism for enabling new features for new installations without affecting existing installations (as would occur with changes to config.default.php)

*/

$thumbs_display_fields = array(8,3);
$list_display_fields = array(8,3,12);
$sort_fields = array(12);

// Set imagemagick default for new installs to expect the newer version with the sRGB bug fixed.
$imagemagick_colorspace = 'sRGB';

$slideshow_big=true;
$home_slideshow_width=1400;
$home_slideshow_height=900;

$homeanim_folder = 'filestore/system/slideshow';

#



$view_title_field=51;
$thumbs_display_fields=array(51,3);
$list_display_fields=array(51,3);


$enable_remote_apis=true;
$api_scramble_key = 'sadE5ytuPUMe';
