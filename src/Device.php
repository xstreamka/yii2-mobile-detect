<?php
/**
 * @link https://github.com/xstreamka/yii2-mobile-detect
 * @copyright Copyright (c) 2020 XStream
 */

namespace xstreamka\mobiledetect;

use Yii;
use yii\web\ServerErrorHttpException;

/**
 * Mobile_Detect for Yii2.
 *
 * @property array $tablet Array of users' tablets devices
 * @property array $phone Array of users' phone devices
 *
 * Class Device
 * @package xstreamka\mobiledetect
 */
class Device
{
	/** @var \Mobile_Detect $detect Main class */
	public static $detect;

	/** @var bool $isTablet Tablet */
	public static $isTablet;

	/** @var bool $isMobile Mobile */
	public static $isMobile;

	/** @var bool $isPhone Phone */
	public static $isPhone;

	/** @var bool $isIphone iPhone */
	public static $isIphone;

	/** @var bool $isSamsung Samsung */
	public static $isSamsung;

	/** @var string|null $info About device (HTTP_USER_AGENT) */
	public static $info;

	public $tablet;
	public $phone;

	public function __construct()
	{
		$tablets = (array)(Yii::$app->components['device']['tablet'] ?? []);
		$phones = (array)(Yii::$app->components['device']['phone'] ?? []);
		if (array_intersect($tablets, $phones)) {
			throw new ServerErrorHttpException ('device component: There are convergence in arrays "tablet" and "phone".');
		}

		require_once __DIR__ . '/../lib/Mobile_Detect.php';
		self::$detect = new \Mobile_Detect;

		self::$isIphone = self::$detect->isIphone();
		self::$isSamsung = self::$detect->isSamsung();

		self::$info = $_SERVER['HTTP_USER_AGENT'] ?? null;

		self::$isTablet = $this->isTablet();
		self::$isPhone = $this->isPhone();
		self::$isMobile = $this->isMobile();
	}

	/**
	 * Tablet.
	 * @return bool
	 */
	protected function isTablet()
	{
		$tablets = (array)(Yii::$app->components['device']['tablet'] ?? []);
		$phones = (array)(Yii::$app->components['device']['phone'] ?? []);

		foreach ($tablets as $tablet) {
			if (strpos(self::$info, $tablet) !== false) {
				return true;
			}
		}

		foreach ($phones as $phone) {
			if (strpos(self::$info, $phone) !== false) {
				return false;
			}
		}

		return self::$detect->isTablet();
	}

	/**
	 * Mobile.
	 * @return bool
	 */
	protected function isPhone()
	{
		$tablets = (array)(Yii::$app->components['device']['tablet'] ?? []);
		$phones = (array)(Yii::$app->components['device']['phone'] ?? []);

		foreach ($tablets as $tablet) {
			if (strpos(self::$info, $tablet) !== false) {
				return false;
			}
		}

		foreach ($phones as $phone) {
			if (strpos(self::$info, $phone) !== false) {
				return true;
			}
		}

		return self::$detect->isMobile() && !self::$detect->isTablet();
	}

	/**
	 * Mobile: Tablet or Phone.
	 * @return bool
	 */
	protected function isMobile()
	{
		return $this->isTablet() || $this->isPhone() || self::$detect->isMobile();
	}
}