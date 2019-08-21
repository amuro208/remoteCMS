<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Localrfidscan
 *
 * @Table(name="localrfidscan", indexes={@Index(name="fk_ScannedRFID_LocalUser1_idx", columns={"localUserId"})})
 * @Entity
 */
class Localrfidscan
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
     * @Column(name="rfid", type="string", length=64, nullable=true)
     */
    private $rfid;

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
     * @var \Localuser
     *
     * @ManyToOne(targetEntity="Localuser")
     * @JoinColumns({
     *   @JoinColumn(name="localUserId", referencedColumnName="id")
     * })
     */
    private $localuserid;


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
     * Set rfid
     *
     * @param string $rfid
     * @return Localrfidscan
     */
    public function setRfid($rfid)
    {
        $this->rfid = $rfid;
    
        return $this;
    }

    /**
     * Get rfid
     *
     * @return string 
     */
    public function getRfid()
    {
        return $this->rfid;
    }

    /**
     * Set createdate
     *
     * @param \DateTime $createdate
     * @return Localrfidscan
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
     * @return Localrfidscan
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
     * @return Localrfidscan
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
     * @return Localrfidscan
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
     * @return Localrfidscan
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
     * Set localuserid
     *
     * @param \Localuser $localuserid
     * @return Localrfidscan
     */
    public function setLocaluserid(\Localuser $localuserid = null)
    {
        $this->localuserid = $localuserid;
    
        return $this;
    }

    /**
     * Get localuserid
     *
     * @return \Localuser 
     */
    public function getLocaluserid()
    {
        return $this->localuserid;
    }
}
