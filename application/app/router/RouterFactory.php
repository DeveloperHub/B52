<?php

use Nette\Application\Routers\RouteList,
	Nette\Application\Routers\Route,
	Nette\Application\Routers\SimpleRouter;


/**
 * Router factory.
 */
class RouterFactory
{

	/**
	 * @return Nette\Application\IRouter
	 */
	public function createRouter()
	{
		$router = new RouteList();

		$router[] = $apiRouter = new RouteList('Api');
		$apiRouter[] = new Route('api/<presenter=Api>/<action>');

		$router[] = $adminRouter = new RouteList('Admin');
		$adminRouter[] = new Route('admin/<presenter>[/<action>][/<id>]', 'Homepage:default');

		$router[] = $waitressRouter = new RouteList('Waitress');
		$waitressRouter[] = new Route('waitress/<presenter=History>/<action=default>/<id>/<idMessage>');
		$waitressRouter[] = new Route('waitress/<presenter>[/<action>][/<id>]', 'Orders:default');

		$router[] = $clientRouter = new RouteList('Client');
		$clientRouter[] = new Route('<presenter=Orders>/<action=item>/<id>[/<idVariation>]');
		$clientRouter[] = new Route('<presenter>/<action>[/<id>]', 'Offer:default');

		return $router;
	}

}
