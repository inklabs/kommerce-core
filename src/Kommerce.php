<?php
namespace inklabs\kommerce;

use DB;
use ORM;
use DateTime;
use DateTimeZone;

class Kommerce {
	const NAME = 'Zen Kommerce';
	const SAFE_NAME = 'zen_kommerce';
	const VERSION  = '0.3.0';
	const CODENAME = 'alpha';
	const WEBSITE = 'http://inklabs.github.io/kommerce/';
	const GITHUB = 'https://github.com/inklabs/kommerce';

	const PRODUCTION  = 10;
	const STAGING     = 20;
	const TESTING     = 30;
	const DEVELOPMENT = 40;

	public static $environment = self::DEVELOPMENT;

	public static $encode_base = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	public static $enable_x_forwarded_for = FALSE;
	public static $mock_ip_address = NULL;
	public static $internal_timezone = 'UTC';

	public static $content_type = 'text/html';
	public static $catalog_promotions = array();
	public static $product_ids = array();
	public static $tags = array();

	public static function get_slug($string) {
		$slug = preg_replace(
			array('/\'/', '/[^a-z0-9-]+/'),
			array('',     '-'),
			strtolower($string)
		);
		return preg_replace('/-+/', '-', $slug);
	}

	public static function base_decode($encoded_string, $base = NULL) {
		if ($base === NULL) {
			$base = self::$encode_base;
		}

		$b = strlen($base);
		$limit = strlen($encoded_string);
		$res = strpos($base, $encoded_string[0]);

		for($i=1; $i < $limit; $i++) {
			$res = $b * $res + strpos($base, $encoded_string[$i]);
		}

		return (int) $res;
	}

	public static function base_encode($orig_num, $base = NULL) {
		if ($base === NULL) {
			$base = self::$encode_base;
		}

		$b = strlen($base);
		$encoded_string = '';
		$num = $orig_num;
		
		do {
			$r = $num % $b;
			$num = floor($num / $b);
			$encoded_string = $base[$r] . $encoded_string;
		} while ($num);

		return $encoded_string;
	}

	/**
	 * Return FALSE if the IP address is a private one, TRUE otherwise.
	 *  10.0.0.0/8
	 *  172.16.0.0/12
	 *  192.168.0.0/16
	 *  169.254.0.0/16
	 *  127.0.0.1
	 *
	 * @param string $ip 
	 * @return bool
	 */
	public static function is_private_ip($ip) { 
		return ! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
	}

	public static function remote_ip($mock_local = FALSE) {

		$ip = Arr::get($_SERVER, 'REMOTE_ADDR');

		if (TRUE === self::$enable_x_forwarded_for) {
			$ip = Arr::get($_SERVER, 'HTTP_X_FORWARDED_FOR', $ip);
		}

		if ($mock_local AND self::is_private_ip($ip)) {
			$ip = self::$mock_ip_address;
		}

		return $ip;
	}

	public static function verify_country($allowed_countries) {
		$ip_address = self::remote_ip(TRUE);
		$country = Maxmind::get_country($ip_address);
		$iso_3316 = Arr::path($country, 'country.iso_code');

		if (empty($iso_3316)) {
			return;
		}

		if ( ! empty($allowed_countries)) {
			if ( ! in_array($iso_3316, $allowed_countries)) {
				header("HTTP/1.1 403 Forbidden");
				echo '403 Forbidden';
				exit;
			}
 		} else {
			$denied_countries = Kohana::$config->load('environment')->get('denied_countries');
			if ( ! empty($denied_countries)) {
				if (in_array($iso_3316, $denied_countries)) {
					header("HTTP/1.1 403 Forbidden");
					echo '403 Forbidden';
					exit;
				}
			}
		}
	}

	public static function set_content_type($content_type) {
		self::$content_type = $content_type;
	}

	public static function is_prod() {
		return (self::$environment == self::PRODUCTION);
	}

	public static function is_stage() {
		return (self::$environment == self::STAGING);
	}

	public static function is_dev() {
		return (self::$environment == self::DEVELOPMENT);
	}

	public static function show_profiler() {
		if (Kommerce::is_dev()) {
			return TRUE;
		}

		$user_roles = Session::instance()->get('user_roles');
		if (isset($user_roles['developer'])) {
			return TRUE;
		}

		return FALSE;
	}

