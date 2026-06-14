<?php
/**
 * Test the session based storage driver.
 *
 * PHP version 5
 *
 * @category Kolab
 * @package  Kolab_Session
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL 2.1
 */

/**
 * Test the session based storage driver.
 *
 * Copyright 2009-2017 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category Kolab
 * @package  Kolab_Session
 * @author   Gunnar Wrobel <wrobel@pardus.de>
 * @license  http://www.horde.org/licenses/lgpl21 LGPL 2.1
 */
class Horde_Kolab_Session_Unit_Storage_SessionTest extends Horde_Kolab_Session_TestCase
{
    public function setUp()
    {
        require_once __DIR__ . '/../../TestSession.php';
        $GLOBALS['session'] = new Horde_Kolab_Session_Test_Session();
    }

    public function tearDown()
    {
        unset($GLOBALS['session']);
    }

    public function testLoad()
    {
        $GLOBALS['session']->set('kolab_session', 'data', array('data'));
        $storage = new Horde_Kolab_Session_Storage_Session();
        $this->assertEquals($storage->load(), array('data'));
    }

    public function testEmpty()
    {
        $storage = new Horde_Kolab_Session_Storage_Session();
        $this->assertEquals($storage->load(), array());
    }

    public function testSave()
    {
        $storage = new Horde_Kolab_Session_Storage_Session();
        $storage->save(array('data'));
        $this->assertEquals($GLOBALS['session']->get('kolab_session', 'data'), array('data'));
    }
}
