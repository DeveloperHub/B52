<?php
/**
 * Class NewsPresenter
 */

namespace ClientModule;

class NewsPresenter extends BasePresenter
{
	/** @var \NewsRepository */
	private $newsRepository;


	protected function startup()
	{
		parent::startup();

		$this->newsRepository = $this->context->newsRepository;
	}

	public function renderDefault()
	{

	}
}
