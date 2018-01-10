<?php

/**
 * Power toys client
 *
 * Implements client to manage powertoys licences with powertoys rest api server
 *
 * @author Palecian Tamas <paleciantamas@gmail.com>
 * @version 1.0
 */
class PowerToysClient
{
    const ENTITY_LICENCE    = 'licenses';
    const ENTITY_CUSTOMER   = 'customers';

    /**
     * Access Token
     *
     * The access token of the rest api user
     *
     * @var string
     */
    private $accessToken;

    /**
     * Version
     *
     * The version of the current rest api
     *
     * @var string
     */
    private $version;

    /**
     * Server address
     *
     * The server address of the powertoys rest api
     *
     * @var string
     */
    private $serverAddress = 'https://powertoys.io/api';

    /**
     * The current api url generated based on parameters
     *
     * @var string
     */
    private $currentApiCall;

    /**
     * Constructor
     *
     * To setup the powertoys client we require the basic access parameters
     *
     * @param string $accessToken   The access token of the instance
     * @param int    $version       The version of the rest api
     * @param string $serverAddress The server address of the rest api || null
     * and will use the default one
     *
     * @return void
     */
    public function __construct($accessToken, $version = 1, $serverAddress = null)
    {
        $this->accessToken = $accessToken;
        $this->version     = $version;

        ($serverAddress != null) ? $this->serverAddress = $serverAddress : '';
    }

    /**
     * Find customer based on unique id
     *
     * @param string $customerUID
     *
     * @return array || null
     */
    public function findCustomer($customerUID)
    {
        // Generate current url with the requested entity
        $this->_generateServerUrl($this->version, self::ENTITY_CUSTOMER);
        $this->currentApiCall = $this->currentApiCall . '/' . $customerUID;

        $result = $this->_makeGet();
        return $result;
    }

    /**
     * Find all customers
     *
     * @return array || null
     */
    public function findAllCustomers()
    {
        $this->_generateServerUrl($this->version, self::ENTITY_CUSTOMER);

        $result = $this->_makeGet();
        return $result;
    }

    /**
     * Create customer based on post data
     *
     * @param string $postData The client post data
     *
     * @return array || null
     */
    public function createCustomer($postData)
    {
        $this->_generateServerUrl($this->version, self::ENTITY_CUSTOMER);

        $result = $this->_makePost($postData);
        return $result;
    }

    /**
     * Update customer based on requested parameters
     *
     * @param string $customerUID     The customer unique id
     * @param array  $putData         The customer put data
     *
     * @return array || null
     */
    public function updateCustomer($customerUID, $putData)
    {
        $this->_generateServerUrl($this->version, self::ENTITY_CUSTOMER);
        $this->currentApiCall = $this->currentApiCall . '/' . $customerUID;

        $result = $this->_makePut($putData);
        return $result;
    }

    /**
     * Delete customer based on unique id
     *
     * @param string $customerUID
     *
     * @return array || null
     */
    public function deleteCustomer($customerUID)
    {
        $this->_generateServerUrl($this->version, self::ENTITY_LICENCE);
        $this->currentApiCall = $this->currentApiUrl . '/' . $customerUID;

        $result = $this->_makeDelete();
        return $result;
    }

    /**
     * Find licence based on unique id
     *
     * @param string $licenceUID
     *
     * @return array || null
     */
    public function findLicence($licenceUID)
    {
        // Generate current url with the requested entity
        $this->_generateServerUrl($this->version, self::ENTITY_LICENCE);
        $this->currentApiCall = $this->currentApiCall . '/' . $licenceUID;

        $result = $this->_makeGet();
        return $result;
    }

    /**
     * Find all licences
     *
     * @return array || null
     */
    public function findAllLicences()
    {
        $this->_generateServerUrl($this->version, self::ENTITY_LICENCE);

        $result = $this->_makeGet();
        return $result;
    }

    /**
     * Create licence based on requested parameters
     *
     * @param string $customerUID   The customer unique id
     * @param string $licenceType   The licence type to create
     * @param string $serverAddress The server address of the licence
     *
     * @return array || null
     */
    public function createLicence($customerUID, $licenceType, $serverAddress)
    {
        $this->_generateServerUrl($this->version, self::ENTITY_LICENCE);

        // Generate form array
        $postData = [
          'customer_uid' => $customerUID,
          'licence_type' => $licenceType,
          'server_address' => $serverAddress
        ];

        $result = $this->_makePost($postData);
        return $result;
    }

    /**
     * Update licence based on requested parameters
     *
     * @param string $licenceUID      The licence unique id
     * @param array  $licencePutData  The licence put data
     *
     * @return array || null
     */
    public function updateLicence($licenceUID, $licencePutData)
    {
        $this->_generateServerUrl($this->version, self::ENTITY_LICENCE);
        $this->currentApiCall = $this->currentApiCall . '/' . $licenceUID;

        $result = $this->_makePut($licencePutData);
        return $result;
    }

