<?php

namespace Towersystems\Import\Importer;

interface ImporterResultInterface {

	/**
	 * [start description]
	 * @return void [description]
	 */
	public function start(): void;

	/**
	 * [stop description]
	 * @return void [description]
	 */
	public function stop(): void;

	/**
	 * [success description]
	 * @param  int    $rowNum [description]
	 * @return void         [description]
	 */
	public function success(int $rowNum): void;

	/**
	 * [failed description]
	 * @param  int    $rowNum [description]
	 * @return void         [description]
	 */
	public function failed(int $rowNum, $errorMsg = ""): void;

	/**
	 * [getDuration description]
	 * @return float [description]
	 */
	public function getDuration(): float;

	/**
	 * [getSuccessRows description]
	 * @return array [description]
	 */
	public function getSuccessRows(): array;

	/**
	 * [getFailedRows description]
	 * @return array [description]
	 */
	public function getFailedRows(): array;
}