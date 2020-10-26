<?php

namespace Concrete\Package\JeroTidy;

use Concrete\Core\Support\Facade\Events;
use Package;

defined('C5_EXECUTE') or die(_('Access Denied.'));

class Controller extends Package {
	protected $pkgHandle = 'jero_tidy';
	protected $appVersionRequired = '5.8';
	protected $pkgVersion = '0.9';

	public function getPackageName () {
		return t('JeRo Tidy');
	}

	public function getPackageDescription () {
		return t('Tidy up uploaded file names on load');
	}

	public function on_start () {
		Events::addListener('on_file_add', function ($event) {
			/* @var $event \Concrete\Core\File\Event\FileVersion */
			$fv = $event->getFileVersionObject();
			/* @var $fv \Concrete\Core\Entity\File\Version */
			$title = $fv->getTitle();
			$parts = explode('.', $title);
			array_pop($parts);
			$title = implode(' ', $parts);
			$title = str_replace(['_', '-',], ' ', $title);
			$title = ucwords(strtolower($title));

			if ($title) {
				$fv->updateTitle($title);
			}
		});
	}
}
