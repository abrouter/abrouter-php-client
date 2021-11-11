<?php
declare(strict_types = 1);

namespace Abrouter\Client\Transformers;

use Abrouter\Client\Entities\Client\Response;
use Abrouter\Client\Entities\RunExperiment;
use Abrouter\Client\Exceptions\InvalidJsonApiResponseException;
use Abrouter\Client\JsonApiParser\Parser;
use \Exception;

class RunExperimentRequestTransformer
{
    /**
     * @param Response $response
     *
     * @return RunExperiment
     * @throws InvalidJsonApiResponseException
     */
    public function transform(Response $response): RunExperiment
    {
        try {
            $json = Parser::parse($response->getResponseJson());
            
            $branchUid = $json->getAttributes()['branch-uid'];
            $experimentUid = $json->getAttributes()['experiment-uid'];
            
            return new RunExperiment($branchUid, $experimentUid);
        } catch (Exception $e) {
            throw new InvalidJsonApiResponseException($e->getMessage());
        }
    }
}
