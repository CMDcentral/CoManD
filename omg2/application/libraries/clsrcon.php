<?php
class clsRcon {
    /**
     * Address of the server
     *
     * @var string
     */
    protected $m_sAddress;
    /**
     * Port number of the server
     *
     * @var int
     */
    protected $m_iPort;
    /**
     * rcon password
     *
     * @var string
     */
    protected $m_sPassword;
    /**
     * TCP socket for communication
     *
     * @var object
     */
    protected $m_oSocket = false;
    /**
     * rcon request id
     *
     * @var int
     */
    protected $m_iRequestId = 0;
    /**
     * timeout in usec
     *
     * @var int
     */
    protected $m_iReadTimeout = 150000;

    const SERVERDATA_EXECCOMMAND = 2;
    const SERVERDATA_AUTH = 3;
    const SERVERDATA_RESPONSE_VALUE = 0;
    const SERVERDATA_AUTH_RESPONSE = 2;

    /**
     * __construct
     * Set the variables used to connect
     *
     * @access public
     * @param string $p_sAddress
     * @param int $p_iPort
     * @param string $p_sPassword
     * @return clsRcon
     */
    public function __construct($p_sAddress="", $p_iPort="", $p_sPassword="") {
        $this->m_sAddress = $p_sAddress;
        $this->m_iPort = $p_iPort;
        $this->m_sPassword = $p_sPassword;
    }

    /**
     * __destruct
     * closes the socket
     *
     * @access public
     * @return void
     */
    public function __destruct() {
        if ($this->m_oSocket !== false) {
            socket_close($this->m_oSocket);
            $this->m_oSocket = false;
        }
    }

    /**
     * connect
     * Connects the socket and authenticates with the server
     *
     * @access public
     * @return boolean
     */
    public function connect() {
        // create a socket
        if (($this->m_oSocket = socket_create(AF_INET,SOCK_STREAM, SOL_TCP)) === false) {
            return false;
        }
        // connect it
        if (socket_connect($this->m_oSocket, $this->m_sAddress, $this->m_iPort) === false) {
            $this->m_oSocket = false;
            return false;
        }
        // send authentication request
        $this->rawPacketSend($this->m_sPassword, null, self::SERVERDATA_AUTH);
        // read the response
        $aResult = $this->rawPacketRead();
        // check if we authenticated succesfully
        if ($aResult[0]['CommandResponse'] != self::SERVERDATA_AUTH_RESPONSE) {
            $this->__destruct();
            return false;
        } else {
            return true;
        }
    }

    /**
     * rcon
     * execute an rcon command
     *
     * @access public
     * @param string $p_sCommand
     * @return array
     */
    public function rcon($p_sCommand) {
        // check connection
        if($this->m_oSocket === false) {
            return false;
        }
        $this->rawPacketSend($p_sCommand);

        return $this->rawPacketRead();
    }

    /**
     * rawPacketSend
     * Builds up a packet and sends it to the server
     *
     * @access protected
     * @param string $p_sString1
     * @param string $p_sString2
     * @param int $p_iCommand
     * @return void
     */
    protected function rawPacketSend($p_sString1, $p_sString2 = NULL, $p_iCommand = self::SERVERDATA_EXECCOMMAND) {
        // build the packet backwards
        $sPacket = $p_sString1 . "\x00" . $p_sString2 . "\x00";
        // build the Request ID and Command into the Packet
        $sPacket = pack('VV',++$this->m_iRequestID, $p_iCommand) . $sPacket;
        // add the length
        $sPacket = pack('V',strlen($sPacket)) . $sPacket;
        // send the packet.
        socket_send($this->m_oSocket, $sPacket, strlen($sPacket), 0x00);
    }

    /**
     * rawPacketRead
     * reads and parses the rcon response
     *
     * @access protected
     * @return array
     */
    protected function rawPacketRead() {
        // the packets
        $aPackets = array();
        // our reading socket
        $aRead = array($this->m_oSocket);
        // we need to use a buffer cause sometimes a packet is send over more then 1 'read request'
        $sBuffer = '';
        while (socket_select($aRead, $aWrite = NULL, $aExcept = NULL, 0, $this->m_iReadTimeout)) {
            // get the packet length
            if (strlen($sBuffer) == 0) {
                $aPacketLength = unpack('V1PacketLength', socket_read($aRead[0], 4));
            }

            // read some data
            $sBuffer .= socket_read($aRead[0], $aPacketLength['PacketLength'] - strlen($sBuffer));
            // if the package is complete parse it
            if (strlen($sBuffer) == $aPacketLength['PacketLength']) {
                // read the actuall packet
                $aPacket = unpack('V1RequestID/V1CommandResponse/a*String1/a*String2', $sBuffer);
                $sBuffer = '';

                if (isset($aPackets[$aPacket['RequestID']]) && $aPacket['CommandResponse'] != self::SERVERDATA_AUTH_RESPONSE) {
                    // existing reply, append the data
                    $aPackets[$aPacket['RequestID']]['String1'] .= $aPacket['String1'];
                    $aPackets[$aPacket['RequestID']]['String2'] .= $aPacket['String2'];
                } else {
                    // new reply
                    $aPackets[$aPacket['RequestID']] = $aPacket;
                }
            }
        }
        return array_values($aPackets);
    }
} 
