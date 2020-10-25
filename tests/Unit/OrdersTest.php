<?php


namespace App\Tests\Unit;


use App\Entity\Address;
use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\Product;
use App\Entity\Users;
use PHPUnit\Framework\TestCase;

class OrdersTest extends TestCase
{
    /**
     * @var OrderProduct
     */
    private $orders;

    protected function setUp()
    {
        parent::setUp();
        $this->orders = new OrderProduct();
    }

    public function testGetOrders()
    {
        $order = new Order();
        $user = new Users();
        $product = new Product();
        $address = new Address();

        $product
            ->setPrice('10')
            ->setLabel('Crème')
            ->setRef('4122');
        $address
            ->setStreet('rue emile zola')
            ->setZip('93300')
            ->setCity('La courneuve');

        $user
            ->setFirstname('Sidi')
            ->setLastname('Diawara')
            ->setEmail('toto@tata.fr')
            ->setAddress($address);

        $order
            ->setUsers($user)
            ->setMarketplace('ZOOZOO');

       $this->orders
            ->setQte('10')
            ->setOrders($order)
            ->setProducts($product);

        self::assertInstanceOf(OrderProduct::class,  $this->orders);
        self::assertEquals('10', $this->orders->getQte());
        self::assertEquals('Crème', $this->orders->getProducts()->getLabel());
        self::assertEquals('ZOOZOO', $this->orders->getOrders()->getMarketplace());
    }
}