<?php
namespace LoyaltyProgram\RewardPoint\Block;

class MyPoint extends \Magento\Framework\View\Element\Template
{
	protected $customer;
	public function __construct(
		\Magento\Framework\App\Request\Http $request,
		\Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
		\Magento\Customer\Model\SessionFactory $customerSession,
		\Magento\Framework\View\Element\Template\Context $context)
	{
		$this->request = $request;
		$this->customerRepository = $customerRepository;
		$this->_customerSession = $customerSession;
		parent::__construct($context);
	}

	public function sayHello()
	{
		return __('Hello World');
	}

	// public function sayDate()
	// {
	// 	$date = $this->date->gmtDate();
	// 	$date = $this->timezone->date(new \DateTime($date))->format('m/d/y H:i:s');
	// 	return $date;
	// }


	public function getCustomerId(){
		$customer = $this->_customerSession->create();
		return $customer->getCustomer()->getId();
	}
}
