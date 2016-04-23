<?php
/*
/* ------------------------------ */
/* Include Mobile Detect Library */
/* ---------------------------- */
require_once 'Mobile_Detect.php';
/* -------------------------- */
class Device{
	/* Check Device */
	public static function make()
	{
		$detect = new Mobile_Detect;
		$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'Mobile' : 'Desktop') : 'Desktop');
		$scriptVersion = $detect->getScriptVersion();
		return $deviceType;
	}
}