<?php
namespace AHT\Portfolio\Plugin;

use Magento\Framework\Interception;

class Product2
{
	public function aroundGetPrice(\Magento\Catalog\Model\Product $subject, callable $proceed)
	{

		      $result = $proceed(); /// Proceed cua callable dung de nhan lai gia tri tra ve cua phuong thuc khi chay xong phan befoce vs around(firts) => lay ket qua tra ve de thuc hien tiep cac around(s), after.
		      return $result + 500;
	}
}