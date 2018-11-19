<?php

namespace Towersystems\Import\Importer;

interface ImporterInterface {

	/**
	 * @param  $data
	 *
	 * @return ImporterResultInterface
	 */
	public function import($data): ImporterResultInterface;

	/**
	 * [importData description]
	 *
	 * @param  int    $i   [description]
	 * @param  array  $row [description]
	 *
	 * @return bool      [description]
	 */
	public function importData(int $i, array $row): bool;
}