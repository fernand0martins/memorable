<?php

declare(strict_types=1);

namespace App\Swagger;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * This class decorates the swagger ui to have a authentication button on the top
 * Class SwaggerDecorator
 * @package App\Swagger
 */
final class SwaggerDecorator implements NormalizerInterface
{
    /** @var NormalizerInterface */
    private NormalizerInterface $decorated;

    /**
     * SwaggerDecorator constructor.
     * @param NormalizerInterface $decorated
     */
    public function __construct(NormalizerInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    /**
     * @param mixed $data
     * @param string|null $format
     * @return bool
     */
    public function supportsNormalization($data, string $format = null): bool
    {
        return $this->decorated->supportsNormalization($data, $format);
    }

    /**
     * @param mixed $object
     * @param string|null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|string|null
     * @throws ExceptionInterface
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $docs = $this->decorated->normalize($object, $format, $context);

        $tokenDocumentation = [
            'paths' => [
                '/jwt/register' => [
                    'post' => [
                        'tags' => ['JWT'],
                        'operationId' => 'postCredentialsItem',
                        'summary' => 'Create account',
                        'parameters' => [
                           [
                               'name' => 'User',
                               'in' => 'body',
                               'schema' => [
                                   'type' => 'object',
                                   'properties' => [
                                       'username' => [
                                           'type' => 'string',
                                           'example' => 'api',
                                       ],
                                       'password' => [
                                           'type' => 'string',
                                           'example' => 'api',
                                       ],
                                   ],
                               ]
                           ]
                        ],
                        'responses' => [
                            Response::HTTP_OK => [
                                'description' => 'Create account'
                            ],
                        ],
                    ],
                ],
                '/jwt/login' => [
                    'post' => [
                        'tags' => ['JWT'],
                        'operationId' => 'postCredentialsItem',
                        'summary' => 'Get JWT token',
                        'parameters' => [
                            [
                                'name' => 'User',
                                'in' => 'body',
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'username' => [
                                            'type' => 'string',
                                            'example' => 'api',
                                        ],
                                        'password' => [
                                            'type' => 'string',
                                            'example' => 'api',
                                        ],
                                    ],
                                ]
                            ]
                        ],
                        'responses' => [
                            Response::HTTP_OK => [
                                'description' => 'Get JWT token',
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'token' => [
                                                    'type' => 'string',
                                                    'readOnly' => true,
                                                ],
                                            ],
                                        ]
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return array_merge_recursive($docs, $tokenDocumentation);
    }
}