    /**
     * Delete licence based on unique id
     *
     * @param string $licenceUID
     *
     * @return array || null
     */
    public function deleteLicence($licenceUID)
    {
        $this->_generateServerUrl($this->version, self::ENTITY_LICENCE);
        $this->currentApiCall = $this->currentApiUrl . '/' . $licenceUID;

        $result = $this->_makeDelete();
        return $result;
    }

    /**
     * Verify licence based on licence key and server ip address
     *
     * @param string $licenceKey      The unique licence key
     * @param string $serverIpAddress The server ip address
     *
     * @return array || null
     */
    public function verifyLicence($licenceKey, $serverIpAddress)
    {
        $this->_generateServerUrl($this->version, self::ENTITY_LICENCE);
        $this->currentApiCall = $this->currentApiCall . '/verify-licence';

        $licencePost = [
          'licence_key' => $licenceKey,
          'server_address' => $serverIpAddress
        ];

        $result = $this->_makePost($licencePost);
        return $result;
    }

    /**
     * Activate licence based on licence key and server ip address
     *
     * @param string $licenceKey      The unique licence key
     * @param string $serverIpAddress The server ip address
     *
     * @return array || null
     */
    public function activateLicence($licenceKey, $serverIpAddress)
    {
        $this->_generateServerUrl($this->version, self::ENTITY_LICENCE);
        $this->currentApiCall = $this->currentApiCall . '/activate-licence';

        $licencePost = [
          'licence_key' => $licenceKey,
          'server_address' => $serverIpAddress
        ];

        $result = $this->_makePost($licencePost);
        return $result;
    }

    /**
     * Deactivate licence based on licence key and server ip address
     *
     * @param string $licenceKey      The unique licence key
     * @param string $serverIpAddress The server ip address
     *
     * @return array || null
     */
    public function deactivateLicence($licenceKey, $serverIpAddress)
    {
        $this->_generateServerUrl($this->version, self::ENTITY_LICENCE);
        $this->currentApiCall = $this->currentApiCall . '/deactivate-licence';

        $licencePost = [
          'licence_key' => $licenceKey,
          'server_address' => $serverIpAddress
        ];

        $result = $this->_makePost($licencePost);
        return $result;
    }

    /**
     * Make a get request with curl
     *
     * @return array || null
     */
    private function _makeGet()
    {
        $curl = curl_init($this->currentApiCall);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $this->_generateAuthHeader($curl);
        $result = curl_exec($curl);

        if($result)
        {
          return json_decode($result, true);
        }

        return null;
    }

    /**
     * Make post request with curl
     *
     * @param array $postData
     *
     * @return array || null
     */
    private function _makePost($postData)
    {
        $curl = curl_init($this->currentApiCall);

        $dataString = http_build_query($postData);

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_FAILONERROR, true);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_HTTPHEADER, [
              'Content-Type: application/json',
              'Content-Length: ' . strlen($dataString)
            ]
        );

        $curl = $this->_generateAuthHeader($curl);
        $result = curl_exec($curl);

        if($result)
        {
          return json_decode($result, true);
        }

        return null;
    }

    /**
     * Make put request with curl
     *
     * @param string $putData
     *
     * @return array || null
     */
    private function _makePut($putData)
    {
        $curl = curl_init($this->currentApiCall);

        $dataString = http_build_query($putData);

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($curl, CURLOPT_FAILONERROR, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $dataString);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($dataString))
        );

        $curl = $this->_generateAuthHeader($curl);
        $result = curl_exec($curl);

        if($result)
        {
          return json_decode($result, true);
        }

        return null;
    }

    /**
     * Make delete request with curl
     *
     * @return array || null
     */
    private function _makeDelete()
    {
        $curl = curl_init($this->currentApiCall);

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_FAILONERROR, true);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'Content-Type: application/json',
          'Content-Length: ' . strlen($data_string))
        );

        $curl = $this->_generateAuthHeader($curl);
        $result = curl_exec($curl);

        if($result)
        {
          return json_decode($result, true);
        }

        return null;
    }

    /**
     * Generate the api url with the requested parameters
     *
     * @param int $version The version of the rest api
     * @param string $entity The entity type for what we make call
     *
     * @return void
     */
    private function _generateServerUrl($version, $entity)
    {
        $this->currentApiCall = $this->serverAddress . '/v' . $version . '/' . $entity;
    }

    /**
     * Generate auth header for curl options
     *
     * @param Curl $curl
     *
     * @return Curl
     */
    private function _generateAuthHeader($curl)
    {
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'Authorization: Bearer ' . $this->accessToken,
        ));

        return $curl;
    }
}
