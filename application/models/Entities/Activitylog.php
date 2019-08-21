<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Activitylog
 *
 * @Table(name="activitylog", indexes={@Index(name="fk_table1_EmailLog1_idx", columns={"emailLogId"})})
 * @Entity
 */
class Activitylog
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
     * @Column(name="activityType", type="string", length=10, nullable=true)
     */
    private $activitytype;

    /**
     * @var string
     *
     * @Column(name="platform", type="string", length=45, nullable=true)
     */
    private $platform;

    /**
     * @var string
     *
     * @Column(name="browser", type="string", length=45, nullable=true)
     */
    private $browser;

    /**
     * @var string
     *
     * @Column(name="version", type="string", length=45, nullable=true)
     */
    private $version;

    /**
     * @var string
     *
     * @Column(name="referer", type="string", length=64, nullable=true)
     */
    private $referer;

    /**
     * @var integer
     *
     * @Column(name="clicked", type="integer", nullable=false)
     */
    private $clicked = '0';

    /**
     * @var integer
     *
     * @Column(name="downloaded", type="integer", nullable=false)
     */
    private $downloaded = '0';

    /**
     * @var integer
     *
     * @Column(name="shared1", type="integer", nullable=false)
     */
    private $shared1 = '0';

    /**
     * @var integer
     *
     * @Column(name="shared2", type="integer", nullable=false)
     */
    private $shared2 = '0';

    /**
     * @var integer
     *
     * @Column(name="shared3", type="integer", nullable=false)
     */
    private $shared3 = '0';

    /**
     * @var string
     *
     * @Column(name="reserve1", type="string", length=64, nullable=true)
     */
    private $reserve1;

    /**
     * @var string
     *
     * @Column(name="reserve2", type="string", length=64, nullable=true)
     */
    private $reserve2;

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
     * @var \Emaillog
     *
     * @ManyToOne(targetEntity="Emaillog")
     * @JoinColumns({
     *   @JoinColumn(name="emailLogId", referencedColumnName="id")
     * })
     */
    private $emaillogid;


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
     * Set activitytype
     *
     * @param string $activitytype
     * @return Activitylog
     */
    public function setActivitytype($activitytype)
    {
        $this->activitytype = $activitytype;
    
        return $this;
    }

    /**
     * Get activitytype
     *
     * @return string 
     */
    public function getActivitytype()
    {
        return $this->activitytype;
    }

    /**
     * Set platform
     *
     * @param string $platform
     * @return Activitylog
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;
    
        return $this;
    }

    /**
     * Get platform
     *
     * @return string 
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * Set browser
     *
     * @param string $browser
     * @return Activitylog
     */
    public function setBrowser($browser)
    {
        $this->browser = $browser;
    
        return $this;
    }

    /**
     * Get browser
     *
     * @return string 
     */
    public function getBrowser()
    {
        return $this->browser;
    }

    /**
     * Set version
     *
     * @param string $version
     * @return Activitylog
     */
    public function setVersion($version)
    {
        $this->version = $version;
    
        return $this;
    }

    /**
     * Get version
     *
     * @return string 
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set referer
     *
     * @param string $referer
     * @return Activitylog
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;
    
        return $this;
    }

    /**
     * Get referer
     *
     * @return string 
     */
    public function getReferer()
    {
        return $this->referer;
    }

    /**
     * Set clicked
     *
     * @param integer $clicked
     * @return Activitylog
     */
    public function setClicked($clicked)
    {
        $this->clicked = $clicked;
    
        return $this;
    }

    /**
     * Get clicked
     *
     * @return integer 
     */
    public function getClicked()
    {
        return $this->clicked;
    }

    /**
     * Set downloaded
     *
     * @param integer $downloaded
     * @return Activitylog
     */
    public function setDownloaded($downloaded)
    {
        $this->downloaded = $downloaded;
    
        return $this;
    }

    /**
     * Get downloaded
     *
     * @return integer 
     */
    public function getDownloaded()
    {
        return $this->downloaded;
    }

    /**
     * Set shared1
     *
     * @param integer $shared1
     * @return Activitylog
     */
    public function setShared1($shared1)
    {
        $this->shared1 = $shared1;
    
        return $this;
    }

    /**
     * Get shared1
     *
     * @return integer 
     */
    public function getShared1()
    {
        return $this->shared1;
    }

    /**
     * Set shared2
     *
     * @param integer $shared2
     * @return Activitylog
     */
    public function setShared2($shared2)
    {
        $this->shared2 = $shared2;
    
        return $this;
    }

    /**
     * Get shared2
     *
     * @return integer 
     */
    public function getShared2()
    {
        return $this->shared2;
    }

    /**
     * Set shared3
     *
     * @param integer $shared3
     * @return Activitylog
     */
    public function setShared3($shared3)
    {
        $this->shared3 = $shared3;
    
        return $this;
    }

    /**
     * Get shared3
     *
     * @return integer 
     */
    public function getShared3()
    {
        return $this->shared3;
    }

    /**
     * Set reserve1
     *
     * @param string $reserve1
     * @return Activitylog
     */
    public function setReserve1($reserve1)
    {
        $this->reserve1 = $reserve1;
    
        return $this;
    }

    /**
     * Get reserve1
     *
     * @return string 
     */
    public function getReserve1()
    {
        return $this->reserve1;
    }

    /**
     * Set reserve2
     *
     * @param string $reserve2
     * @return Activitylog
     */
    public function setReserve2($reserve2)
    {
        $this->reserve2 = $reserve2;
    
        return $this;
    }

    /**
     * Get reserve2
     *
     * @return string 
     */
    public function getReserve2()
    {
        return $this->reserve2;
    }

    /**
     * Set createdate
     *
     * @param \DateTime $createdate
     * @return Activitylog
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
     * @return Activitylog
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
     * @return Activitylog
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
     * @return Activitylog
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
     * @return Activitylog
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
     * Set emaillogid
     *
     * @param \Emaillog $emaillogid
     * @return Activitylog
     */
    public function setEmaillogid(\Emaillog $emaillogid = null)
    {
        $this->emaillogid = $emaillogid;
    
        return $this;
    }

    /**
     * Get emaillogid
     *
     * @return \Emaillog 
     */
    public function getEmaillogid()
    {
        return $this->emaillogid;
    }
}
