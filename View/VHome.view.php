<?php
	class VHome
	{
	    public function __construct(){}

	    public function __destruct(){}

	    public function showHtml($path)
	    {
	        $vhtml = new VHtml();
	        $vhtml->showHtml($path);

	    } // showHtml($path)
	} //VHome
?>