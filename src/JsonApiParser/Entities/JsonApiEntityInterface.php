<?php
declare(strict_types = 1);

namespace Abrouter\Client\JsonApiParser\Entities;

interface JsonApiEntityInterface
{
    /**
     * @return array
     */
    public function getAttributes(): array;
    
    /**
     * @return array
     */
    public function getRelationships(): ?array;
    
    /**
     * @return array
     */
    public function getMeta(): ?array;
}
