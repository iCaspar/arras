<?php
/* Alternate Styles & Layouts Functions */
global $arras_registered_alt_layouts;

function register_alternate_layout( $id, $name ) {
	global $arras_registered_alt_layouts;
	$arras_registered_alt_layouts[ $id ] = $name;
}