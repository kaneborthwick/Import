<?php

namespace Towersystems\Import\Processor;

use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Towersystems\Resource\Factory\FactoryInterface;
use Towersystems\Resource\Model\ResourceInterface;
use Towersystems\Resource\Repository\RepositoryInterface;

/**
 *  Generic resource processor
 */
class ResourceProcessor extends ResourceProcessorInterface {

	/**
	 * @var FactoryInterface
	 */
	protected $resourceFactory;

	/**
	 * @var RepositoryInterface
	 */
	protected $resourceRepository;

	/**
	 * @var PropertyAccessorInterface
	 */
	protected $propertyAccessor;

	/**
	 * @var array
	 */
	protected $headerKeys;

	/**
	 * [__construct description]
	 *
	 * @param FactoryInterface    $resourceFactory    [description]
	 * @param RepositoryInterface $resourceRepository [description]
	 * @param array               $headerKeys         [description]
	 */
	function __construct(
		FactoryInterface $resourceFactory,
		RepositoryInterface $resourceRepository,
		PropertyAccessorInterface $propertyAccessor,
		array $headerKeys

	) {
		$this->resourceFactory = $resourceFactory;
		$this->resourceRepository = $resourceRepository;
		$this->propertyAccessor = $propertyAccessor;
		$this->headerKeys = $headerKeys;
	}

	/**
	 * {@inheritdoc}
	 */
	public function process(array $data): void{

		$resource = $this->getResource($data);

		foreach ($this->headerKeys as $headerKey) {
			if (false === $this->propertyAccessor->isReadable($resource, $headerKey)) {
				continue; // throw exception ?
			}

			$dataValue = $data[$headerKey];

			if (strlen((string) $dataValue) === 0 && !is_bool($dataValue)) {
				$dataValue = null;
			}

			$this->propertyAccessor->setValue($resource, $headerKey, $dataValue);
		}

		$this->resourceRepository->add($resource);

	}

	/**
	 * [getResource description]
	 *
	 * @param  array  $data [description]
	 * @return [type]       [description]
	 */
	private function getResource(array $data): ResourceInterface{

		$lowerCaseKey = strtolower(key($data));
		$resource = $this->resourceRepository->findOneBy([$lowerCaseKey => $data[key($data)]]);

		if (null === $resource) {
			$resource = $this->resourceFactory->createNew();
		}

		return $resource;
	}

}