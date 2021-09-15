<?php

namespace Symfonic;

use Symfonic\Builder\HttpKernel\BuilderKernel;
use Symplify\SymplifyKernel\ValueObject\KernelBootAndApplicationRun;

require_once __DIR__ . '/../../../vendor/autoload.php';

$application = new KernelBootAndApplicationRun(BuilderKernel::class);
$application->run();
