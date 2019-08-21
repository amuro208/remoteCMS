<?php



use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Localuser
 *
 * @Table(name="localuser")
 * @Entity
 */
class Localuser
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
     * @Column(name="siteCode", type="string", length=10, nullable=true)
     */
    private $sitecode;

    /**
     * @var string
     *
     * @Column(name="eventCode", type="string", length=10, nullable=true)
     */
    private $eventcode;

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
     * @Column(name="phone", type="string", length=20, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @Column(name="mobile", type="string", length=20, nullable=true)
     */
    private $mobile;

    /**
     * @var string
     *
     * @Column(name="zipCode", type="string", length=10, nullable=true)
     */
    private $zipcode;

    /**
     * @var string
     *
     * @Column(name="email", type="string", length=128, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @Column(name="gameCode", type="string", length=10, nullable=true)
     */
    private $gamecode;

    /**
     * @var string
     *
     * @Column(name="teamCode", type="string", length=10, nullable=true)
     */
    private $teamcode;

    /**
     * @var string
     *
     * @Column(name="teamPlayerCode", type="string", length=10, nullable=true)
     */
    private $teamplayercode;

    /**
     * @var string
     *
     * @Column(name="isRemoteSynced", type="string", length=1, nullable=true)
     */
    private $isremotesynced = 'N';

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
     * @var string
     *
     * @Column(name="videoId", type="string", length=64, nullable=true)
     */
    private $videoid;

    /**
     * @var string
     *
     * @Column(name="photoId", type="string", length=64, nullable=true)
     */
    private $photoid;

    /**
     * @var string
     *
     * @Column(name="isApproved", type="string", length=1, nullable=true)
     */
    private $isapproved;

    /**
     * @var \DateTime
     *
     * @Column(name="approvedDate", type="datetime", nullable=true)
     */
    private $approveddate;

    /**
     * @var integer
     *
     * @Column(name="approvedUser", type="integer", nullable=true)
     */
    private $approveduser;

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
     * @OneToMany(targetEntity="Localmedia", mappedBy="userid")
     **/
    private $medias;
    public function getMedias(){
        return $this->medias;
    }

    /**
     * @OneToMany(targetEntity="Localrfidscan", mappedBy="localuserid")
     **/
    private $localRfidScans;
    public function getLocalRFIDScans(){
        return $this->localRfidScans;
    }

    public function __construct() {
        $this->medias = new ArrayCollection();
        $this->localRfidScans = new ArrayCollection();
    }

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
     * Set sitecode
     *
     * @param string $sitecode
     * @return Localuser
     */
    public function setSitecode($sitecode)
    {
        $this->sitecode = $sitecode;
    
        return $this;
    }

    /**
     * Get sitecode
     *
     * @return string 
     */
    public function getSitecode()
    {
        return $this->sitecode;
    }

    /**
     * Set eventcode
     *
     * @param string $eventcode
     * @return Localuser
     */
    public function setEventcode($eventcode)
    {
        $this->eventcode = $eventcode;
    
        return $this;
    }

    /**
     * Get eventcode
     *
     * @return string 
     */
    public function getEventcode()
    {
        return $this->eventcode;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Localuser
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
     * @return Localuser
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
     * Set phone
     *
     * @param string $phone
     * @return Localuser
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     * @return Localuser
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
     * Set zipcode
     *
     * @param string $zipcode
     * @return Localuser
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
    
        return $this;
    }

    /**
     * Get zipcode
     *
     * @return string 
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Localuser
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
     * Set gamecode
     *
     * @param string $gamecode
     * @return Localuser
     */
    public function setGamecode($gamecode)
    {
        $this->gamecode = $gamecode;
    
        return $this;
    }

    /**
     * Get gamecode
     *
     * @return string 
     */
    public function getGamecode()
    {
        return $this->gamecode;
    }

    /**
     * Set teamcode
     *
     * @param string $teamcode
     * @return Localuser
     */
    public function setTeamcode($teamcode)
    {
        $this->teamcode = $teamcode;
    
        return $this;
    }

    /**
     * Get teamcode
     *
     * @return string 
     */
    public function getTeamcode()
    {
        return $this->teamcode;
    }

    /**
     * Set teamplayercode
     *
     * @param string $teamplayercode
     * @return Localuser
     */
    public function setTeamplayercode($teamplayercode)
    {
        $this->teamplayercode = $teamplayercode;
    
        return $this;
    }

    /**
     * Get teamplayercode
     *
     * @return string 
     */
    public function getTeamplayercode()
    {
        return $this->teamplayercode;
    }

    /**
     * Set isremotesynced
     *
     * @param string $isremotesynced
     * @return Localuser
     */
    public function setIsremotesynced($isremotesynced)
    {
        $this->isremotesynced = $isremotesynced;
    
        return $this;
    }

    /**
     * Get isremotesynced
     *
     * @return string 
     */
    public function getIsremotesynced()
    {
        return $this->isremotesynced;
    }

    /**
     * Set reserve1
     *
     * @param string $reserve1
     * @return Localuser
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
     * @return Localuser
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
     * @return Localuser
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
     * @return Localuser
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
     * @return Localuser
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
     * Set videoid
     *
     * @param string $videoid
     * @return Localuser
     */
    public function setVideoid($videoid)
    {
        $this->videoid = $videoid;
    
        return $this;
    }

    /**
     * Get videoid
     *
     * @return string 
     */
    public function getVideoid()
    {
        return $this->videoid;
    }

    /**
     * Set photoid
     *
     * @param string $photoid
     * @return Localuser
     */
    public function setPhotoid($photoid)
    {
        $this->photoid = $photoid;
    
        return $this;
    }

    /**
     * Get photoid
     *
     * @return string 
     */
    public function getPhotoid()
    {
        return $this->photoid;
    }

    /**
     * Set isapproved
     *
     * @param string $isapproved
     * @return Localuser
     */
    public function setIsapproved($isapproved)
    {
        $this->isapproved = $isapproved;
    
        return $this;
    }

    /**
     * Get isapproved
     *
     * @return string 
     */
    public function getIsapproved()
    {
        return $this->isapproved;
    }

    /**
     * Set approveddate
     *
     * @param \DateTime $approveddate
     * @return Localuser
     */
    public function setApproveddate($approveddate)
    {
        $this->approveddate = $approveddate;
    
        return $this;
    }

    /**
     * Get approveddate
     *
     * @return \DateTime 
     */
    public function getApproveddate()
    {
        return $this->approveddate;
    }

    /**
     * Set approveduser
     *
     * @param integer $approveduser
     * @return Localuser
     */
    public function setApproveduser($approveduser)
    {
        $this->approveduser = $approveduser;
    
        return $this;
    }

    /**
     * Get approveduser
     *
     * @return integer 
     */
    public function getApproveduser()
    {
        return $this->approveduser;
    }

    /**
     * Set createdate
     *
     * @param \DateTime $createdate
     * @return Localuser
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
     * @return Localuser
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
     * @return Localuser
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
     * @return Localuser
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
     * @return Localuser
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
