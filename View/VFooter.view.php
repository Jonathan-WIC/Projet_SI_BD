<?php
	class VFooter
	{
	    public function __construct(){}

	    public function __destruct(){}

	    public function showFooter()
	    {
	        $vhtml = new VHtml();
	        $vhtml->showHtml('Html/footer.html');

	    } // showFooter()
	} //VFooter
?>