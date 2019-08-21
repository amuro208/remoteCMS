<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Media
 *
 * @Table(name="media", indexes={@Index(name="fk_Media_LocalUser1_idx", columns={"userId"})})
 * @Entity
 */
class Media
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
     * @Column(name="typeCode", type="string", length=10, nullable=true)
     */
    private $typecode;

    /**
     * @var string
     *
     * @Column(name="filePath", type="string", length=128, nullable=true)
     */
    private $filepath;

    /**
     * @var string
     *
     * @Column(name="fileName", type="string", length=128, nullable=true)
     */
    private $filename;

    /**
     * @var string
     *
     * @Column(name="thumbFilePath", type="string", length=128, nullable=true)
     */
    private $thumbfilepath;

    /**
     * @var string
     *
     * @Column(name="Mimetype", type="string", length=64, nullable=true)
     */
    private $mimetype;

    /**
     * @var string
     *
     * @Column(name="shortUrl", type="string", length=128, nullable=true)
     */
    private $shorturl;

    /**
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
     * Set typecode
     *
     * @param string $typecode
     * @return Media
     */
    public function setTypecode($typecode)
    {
        $this->typecode = $typecode;
    
        return $this;
    }

    /**
     * Get typecode
     *
     * @return string 
     */
    public function getTypecode()
    {
        return $this->typecode;
    }

    /**
     * Set filepath
     *
     * @param string $filepath
     * @return Media
     */
    public function setFilepath($filepath)
    {
        $this->filepath = $filepath;
    
        return $this;
    }

    /**
     * Get filepath
     *
     * @return string 
     */
    public function getFilepath()
    {
        return $this->filepath;
    }

    /**
     * Set filename
     *
     * @param string $filename
     * @return Media
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    
        return $this;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set thumbfilepath
     *
     * @param string $thumbfilepath
     * @return Media
     */
    public function setThumbfilepath($thumbfilepath)
    {
        $this->thumbfilepath = $thumbfilepath;
    
        return $this;
    }

    /**
     * Get thumbfilepath
     *
     * @return string 
     */
    public function getThumbfilepath()
    {
        return $this->thumbfilepath;
    }

    /**
     * Set mimetype
     *
     * @param string $mimetype
     * @return Media
     */
    public function setMimetype($mimetype)
    {
        $this->mimetype = $mimetype;
    
        return $this;
    }

    /**
     * Get mimetype
     *
     * @return string 
     */
    public function getMimetype()
    {
        return $this->mimetype;
    }

    /**
     * Set shorturl
     *
     * @param string $shorturl
     * @return Media
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
     * Set createdate
     *
     * @param \DateTime $createdate
     * @return Media
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
     * @return Media
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
     * @return Media
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
     * @return Media
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
     * @return Media
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
     * @return Media
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
