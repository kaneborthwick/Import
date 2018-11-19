<?php

namespace Towersystems\Import\StopWatch;

/**
 *
 */
class StopWatch implements StopWatchInterface {

	/**
	 * [$time description]
	 * @var [type]
	 */
	protected $timeStart;

	/**
	 * [$timeStop description]
	 * @var [type]
	 */
	protected $timeStop;

	/**
	 * {@inheritdoc}
	 */
	public function reset(): void{
		$this->timeStart = null;
		$this->timeStop = null;
	}

	/**
	 * {@inheritdoc}
	 */
	public function start(): void{
		$this->timeStart = microtime(true);
	}

	/**
	 * {@inheritdoc}
	 */
	public function stop(): void{
		$this->timeStop = microtime(true);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDuration(): float {
		return $this->timeStop - $this->timeStart;
	}

}