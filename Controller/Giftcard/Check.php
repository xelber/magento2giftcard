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


class Check extends Action
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
		$code = $this->getRequest()->getParam('code');
		$data = [
			'success' => false
		];
		if ( empty($code) ) return $result->setData($data);

		$re = new Retailexpress();
		$balance = $re->voucherGetBalance($code);

		if ( empty($balance) ) return $result->setData($data);

		$quote = $this->session->getQuote();
		$grand = $quote->getGrandTotal();
		$applied = min($grand, $balance);
		$quote->setGiftcardAmount($applied);
		$quote->setGiftcardCode($code);
		$quote->collectTotals();
		$quote->save();
		$data['success'] = TRUE;
		$data['balance'] = $balance;

		return $result->setData($data);
	}
}