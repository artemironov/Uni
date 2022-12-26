<?php

/**
 * Русификация
 * Формирование предложений в соответствии с правилами русского языка
 */

class russian {
	// Возвращает месяц на русском языке
	public static function get_month_name($num) {
		$months = array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');
		return $months[$num-1];
	}

	// Возвращает дату на русском языке
	public static function get_date_time($template='') {
		$RinTemplate = strpos($template, "R");
		if ($RinTemplate === FALSE) {
			return get_the_time($template);
		} else {
			$text = '';
			if ($RinTemplate > 0) {
				$text = get_the_time(substr($template, 0, $RinTemplate));
			}
			$text .= self::get_month_name(get_the_time('n'));
			$text .= self::get_date_time( substr($template, $RinTemplate+1) );
			return $text;
		}
	}
}

