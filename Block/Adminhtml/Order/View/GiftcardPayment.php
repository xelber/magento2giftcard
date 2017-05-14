<?php
/**
 * Created by PhpStorm.
 * User: hiran.milinda
 * Date: 14/5/17
 * Time: 9:03 AM
 */

namespace Retailexpress\Giftcard\Block\Adminhtml\Order\View;



class GiftcardPayment extends \Magento\Framework\View\Element\Template
{
	/**
	 * @return \Magento\Sales\Model\Order
	 */
	public function getOrder()
	{
		return $this->getParentBlock()->getOrder();
	}

	public function isGiftCardOrder()
	{
		$order = $this->getOrder();
		return !empty($order->getGiftcardAmount());
	}

	public function getGiftCardAmount()
	{
		return $this->getOrder()->getGiftcardAmount();
	}

	public function getGiftCardCode()
	{
		return $this->getOrder()->getGiftcardCode();
	}
}