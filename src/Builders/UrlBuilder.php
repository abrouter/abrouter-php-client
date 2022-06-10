<?php

declare(strict_types=1);

namespace Abrouter\Client\Builders;

use Abrouter\Client\Config\Accessors\HostConfigAccessor;

class UrlBuilder
{
    public const RUN_EXPERIMENT_API_URL = 'api/v1/experiment/run';
    public const RUN_FEATURE_FLAG_API_URL = 'api/v1/feature-toggles/run';
    public const SEND_EVENT_API_URL = 'api/v1/event';
    public const FETCH_BRANCHES_API_URL = 'api/v1/experiments';
    public const ADD_USER_TO_EXP = 'api/v1/experiments/add-user';
    public const LIST_EXPERIMENT_USERS = 'api/v1/experiments/have-user/{id}';
    public const LIST_USER_EVENTS = 'api/v1/statistics/user/{id}';

    /**
     * @var HostConfigAccessor
     */
    private HostConfigAccessor $hostConfigAccessor;


    private string $url;

    public function __construct(HostConfigAccessor $hostConfigAccessor)
    {
        $this->hostConfigAccessor = $hostConfigAccessor;
        $this->host = $hostConfigAccessor->getHost();
    }

    public function runExperimentUri(): self
    {
        return $this->setUrl(self::RUN_EXPERIMENT_API_URL);
    }

    public function addUserToExp(): self
    {
        return $this->setUrl(self::ADD_USER_TO_EXP);
    }

    public function fetchBranchesUri(string $alias = null): self
    {
        //todo: make it in the right way
        $filter = '';
        if ($alias !== null) {
            $filter = '?include=branches&filter[alias]=' . $alias;
        }

        return $this->setUrl(self::FETCH_BRANCHES_API_URL . $filter);
    }

    public function runFeatureFlagUri(): self
    {
        return $this->setUrl(self::RUN_FEATURE_FLAG_API_URL);
    }

    public function sendEventUri()
    {
        return $this->setUrl(self::SEND_EVENT_API_URL);
    }

    public function listExperimentUsersUri(string $id): self
    {
        return $this->setUrl(str_replace('{id}', $id, self::LIST_EXPERIMENT_USERS));
    }

    public function listUserEvents(string $id): self
    {
        return $this->setUrl(str_replace('{id}', $id, self::LIST_USER_EVENTS));
    }

    public function build(): string
    {
        return $this->injectHost($this->url);
    }

    private function reset()
    {
        $this->url = '';
        return $this;
    }

    private function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    private function injectHost(string $uri)
    {
        return join('/', [$this->hostConfigAccessor->getHost(), $uri]);
    }
}
