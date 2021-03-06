<?php

namespace Acelle\Helpers;

class LicenseHelper
{
    // license type
    const TYPE_REGULAR = 'regular';
    const TYPE_EXTENDED = 'extended';

    /**
     * Get license type: normal / extended.
     *
     * @var string
     */
    public static function getLicense($license)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"http://verify.acellemail.com/"); // @todo hard-coded here
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 10000);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
            http_build_query(array(
                'purchase-code' => $license,
                'item-id' => '17796082' // @todo hard-coded here
            )
        ));
        curl_setopt($ch,CURLOPT_USERAGENT,md5($license));

        // receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec($ch);

        // Get error
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        curl_close($ch);

        if ($curl_errno > 0) {
            // Uncatchable error
            throw new \Exception($curl_error);
        } else {
            return json_decode($server_output, true);
        }
    }

    /**
     * Get license type: normal / extended.
     *
     * @var string
     */
    public static function getLicenseType($license)
    {
        $result = self::getLicense($license);

        # return '' if not valid
        if ($result['status'] != 'valid') {
            // License is not valid
            throw new \Exception(trans('messages.license_is_not_valid'));
        }

        return $result['data']['verify-purchase']['licence'] == 'Regular License' ? self::TYPE_REGULAR : self::TYPE_EXTENDED;
    }

    /**
    * Check is valid extend license
    *
    * @return boolean
    */
    public static function isExtended($license)
    {
        return LicenseHelper::isValid($license) && LicenseHelper::getLicenseType($license) == LicenseHelper::TYPE_EXTENDED;
    }

    /**
    * Check license is valid
    *
    * @return boolean
    */
    public static function isValid($license)
    {
        $result = self::getLicense($license);

        return $result['status'] == 'valid';
    }

    /**
     * Check license is extended not remote.
     *
     * @var boolean
     */
    public static function systemLicenseIsExtended()
    {
        return \Acelle\Model\Setting::get('license_type') == LicenseHelper::TYPE_EXTENDED;
    }

    /**
     * Check when show not extended popup.
     *
     * @var boolean
     */
    public static function showNotExtendedLicensePopup()
    {
        return (\Request::is('*payment_methods*'))
            && !LicenseHelper::systemLicenseIsExtended();
    }
}