	public static function get_short_name() {
		switch(self::$environment) {
			case self::PRODUCTION:  $environment_name = 'prod';  break;
			case self::DEVELOPMENT: $environment_name = 'dev';   break;
			case self::STAGING:     $environment_name = 'stage'; break;
		}
		return $environment_name;
	}

	public static function cache_directory($image_code, $sub_dir, $create = FALSE) {
		$directory_path = APPPATH . 'cache/' . $sub_dir . '/' . self::sub_path($image_code);

		if ($create) {
			if ( ! file_exists($directory_path)) {
				if ( ! @mkdir($directory_path, 0777, TRUE)) {
					throw new Exception('Unable to create directory: ' . $directory_path);
				}
			}
		}

		return $directory_path;
	}

	public static function private_data_directory($image_code, $sub_dir, $create = FALSE) {
		$directory_path = APPPATH . 'data/' . $sub_dir . '/' . self::sub_path($image_code);

		if ($create) {
			if ( ! file_exists($directory_path)) {
				if ( ! @mkdir($directory_path, 0777, TRUE)) {
					throw new Exception('Unable to create directory: ' . $directory_path);
				}
			}
		}

		return $directory_path;
	}

	public static function data_directory($image_code, $sub_dir, $create = FALSE) {
		$directory_path = DOCROOT . 'data/' . $sub_dir . '/' . self::sub_path($image_code);

		if ($create) {
			if ( ! file_exists($directory_path)) {
				if ( ! @mkdir($directory_path, 0777, TRUE)) {
					throw new Exception('Unable to create directory: ' . $directory_path);
				}
			}
		}

		return $directory_path;
	}

	public static function sub_path($image_code) {
		return substr($image_code, 0, 3) . '/' . substr($image_code, 3, 3) . '/';
	}

	public static function human_filesize($bytes, $decimals = 2) {
		$sz = 'BKMGTP';
		$factor = floor((strlen($bytes) - 1) / 3);
		return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
	}

	public static function get_products_by_tag( & $pagination, $tag_id) {
		$products = ORM::factory('Product')
			->join('product_tag')->on('product_tag.product_id', '=', 'product.id')
			->where('tag_id', '=', $tag_id)
			->where('product.visible', '=', 1)
			->where('product.active', '=', 1)
			->pagination($pagination)
			->order_by('name')
			->find_all()
			->as_array('id');

		return $products;
	}

	public static function get_related_products($product_ids, $limit = 12, $params = array()) {
		$product_group_id = NULL;
		if (is_a($product_ids, 'Model_Product')) {
			$product_group_id = $product_ids->product_group_id;
			$product_ids = [$product_ids->id];
		} else if ( ! is_array($product_ids)) {
			$product_ids = [$product_ids];
		}

		if (empty($params['tags'])) {
			$tags = ORM::factory('Tag')
				->where('product_id', 'IN', $product_ids)
				->join('product_tag')->on('product_tag.tag_id', '=', 'tag.id')
				->find_all()
				->as_array('id');
		} else {
			$tags = $params['tags'];
		}

		if (Arr::get($params, 'randomize')) {
			$order_by = DB::expr('RAND()');
		} else {
			$order_by = DB::expr('RAND(' . array_sum($product_ids) . ')');
		}

		$related_products = ORM::factory('Product');

		if ( ! empty($tags)) {
			$related_products = $related_products
				->join('product_tag')->on('product_tag.product_id', '=', 'product.id')
				->where('tag_id', 'IN', array_keys($tags));
		}

		if ( ! empty($product_group_id)) {
			$related_products = $related_products
				->where('product.product_group_id', '<>', $product_group_id);
		}

		$related_products = $related_products
			->where('product.id', 'NOT IN', $product_ids)
			->where('product.visible', '=', 1)
			->where_open()
				->where('product.require_inventory', '=', 1)
				->where('product.quantity', '>', 0)
				->or_where_open()
					->where('product.require_inventory', '=', 0)
				->or_where_close()
			->where_close()
			->where('product.active', '=', 1)
			->group_by('product.id')
			->order_by($order_by)
			->limit($limit)
			->find_all()
			->as_array();

		return $related_products;
	}

	public static function get_random_products($limit = 12) {
		return ORM::factory('Product')
			->where('product.visible', '=', 1)
			->where('product.active', '=', 1)
			->order_by(DB::expr('RAND()'))
			->limit($limit)
			->find_all()
			->as_array();
	}

