<?php

namespace App\Services;

use SoapClient;

class ESMSService
{
    protected $client;
    protected $username;
    protected $password;
    protected $wsdl;

    public function __construct()
    {
//        $this->username = config('services.mobitel.username');
//        $this->password = config('services.mobitel.password');
//        $this->wsdl = config('services.mobitel.wsdl');
        $this->username = env('MOBITEL_SMS_USERNAME');
        $this->password = env('MOBITEL_SMS_PASSWORD');
        $this->wsdl = env('MOBITEL_SMS_WSDL', 'http://smeapps.mobitel.lk:8585/EnterpriseSMSV3/EnterpriseSMSWS?wsdl');
        $this->client = $this->getClient();
    }

    // Create SOAP client
    protected function getClient()
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        return new SoapClient($this->wsdl);
    }

    // Service test
    public function serviceTest()
    {
        $user = new \stdClass();
        $user->id = '';
        $user->username = $this->username;
        $user->password = $this->password;
        $user->customer = '';

        $serviceTest = new \stdClass();
        $serviceTest->arg0 = $user;

        return $this->client->serviceTest($serviceTest);
    }

    // Create session
    public function createSession()
    {
        $user = new \stdClass();
        $user->id = '';
        $user->username = $this->username;
        $user->password = $this->password;
        $user->customer = '';

        $createSession = new \stdClass();
        $createSession->user = $user;

        $createSessionResponse = $this->client->createSession($createSession);

        return $createSessionResponse->return;
    }

    // Check if session is valid
    public function isSession($session)
    {
        $isSession = new \stdClass();
        $isSession->session = $session;

        $isSessionResponse = $this->client->isSession($isSession);

        return $isSessionResponse->return;
    }

    // Send SMS to recipients
    public function sendMessages($session, $alias, $message, $recipients, $messageType)
    {
        $smsMessage = new \stdClass();
        $smsMessage->message = $message;
        $smsMessage->messageId = "";
        $smsMessage->recipients = $recipients;
        $smsMessage->retries = "";
        $smsMessage->sender = $alias;
        $smsMessage->messageType = $messageType;
        $smsMessage->sequenceNum = "";
        $smsMessage->status = "";
        $smsMessage->time = "";
        $smsMessage->type = "";
        $smsMessage->user = "";

        $sendMessages = new \stdClass();
        $sendMessages->session = $session;
        $sendMessages->smsMessage = $smsMessage;

        $sendMessagesResponse = $this->client->sendMessages($sendMessages);

        return $sendMessagesResponse->return;
    }

    // Send Unicode SMS to recipients
