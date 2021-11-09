<?php
declare(strict_types = 1);

namespace Abrouter\Client\JsonApiParser\Entities;

class JsonApiEntity implements JsonApiEntityInterface
{
    /**
     * @var array
     */
    private $attributes;
    
    /**
     * @var array
     */
    private $relationships;
    
    /**
     * @var array
     */
    private ?array $meta;
    
    public function __construct(array $attributes, array $relationships, array $meta)
    {
        $this->attributes = $attributes;
        $this->relationships = $relationships;
        $this->meta = $meta;
    }
    
    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }
    
    /**
     * @return array
     */
    public function getRelationships(): ?array
    {
        return $this->relationships;
    }
    
    /**
     * @return array
     */
    public function getMeta(): ?array
    {
        return $this->meta;
    }
}
