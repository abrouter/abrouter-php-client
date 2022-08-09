<?php

declare(strict_types=1);

namespace Abrouter\Client\DB\Dictionary;

class ParallelRunningDictionary
{
    public const IS_INITIAZLIED_KEY = 'parallelRunningIsInitialized';
    public const IS_RUNNING_KEY = 'parallelRunningReadyToServe';
    public const RELATED_USERS_KEY = 'parallelRunningRelatedUsers';

    public const IS_INITIAZLIED_TRUE_VALUE = 'initialized';
    public const IS_RUNNING_VALUE_TRUE = 'ready';
    public const IS_RUNNING_VALUE_STOPPED = 'stopped';
}
