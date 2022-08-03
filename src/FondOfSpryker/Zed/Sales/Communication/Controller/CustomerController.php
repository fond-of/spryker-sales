<?php

namespace FondOfSpryker\Zed\Sales\Communication\Controller;

use Spryker\Zed\Sales\Communication\Controller\CustomerController as SprykerCustomerController;
use Spryker\Zed\Sales\SalesConfig;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Spryker\Zed\Sales\Communication\SalesCommunicationFactory getFactory()
 * @method \Spryker\Zed\Sales\Business\SalesFacadeInterface getFacade()
 * @method \Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface getQueryContainer()
 * @method \Spryker\Zed\Sales\Persistence\SalesRepositoryInterface getRepository()
 */
class CustomerController extends SprykerCustomerController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function ordersTableAction(Request $request)
    {
        $customerReference = (string)$request->query->get(SalesConfig::PARAM_CUSTOMER_REFERENCE);
        $ordersTable = $this->getFactory()->createCustomerOrdersTable($customerReference);

        return $this->jsonResponse($ordersTable->fetchData());
    }
}
