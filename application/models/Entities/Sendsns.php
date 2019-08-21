<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Sendsns
 *
 * @Table(name="sendsns", indexes={@Index(name="fk_SNS_User1_idx", columns={"userId"})})
 * @Entity
 */
class Sendsns
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
     * @Column(name="snsTypeCode", type="string", length=10, nullable=true)
     */
    private $snstypecode;

    /**
     * @var string
     *
     * @Column(name="accessToken", type="string", length=256, nullable=true)
     */
    private $accesstoken;

    /**
     * @var string
     *
     * @Column(name="secretToken", type="string", length=256, nullable=true)
    */
    private $secrettoken;


    /**
     * @var string
     *
     * @Column(name="snsId", type="string", length=128, nullable=true)
     */
    private $snsid;

    /**
     * @var string
     *
     * @Column(name="snsUrl", type="string", length=128, nullable=true)
     */
    private $snsurl;

    /**
     * @var string
     *
     * @Column(name="snsShortUrl", type="string", length=128, nullable=true)
     */
    private $snsshorturl;

    /**
     * @var string
     *
     * @Column(name="accessCode", type="string", length=64, nullable=true)
     */
    private $accesscode;

    /**
     * @var string
     *
     * @Column(name="isSent", type="string", length=1, nullable=true)
     */
    private $issent = 'N';

    /**
     * @var \DateTime
     *
     * @Column(name="sentDate", type="datetime", nullable=true)
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
     * Set snstypecode
     *
     * @param string $snstypecode
     * @return Sendsns
     */
    public function setSnstypecode($snstypecode)
    {
        $this->snstypecode = $snstypecode;
    
        return $this;
    }

    /**
     * Get snstypecode
     *
     * @return string 
     */
    public function getSnstypecode()
    {
        return $this->snstypecode;
    }

    /**
     * Set accesstoken
     *
     * @param string $accesstoken
     * @return Sendsns
     */
    public function setAccesstoken($accesstoken)
    {
        $this->accesstoken = $accesstoken;
    
        return $this;
    }

    /**
     * Get accesstoken
     *
     * @return string 
     */
    public function getAccesstoken()
    {
        return $this->accesstoken;
    }

    /**
     * Set secrettoken
     *
     * @param string $secrettoken
     * @return Sendsns
     */
    public function setSecrettoken($secrettoken)
    {
        $this->secrettoken = $secrettoken;
    
        return $this;
    }

    /**
     * Get secrettoken
     *
     * @return string 
     */
    public function getSecrettoken()
    {
        return $this->secrettoken;
    }

    /**
     * Set snsid
     *
     * @param string $snsid
     * @return Sendsns
     */
    public function setSnsid($snsid)
    {
        $this->snsid = $snsid;
    
        return $this;
    }

    /**
     * Get snsid
     *
     * @return string 
     */
    public function getSnsid()
    {
        return $this->snsid;
    }

    /**
     * Set snsurl
     *
     * @param string $snsurl
     * @return Sendsns
     */
    public function setSnsurl($snsurl)
    {
        $this->snsurl = $snsurl;
    
        return $this;
    }

    /**
     * Get snsurl
     *
     * @return string 
     */
    public function getSnsurl()
    {
        return $this->snsurl;
    }

    /**
     * Set snsshorturl
     *
     * @param string $snsshorturl
     * @return Sendsns
     */
    public function setSnsshorturl($snsshorturl)
    {
        $this->snsshorturl = $snsshorturl;
    
        return $this;
    }

    /**
     * Get snsshorturl
     *
     * @return string 
     */
    public function getSnsshorturl()
    {
        return $this->snsshorturl;
    }

    /**
     * Set accesscode
     *
     * @param string $accesscode
     * @return Sendsns
     */
    public function setAccesscode($accesscode)
    {
        $this->accesscode = $accesscode;
    
        return $this;
    }

    /**
     * Get accesscode
     *
     * @return string 
     */
    public function getAccesscode()
    {
        return $this->accesscode;
    }

    /**
     * Set issent
     *
     * @param string $issent
     * @return Sendsns
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
     * @param \DateTime $sentdate
     * @return Sendsns
     */
    public function setSentdate($sentdate)
    {
        $this->sentdate = $sentdate;
    
        return $this;
    }

    /**
     * Get sentdate
     *
     * @return \DateTime 
     */
    public function getSentdate()
    {
        return $this->sentdate;
    }

    /**
     * Set createdate
     *
     * @param \DateTime $createdate
     * @return Sendsns
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
     * @return Sendsns
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
     * @return Sendsns
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
     * @return Sendsns
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
     * @return Sendsns
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
     * Set userid
     *
     * @param \User $userid
     * @return Sendsns
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
