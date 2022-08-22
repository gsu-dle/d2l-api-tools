<?php

declare(strict_types=1);

namespace GAState\Tools\D2L\Model\IPSIS;

use GAState\Tools\D2L\Model\D2LModel;
use ReflectionProperty;

class IPSISLogEntryModel extends D2LModel
{
    public ?string $DeveloperMessage = null;
    public ?string $ExceptionMessage = null;
    public ?string $LogDate = null;
    public ?string $Username = null;
    public ?string $TenantId = null;
    public ?string $SourceSystemId = null;
    public ?string $MessageId = null;
    public ?string $RecordType = null;
    public ?string $Operation = null;
    public ?string $SourcedId = null;
    public ?string $LogLevel = null;
    public ?int $HashValue = null;

    /**
     * @param object $values
     * 
     * @return void
     */
    public function setValues(object $values): void
    {
        $metadata = property_exists($values, "Metadata") && is_string($values->Metadata) ? json_decode($values->Metadata, true) : [];
        if (is_array($metadata)) {
            foreach ($metadata as $name => $value) {
                $name = str_ireplace('-str', '', $name);
                if (property_exists($this, $name)) {
                    (new ReflectionProperty($this, $name))->setValue($this, $value);
                }
            }
        }
        unset($values->Metadata);

        parent::setValues(values: $values);
    }
}
