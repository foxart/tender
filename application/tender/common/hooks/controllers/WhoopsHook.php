<?php

namespace tender\common\hooks\controllers;

use fa\classes\Controller;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;
use Whoops\Util\Misc;

class WhoopsHook extends Controller {

	public function initialize() {
		$run = new Run();
		$handler = new PrettyPageHandler();
//$handler->setEditor('phpstorm');
		$handler->setEditor(function ($file, $line) {
			// if your development server is not local it's good to map remote files to local
//			$translations = array('^' . __DIR__ => '~/C:\Program Files (x86)\JetBrains\PhpStorm 2016.3\bin\phpstorm.exe');
			// change to your path
//			foreach ($translations as $from => $to) {
//				$file = preg_replace('#' . $from . '#', $to, $file, 1);
//			}
			// Intellig platform requires that you send an Ajax request, else the browser will quit the page
			return array(
				'url' => "http://localhost:63342/api/file/?file=$file&line=$line",
				'ajax' => TRUE,
			);
		});
//$handler = new \Whoops\Handler\PlainTextHandler();
// Add some custom tables with relevant info about your application, that could prove useful in the error page:
//$handler->addDataTable('Killer App Details', array(
//	"Some Data" => 'some data',
//	"Some Id" => 'some id',
//));
// Set the title of the error page:
//$handler->setPageTitle("Whoops! There was a problem.");
		$run->pushHandler($handler);
// Add a special handler to deal with AJAX requests with an equally-informative JSON response. Since this handler is first in the stack, it will be executed before the error page handler, and will have a chance to decide if anything needs to be done.
		if (Misc::isAjaxRequest()) {
			$run->pushHandler(new JsonResponseHandler());
//	$run->pushHandler(new \Whoops\Handler\XmlResponseHandler);
		}
// Register the handler with PHP, and you're set!
		$run->register();
	}
}


