<?php

namespace Retailexpress\Giftcard\Observer;


use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class UpdateGiftCardAmount
 * @package Retailexpress\Giftcard\Observer
 *
 * When creating order, gift card related information will be copied over from quote
 * Listen to sales_model_service_quote_submit_before event
 *
 */
class UpdateGiftCardAmount implements ObserverInterface
{

	public function execute(Observer $observer)
	{
		$order = $observer->getEvent()->getData('order');
		$quote = $observer->getEvent()->getData('quote');

		$order->setData('giftcard_code', $quote->getData('giftcard_code'));
		$order->setData('giftcard_amount', $quote->getData('giftcard_amount'));
		$order->setData('base_giftcard_amount', $quote->getData('base_giftcard_amount'));

		return $this;
	}
}