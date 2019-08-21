<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Rfidscan
 *
 * @Table(name="rfidscan", indexes={@Index(name="fk_ScannedRFID_User1_idx", columns={"userId"}), @Index(name="fk_ScannedRFID_RFID1_idx", columns={"rfidId"}), @Index(name="fk_ScannedRFID_Media1_idx", columns={"mediaId"})})
 * @Entity
 */
class Rfidscan
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
     * @Column(name="RFID", type="string", length=64, nullable=true)
     */
    private $rfid;

    /**
     * @var string
     *
     * @Column(name="fbId", type="string", length=64, nullable=true)
     */
    private $fbid;

    /**
     * @var string
     *
     * @Column(name="fbUrl", type="string", length=128, nullable=true)
     */
    private $fburl;

    /**
     * @var string
     *
     * @Column(name="fbShortUrl", type="string", length=128, nullable=true)
     */
    private $fbshorturl;

    /**
     * @var string
     *
     * @Column(name="isSent", type="string", length=1, nullable=true)
     */
    private $issent = 'N';

    /**
     * @var string
     *
     * @Column(name="sentDate", type="string", length=10, nullable=true)
     */
    private $sentdate;

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
     * @var \Media
     *
     * @ManyToOne(targetEntity="Media")
     * @JoinColumns({
     *   @JoinColumn(name="mediaId", referencedColumnName="id")
     * })
     */
    private $mediaid;

    /**
     * @var \Rfid
     *
     * @ManyToOne(targetEntity="Rfid")
     * @JoinColumns({
     *   @JoinColumn(name="rfidId", referencedColumnName="id")
     * })
     */
    private $rfidid;

    /**
     * @var \User
     *
     * @ManyToOne(targetEntity="User")
     * @JoinColumns({
     *   @JoinColumn(name="userId", referencedColumnName="id")
     * })
     */
    private $userid;


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
     * @return Rfidscan
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
     * Set fbid
     *
     * @param string $fbid
     * @return Rfidscan
     */
    public function setFbid($fbid)
    {
        $this->fbid = $fbid;
    
        return $this;
    }

    /**
     * Get fbid
     *
     * @return string 
     */
    public function getFbid()
    {
        return $this->fbid;
    }

    /**
     * Set fburl
     *
     * @param string $fburl
     * @return Rfidscan
     */
    public function setFburl($fburl)
    {
        $this->fburl = $fburl;
    
        return $this;
    }

    /**
     * Get fburl
     *
     * @return string 
     */
    public function getFburl()
    {
        return $this->fburl;
    }

    /**
     * Set fbshorturl
     *
     * @param string $fbshorturl
     * @return Rfidscan
     */
    public function setFbshorturl($fbshorturl)
    {
        $this->fbshorturl = $fbshorturl;
    
        return $this;
    }

    /**
     * Get fbshorturl
     *
     * @return string 
     */
    public function getFbshorturl()
    {
        return $this->fbshorturl;
    }

    /**
     * Set issent
     *
     * @param string $issent
     * @return Rfidscan
     */
    public function setIssent($issent)
    {
        $this->issent = $issent;
    
        return $this;
    }

    /**
     * Get issent
     *
     * @return string 
     */
    public function getIssent()
    {
        return $this->issent;
    }

    /**
     * Set sentdate
     *
     * @param string $sentdate
     * @return Rfidscan
     */
    public function setSentdate($sentdate)
    {
        $this->sentdate = $sentdate;
    
        return $this;
    }

    /**
     * Get sentdate
     *
     * @return string 
     */
    public function getSentdate()
    {
        return $this->sentdate;
    }

    /**
     * Set createdate
     *
     * @param \DateTime $createdate
     * @return Rfidscan
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
     * @return Rfidscan
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
     * @return Rfidscan
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
     * @return Rfidscan
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
     * @return Rfidscan
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
     * Set mediaid
     *
     * @param \Media $mediaid
     * @return Rfidscan
     */
    public function setMediaid(\Media $mediaid = null)
    {
        $this->mediaid = $mediaid;
    
        return $this;
    }

    /**
     * Get mediaid
     *
     * @return \Media 
     */
    public function getMediaid()
    {
        return $this->mediaid;
    }

    /**
     * Set rfidid
     *
     * @param \Rfid $rfidid
     * @return Rfidscan
     */
    public function setRfidid(\Rfid $rfidid = null)
    {
        $this->rfidid = $rfidid;
    
        return $this;
    }

    /**
     * Get rfidid
     *
     * @return \Rfid 
     */
    public function getRfidid()
    {
        return $this->rfidid;
    }

    /**
     * Set userid
     *
     * @param \User $userid
     * @return Rfidscan
     */
    public function setUserid(\User $userid = null)
    {
        $this->userid = $userid;
    
        return $this;
    }

    /**
     * Get userid
     *
     * @return \User 
     */
    public function getUserid()
    {
        return $this->userid;
    }
}
