<?php

namespace Retailexpress\Giftcard\Model\Total;


use Magento\Quote\Model\Quote\Address\Total\AbstractTotal;

class GiftCardAmount extends AbstractTotal
{
	protected $_code = 'giftcard';

	/**
	 * @var \Magento\Framework\Pricing\PriceCurrencyInterface
	 */
	protected $_priceCurrency;
	/**
	 * Custom constructor.
	 * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
	 */
	public function __construct(
		\Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
	){
		$this->_priceCurrency = $priceCurrency;
	}
	/**
	 * @param \Magento\Quote\Model\Quote $quote
	 * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
	 * @param \Magento\Quote\Model\Quote\Address\Total $total
	 * @return $this|bool
	 */
	public function collect(
		\Magento\Quote\Model\Quote $quote,
		\Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
		\Magento\Quote\Model\Quote\Address\Total $total
	)
	{
		parent::collect($quote, $shippingAssignment, $total);

		if (!count($shippingAssignment->getItems())) return $this;

		$giftAmount = $quote->getGiftcardAmount();

		if ( empty($giftAmount) ) $giftAmount = 0;

		$baseDiscount = $giftAmount;
		$discount =  $this->_priceCurrency->convert($baseDiscount);
		$total->addTotalAmount('giftcard', -$discount);
		$total->addBaseTotalAmount('giftcard', -$baseDiscount);

		return $this;
	}

	/**
	 * Assign subtotal amount and label to address object
	 *
	 * @param \Magento\Quote\Model\Quote $quote
	 * @param \Magento\Quote\Model\Quote\Address\Total $total
	 * @return array
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 */
	public function fetch(
		\Magento\Quote\Model\Quote $quote,
		\Magento\Quote\Model\Quote\Address\Total $total
	)
	{
		$result = [
			'code' => $this->getCode(),
			'title' => __('Giftcard payment'),
			'value' => $quote->getGiftcardAmount()
		];
		return $result;
	}
}