<?php

declare(strict_types=1);

namespace Symplify\SymplifyKernel\Strings;

use Nette\Utils\Strings;
use Symplify\SymplifyKernel\Exception\HttpKernel\TooGenericKernelClassException;
use Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;

final class KernelUniqueHasher
{
    private StringsConverter $stringsConverter;

    public function __construct()
    {
        $this->stringsConverter = new StringsConverter();
    }

    public function hashKernelClass(string $kernelClass): string
    {
        $this->ensureIsNotGenericKernelClass($kernelClass);

        $shortClassName = (string) Strings::after($kernelClass, '\\', -1);
        $userSpecificShortClassName = $shortClassName . get_current_user();

        return $this->stringsConverter->camelCaseToGlue($userSpecificShortClassName, '_');
    }

    private function ensureIsNotGenericKernelClass(string $kernelClass): void
    {
        if ($kernelClass !== AbstractSymplifyKernel::class) {
            return;
        }

        $message = sprintf('Instead of "%s", provide final Kernel class', AbstractSymplifyKernel::class);
        throw new TooGenericKernelClassException($message);
    }
}
