<?php

declare(strict_types=1);

namespace App\Controller;

use App\Presenter\Product;
use App\Queue\Status;
use App\Request;
use FOS\RestBundle\Controller\Annotations as Rest;
use ProductsCatalog\Application\Bus\CommandBus\CommandBus;
use ProductsCatalog\Application\Command\AddNewProductCommand;
use ProductsCatalog\Shared\Exception\InvalidUidHashException;
use ProductsCatalog\Shared\Uid;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ProductsController extends ApiController
{
    /** @var CommandBus */
    private $commandBus;

    /** @var Product\Presenter */
    private $productPresenter;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        CommandBus $commandBus,
        Product\Presenter $productPresenter,
        LoggerInterface $logger
    ) {
        $this->commandBus = $commandBus;
        $this->productPresenter = $productPresenter;
        $this->logger = $logger;
    }

    /**
     * @Rest\Route(
     *     "api/products",
     *     format="json",
     *     condition="request.attributes.get('version') == 'v2'",
     *     methods={"POST"}
     * )
     * @ParamConverter("request", converter="fos_rest.request_body")
     */
    public function postProductsAction(
        Request\AddNewProduct $request,
        ConstraintViolationListInterface $validationErrors
    ) {
        try {
            if ($validationErrors->count()) {
                return $this->prepareValidationErrorsResponse($validationErrors);
            }

            $uid = new Uid();

            $command = new AddNewProductCommand(
                (string) $uid,
                $request->name,
                $request->priceAmount,
                $request->priceCurrency
            );

            //we can make query here to make some checks, ex. unique name

            $this->commandBus->handle($command);

            return $this->preparePostSuccessResponse(
                new Status(Status::PENDING),
                $uid
            );
        } catch (\Throwable $error) {
            $this->logger->error($error);
            throw new \RuntimeException('Internal error');
        }
    }

    /**
     *
     * @Rest\Route(
     *     "api/products/{uidHash}",
     *     format="json",
     *     methods={"GET"}
     * )
     */
    public function getProductsAction(string $uidHash)
    {
        try {
            $uid = new Uid($uidHash);

            //create query
        } catch (InvalidUidHashException $exception) {
            $violationList = new ConstraintViolationList([
                new ConstraintViolation(
                    $exception->getMessage(),
                    null,
                    [],
                    $uidHash,
                    null,
                    $uidHash
                )
            ]);
            return $this->prepareValidationErrorsResponse($violationList);
        } catch (\Throwable $error) {
            $this->logger->error($error);

            throw new \RuntimeException('Internal error');
        }
    }
}
