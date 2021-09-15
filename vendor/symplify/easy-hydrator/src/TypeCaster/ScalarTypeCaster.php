<?php

declare(strict_types=1);

namespace Symplify\EasyHydrator\TypeCaster;

use ReflectionParameter;
use Symplify\EasyHydrator\ClassConstructorValuesResolver;
use Symplify\EasyHydrator\Contract\TypeCasterInterface;
use Symplify\EasyHydrator\ParameterTypeRecognizer;

final class ScalarTypeCaster implements TypeCasterInterface
{
    public function __construct(
        private ParameterTypeRecognizer $parameterTypeRecognizer
    ) {
    }

    public function isSupported(ReflectionParameter $reflectionParameter): bool
    {
        $type = $this->parameterTypeRecognizer->getType($reflectionParameter);

        return in_array($type, ['string', 'bool', 'int', 'float'], true);
    }

    public function retype(
        $value,
        ReflectionParameter $reflectionParameter,
        ClassConstructorValuesResolver $classConstructorValuesResolver
    ) {
        $type = $this->parameterTypeRecognizer->getType($reflectionParameter);

        if ($value === null && $reflectionParameter->allowsNull()) {
            return null;
        }

        if ($type === 'string') {
            return (string) $value;
        }

        if ($type === 'bool') {
            return (bool) $value;
        }

        if ($type === 'int') {
            return (int) $value;
        }

        if ($type === 'float') {
            return (float) $value;
        }

        return $value;
    }

    public function getPriority(): int
    {
        return 10;
    }
}
