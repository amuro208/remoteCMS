<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Rfid
 *
 * @Table(name="rfid")
 * @Entity
 */
class Rfid
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
     * @Column(name="firstName", type="string", length=64, nullable=true)
     */
    private $firstname;

    /**
     * @var string
     *
     * @Column(name="lastName", type="string", length=64, nullable=true)
     */
    private $lastname;

    /**
     * @var string
     *
     * @Column(name="BOD", type="string", length=10, nullable=true)
     */
    private $bod;

    /**
     * @var string
     *
     * @Column(name="email", type="string", length=128, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @Column(name="mobile", type="string", length=45, nullable=true)
     */
    private $mobile;

    /**
     * @var string
     *
     * @Column(name="rfid", type="string", length=64, nullable=true)
     */
    private $rfid;

    /**
     * @var string
     *
     * @Column(name="fbUserId", type="string", length=64, nullable=true)
     */
    private $fbuserid;

    /**
     * @var string
     *
     * @Column(name="accessCode", type="string", length=128, nullable=true)
     */
    private $accesscode;

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
     * @var string
     *
     * @Column(name="reserve3", type="string", length=64, nullable=true)
     */
    private $reserve3;

    /**
     * @var string
     *
     * @Column(name="reserve4", type="string", length=64, nullable=true)
     */
    private $reserve4;

    /**
     * @var string
     *
     * @Column(name="reserve5", type="string", length=64, nullable=true)
     */
    private $reserve5;

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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Rfid
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    
        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Rfid
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set bod
     *
     * @param string $bod
     * @return Rfid
     */
    public function setBod($bod)
    {
        $this->bod = $bod;
    
        return $this;
    }

    /**
     * Get bod
     *
     * @return string 
     */
    public function getBod()
    {
        return $this->bod;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Rfid
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
     * Set mobile
     *
     * @param string $mobile
     * @return Rfid
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    
        return $this;
    }

    /**
     * Get mobile
     *
     * @return string 
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set rfid
     *
     * @param string $rfid
     * @return Rfid
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
     * Set fbuserid
     *
     * @param string $fbuserid
     * @return Rfid
     */
    public function setFbuserid($fbuserid)
    {
        $this->fbuserid = $fbuserid;
    
        return $this;
    }

    /**
     * Get fbuserid
     *
     * @return string 
     */
    public function getFbuserid()
    {
        return $this->fbuserid;
    }

    /**
     * Set accesscode
     *
     * @param string $accesscode
     * @return Rfid
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
     * Set reserve1
     *
     * @param string $reserve1
     * @return Rfid
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
     * @return Rfid
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
     * @return Rfid
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
     * @return Rfid
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
     * @return Rfid
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
     * Set createdate
     *
     * @param \DateTime $createdate
     * @return Rfid
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
     * @return Rfid
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
     * @return Rfid
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
     * @return Rfid
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
     * @return Rfid
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
}
