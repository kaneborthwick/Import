<?php

namespace Towersystems\Import\Importer;

use Doctrine\Common\Persistence\ObjectManager;
use Towersystems\Import\Exception\ImporterException;
use Towersystems\Import\Processor\ResourceProcessorInterface;

class Importer implements ImporterInterface {

	/**
	 * @var ImporterResultInterface
	 */
	protected $result;

	/**
	 * @var ObjectManager
	 */
	protected $objectManager;

	/**
	 * @var ResourceProcessorInterface
	 */
	protected $resourceProcessor;

	/**
	 * @var integer
	 */
	protected $batchCount = 0;

	/**
	 * [__construct description]
	 *
	 * @param ImporterResultInterface    $result            [description]
	 * @param ObjectManager              $objectManager     [description]
	 * @param ResourceProcessorInterface $resourceProcessor [description]
	 * @param int                        $batchSize         [description]
	 */
	public function __construct(
		ImporterResultInterface $result,
		ObjectManager $objectManager,
		ResourceProcessorInterface $resourceProcessor,
		int $batchSize = 25
	) {
		$this->resourceProcessor = $resourceProcessor;
		$this->result = $result;
		$this->objectManager = $objectManager;
		$this->batchSize = $batchSize;
	}

	/**
	 * {@inheritdoc}
	 */
	public function import($dataset): ImporterResultInterface{

		$this->result->start();

		foreach ($dataset as $index => $data) {
			$this->importData($index, $data);
		}

		$this->result->stop();

		return $this->result;
	}

	/**
	 * {@inheritdoc}
	 */
	public function importData($index, $data): bool {
		try {
			$this->resourceProcessor->process($data);
			$this->result->success($index);
			++$this->batchCount;
			if ($this->batchSize && $this->batchCount === $this->batchSize) {
				$this->objectManager->flush();
				$this->batchCount = 0;
			}
		} catch (ImporterException $e) {
			$this->result->failed($index, $e->getMessage());
			return false;
		}

		return true;
	}

}