<?php
/**
 * Setup autoloading for the tests.
 *
 * PHP version 5
 *
 * @category Kolab
 * @package  Kolab_Session
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL 2.1
 */

/** Load the basic test definition */
require_once __DIR__ . '/TestCase.php';

/** Load the stub definitions */
require_once __DIR__ . '/Stub/Imap.php';
require_once __DIR__ . '/Stub/ImapFactory.php';
