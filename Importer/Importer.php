<?php

namespace Towersystems\Import\Importer;

use Doctrine\Common\Persistence\ObjectManager;
use Towersystems\Import\Exception\ImporterException;
use Towersystems\Import\Processor\ResourceProcessorInterface;

class Importer implements ImporterInterface {

	/**
	 * @var ResourceProcessorInterface
	 */
	protected $resourceProcessor;

	/**
	 * @var ImporterResultInterface
	 */
	protected $result;

	/**
	 * @var ObjectManager
	 */
	protected $objectManager;

	/**
	 * @var integer
	 */
	protected $batchCount = 0;

	/**
	 * [__construct description]
	 *
	 * @param ResourceProcessorInterface $resourceProcessor [description]
	 * @param ImporterResultInterface    $result            [description]
	 * @param ObjectManager              $objectManager     [description]
	 * @param int                        $batchSize         [description]
	 */
	public function __construct(
		ResourceProcessorInterface $resourceProcessor,
		ImporterResultInterface $result,
		ObjectManager $objectManager,
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
	public function import($fileName): ImporterResultInterface{

		$this->result->start();

		if ($this->batchCount) {
			$this->objectManager->flush();
		}

		$this->result->stop();

		return $this->result;

	}

	/**
	 * {@inheritdoc}
	 */
	public function importData(int $i, array $row): bool {
		try {
			$this->resourceProcessor->process($row);
			$this->result->success($i);
			++$this->batchCount;
			if ($this->batchSize && $this->batchCount === $this->batchSize) {
				$this->objectManager->flush();
				$this->batchCount = 0;
			}
		} catch (ImporterException $e) {
			$this->result->failed($i, $e->getMessage());
			return false;
		}

		return true;
	}

}