<?php

namespace App\DataFixtures;

use App\Entity\Asset;
use App\Repository\S3Repository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class AssetFixtures
 * @package App\DataFixtures
 */
class AssetFixtures extends Fixture
{
    /** @var S3Repository */
    private $s3Repository;

    /**
     * AssetFixtures constructor.
     * @param S3Repository $s3Repository
     */
    public function __construct(S3Repository $s3Repository)
    {
        $this->s3Repository = $s3Repository;
    }

    /**
     * Load data
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        //create 10 basic assets
        for ($i = 0; $i < 10; $i++) {
            $asset = new Asset();
            $asset->setName('basic_asset_' . $i);
            $manager->persist($asset);

        }

        //create txt dummy asset
        $txtFile = $this->s3Repository->uploadS3TextFile(
            'media_text_' . time() . '.txt',
            'time of creation: ' . time()
        );
        $textAsset = new Asset();
        $textAsset->setName('text_asset');
        $textAsset->setCollection(
            [
                'name' => 'dummy text file',
                'source' => $txtFile
            ]
        );
        $manager->persist($textAsset);

        //create image dummy asset
        $fileName ='dog_' . time() . '.jpg';
        $imageFile = $this->s3Repository->uploadS3ImageFile(
            $fileName,
            '/../../resources/dog.jpg'
        );
        $imageAsset = new Asset();
        $imageAsset->setName('image_asset');
        $imageAsset->setCollection(
            [
                'name' => 'dummy image file',
                'source' => $imageFile
            ]
        );
        $manager->persist($imageAsset);

        $manager->flush();
    }
}
