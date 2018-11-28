<?php

namespace Towersystems\Import\Importer;

use Towersystems\Import\StopWatch\StopWatch;

class ImporterResult implements ImporterResultInterface {

	/**
	 * @var StopWatch
	 */
	private $stopwatch;

	/**
	 * @var array
	 */
	private $success = [];

	/**
	 * @var array
	 */
	private $failed = [];

	/**
	 * [__construct description]
	 * @param StopWatch $stopwatch [description]
	 */
	public function __construct(
		StopWatch $stopwatch
	) {
		$this->stopwatch = $stopwatch;
	}

	/**
	 * {@inheritdoc}
	 */
	public function start(): void{
		$this->stopwatch->start();
	}

	/**
	 * {@inheritdoc}
	 */
	public function stop(): void{
		$this->stopwatch->stop();
	}

	/**
	 * {@inheritdoc}
	 */
	public function success($index): void{
		$this->success[] = $index;
	}

	/**
	 * {@inheritdoc}
	 */
	public function failed($index, $errorMsg = ""): void{
		$this->failed[] = ['index' => $index, 'error' => $errorMsg];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSuccessRows(): array{
		return $this->success;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getFailedRows(): array{
		return $this->failed;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDuration(): float {
		return $this->stopwatch->getDuration();
	}

}