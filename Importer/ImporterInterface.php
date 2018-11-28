<?php

namespace Towersystems\Import\Importer;

interface ImporterInterface {

	/**
	 * @param  $dataset
	 *
	 * @return ImporterResultInterface
	 */
	public function import($dataset): ImporterResultInterface;

	/**
	 * [importData description]
	 *
	 * @param  $index [description]
	 * @param  $data  [description]
	 *
	 * @return bool   [description]
	 */
	public function importData($index, $data): bool;
}