	public static function get_random_tags($limit = 12) {
		return ORM::factory('Tag')
			->order_by(DB::expr('RAND()'))
			->limit($limit)
			->find_all()
			->as_array();
	}

	public static function get_product_attributes($product_ids) {
		return ORM::factory('Attribute')
			->join('product_attribute')
			->on('product_attribute.attribute_id', '=', 'attribute.id')
			->where('product_attribute.product_id', 'IN', $product_ids)
			->group_by('attribute.id')
			->find_all()
			->as_array('id');
	}

	public static function get_product_attribute_values($product_ids) {
		return ORM::factory('Attribute_Value')
			->join('product_attribute')
			->on('product_attribute.attribute_value_id', '=', 'attribute_value.id')
			->where('product_attribute.product_id', 'IN', $product_ids)
			->group_by('attribute_value.id')
			->find_all()
			->as_array('id');
	}

	public static function get_product_attribute_grid($product_ids) {
		$rows = DB::select('product_id', 'attribute_id', 'attribute_value_id')
			->from('product_attribute')
			->where('product_attribute.product_id', 'IN', $product_ids)
			->execute();

		$product_attributes = array();
		foreach ($rows as $row) {
			$product_attributes[$row['attribute_id']][$row['attribute_value_id']][] = $row['product_id'];
		}

		return $product_attributes;
	}

	public static function get_selected_product($attributes) {
		$selected_product = ORM::factory('Product')
			->join('product_attribute', 'LEFT')
			->on('product_attribute.product_id', '=', 'product.id');

		foreach ($attributes as $attribute_id => $attribute_value_id) {
			$selected_product = $selected_product
				->or_where_open()
					->where('attribute_id', '=', $attribute_id)
					->where('attribute_value_id', '=', $attribute_value_id)
				->or_where_close();
		}

		$selected_product = $selected_product
			->group_by('product_attribute.product_id')
			->having(DB::expr('count(product_attribute.product_id)'), '>', 1)
			->limit(1)
			->find();

		return $selected_product;
	}

	// Convert price in cents to 20%
	public static function display_percent($percent) {
		return $percent . '%';
	}

	// Convert price in cents to $x,xxx.xx
	public static function display_price($price, $display_if_null = TRUE) {
		if ($display_if_null !== TRUE AND $price === NULL) {
			return $display_if_null;
		}

		return '$' . number_format(($price / 100), 2);
	}

	// Convert price in cents to x,xxx.xx
	public static function numeric_price($price) {
		return number_format(($price / 100), 2);
	}

	// Convert price in cents to xxxx.xx
	public static function float_price($price, $display_if_null = TRUE) {
		if ($display_if_null !== TRUE AND $price === NULL) {
			return $display_if_null;
		}

		return number_format(($price / 100), 2, NULL, '');
	}

	// Convert percent to xxxx.xx
	public static function float_percent($percent, $display_if_null = TRUE) {
		if ($display_if_null !== TRUE AND $percent === NULL) {
			return $display_if_null;
		}

		return number_format($percent, 2, NULL, '');
	}

	public static function login($username, $password) {
		$remote_ip = Kommerce::remote_ip();

		// Prepare login event
		$user_login = ORM::factory('User_Login');
		$user_login->user_id = NULL;
		$user_login->username = $username;
		$user_login->ip4 = ip2long($remote_ip);

		if (self::_login($username, $password)) {
			StatsD::increment('login.success');

			$user = Kommerce::get_user();
			$user_login->user_id = $user->id;
			$user_login->result = 'success';
			$user_login->save();

			return TRUE;
		} else {
			StatsD::increment('login.fail');

			$user_login->result = 'fail';
			$user_login->save();

			return FALSE;
		}
	}

	public static function _login($username, $password) {
		$user = ORM::factory('User')
			->where('email', '=', $username)
			->find();

		if (password_verify($password, $user->password)) {
			Session::instance()->set('user', $user);

			return self::logged_in();
		} else {
			return FALSE;
		}
	}

	public static function logout() {
		Session::instance()
			->delete('user')
			->delete('user_roles')
			->regenerate();

		// Double check
		return ! self::logged_in();
	}

