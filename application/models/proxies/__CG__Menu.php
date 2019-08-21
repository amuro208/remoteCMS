<?php

namespace DoctrineProxies\__CG__;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Menu extends \Menu implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', '' . "\0" . 'Menu' . "\0" . 'id', '' . "\0" . 'Menu' . "\0" . 'name', '' . "\0" . 'Menu' . "\0" . 'url', '' . "\0" . 'Menu' . "\0" . 'order', '' . "\0" . 'Menu' . "\0" . 'createdate', '' . "\0" . 'Menu' . "\0" . 'createuser', '' . "\0" . 'Menu' . "\0" . 'updatedate', '' . "\0" . 'Menu' . "\0" . 'updateuser', '' . "\0" . 'Menu' . "\0" . 'valid', '' . "\0" . 'Menu' . "\0" . 'pid', '' . "\0" . 'Menu' . "\0" . 'menuroles');
        }

        return array('__isInitialized__', '' . "\0" . 'Menu' . "\0" . 'id', '' . "\0" . 'Menu' . "\0" . 'name', '' . "\0" . 'Menu' . "\0" . 'url', '' . "\0" . 'Menu' . "\0" . 'order', '' . "\0" . 'Menu' . "\0" . 'createdate', '' . "\0" . 'Menu' . "\0" . 'createuser', '' . "\0" . 'Menu' . "\0" . 'updatedate', '' . "\0" . 'Menu' . "\0" . 'updateuser', '' . "\0" . 'Menu' . "\0" . 'valid', '' . "\0" . 'Menu' . "\0" . 'pid', '' . "\0" . 'Menu' . "\0" . 'menuroles');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Menu $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getMenuRoles()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMenuRoles', array());

        return parent::getMenuRoles();
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', array());

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function setName($name)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setName', array($name));

        return parent::setName($name);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getName', array());

        return parent::getName();
    }

    /**
     * {@inheritDoc}
     */
    public function setUrl($url)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUrl', array($url));

        return parent::setUrl($url);
    }

    /**
     * {@inheritDoc}
     */
    public function getUrl()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUrl', array());

        return parent::getUrl();
    }

    /**
     * {@inheritDoc}
     */
    public function setOrder($order)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setOrder', array($order));

        return parent::setOrder($order);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getOrder', array());

        return parent::getOrder();
    }

    /**
     * {@inheritDoc}
     */
    public function setCreatedate($createdate)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCreatedate', array($createdate));

        return parent::setCreatedate($createdate);
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCreatedate', array());

        return parent::getCreatedate();
    }

    /**
     * {@inheritDoc}
     */
    public function setCreateuser($createuser)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCreateuser', array($createuser));

        return parent::setCreateuser($createuser);
    }

    /**
     * {@inheritDoc}
     */
    public function getCreateuser()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCreateuser', array());

        return parent::getCreateuser();
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdatedate($updatedate)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUpdatedate', array($updatedate));

        return parent::setUpdatedate($updatedate);
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdatedate()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUpdatedate', array());

        return parent::getUpdatedate();
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdateuser($updateuser)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUpdateuser', array($updateuser));

        return parent::setUpdateuser($updateuser);
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdateuser()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUpdateuser', array());

        return parent::getUpdateuser();
    }

    /**
     * {@inheritDoc}
     */
    public function setValid($valid)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setValid', array($valid));

        return parent::setValid($valid);
    }

    /**
     * {@inheritDoc}
     */
    public function getValid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getValid', array());

        return parent::getValid();
    }

    /**
     * {@inheritDoc}
     */
    public function setPid(\Menu $pid = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPid', array($pid));

        return parent::setPid($pid);
    }

    /**
     * {@inheritDoc}
     */
    public function getPid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPid', array());

        return parent::getPid();
    }

}
