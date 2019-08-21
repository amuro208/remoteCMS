<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Emaillog
 *
 * @Table(name="emaillog", indexes={@Index(name="fk_EmailLog_User1_idx", columns={"userId"})})
 * @Entity
 */
class Emaillog
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
     * @Column(name="accessCode", type="string", length=128, nullable=true)
     */
    private $accesscode;

    /**
     * @var string
     *
     * @Column(name="shareAccessCode", type="string", length=128, nullable=true)
     */
    private $shareaccesscode;

    /**
     * @var string
     *
     * @Column(name="email", type="string", length=128, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @Column(name="isValidEmail", type="string", length=1, nullable=true)
     */
    private $isvalidemail = 'N';

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
     * @var string
     *
     * @Column(name="isOpened", type="string", length=1, nullable=true)
     */
    private $isopened = 'N';

    /**
     * @var \DateTime
     *
     * @Column(name="openedDate", type="datetime", nullable=true)
     */
    private $openeddate;

    /**
     * @var string
     *
     * @Column(name="shortUrl", type="string", length=256, nullable=true)
     */
    private $shorturl;

    /**
     * @var string
     *
     * @Column(name="reserve1", type="string", length=256, nullable=true)
     */
    private $reserve1;

    /**
     * @var string
     *
     * @Column(name="reserve2", type="string", length=256, nullable=true)
     */
    private $reserve2;

    /**
     * @var string
     *
     * @Column(name="reserve3", type="string", length=256, nullable=true)
     */
    private $reserve3;

    /**
     * @var string
     *
     * @Column(name="reserve4", type="string", length=256, nullable=true)
     */
    private $reserve4;

    /**
     * @var string
     *
     * @Column(name="reserve5", type="string", length=256, nullable=true)
     */
    private $reserve5;

    /**
     * @var string
     *
     * @Column(name="reserve6", type="string", length=256, nullable=true)
     */
    private $reserve6;

    /**
     * @var string
     *
     * @Column(name="reserve7", type="string", length=256, nullable=true)
     */
    private $reserve7;

    /**
     * @var string
     *
     * @Column(name="reserve8", type="string", length=256, nullable=true)
     */
    private $reserve8;

    /**
     * @var string
     *
     * @Column(name="reserve9", type="string", length=256, nullable=true)
     */
    private $reserve9;

    /**
     * @var string
     *
     * @Column(name="reserve10", type="string", length=256, nullable=true)
     */
    private $reserve10;

    /**
     * @var string
     *
     * @Column(name="edmMedia", type="string", length=64, nullable=true)
     */
    private $edmmedia;

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
     * Set accesscode
     *
     * @param string $accesscode
     * @return Emaillog
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
     * Set shareaccesscode
     *
     * @param string $shareaccesscode
     * @return Emaillog
     */
    public function setShareaccesscode($shareaccesscode)
    {
        $this->shareaccesscode = $shareaccesscode;
    
        return $this;
    }

    /**
     * Get shareaccesscode
     *
     * @return string 
     */
    public function getShareaccesscode()
    {
        return $this->shareaccesscode;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Emaillog
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isvalidemail
     *
     * @param string $isvalidemail
     * @return Emaillog
     */
    public function setIsvalidemail($isvalidemail)
    {
        $this->isvalidemail = $isvalidemail;
    
        return $this;
    }

    /**
     * Get isvalidemail
     *
     * @return string 
     */
    public function getIsvalidemail()
    {
        return $this->isvalidemail;
    }

    /**
     * Set issent
     *
     * @param string $issent
     * @return Emaillog
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
     * @return Emaillog
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
     * Set isopened
     *
     * @param string $isopened
     * @return Emaillog
     */
    public function setIsopened($isopened)
    {
        $this->isopened = $isopened;
    
        return $this;
    }

    /**
     * Get isopened
     *
     * @return string 
     */
    public function getIsopened()
    {
        return $this->isopened;
    }

    /**
     * Set openeddate
     *
     * @param \DateTime $openeddate
     * @return Emaillog
     */
    public function setOpeneddate($openeddate)
    {
        $this->openeddate = $openeddate;
    
        return $this;
    }

    /**
     * Get openeddate
     *
     * @return \DateTime 
     */
    public function getOpeneddate()
    {
        return $this->openeddate;
    }

    /**
     * Set shorturl
     *
     * @param string $shorturl
     * @return Emaillog
     */
    public function setShorturl($shorturl)
    {
        $this->shorturl = $shorturl;
    
        return $this;
    }

    /**
     * Get shorturl
     *
     * @return string 
     */
    public function getShorturl()
    {
        return $this->shorturl;
    }

    /**
     * Set reserve1
     *
     * @param string $reserve1
     * @return Emaillog
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
     * @return Emaillog
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
     * Set reserve3
     *
     * @param string $reserve3
     * @return Emaillog
     */
    public function setReserve3($reserve3)
    {
        $this->reserve3 = $reserve3;
    
        return $this;
    }

    /**
     * Get reserve3
     *
     * @return string 
     */
    public function getReserve3()
    {
        return $this->reserve3;
    }

    /**
     * Set reserve4
     *
     * @param string $reserve4
     * @return Emaillog
     */
    public function setReserve4($reserve4)
    {
        $this->reserve4 = $reserve4;
    
        return $this;
    }

    /**
     * Get reserve4
     *
     * @return string 
     */
    public function getReserve4()
    {
        return $this->reserve4;
    }

    /**
     * Set reserve5
     *
     * @param string $reserve5
     * @return Emaillog
     */
    public function setReserve5($reserve5)
    {
        $this->reserve5 = $reserve5;
    
        return $this;
    }

    /**
     * Get reserve5
     *
     * @return string 
     */
    public function getReserve5()
    {
        return $this->reserve5;
    }

    /**
     * Set reserve6
     *
     * @param string $reserve6
     * @return Emaillog
     */
    public function setReserve6($reserve6)
    {
        $this->reserve6 = $reserve6;
    
        return $this;
    }

    /**
     * Get reserve6
     *
     * @return string 
     */
    public function getReserve6()
    {
        return $this->reserve6;
    }

    /**
     * Set reserve7
     *
     * @param string $reserve7
     * @return Emaillog
     */
    public function setReserve7($reserve7)
    {
        $this->reserve7 = $reserve7;
    
        return $this;
    }

    /**
     * Get reserve7
     *
     * @return string 
     */
    public function getReserve7()
    {
        return $this->reserve7;
    }

    /**
     * Set reserve8
     *
     * @param string $reserve8
     * @return Emaillog
     */
    public function setReserve8($reserve8)
    {
        $this->reserve8 = $reserve8;
    
        return $this;
    }

    /**
     * Get reserve8
     *
     * @return string 
     */
    public function getReserve8()
    {
        return $this->reserve8;
    }

    /**
     * Set reserve9
     *
     * @param string $reserve9
     * @return Emaillog
     */
    public function setReserve9($reserve9)
    {
        $this->reserve9 = $reserve9;
    
        return $this;
    }

    /**
     * Get reserve9
     *
     * @return string 
     */
    public function getReserve9()
    {
        return $this->reserve9;
    }

    /**
     * Set reserve10
     *
     * @param string $reserve10
     * @return Emaillog
     */
    public function setReserve10($reserve10)
    {
        $this->reserve10 = $reserve10;
    
        return $this;
    }

    /**
     * Get reserve10
     *
     * @return string 
     */
    public function getReserve10()
    {
        return $this->reserve10;
    }

    /**
     * Set edmmedia
     *
     * @param string $edmmedia
     * @return Emaillog
     */
    public function setEdmmedia($edmmedia)
    {
        $this->edmmedia = $edmmedia;
    
        return $this;
    }

    /**
     * Get edmmedia
     *
     * @return string 
     */
    public function getEdmmedia()
    {
        return $this->edmmedia;
    }

    /**
     * Set createdate
     *
     * @param \DateTime $createdate
     * @return Emaillog
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
     * @return Emaillog
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
     * @return Emaillog
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
     * @return Emaillog
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
     * @return Emaillog
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
     * @return Emaillog
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
