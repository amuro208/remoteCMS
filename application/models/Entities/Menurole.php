<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Menurole
 *
 * @Table(name="menurole", indexes={@Index(name="fk_RoleMenu_Menu1_idx", columns={"menuId"}), @Index(name="fk_RoleMenu_Role1_idx", columns={"roleId"})})
 * @Entity
 */
class Menurole
{
    /**
     * @var integer
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="accessable", type="string", length=1, nullable=true)
     */
    private $accessable = 'N';

    /**
     * @var string
     *
     * @Column(name="readable", type="string", length=1, nullable=true)
     */
    private $readable = 'N';

    /**
     * @var string
     *
     * @Column(name="writable", type="string", length=1, nullable=true)
     */
    private $writable = 'N';

    /**
     * @var string
     *
     * @Column(name="confirmable", type="string", length=1, nullable=true)
     */
    private $confirmable = 'N';

    /**
     * @var \DateTime
     *
     * @Column(name="createDate", type="datetime", nullable=true)
     */
    private $createdate;

    /**
     * @var integer
     *
     * @Column(name="createUser", type="integer", nullable=true)
     */
    private $createuser;

    /**
     * @var \DateTime
     *
     * @Column(name="updateDate", type="datetime", nullable=true)
     */
    private $updatedate;

    /**
     * @var integer
     *
     * @Column(name="updateUser", type="integer", nullable=true)
     */
    private $updateuser;

    /**
     * @var string
     *
     * @Column(name="valid", type="string", length=1, nullable=true)
     */
    private $valid = 'Y';

    /**
     * @var \Menu
     *
     * @ManyToOne(targetEntity="Menu")
     * @JoinColumns({
     *   @JoinColumn(name="menuId", referencedColumnName="id")
     * })
     */
    private $menuid;

    /**
     * @var \Role
     *
     * @ManyToOne(targetEntity="Role")
     * @JoinColumns({
     *   @JoinColumn(name="roleId", referencedColumnName="id")
     * })
     */
    private $roleid;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set accessable
     *
     * @param string $accessable
     * @return Menurole
     */
    public function setAccessable($accessable)
    {
        $this->accessable = $accessable;
    
        return $this;
    }

    /**
     * Get accessable
     *
     * @return string 
     */
    public function getAccessable()
    {
        return $this->accessable;
    }

    /**
     * Set readable
     *
     * @param string $readable
     * @return Menurole
     */
    public function setReadable($readable)
    {
        $this->readable = $readable;
    
        return $this;
    }

    /**
     * Get readable
     *
     * @return string 
     */
    public function getReadable()
    {
        return $this->readable;
    }

    /**
     * Set writable
     *
     * @param string $writable
     * @return Menurole
     */
    public function setWritable($writable)
    {
        $this->writable = $writable;
    
        return $this;
    }

    /**
     * Get writable
     *
     * @return string 
     */
    public function getWritable()
    {
        return $this->writable;
    }

    /**
     * Set confirmable
     *
     * @param string $confirmable
     * @return Menurole
     */
    public function setConfirmable($confirmable)
    {
        $this->confirmable = $confirmable;
    
        return $this;
    }

    /**
     * Get confirmable
     *
     * @return string 
     */
    public function getConfirmable()
    {
        return $this->confirmable;
    }

    /**
     * Set createdate
     *
     * @param \DateTime $createdate
     * @return Menurole
     */
    public function setCreatedate($createdate)
    {
        $this->createdate = $createdate;
    
        return $this;
    }

    /**
     * Get createdate
     *
     * @return \DateTime 
     */
    public function getCreatedate()
    {
        return $this->createdate;
    }

    /**
     * Set createuser
     *
     * @param integer $createuser
     * @return Menurole
     */
    public function setCreateuser($createuser)
    {
        $this->createuser = $createuser;
    
        return $this;
    }

    /**
     * Get createuser
     *
     * @return integer 
     */
    public function getCreateuser()
    {
        return $this->createuser;
    }

    /**
     * Set updatedate
     *
     * @param \DateTime $updatedate
     * @return Menurole
     */
    public function setUpdatedate($updatedate)
    {
        $this->updatedate = $updatedate;
    
        return $this;
    }

    /**
     * Get updatedate
     *
     * @return \DateTime 
     */
    public function getUpdatedate()
    {
        return $this->updatedate;
    }

    /**
     * Set updateuser
     *
     * @param integer $updateuser
     * @return Menurole
     */
    public function setUpdateuser($updateuser)
    {
        $this->updateuser = $updateuser;
    
        return $this;
    }

    /**
     * Get updateuser
     *
     * @return integer 
     */
    public function getUpdateuser()
    {
        return $this->updateuser;
    }

    /**
     * Set valid
     *
     * @param string $valid
     * @return Menurole
     */
    public function setValid($valid)
    {
        $this->valid = $valid;
    
        return $this;
    }

    /**
     * Get valid
     *
     * @return string 
     */
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * Set menuid
     *
     * @param \Menu $menuid
     * @return Menurole
     */
    public function setMenuid(\Menu $menuid = null)
    {
        $this->menuid = $menuid;
    
        return $this;
    }

    /**
     * Get menuid
     *
     * @return \Menu 
     */
    public function getMenuid()
    {
        return $this->menuid;
    }

    /**
     * Set roleid
     *
     * @param \Role $roleid
     * @return Menurole
     */
    public function setRoleid(\Role $roleid = null)
    {
        $this->roleid = $roleid;
    
        return $this;
    }

    /**
     * Get roleid
     *
     * @return \Role 
     */
    public function getRoleid()
    {
        return $this->roleid;
    }
}
