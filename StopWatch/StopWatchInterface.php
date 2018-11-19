<?php

namespace Towersystems\Import\StopWatch;

/**
 *
 */
interface StopWatchInterface {

	/**
	 * [reset description]
	 * @return [type] [description]
	 */
	public function reset(): void;

	/**
	 * [start description]
	 * @return [type] [description]
	 */
	public function start(): void;

	/**
	 * [stop description]
	 * @return [type] [description]
	 */
	public function stop(): void;

	/**
	 * [getDuration description]
	 * @return [type] [description]
	 */
	public function getDuration(): float;

}