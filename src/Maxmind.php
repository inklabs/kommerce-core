<?php
namespace inklabs\Kommerce;

class Maxmind {

	public static function city_time() {
		try {
			return filemtime(APPPATH . '/data/maxmind/GeoLite2-City.mmdb');
		} catch (Exception $e) {
			return NULL;
		}
	}

	public static function country_time() {
		try {
			return filemtime(APPPATH . '/data/maxmind/GeoLite2-Country.mmdb');
		} catch (Exception $e) {
			return NULL;
		}
	}

	public static function iso_3316($ip = NULL) {
		if ($ip === NULL) {
			$ip = Kommerce::remote_ip(TRUE);
		}

		return Arr::path(self::get_country($ip), 'country.iso_code');
	}

	public static function flag_image($iso_3316 = NULL, $attributes = []) {
		if ($iso_3316 === NULL) {
			$iso_3316 = self::iso_3316();
		}

		$attributes['class'] = trim(Arr::get($attributes, 'class') . ' flag flag-' . strtolower($iso_3316));

		return HTML::image('asset/kohana-kommerce/img/blank.gif', $attributes);
	}

	public static function get_city($ip_address) {
		try {
			$reader = new \MaxMind\Db\Reader(APPPATH . '/data/maxmind/GeoLite2-City.mmdb');
			$result = $reader->get($ip_address);
			$reader->close();

			return $result;
		} catch (Exception $e) {
			return [];
		}
	}

	public static function get_country($ip_address) {
		try {
			$reader = new \MaxMind\Db\Reader(APPPATH . '/data/maxmind/GeoLite2-Country.mmdb');
			$result = $reader->get($ip_address);
			$reader->close();
		} catch (Exception $e) {
			$result = [];
		}

		return $result;
	}
}
