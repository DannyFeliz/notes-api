<?php 

namespace Notes\Library;

use ReflectionClass;

/**
 * Factory Manager
 *
 * @package Notes\Library
 * @version 0.0.1
 */
class FactoryManager
{
    /**
     * Pool of intstance for unique instances
     *
     * @staticvar array	 
     */
    private static $poolInstances = array();

    /**
     * Factory class for unique instance using pool objects
     *
     * @param string $className Name of the class to create the instance
     * @return mixed
     * @throws \Exception
     */
    final public static function getInstance($className)
    {
        $instantiable = new ReflectionClass($className);
        
        // Verify the pool
        if (!$instantiable->isInstantiable()) {
            throw new \Exception("The construct for class '$className' must be protected", 1);
        }
        
        // Create the instance and response
        if (empty(self::$poolInstances[$className])) {
            self::$poolInstances[$className] = new $className();
        }
        return self::$poolInstances[$className];
    }
}
