<?php
/**
 * Mock authentication for the Kolab session information.
 *
 * PHP version 5
 *
 * @category Kolab
 * @package  Kolab_Session
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.fsf.org/copyleft/lgpl.html LGPL
 * @link     http://pear.horde.org/index.php?package=Kolab_Session
 */

/**
 * Mock authentication for the Kolab session information.
 *
 * Copyright 2009-2010 The Horde Project (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (LGPL). If you
 * did not receive this file, see http://www.fsf.org/copyleft/lgpl.html.
 *
 * @category Kolab
 * @package  Kolab_Session
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.fsf.org/copyleft/lgpl.html LGPL
 * @link     http://pear.horde.org/index.php?package=Kolab_Session
 */
class Horde_Kolab_Session_Auth_Mock
implements Horde_Interfaces_Registry_Auth
{
    /**
     * The user this instance will report.
     *
     * @var string
     */
    private $_user;

    /**
     * Constructor
     *
     * @param string $user The user this instance should report.
     */
    public function __construct($user)
    {
        $this->_user = $user;
    }

    /**
     * Returns the currently logged in user, if there is one.
     *
     * @param string $format  The return format, defaults to the unique Horde
     *                        ID. Alternative formats:
     *                        - bare: Horde ID without any domain information
     *                          (e.g., foo@example.com would be returned as
     *                          'foo').
     *                        - domain: Domain of the Horde ID (e.g.,
     *                          foo@example.com would be returned as
     *                          'example.com').
     *                        - original: The username used to originally login
     *                          to Horde.
     *
     * @return mixed  The user ID or false if no user is logged in.
     */
    public function getAuth($format = null)
    {
        if (empty($this->_user)) {
            return false;
        }

        $user = $this->_user;

        switch ($format) {
        case 'bare':
            return (($pos = strpos($user, '@')) === false)
                ? $user
                : substr($user, 0, $pos);

        case 'domain':
            return (($pos = strpos($user, '@')) === false)
                ? false
                : substr($user, $pos + 1);

        default:
            return $user;
        }
    }
}