	public static function csrf_validation($array, $action_name = '', $force = FALSE) {
		// Only use CSRF for active sessions, if not forced.
		// This allows for no cookies required on product page.
		if ( ! $force AND ! Session::has_started()) {
			return TRUE;
		}

		$csrf = Arr::get($array, 'csrf');
		if (empty($csrf) OR ! Security::check($csrf)) {
			Message::add('error', 'Invalid request');

			$csrf_action = 'csrf';
			if ( ! empty($action_name)) {
				$csrf_action .= '.' . $action_name;
			}
			StatsD::increment($csrf_action);

			Kohana::$log->add(Log::ERROR, 'CSRF token (' . $csrf . ') does not match (' . Security::token() . ')');

			return FALSE;
		} else {
			// Invalidate the token
			Security::invalidate();

			return TRUE;
		}
	}

	/**
	 * @param   mixed    $role Role name string or array with role names
	 * @return  boolean
	 */
	public static function logged_in($roles = NULL)
	{
		if ( ! Session::has_started()) {
			return FALSE;
		}

		// Get the user from the session
		$user = self::get_user();

		if ($user === NULL) {
			return FALSE;
		}

		if ($roles === NULL) {
			return TRUE;
		}

		if ( ! is_array($roles)) {
			$roles = array($roles);
		}

		$user_roles = Session::instance()->get('user_roles');

		if ($user_roles === NULL) {
			// Get all the roles
			$user_roles = DB::select('role.*')
				->from('role')
				->join('user_role')->on('user_role.role_id', '=', 'role.id')
				->where('user_role.user_id', '=', $user->id)
				->execute()
				->as_array('name', 'id');

			Session::instance()->set('user_roles', $user_roles);
		}

		foreach ($roles as $role) {
			if ( ! isset($user_roles[$role])) {
				return FALSE;
			}
		}

		return TRUE;
	}

	public static function get_user($default = NULL) {
		return Session::instance()->get('user', $default);
	}

	public static function get_states() {
		return array(
			''=>'State',
			'AL'=>'Alabama',
			'AK'=>'Alaska',
			'AZ'=>'Arizona',
			'AR'=>'Arkansas',
			'CA'=>'California',
			'CO'=>'Colorado',
			'CT'=>'Connecticut',
			'DE'=>'Delaware',
			'DC'=>'District Of Columbia',
			'FL'=>'Florida',
			'GA'=>'Georgia',
			'HI'=>'Hawaii',
			'ID'=>'Idaho',
			'IL'=>'Illinois',
			'IN'=>'Indiana',
			'IA'=>'Iowa',
			'KS'=>'Kansas',
			'KY'=>'Kentucky',
			'LA'=>'Louisiana',
			'ME'=>'Maine',
			'MD'=>'Maryland',
			'MA'=>'Massachusetts',
			'MI'=>'Michigan',
			'MN'=>'Minnesota',
			'MS'=>'Mississippi',
			'MO'=>'Missouri',
			'MT'=>'Montana',
			'NE'=>'Nebraska',
			'NV'=>'Nevada',
			'NH'=>'New Hampshire',
			'NJ'=>'New Jersey',
			'NM'=>'New Mexico',
			'NY'=>'New York',
			'NC'=>'North Carolina',
			'ND'=>'North Dakota',
			'OH'=>'Ohio',
			'OK'=>'Oklahoma',
			'OR'=>'Oregon',
			'PA'=>'Pennsylvania',
			'RI'=>'Rhode Island',
			'SC'=>'South Carolina',
			'SD'=>'South Dakota',
			'TN'=>'Tennessee',
			'TX'=>'Texas',
			'UT'=>'Utah',
			'VT'=>'Vermont',
			'VA'=>'Virginia',
			'WA'=>'Washington',
			'WV'=>'West Virginia',
			'WI'=>'Wisconsin',
			'WY'=>'Wyoming',

			'GU'=>'Guam',
			'FM'=>'Federated States of Micronesia',
			'MH'=>'Marshall Islands',
			'PW'=>'Palau',
			'AA'=>'US Armed Forces - Americas',
			'AE'=>'US Armed Forces - Europe',
			'AP'=>'US Armed Forces - Pacific',
		);
	}

	public static function get_months() {
		$months = array('' => 'Month');

		for ($i = 1; $i <= 12; $i++) {
			$num = str_pad($i, 2, '0', STR_PAD_LEFT);
			$months[$num] = $num;
		}

		return $months;
	}

