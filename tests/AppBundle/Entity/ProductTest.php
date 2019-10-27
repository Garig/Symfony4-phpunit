<?php

namespace Tests\AppBundle\Entity;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testcomputeTVAFoodProduct()
    {
        $product = new Product('Un produit', Product::FOOD_PRODUCT, 20);

        $result = $product->computeTVA();
        //ca teste un === entre les 2 valeurs
        $this->assertSame(1.1, $result);
    }

    public function testComputeTVAOtherProduct()
    {
        $product = new Product('Un autre produit', 'Un autre type de produit', 20);

        $this->assertSame(3.92, $product->computeTVA());
    }

    public function testNegativePriceComputeTVA()
    {
        $product = new Product('Un produit', Product::FOOD_PRODUCT, -20);

        $this->expectException('LogicException');

        $product->computeTVA();
    }

    /**
     * @dataProvider pricesForFoodProduct
     */
    public function testcomputeTVAFoodProductArgs($price, $expectedTva)
    {
        $product = new Product('Un produit', Product::FOOD_PRODUCT, $price);

        $this->assertSame($expectedTva, $product->computeTVA());
    }

    public function pricesForFoodProduct()
    {
        return [
            [0, 0.0],
            [20, 1.1],
            [100, 5.5]
        ];
    }
}