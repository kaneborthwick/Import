<?php

declare (strict_types = 1);

namespace Towersystems\Import\Processor;

use Zend\Stdlib\PriorityQueue;

final class CompositeResourceProcessor implements ResourceProcessorInterface {

	/**
	 * @var PriorityQueue|resourceDeltaProcessorInterface[]
	 */
	private $resourceDeltaProcessors;

	/**
	 * [__construct description]
	 */
	public function __construct() {
		$this->resourceDeltaProcessors = new PriorityQueue();
	}

	/**
	 * {@inheritdoc}
	 */
	public function addProcessor(ResourceProcessorInterface $resourceDeltaProcessor, $priority = 0) {
		$this->resourceDeltaProcessors->insert($resourceDeltaProcessor, $priority);
	}

	/**
	 * {@inheritdoc}
	 */
	public function process(array $resourceDelta): void {
		foreach ($this->resourceDeltaProcessors as $resourceDeltaProcessor) {
			$resourceDeltaProcessor->process($resourceDelta);
		}
	}

}
