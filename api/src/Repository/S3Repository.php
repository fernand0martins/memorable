<?php


namespace App\Repository;

use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;

class S3Repository
{
    /** @var string */
    private $s3BucketName;

    /** @var S3Client */
    private $s3Client;

    /**
     * AppFixtures constructor.
     * @param string $s3Region
     * @param string $s3BucketName
     * @param string $s3Key
     * @param string $s3Secret
     */
    public function __construct(
        string $s3Region,
        string $s3BucketName,
        string $s3Key,
        string $s3Secret
    )
    {
        $this->s3BucketName = $s3BucketName;

        $this->s3Client = new S3Client([
            'version' => 'latest',
            'region' => $s3Region,
            'credentials' => [
                'key' => $s3Key,
                'secret' => $s3Secret
            ]
        ]);
    }

    /**
     * Upload a dummy txt file to S3
     * @param string $fileName
     * @param string $fileBody
     * @param string $permissions
     * @return string
     */
    PUBLIC function uploadS3TextFile(
        string $fileName,
        string $fileBody,
        string $permissions = 'public-read'
    ): string
    {
        try {
            $result = $this->s3Client->putObject([
                'Bucket' => $this->s3BucketName,
                'Key' => $fileName,
                'Body' => $fileBody,
                'ACL' => $permissions
            ]);
        } catch (S3Exception $e) {
            //todo logger here
            echo $e->getMessage() . PHP_EOL;
        }

        return $result['ObjectURL'] ?? '';
    }

    /**
     * Upload a dummy image file to S3
     * @param string $fileName
     * @param string $filePath
     * @return string
     */
    public function uploadS3ImageFile(string $fileName, string $filePath): string
    {
        try {
            if (!file_exists('/tmp/tmpfile')) {
                mkdir('/tmp/tmpfile');
            }

            // Create temp file
            $tempFilePath = '/tmp/tmpfile/' . $fileName;
            $tempFile = fopen($tempFilePath, "w") or die("Error: Unable to open file.");
            $fileContents = file_get_contents(__DIR__ . $filePath);
            file_put_contents($tempFilePath, $fileContents);

            // Put on S3
            $result = $this->s3Client->putObject(
                array(
                    'Bucket' => $this->s3BucketName,
                    'Key' => $fileName,
                    'SourceFile' => $tempFilePath,
                    'ACL' => 'public-read'
                )
            );

        } catch (S3Exception $e) {
            //todo logger here
            echo $e->getMessage() . PHP_EOL;
        }

        return $result['ObjectURL'] ?? '';
    }
}
