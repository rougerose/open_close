<?php

class StoreHoursTest extends PHPUnit_Framework_TestCase
{
	protected function setUp() {
		require_once __DIR__ . '/StoreHours.class.php';

		date_default_timezone_set('UTC');
	}

	public function testHoursTodayMethod() {
		$sh = $this->instantiateWithDefaultData();

		$this->assertEquals(['11:00-20:30'], $sh->hours_today(strtotime('2016-02-08'))); // mon
		$this->assertEquals(['11:00-13:00', '18:00-20:30'], $sh->hours_today(strtotime('2016-02-09'))); // tue
		$this->assertEquals(['11:00-20:30'], $sh->hours_today(strtotime('2016-02-10'))); // wed
		$this->assertEquals(['11:00-1:30'], $sh->hours_today(strtotime('2016-02-11'))); // thu
		$this->assertEquals(['11:00-20:30'], $sh->hours_today(strtotime('2016-02-12'))); // fri
		$this->assertEquals(['11:00-20:00'], $sh->hours_today(strtotime('2016-02-13'))); // sat
		$this->assertEquals([], $sh->hours_today(strtotime('2016-02-14'))); // sun

		// Exceptions (dates, not the PHP kind)

		$this->assertEquals(['11:00-18:00'], $sh->hours_today(strtotime('2016-02-24')));
		$this->assertEquals(['11:00-16:00', '18:00-20:30'], $sh->hours_today(strtotime('2016-10-18')));

		$this->assertEquals(['09:00-11:00'], $sh->hours_today(strtotime('2016-02-01')));
		$this->assertEquals(['11:00-20:30'], $sh->hours_today(strtotime('2017-02-01'))); // wed
	}

	public function testIsOpenMethod() {
		$sh = $this->instantiateWithDefaultData();

		$this->assertEquals(false, $sh->is_open(strtotime('2016-02-08 10:59:59'))); // mon
		$this->assertEquals(true, $sh->is_open(strtotime('2016-02-08 11:00:00')));
		$this->assertEquals(true, $sh->is_open(strtotime('2016-02-08 20:30:00')));
		$this->assertEquals(false, $sh->is_open(strtotime('2016-02-08 20:30:01')));

		$this->assertEquals(false, $sh->is_open(strtotime('2016-02-09 10:59:59'))); // tue
		$this->assertEquals(true, $sh->is_open(strtotime('2016-02-09 11:00:00')));
		$this->assertEquals(true, $sh->is_open(strtotime('2016-02-09 13:00:00')));
		$this->assertEquals(false, $sh->is_open(strtotime('2016-02-09 13:00:01')));
		$this->assertEquals(false, $sh->is_open(strtotime('2016-02-09 17:59:59')));
		$this->assertEquals(true, $sh->is_open(strtotime('2016-02-09 18:00:00')));
		$this->assertEquals(true, $sh->is_open(strtotime('2016-02-09 20:30:00')));
		$this->assertEquals(false, $sh->is_open(strtotime('2016-02-09 20:30:01')));

		// "open late"

		$this->assertEquals(false, $sh->is_open(strtotime('2016-02-11 00:30:00'))); // thu
		$this->assertEquals(true, $sh->is_open(strtotime('2016-02-11 23:59:59')));
		$this->assertEquals(true, $sh->is_open(strtotime('2016-02-12 00:00:00'))); // fri
		$this->assertEquals(true, $sh->is_open(strtotime('2016-02-12 01:30:00')));
		$this->assertEquals(false, $sh->is_open(strtotime('2016-02-12 01:30:01')));

		// Exceptions (dates, not the PHP kind)

		$this->assertEquals(false, $sh->is_open(strtotime('2016-02-24 10:59:59')));
		$this->assertEquals(true, $sh->is_open(strtotime('2016-02-24 11:00:00')));
		$this->assertEquals(true, $sh->is_open(strtotime('2016-02-24 18:00:00')));
		$this->assertEquals(false, $sh->is_open(strtotime('2016-02-24 18:00:01')));

		$this->assertEquals(false, $sh->is_open(strtotime('2016-10-18 10:59:59')));
		$this->assertEquals(true, $sh->is_open(strtotime('2016-10-18 11:00:00')));
		$this->assertEquals(true, $sh->is_open(strtotime('2016-10-18 16:00:00')));
		$this->assertEquals(false, $sh->is_open(strtotime('2016-10-18 16:00:01')));
		$this->assertEquals(false, $sh->is_open(strtotime('2016-10-18 17:59:59')));
		$this->assertEquals(true, $sh->is_open(strtotime('2016-10-18 18:00:00')));
		$this->assertEquals(true, $sh->is_open(strtotime('2016-10-18 20:30:00')));
		$this->assertEquals(false, $sh->is_open(strtotime('2016-10-18 20:30:01')));

		$this->assertEquals(false, $sh->is_open(strtotime('2016-02-01 08:59:59')));
		$this->assertEquals(true, $sh->is_open(strtotime('2016-02-01 09:00:00')));
		$this->assertEquals(true, $sh->is_open(strtotime('2016-02-01 11:00:00')));
		$this->assertEquals(false, $sh->is_open(strtotime('2016-02-01 11:00:01')));

		$this->assertEquals(false, $sh->is_open(strtotime('2017-02-01 10:59:59'))); // wed
		$this->assertEquals(true, $sh->is_open(strtotime('2017-02-01 11:00:00')));
		$this->assertEquals(true, $sh->is_open(strtotime('2017-02-01 20:30:00')));
		$this->assertEquals(false, $sh->is_open(strtotime('2017-02-01 20:30:01')));
	}