	public static function get_years() {
		$years = array('' => 'Year');
		$current_year = (int) date('Y');

		for ($i = $current_year; $i <= ($current_year + 12); $i++) {
			$years[$i] = $i;
		}

		return $years;
	}

	public static function get_past_period($days) {
		if ( ! is_int($days) OR $days < 0 OR $days > 90) {
			throw new Exception('Period not supported');
		}

		$start = self::get_current_date('-' . $days . ' days');
		$period = new DatePeriod($start, new DateInterval('P1D'), $days);

		$period_list = array();
		foreach ($period as $date) {
			$period_list[$date->format('Y-m-d')] = 0;
		}

		reset($period_list);
		$begin_date = key($period_list) . ' 00:00';
		end($period_list);
		$end_date = key($period_list) . ' 23:59';

		return array(
			'list' => $period_list,
			'begin_date' => $begin_date,
			'end_date' => $end_date,
		);
	}

	public static function format_date($timestamp = NULL, $format = NULL) {
		if ($format === NULL) {
			$format = Kohana::$config->load('environment.format_date');
		}

		$output = new DateTime();
		$output->setTimestamp($timestamp);
		$output->setTimezone(new DateTimeZone(Kohana::$config->load('environment.display_timezone')));
		return $output->format($format);
	}

	public static function format_time($timestamp = NULL) {
		return self::format_date($timestamp,
			Kohana::$config->load('environment')->get('format_time')
		);
	}

	public static function format_date_time($timestamp = NULL) {
		return self::format_date($timestamp,
			Kohana::$config->load('environment')->get('format_date') . ' ' .
			Kohana::$config->load('environment')->get('format_time')
		);
	}

	public static function format_internal_date($timestamp = NULL, $format = DateTime::W3C) {
		$date = new DateTime();

		if ($timestamp !== NULL) {
			$date->setTimestamp($timestamp);
		}

		$date->setTimeZone(new DateTimeZone(self::$internal_timezone));
		return $date->format($format);
	}

	public static function get_current_date($timestamp = NULL) {
		return new DateTime($timestamp, new DateTimeZone(self::$internal_timezone));
	}

	public static function load_catalog_promotions() {
		$current_date = self::get_current_date();

		$product_ids = array_keys(self::$product_ids);

		$catalog_promotion = ORM::factory('Catalog_Promotion')
			->join('product_tag', 'LEFT')->on('product_tag.tag_id', '=', 'catalog_promotion.tag_id')
			->and_where_open()
				->where('catalog_promotion.tag_id', 'IS', NULL);

		if ( ! empty($product_ids)) {
			$catalog_promotion = $catalog_promotion
				->or_where('product_id', 'IN', $product_ids);
		}

		$catalog_promotion = $catalog_promotion->and_where_close();

		self::$catalog_promotions += $catalog_promotion
			->and_where_open()
				->and_where_open()
					->where('start', '<=', $current_date->format('Y-m-d'))
					->or_where('start', 'IS', NULL)
				->and_where_close()
				->and_where_open()
					->where('end', '>=', $current_date->format('Y-m-d'))
					->or_where('end', 'IS', NULL)
				->and_where_close()
			->and_where_close()
			->find_all()
			->as_array('id');
	}

	public static function load_product_tags() {
		$products = func_get_args();
		if (empty($products)) {
			return;
		}

		$product_ids = array();
		foreach ($products as $product) {
			if (is_array($product)) {
				foreach ($product as $p) {
					$product_ids[] = $p->id;
				}
			} else {
				$product_ids[] = $product->id;
			}
		}
		$product_ids = array_unique($product_ids);

		if ( ! empty($product_ids)) {
			$product_tags = ORM::factory('Product_Tag')
				->where('product_id', 'IN', $product_ids)
				->find_all()
				->as_multi_array('product_id', 'tag_id');

			foreach ($products as $product) {
				if (is_array($product)) {
					foreach ($product as $p) {
						if (isset($product_tags[$p->id])) {
							$p->tags = $product_tags[$p->id];
						}
					}
				} else {
					if (isset($product_tags[$product->id])) {
						$product->tags = $product_tags[$product->id];
					}
				}
			}
		}
	}

