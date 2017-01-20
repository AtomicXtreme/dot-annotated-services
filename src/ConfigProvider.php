<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-annotated-services
 * @author: n3vrax
 * Date: 1/20/2017
 * Time: 4:38 PM
 */

namespace Dot\AnnotatedServiced;

/**
 * Class ConfigProvider
 * @package Dot\AnnotatedServiced
 */
class ConfigProvider
{
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependenciesConfig(),
        ];
    }

    public function getDependenciesConfig()
    {
        return [

        ];
    }
}