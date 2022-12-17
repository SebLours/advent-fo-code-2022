<?php

use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\ForbiddenFunctionsSniff;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->import('vendor/sylius-labs/coding-standard/ecs.php');

    $ecsConfig->paths([
        __DIR__ . '/src/',
    ]);

    $ecsConfig->ruleWithConfiguration(OrderedImportsFixer::class, [
        'imports_order' => ['const', 'class', 'function'],
    ]);

    $ecsConfig->ruleWithConfiguration(ForbiddenFunctionsSniff::class, ['forbiddenFunctions' => [
        'sizeof' => 'count',
        'delete' => 'unset',
        'd' => null,
        'dd' => null,
        'dump' => null,
        'var_dump' => null,
    ]]);
};