	public static function load_tags() {
		$products = func_get_args();
		if (empty($products)) {
			return;
		}

		$product_ids = array();
		foreach ($products as $product) {
			if (is_array($product)) {
				foreach ($product as $p) {
					$product_ids[] = $p->id;
				}
			} else {
				$product_ids[] = $product->id;
			}
		}
		$product_ids = array_unique($product_ids);

		self::$tags = ORM::factory('Tag')
			->join('product_tag')->on('product_tag.tag_id', '=', 'tag.id')
			->where('product_id', 'IN', $product_ids)
			->group_by('tag.id')
			->find_all()
			->as_array('id');
	}

	public static function load_product_discounts() {
		$products = func_get_args();
		if (empty($products)) {
			return;
		}

		$product_ids = array();
		foreach ($products as $product) {
			if (is_array($product)) {
				foreach ($product as $p) {
					$product_ids[] = $p->id;
				}
			} else {
				$product_ids[] = $product->id;
			}
		}
		$product_ids = array_unique($product_ids);

		$current_date = self::get_current_date();

		$product_discounts = ORM::factory('Product_Discount')
			->where('product_id', 'IN', $product_ids)
			->and_where_open()
				->where('start', '<=', $current_date->format('Y-m-d'))
				->or_where('start', 'IS', NULL)
			->and_where_close()
			->and_where_open()
				->where('end', '>=', $current_date->format('Y-m-d'))
				->or_where('end', 'IS', NULL)
			->and_where_close()
			->order_by('product_id')
			->order_by('quantity', 'DESC')
			->find_all()
			->as_multi_array('product_id');

		foreach ($products as $product) {
			if (is_array($product)) {
				foreach ($product as $p) {
					if (isset($product_discounts[$p->id])) {
						$p->discounts = $product_discounts[$p->id];
					}
				}
			} else {
				if (isset($product_discounts[$product->id])) {
					$product->discounts = $product_discounts[$product->id];
				}
			}
		}
	}

	public static function get_price($quantity, $price, $discounts = array(), $tags = array()) {
		// echo '<h4>get_price</h4>'; dBug::jam(get_defined_vars());
		$promotion_name = '';

		$discount_price = $price;
		$discount_promotion_name = '';
		$discount_and_catalog_applied = FALSE;

		if ($discounts !== NULL) {
			foreach ($discounts as $discount) {
				if ($quantity >= $discount->quantity) {
					$discount_promotion_name = $discount->quantity . 'x for ' .
						Kommerce::display_price($discount->price) . ' ea.';

					$discount_price = $discount->price;

					// Apply catalog promotions in addition to product quantity discounts?
					if ($discount->apply_catalog_promotions AND $discount_price < $price) {
						$price = $discount_price;
						$discount_and_catalog_applied = TRUE;
					}

					break;
				}
			}
		}

		$current_date = self::get_current_date();
		$current_date_ts = strtotime($current_date->format('Y-m-d'));

		$catalog_promotion_price = $price;
		$catalog_promotion_name = NULL;
		$catalog_promotion = NULL;

		foreach (self::$catalog_promotions as $promotion) {
			if ($current_date_ts < strtotime($promotion->start) OR $current_date_ts > strtotime($promotion->end)) {
				continue;
			} elseif ($promotion->max_redemptions !== NULL AND $promotion->redemptions >= $promotion->max_redemptions) {
				continue;
			} elseif ($promotion->tag_id !== NULL AND ! in_array($promotion->tag_id, $tags)) {
				continue;
			} else {
				if ($promotion->discount_type == 'fixed') {
					$promotion_discount = (int) $promotion->discount_value;
				} elseif ($promotion->discount_type == 'percent') {
					$promotion_discount = (int) ($price * ($promotion->discount_value) / 100);
				}

				$catalog_promotion_price_current = $price - $promotion_discount;

				if ($catalog_promotion_price_current < $catalog_promotion_price) {
					$catalog_promotion_price = $catalog_promotion_price_current;
					$catalog_promotion_name = $promotion->name;
					$catalog_promotion = $promotion;
				}
			}
		}

		if ($catalog_promotion_price <= $discount_price) {
			$price = $catalog_promotion_price;
			$promotion_name = $catalog_promotion_name;
			if ($discount_and_catalog_applied) {
				$promotion_name = $discount_promotion_name . ' and ' . $promotion_name;
			}
		} else {
			$price = $discount_price;
			$promotion_name = $discount_promotion_name;
		}

		if ($price < 0) {
			$price = 0;
		}

		return array(
			'price' => $price,
			'promotion_name' => $promotion_name,
			'catalog_promotion' => $catalog_promotion,
		);
	}
}
