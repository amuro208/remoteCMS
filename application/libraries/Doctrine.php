<?php
use Doctrine\Common\ClassLoader,
    Doctrine\ORM\Configuration,
    Doctrine\ORM\EntityManager,
    Doctrine\ORM\Tools\Setup,
    Doctrine\Common\Cache\ArrayCache,
    Doctrine\Common\Cache\ApcCache,
    Doctrine\DBAL\Logging\EchoSQLLogger,
    Doctrine\ORM\Mapping\Driver\DatabaseDriver,
    Doctrine\ORM\Tools\DisconnectedClassMetadataFactory,
    Doctrine\ORM\Tools\EntityGenerator;

/**
 * CodeIgniter Smarty Class
 *
 * initializes basic doctrine settings and act as doctrine object
 *
 * @final   Doctrine
 * @category    Libraries
 * @author  Md. Ali Ahsan Rana
 * @link    http://codesamplez.com/
 */
class Doctrine
{
  /**
   * @var EntityManager $em
   */
  public $em = null;

  /**
   * constructor
   */
  public function __construct()
  {

    require_once __DIR__ . '/Doctrine/ORM/Tools/Setup.php';
		Setup::registerAutoloadDirectory(__DIR__);

    if(ENVIRONMENT == "development"){
      ini_set("display_errors", "On");
    }

    // load database configuration from CodeIgniter
    require APPPATH . 'config/database.php';

    // With this configuration, your model files need to be in application/models/Entity
		// e.g. Creating a new Entity\User loads the class from application/models/Entity/User.php
		$models_namespace = 'Entity';
		$models_path = APPPATH . 'models';
		$proxies_dir = APPPATH . 'models/proxies';
		$metadata_paths = array(APPPATH . 'models');
		// Set $dev_mode to TRUE to disable caching while you develop

    $dev_mode = false;
    if(ENVIRONMENT == "development"){
      $dev_mode = true;
    }else{
      $dev_mode = false;
    }
		// If you want to use a different metadata driver, change createAnnotationMetadataConfiguration
		// to createXMLMetadataConfiguration or createYAMLMetadataConfiguration.
		$config = Setup::createAnnotationMetadataConfiguration($metadata_paths, $dev_mode, $proxies_dir);
    /*
    if(ENVIRONMENT == "development"){
      require_once APPPATH . "libraries/Profiler.php";
      $logger = new Profiler;
      $config->setSQLLogger($logger);
    }
    */
    // Database connection information
    $connectionOptions = array(
      'driver' => 'mysqli',
      'user' => $db['default']['username'],
      'password' => $db['default']['password'],
      'host' => $db['default']['hostname'],
      'dbname' => $db['default']['database']
    );

    // Create EntityManager
    $this->em = EntityManager::create($connectionOptions, $config);

    /* Generate entity objects automatically from mysql db tables. Run once.
     * http://codesamplez.com/development/using-doctrine-with-codeigniter
     */
    //### Never open this comment from now on.
    //$this->generate_classes();
    //### Never open this comment from now on.

    //$this->generate_proxies();
  }

  /**
   * generate entity objects automatically from mysql db tables
   * @return none
   */
  function generate_classes()
  {
    // custom datatypes (not mapped for reverse engineering)
    $this->em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('set', 'string');
    $this->em->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

    // fetch metadata
    $driver = new DatabaseDriver($this->em->getConnection()->getSchemaManager());
    $this->em->getConfiguration()->setMetadataDriverImpl($driver);

    if(ENVIRONMENT == "development"){
      $cmf = new DisconnectedClassMetadataFactory();
      $cmf->setEntityManager($this->em);
      $classes = $driver->getAllClassNames();
      //$metadata  = $cmf->getAllMetadata();
      $metadata = array();
      foreach ($classes as $class) {
        //any unsupported table/schema could be handled here to exclude some classes
        if (true) {
          $metadata[] = $cmf->getMetadataFor($class);
        }
      }

      $generator = new EntityGenerator();
      $generator->setRegenerateEntityIfExists(false);
      $generator->setUpdateEntityIfExists(false);
      $generator->setGenerateStubMethods(true);
      $generator->setGenerateAnnotations(true);
      $generator->generate($metadata, APPPATH . "models/Entities");
    }
  }

  function generate_proxies(){
    $proxyDir = APPPATH . 'models/proxies';
    $proxyFactory = $this->em->getProxyFactory();
    $metadatas = $this->em->getMetadataFactory()->getAllMetadata();
    $proxyFactory->generateProxyClasses($metadatas, $proxyDir);
  }
}
