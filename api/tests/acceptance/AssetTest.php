<?php

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Asset;

/**
 * Class AssetTest
 */
class AssetTest extends ApiTestCase
{
    /**
     * tests the assets endpoint to get a collection
     */
    public function testGetAssetCollection(): void
    {
        static::createClient()->request('GET', '/assets');
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceCollectionJsonSchema(Asset::class);
    }
}
