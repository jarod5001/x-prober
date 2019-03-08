<?php

namespace InnStudio\Prober\Components\Benchmark;

use InnStudio\Prober\Components\Events\EventsApi;
use InnStudio\Prober\Components\Helper\HelperApi;
use InnStudio\Prober\Components\I18n\I18nApi;

class Benchmark extends BenchmarkApi
{
    public function __construct()
    {
        EventsApi::on('init', array($this, 'filter'));
    }

    public function filter()
    {
        if ( ! HelperApi::isAction('benchmark')) {
            return;
        }

        $this->display();
    }

    public function display()
    {
        $remainingSeconds = $this->getRemainingSeconds();

        if ($remainingSeconds) {
            HelperApi::dieJson(array(
                'code' => -1,
                'msg'  => '⏳ ' . \sprintf(I18nApi::_('Please wait %d seconds'), $remainingSeconds),
            ));
        }

        $this->saveTmpRecorder();

        \set_time_limit(0);

        $points = $this->getPoints();

        HelperApi::dieJson(array(
            'code' => 0,
            'data' => array(
                'points'     => $points,
                'total'      => \array_sum($points),
                'totalHuman' => \number_format(\array_sum($points)),
            ),
        ));
    }
}
