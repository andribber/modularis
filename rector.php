<?php

declare(strict_types=1);

use Rector\Arguments\Rector\ClassMethod\ArgumentAdderRector;
use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector;
use Rector\CodeQuality\Rector\ClassMethod\ReturnTypeFromStrictScalarReturnExprRector;
use Rector\CodeQuality\Rector\Empty_\SimplifyEmptyCheckOnEmptyArrayRector;
use Rector\CodeQuality\Rector\FunctionLike\SimplifyUselessVariableRector;
use Rector\CodeQuality\Rector\Isset_\IssetOnPropertyObjectToPropertyExistsRector;
use Rector\CodeQuality\Rector\PropertyFetch\ExplicitMethodCallOverMagicGetSetRector;
use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\DeadCode\Rector\FunctionLike\RemoveDeadReturnRector;
use Rector\EarlyReturn\Rector\If_\RemoveAlwaysElseRector;
use Rector\Php71\Rector\FuncCall\CountOnNullRector;
use Rector\Php73\Rector\FuncCall\JsonThrowOnErrorRector;
use Rector\Php80\Rector\ClassMethod\AddParamBasedOnParentClassMethodRector;
use Rector\Php81\Rector\FuncCall\NullToStrictStringFuncCallArgRector;
use Rector\PSR4\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Transform\Rector\FuncCall\ArgumentFuncCallToMethodCallRector;
use Rector\Transform\Rector\StaticCall\StaticCallToMethodCallRector;
use RectorLaravel\Rector\Class_\AnonymousMigrationsRector;
use RectorLaravel\Rector\Class_\UnifyModelDatesWithCastsRector;
use RectorLaravel\Rector\ClassMethod\AddArgumentDefaultValueRector;
use RectorLaravel\Rector\FuncCall\FactoryFuncCallToStaticCallRector;
use RectorLaravel\Rector\FuncCall\HelperFuncCallToFacadeClassRector;
use RectorLaravel\Rector\MethodCall\RedirectBackToBackHelperRector;
use RectorLaravel\Rector\Namespace_\FactoryDefinitionRector;
use RectorLaravel\Rector\PropertyFetch\OptionalToNullsafeOperatorRector;
use RectorLaravel\Rector\PropertyFetch\ReplaceFakerInstanceWithHelperRector;
use RectorLaravel\Rector\StaticCall\RequestStaticValidateToInjectRector;
use RectorLaravel\Set\LaravelSetList;

return static function (RectorConfig $rectorConfig): void {
    // Configs
    $rectorConfig->sets([
        LaravelSetList::LARAVEL_90,
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelSetList::LARAVEL_STATIC_TO_INJECTION,
        LevelSetList::UP_TO_PHP_81,
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
    ]);
    $rectorConfig->phpVersion(PhpVersion::PHP_81);
    $rectorConfig->parallel(600, 4);
    $rectorConfig->importNames();
    $rectorConfig->importShortClasses(false);
    $rectorConfig->cacheDirectory(__DIR__.'/.rector');
    $rectorConfig->cacheClass(FileCacheStorage::class);

    // Rules
    $rectorConfig->rule(AnonymousMigrationsRector::class);
    $rectorConfig->rule(FactoryDefinitionRector::class);
    $rectorConfig->rule(FactoryFuncCallToStaticCallRector::class);
    $rectorConfig->rule(RedirectBackToBackHelperRector::class);
    $rectorConfig->rule(UnifyModelDatesWithCastsRector::class);
    $rectorConfig->rule(RemoveAlwaysElseRector::class);
    $rectorConfig->rule(RemoveDeadReturnRector::class);
    $rectorConfig->rule(SimplifyUselessVariableRector::class);
    $rectorConfig->rule(NormalizeNamespaceByPSR4ComposerAutoloadRector::class);

    $rectorConfig->ruleWithConfiguration(OptionalToNullsafeOperatorRector::class, [
        OptionalToNullsafeOperatorRector::EXCLUDE_METHODS => ['present'],
    ]);

    $rectorConfig->skip([
        ArgumentAdderRector::class,
        ArgumentFuncCallToMethodCallRector::class,
        CompleteDynamicPropertiesRector::class,
        ExplicitMethodCallOverMagicGetSetRector::class,
        HelperFuncCallToFacadeClassRector::class,
        IssetOnPropertyObjectToPropertyExistsRector::class,
        JsonThrowOnErrorRector::class,
        StaticCallToMethodCallRector::class,
        CountOnNullRector::class,
        ReturnTypeFromStrictScalarReturnExprRector::class,
        NullToStrictStringFuncCallArgRector::class,
        ReplaceFakerInstanceWithHelperRector::class,
        SimplifyEmptyCheckOnEmptyArrayRector::class,

        NormalizeNamespaceByPSR4ComposerAutoloadRector::class => [
            __DIR__.'/app/Helpers/*',
        ],

        AddArgumentDefaultValueRector::class => [__DIR__.'/app/Logging/Loki/Formatter.php'],
        RequestStaticValidateToInjectRector::class => [__DIR__.'/app/Logging/Loki/Formatter.php'],
        AddParamBasedOnParentClassMethodRector::class => [__DIR__.'/app/Logging/Loki/Formatter.php'],
    ]);

    $rectorConfig->paths([
        __DIR__.'/app/**',
        __DIR__.'/config/**',
        __DIR__.'/database/factories/**',
        __DIR__.'/database/seeders/**',
    ]);
};