	public function testRenderMethod() {
		$sh = $this->instantiateWithDefaultData();

		ob_start();
		$sh->render(strtotime('2016-02-13 14:30:00')); // sat
		$this->assertEquals('<h3>Yes, we\'re open! Today\'s hours are 11:00am - 8:00pm.</h3>', ob_get_clean());

		ob_start();
		$sh->render(strtotime('2016-02-09 14:30:00')); // tue
		$this->assertEquals(
			'<h3>Sorry, we\'re closed. Today\'s hours are 11:00am - 1:00pm and 6:00pm - 8:30pm.</h3>',
			ob_get_clean()
		);

		ob_start();
		$sh->render(strtotime('2016-02-14 12:00:00')); // sun
		$this->assertEquals('<h3>Sorry, we\'re closed.</h3>', ob_get_clean());

		// "open late" (if still open, display hours from yesterday)

		ob_start();
		$sh->render(strtotime('2016-02-11 23:59:59')); // night from thu->fri, thursday's hours
		$this->assertEquals('<h3>Yes, we\'re open! Today\'s hours are 11:00am - 1:30am.</h3>', ob_get_clean());

		ob_start();
		$sh->render(strtotime('2016-02-12 00:30:00')); // night from thu->fri, thursday's hours
		$this->assertEquals('<h3>Yes, we\'re open! Today\'s hours are 11:00am - 1:30am.</h3>', ob_get_clean());

		ob_start();
		$sh->render(strtotime('2016-02-12 01:30:01')); // closed on friday morning, friday's hours
		$this->assertEquals('<h3>Sorry, we\'re closed. Today\'s hours are 11:00am - 8:30pm.</h3>', ob_get_clean());

		// Exceptions (dates, not the PHP kind)

		ob_start();
		$sh->render(strtotime('2016-02-24 19:00:00'));
		$this->assertEquals('<h3>Sorry, we\'re closed. Today\'s hours are 11:00am - 6:00pm.</h3>', ob_get_clean());

		ob_start();
		$sh->render(strtotime('2016-10-18 19:00:00'));
		$this->assertEquals(
			'<h3>Yes, we\'re open! Today\'s hours are 11:00am - 4:00pm and 6:00pm - 8:30pm.</h3>',
			ob_get_clean()
		);

		ob_start();
		$sh->render(strtotime('2016-02-01 09:00:00'));
		$this->assertEquals('<h3>Yes, we\'re open! Today\'s hours are 9:00am - 11:00am.</h3>', ob_get_clean());

		ob_start();
		$sh->render(strtotime('2016-02-01 12:00:00'));
		$this->assertEquals('<h3>Sorry, we\'re closed. Today\'s hours are 9:00am - 11:00am.</h3>', ob_get_clean());

		ob_start();
		$sh->render(strtotime('2017-02-01 12:00:00')); // wed
		$this->assertEquals('<h3>Yes, we\'re open! Today\'s hours are 11:00am - 8:30pm.</h3>', ob_get_clean());
	}

	public function testWithCustomTemplates() {
		$hours = [
			'mon' => ['09:00-17:00', '17:30-18:00', '19:00-02:30'],
			'thu' => ['17:45-18:00'],
		];

		$exceptions = [
			'2016-02-15' => [],
		];

		$templates = [
			'open' => 'Open. Hours {%hours%}.',
			'separator' => '-',
			'format' => 'G.i',
		];

		$sh = new StoreHours($hours, $exceptions, $templates);

		ob_start();
		$sh->render(strtotime('2016-02-08 14:30:00')); // mon
		$this->assertEquals('Open. Hours 9.00-17.00 and 17.30-18.00 and 19.00-2.30.', ob_get_clean());

		ob_start();
		$sh->render(strtotime('2016-02-11 14:30:00')); // thu
		$this->assertEquals('<h3>Sorry, we\'re closed. Today\'s hours are 17.45-18.00.</h3>', ob_get_clean());

		ob_start();
		$sh->render(strtotime('2016-02-15 14:30:00')); // mon
		$this->assertEquals('<h3>Sorry, we\'re closed.</h3>', ob_get_clean());
	}

