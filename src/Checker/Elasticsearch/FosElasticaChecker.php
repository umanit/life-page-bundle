<?php

declare(strict_types=1);

namespace Umanit\LifePageBundle\Checker\Elasticsearch;

use FOS\ElasticaBundle\Elastica\Client;
use Umanit\LifePageBundle\Checker\CheckerInterface;

class FosElasticaChecker implements CheckerInterface
{
    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getName(): string
    {
        return '[Elasticsearch] Client connection';
    }

    public function check(): ?bool
    {
        try {
            $this->client->getVersion();

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