//    public function sendMessagesMultiLang($session, $alias, $message, $recipients, $messageType)
//    {
//        $smsMessageMultiLang = new \stdClass();
//        $smsMessageMultiLang->message = $message;
//        $smsMessageMultiLang->messageId = "";
//        $smsMessageMultiLang->recipients = $recipients;
//        $smsMessageMultiLang->retries = "";
//        $smsMessageMultiLang->sender = $alias;
//        $smsMessageMultiLang->messageType = $messageType;
//        $smsMessageMultiLang->sequenceNum = "";
//        $smsMessageMultiLang->status = "";
//        $smsMessageMultiLang->time = "";
//        $smsMessageMultiLang->type = "";
//        $smsMessageMultiLang->user = "";
//
//        $sendMessagesMultiLang = new \stdClass();
//        $sendMessagesMultiLang->session = $session;
//        $sendMessagesMultiLang->smsMessageMultiLang = $smsMessageMultiLang;
//
//        $sendMessagesMultiLangResponse = $this->client->sendMessagesMultiLang($sendMessagesMultiLang);
//
//        return $sendMessagesMultiLangResponse->return;
//    }
// Send Unicode SMS to recipients with retry logic
    public function sendMessagesMultiLang($session, $alias, $message, $recipients, $messageType, $maxRetries = 3, $retryDelay = 1000)
    {
        $smsMessageMultiLang = new \stdClass();
        $smsMessageMultiLang->message = $message;
        $smsMessageMultiLang->messageId = "";
        $smsMessageMultiLang->recipients = $recipients;
        $smsMessageMultiLang->retries = "";
        $smsMessageMultiLang->sender = $alias;
        $smsMessageMultiLang->messageType = $messageType;
        $smsMessageMultiLang->sequenceNum = "";
        $smsMessageMultiLang->status = "";
        $smsMessageMultiLang->time = "";
        $smsMessageMultiLang->type = "";
        $smsMessageMultiLang->user = "";

        $sendMessagesMultiLang = new \stdClass();
        $sendMessagesMultiLang->session = $session;
        $sendMessagesMultiLang->smsMessageMultiLang = $smsMessageMultiLang;

        $attempt = 0;
        $lastResponse = null;

        while ($attempt < $maxRetries) {
            try {
                $sendMessagesMultiLangResponse = $this->client->sendMessagesMultiLang($sendMessagesMultiLang);
                $lastResponse = $sendMessagesMultiLangResponse->return;

                // If the return code is 200 (success), return the result immediately
                if ($lastResponse == 200) {
                    return $lastResponse;
                }

                // If it is a session error (151) or the session is in use (152),
                // the session may need to be renewed before retrying
                if (in_array($lastResponse, [151, 152])) {
                    // Renew the session and retry
                    $session = $this->renewSession($session);
                    $sendMessagesMultiLang->session = $session;
                }

                // Log the error (you can replace this with real logging)
                error_log("SMS send attempt " . ($attempt + 1) . " failed with code: " . $lastResponse);

                $attempt++;

                // If max retries has not been reached, wait a bit before retrying
                if ($attempt < $maxRetries) {
                    usleep($retryDelay * 1000); // Convert ms to microseconds
                }

            } catch (\Exception $e) {
                // Log exception
                error_log("SMS send exception on attempt " . ($attempt + 1) . ": " . $e->getMessage());
                $attempt++;

                if ($attempt < $maxRetries) {
                    usleep($retryDelay * 1000);
                }
            }
        }

        // If all retries are exhausted without success, return the last error code
        // or throw an exception if you prefer
        return $lastResponse;
    }

    // Send Campaign SMS to recipients
    public function sendCampaignMessages($session, $alias, $message, $recipients, $datetime, $multilanguage, $messageType)
    {
        $smsCampaignMessage = new \stdClass();
        $smsCampaignMessage->message = $message;
        $smsCampaignMessage->messageId = "";
        $smsCampaignMessage->recipients = $recipients;
        $smsCampaignMessage->retries = "";
        $smsCampaignMessage->sender = $alias;
        $smsCampaignMessage->messageType = $messageType;
        $smsCampaignMessage->sequenceNum = "";
        $smsCampaignMessage->status = "";
        $smsCampaignMessage->time = $datetime;
        $smsCampaignMessage->type = "";
        $smsCampaignMessage->user = "";
        $smsCampaignMessage->esmClass = $multilanguage;

        $sendCampaignMessages = new \stdClass();
        $sendCampaignMessages->session = $session;
        $sendCampaignMessages->smsCampaignMessage = $smsCampaignMessage;

        $sendCampaignMessagesResponse = $this->client->sendCampaignMessages($sendCampaignMessages);

        return $sendCampaignMessagesResponse->return;
    }

    // Renew session
    public function renewSession($session)
    {
        $renewSession = new \stdClass();
        $renewSession->session = $session;

        $renewSessionResponse = $this->client->renewSession($renewSession);

        return $renewSessionResponse->return;
    }

    // Close session
    public function closeSession($session)
    {
        $closeSession = new \stdClass();
        $closeSession->session = $session;

        $this->client->closeSession($closeSession);
    }

    // Retrieve messages from shortcode
    public function getMessagesFromShortCode($session, $shortCode)
    {
        $getMessagesFromShortCode = new \stdClass();
        $getMessagesFromShortCode->session = $session;
        $getMessagesFromShortCode->shortcode = $shortCode;

        $getMessagesFromShortcodeResponse = $this->client->getMessagesFromShortcode($getMessagesFromShortCode);

        return property_exists($getMessagesFromShortcodeResponse, 'return') ? $getMessagesFromShortcodeResponse->return : null;
    }

    // Retrieve delivery report
    public function getDeliveryReports($session, $alias)
    {
        $getDeliveryReports = new \stdClass();
        $getDeliveryReports->session = $session;
        $getDeliveryReports->alias = $alias;

        $getDeliveryReportsResponse = $this->client->getDeliveryReports($getDeliveryReports);

        return property_exists($getDeliveryReportsResponse, 'return') ? $getDeliveryReportsResponse->return : null;
    }

    // Retrieve messages from long number
    public function getMessagesFromLongNumber($session, $longNumber)
    {
        $getMessagesFromLongNumber = new \stdClass();
        $getMessagesFromLongNumber->session = $session;
        $getMessagesFromLongNumber->longNumber = $longNumber;

        $getMessagesFromLongNumberResponse = $this->client->getMessagesFromLongNumber($getMessagesFromLongNumber);

        return property_exists($getMessagesFromLongNumberResponse, 'return') ? $getMessagesFromLongNumberResponse->return : null;
    }
}
