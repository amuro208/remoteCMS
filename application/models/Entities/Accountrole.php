<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Accountrole
 *
 * @Table(name="accountrole", indexes={@Index(name="fk_AccountRole_Account1_idx", columns={"aid"}), @Index(name="fk_AccountRole_Role1_idx", columns={"roleId"})})
 * @Entity
 */
class Accountrole
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
     * @var \Account
     *
     * @ManyToOne(targetEntity="Account")
     * @JoinColumns({
     *   @JoinColumn(name="aid", referencedColumnName="id")
     * })
     */
    private $aid;

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
     * Set createdate
     *
     * @param \DateTime $createdate
     * @return Accountrole
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
     * @return Accountrole
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
     * @return Accountrole
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
     * @return Accountrole
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
     * @return Accountrole
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
     * Set aid
     *
     * @param \Account $aid
     * @return Accountrole
     */
    public function setAid(\Account $aid = null)
    {
        $this->aid = $aid;
    
        return $this;
    }

    /**
     * Get aid
     *
     * @return \Account 
     */
    public function getAid()
    {
        return $this->aid;
    }

    /**
     * Set roleid
     *
     * @param \Role $roleid
     * @return Accountrole
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
