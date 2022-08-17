<?php

namespace Hightemp\WappTestSnotes\Modules\Core\Helpers;

/**
 * ClassFinder
 * 
 * Взято из https://stackoverflow.com/questions/22761554/how-to-get-all-class-names-inside-a-particular-namespace
 * 
 */
class ClassFinder
{
    //This value should be the directory that contains composer.json
    const appRoot = ROOT_PATH;

    public static function getClassesInNamespace($namespace)
    {
        $sPath = self::getNamespaceDirectory($namespace);

        if (!$sPath) return [];

        $files = scandir($sPath);
        $files = array_filter($files, function($sI) { return !in_array($sI, [".", ".."]); });

        $classes = array_map(function($file) use ($namespace){
            return $namespace . '\\' . str_replace('.php', '', $file);
        }, $files);

        return array_filter($classes, function($possibleClass){
            return class_exists($possibleClass);
        });
    }

    private static function getDefinedNamespaces()
    {
        $composerJsonPath = self::appRoot . '/composer.json';
        $composerConfig = json_decode(file_get_contents($composerJsonPath));

        return (array) $composerConfig->autoload->{'psr-4'};
    }

    private static function getNamespaceDirectory($namespace)
    {
        $composerNamespaces = self::getDefinedNamespaces();

        $namespace = preg_replace('/^\\\\/', "", $namespace);
        $namespaceFragments = explode('\\', $namespace);
        $undefinedNamespaceFragments = [];

        while($namespaceFragments) {
            $possibleNamespace = implode('\\', $namespaceFragments) . '\\';

            if(array_key_exists($possibleNamespace, $composerNamespaces)){
                return realpath(self::appRoot . "/" . $composerNamespaces[$possibleNamespace] . implode('/', $undefinedNamespaceFragments));
            }

            array_unshift($undefinedNamespaceFragments, array_pop($namespaceFragments));            
        }

        return false;
    }
}