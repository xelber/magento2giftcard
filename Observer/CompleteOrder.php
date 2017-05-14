<?php

namespace Retailexpress\Giftcard\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Retailexpress\Giftcard\Model\Api\Retailexpress;

/**
 * Class CompleteOrder
 * @package Retailexpress\Giftcard\Observer
 *
 * Once the order is completed, retail express API will be called to create order and add payment
 */
class CompleteOrder implements ObserverInterface
{

	public function execute(Observer $observer)
	{
		//$order = $observer->getEvent()->getData('order'); /** @var $order \Magento\Sales\Model\Order **/

		//if ( empty($order->getGiftcardAmount()) ) return $this; // If no gift card is used, return early

		//$re = new Retailexpress();
		//$re->orderCreateByChannel($re);
		// TODO - Figure out the payment methods IDs using ProductsGetBulkDetailsByChannel
		// TODO - Add payment for both normal and giftcard payment methods
		return $this;
	}
}