	public function testHoursOverviewSimple() {
		$sh = new StoreHours([]);
		$this->assertEquals([
			'Mon' => '-',
			'Tue' => '-',
			'Wed' => '-',
			'Thu' => '-',
			'Fri' => '-',
			'Sat' => '-',
			'Sun' => '-',
		], $sh->hours_this_week());

		$sh = new StoreHours(['fri' => ['']]);
		$this->assertEquals([
			'Mon' => '-',
			'Tue' => '-',
			'Wed' => '-',
			'Thu' => '-',
			'Fri' => '-',
			'Sat' => '-',
			'Sun' => '-',
		], $sh->hours_this_week());

		$sh = new StoreHours([
			'mon' => ['08:00-12:00', '13:00-1:30'],
			'tue' => ['08:00-12:00', '13:00-1:30'],
			'thu' => ['08:00-12:00', '13:00-1:30'],
			'fri' => ['08:00-12:00', '13:00-1:30'],
			'sun' => ['08:00-1:30'],
		]);
		$this->assertEquals([
			'Mon' => '8:00am-12:00pm, 1:00pm-1:30am',
			'Tue' => '8:00am-12:00pm, 1:00pm-1:30am',
			'Wed' => '-',
			'Thu' => '8:00am-12:00pm, 1:00pm-1:30am',
			'Fri' => '8:00am-12:00pm, 1:00pm-1:30am',
			'Sat' => '-',
			'Sun' => '8:00am-1:30am',
		], $sh->hours_this_week());
	}

	public function testHoursOverviewGrouped() {
		$sh = new StoreHours([]);
		$this->assertEquals([], $sh->hours_this_week(true));

		$sh = new StoreHours(['fri' => ['']]);
		$this->assertEquals([], $sh->hours_this_week(true));

		$sh = new StoreHours([
			'sun' => ['08:00-12:00'],
		]);
		$this->assertEquals([
			'Sun' => '8:00am-12:00pm',
		], $sh->hours_this_week(true));

		$sh = new StoreHours([
			'mon' => ['08:00-12:00', '13:00-1:30'],
			'tue' => ['08:00-12:00', '13:00-1:30'],
		]);
		$this->assertEquals([
			'Mon, Tue' => '8:00am-12:00pm, 1:00pm-1:30am',
		], $sh->hours_this_week(true));

		$sh = new StoreHours([
			'mon' => ['08:00-12:00', '13:00-1:30'],
			'tue' => ['08:00-12:00', '13:00-1:30'],
			'wed' => ['08:00-12:00', '13:00-1:30'],
		]);
		$this->assertEquals([
			'Mon-Wed' => '8:00am-12:00pm, 1:00pm-1:30am',
		], $sh->hours_this_week(true));

		$sh = new StoreHours([
			'mon' => ['08:00-12:00', '13:00-1:30'],
			'tue' => ['08:00-12:00', '13:00-1:30'],
			'thu' => ['08:00-12:00', '13:00-1:30'],
			'fri' => ['08:00-12:00', '13:00-1:30'],
			'sun' => ['08:00-1:30'],
		]);
		$this->assertEquals([
			'Mon, Tue, Thu, Fri' => '8:00am-12:00pm, 1:00pm-1:30am',
			'Sun' => '8:00am-1:30am',
		], $sh->hours_this_week(true));

		$sh = new StoreHours([
			'mon' => ['08:00-12:00', '13:00-1:30'],
			'tue' => ['08:00-12:00', '13:00-1:30'],
			'wed' => ['08:00-12:00', '13:00-1:30'],
			'fri' => ['08:00-12:00', '13:00-1:30'],
			'sat' => ['08:00-12:00', '13:00-1:30'],
			'sun' => ['08:00-12:00', '13:00-1:30'],
		]);
		$this->assertEquals([
			'Mon-Wed, Fri-Sun' => '8:00am-12:00pm, 1:00pm-1:30am',
		], $sh->hours_this_week(true));
	}

	/**
	 * @return \StoreHours
	 */
	private function instantiateWithDefaultData() {
		$hours = [
			'mon' => ['11:00-20:30'],
			'tue' => ['11:00-13:00', '18:00-20:30'],
			'wed' => ['11:00-20:30'],
			'thu' => ['11:00-1:30'], // Open late
			'fri' => ['11:00-20:30'],
			'sat' => ['11:00-20:00'],
			'sun' => [''], // Closed all day
		];

		$exceptions = [
			'2/24' => ['11:00-18:00'],
			'10/18' => ['11:00-16:00', '18:00-20:30'],

			'2016-02-01' => ['09:00-11:00'],
		];

		return new StoreHours($hours, $exceptions);
	}
}
