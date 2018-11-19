<?php

namespace Towersystems\Import\Processor;

interface ResourceProcessorInterface {

	/**
	 * [process description]
	 * @param  array  $data [description]
	 * @return [type]       [description]
	 */
	public function process(array $data): void;
}