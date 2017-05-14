<?php
/**
 * Created by PhpStorm.
 * User: hiran.milinda
 * Date: 13/5/17
 * Time: 6:21 PM
 */

namespace Retailexpress\Giftcard\Controller\Giftcard;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Retailexpress\Giftcard\Model\Api\Retailexpress;
use Magento\Checkout\Model\Session as CheckoutSession;


class Clear extends Action
{
	/**
	 * @var \Magento\Framework\Controller\Result\JsonFactory
	 */
	private $resultJsonFactory;
	/**
	 * @var CheckoutSession
	 */
	private $session;

	public function __construct(Context $context,
	                            \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
	                            CheckoutSession $session)
	{
		$this->resultJsonFactory = $resultJsonFactory;
		parent::__construct($context);
		$this->session = $session;
	}

	public function execute()
	{
		$result = $this->resultJsonFactory->create();

		$quote = $this->session->getQuote();
		$quote->setGiftcardAmount(0);
		$quote->save();
		return $result->setData([]);
	}
}