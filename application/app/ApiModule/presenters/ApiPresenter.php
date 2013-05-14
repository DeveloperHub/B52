<?php
/**
 * Class ApiPresenter
 */

namespace ApiModule;

use \Nette\Application\Responses\JsonResponse;

class ApiPresenter extends \BasePresenter
{
	/** @var \Nette\Http\Request */
	private $request;

	/** @var \FlashMessagesRepository */
	private $flashMessagesRepository;

	/** @var \OrdersRepository */
	private $ordersRepository;


	protected function startup()
	{
		parent::startup();

		$this->request = $this->context->httpRequest;
		$this->flashMessagesRepository = $this->context->flashMessagesRepository;
		$this->ordersRepository = $this->context->ordersRepository;
	}


	public function actionNotificationsClient()
	{
		$id = $this->request->getQuery('id');
		$count = $this->flashMessagesRepository->getCountUnreadForClient($id);
		$this->sendResponse(new JsonResponse(array('countMessages' => $count)));
	}

	public function actionNotificationsWaitress()
	{
		$count = $this->flashMessagesRepository->getCountUnreadForWaitress();
		$this->sendResponse(new JsonResponse(array('countMessages' => $count)));
	}


	public function actionIsNewOrders()
	{
		$interval = $this->request->getQuery('interval');
		$countNew = $this->ordersRepository->getCountNew($interval);
		$this->sendResponse(new JsonResponse(array('isNewOrders' => (bool)$countNew)));
	}
}
