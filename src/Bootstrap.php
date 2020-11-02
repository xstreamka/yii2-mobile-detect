<?php
/**
 * @link https://github.com/xstreamka/yii2-mobile-detect
 * @copyright Copyright (c) 2020 XStream
 */

namespace xstreamka\mobiledetect;

use Yii;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface {
	public function bootstrap($app)
	{
		if (empty(Yii::$app->components['device'])) {
			$app->setComponents([
				'device' => [
					'class' => 'xstreamka\mobiledetect\Device',
				],
			]);
		}
		array_push($app->bootstrap, 'device');
	}
}