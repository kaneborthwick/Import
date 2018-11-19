<?php

namespace Towersystems\Import\Importer;

use Towersystems\Import\StopWatch\StopWatch;

class ImporterResult implements ImporterResultInterface {

	/**
	 * @var StopWatch
	 */
	private $stopwatch;

	/**
	 * @var int[]
	 */
	private $success = [];

	/**
	 * @var int[]
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
	public function success(int $rowNum): void{
		$this->success[] = $rowNum;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getSuccessRows(): array
	{
		return $this->success;
	}

	/**
	 * {@inheritdoc}
	 */
	public function failed(int $rowNum, $errorMsg = ""): void{
		$this->failed[] = ['row' => $rowNum, 'error' => $errorMsg];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getFailedRows(): array
	{
		return $this->failed;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDuration(): float {
		return $this->stopwatch->getDuration();
	}

}