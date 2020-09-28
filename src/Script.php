<?php

namespace TimePHP;

use Composer\Installer\PackageEvent;

class Script {

   public static function postPackageInstall(PackageEvent $event) {
      $installedPackage = str_replace("/", ":", $event->getOperation()->getPackage()->getName());
		if(explode(":", $installedPackage)[0] === "timephp"){
      	$content = json_decode(file_get_contents(__DIR__ . "/../bin/components.json"), true);
			$content[] = $installedPackage;	
			file_put_contents(__DIR__ . "/../components.json", json_encode($content, JSON_PRETTY_PRINT));
		}
   }

   public static function prePackageUninstall(PackageEvent $event) {
      $uninstalledPackage = str_replace("/", ":", $event->getOperation()->getPackage()->getName());
		if(explode(":", $uninstalledPackage)[0] === "timephp"){
      	$content = json_decode(file_get_contents(__DIR__ . "/../bin/components.json"), true);
      	if (($key = array_search($uninstalledPackage, $content)) !== false) {
				unset($content[$key]);
		  	}
			file_put_contents(__DIR__ . "/../components.json", json_encode($content, JSON_PRETTY_PRINT));
		}
   }
}