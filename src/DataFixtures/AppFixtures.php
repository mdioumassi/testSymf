<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\Product;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = factory::create();
        for ($i = 0; $i<10; $i++) {
            $order = new Order();
            $user = new Users();
            $product = new Product();
            $orderProduct = new OrderProduct();
            $address = new Address();

            $product
                ->setPrice($faker->randomNumber())
                ->setLabel($faker->text(20))
                ->setRef($faker->uuid);

            $address
                ->setStreet($faker->streetAddress)
                ->setZip($faker->postcode)
                ->setCity($faker->city);

            $user
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setEmail($faker->email)
                ->setAddress($address);

            $order
                ->setUsers($user)
                ->setMarketplace($faker->text(20));

            $orderProduct
                ->setQte($i+1)
                ->setOrders($order)
                ->setProducts($product);

            $manager->persist($orderProduct);
            $manager->flush();
        }
    }
}
