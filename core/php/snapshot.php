<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

require_once dirname(__FILE__) . "/../../../../core/php/core.inc.php";
$camera = camera::byId(init('id'));
if (!is_object($camera)) {
	die();
}
if ($camera->getEqType_name() != 'camera') {
	die();
}
if ($camera->getConfiguration('localApiKey') != init('apikey')) {
	die();
}
header('Content-Type: image/jpeg');
$compress = init('low', $camera->getConfiguration('minCompress', null));
if ($compress != null) {
	if ($compress > $camera->getConfiguration('minCompress', $compress)) {
		$compress = $camera->getConfiguration('minCompress', $compress);
	}
	$data = $camera->getSnapshot();
	$img = imagecreatefromstring($data);
	if ($img === false) {
		echo $data;
	}
	imagejpeg($img, null, $compress);
} else {
	echo $camera->getSnapshot();
}
exit;