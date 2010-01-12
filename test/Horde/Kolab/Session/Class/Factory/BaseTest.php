<?php
/**
 * Test the base factory definition via the constructor based factory.
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
 * Prepare the test setup.
 */
require_once dirname(__FILE__) . '/../../Autoload.php';

/**
 * Test the base factory definition via the constructor based factory.
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
class Horde_Kolab_Session_Class_Factory_BaseTest extends Horde_Kolab_Session_SessionTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->setupFactoryMocks();
        $this->user = $this->getMock(
            'Horde_Kolab_Server_Object_Hash', array(), array(), '', false, false
        );
    }

    public function testMethodGetvalidatorHasResultHordekolabsesessionvalid()
    {
        $session = $this->getMock('Horde_Kolab_Session_Interface');
        $factory = new Horde_Kolab_Session_Factory_Constructor(
            $this->server, $this->session_auth, array(), $this->session_storage
        );
        $this->assertType(
            'Horde_Kolab_Session_Valid_Interface',
            $factory->getSessionValidator($session, $this->session_auth)
        );
    }

    public function testMethodValidateHasResultTrueIfTheSessionIsStillValid()
    {
        $this->session_auth->expects($this->once())
            ->method('getCurrentUser')
            ->will($this->returnValue('mail@example.org'));
        $session = $this->getMock('Horde_Kolab_Session_Interface');
        $session->expects($this->once())
            ->method('getMail')
            ->will($this->returnValue('mail@example.org'));
        $factory = new Horde_Kolab_Session_Factory_Constructor(
            $this->server, $this->session_auth, array(), $this->session_storage
        );
        $this->assertTrue($factory->validate($session));
    }

    public function testMethodCreatesessionHasResultHordekolabsessionstored()
    {
        $factory = new Horde_Kolab_Session_Factory_Constructor(
            $this->server, $this->session_auth, array(), $this->session_storage
        );
        $this->assertType('Horde_Kolab_Session_Decorator_Stored', $factory->createSession());
    }

    public function testMethodGetsessionHasResultHordekolabsessionTheOldSessionIfAnOldSessionWasStoredAndValid()
    {
        $session = $this->getMock('Horde_Kolab_Session_Interface');
        $session->expects($this->once())
            ->method('getMail')
            ->will($this->returnValue('mail@example.org'));
        $this->session_storage->expects($this->once())
            ->method('load')
            ->will($this->returnValue($session));
        $this->session_auth->expects($this->once())
            ->method('getCurrentUser')
            ->will($this->returnValue('mail@example.org'));
        $factory = new Horde_Kolab_Session_Factory_Constructor(
            $this->server, $this->session_auth, array(), $this->session_storage
        );
        $this->assertSame($session, $factory->getSession());
    }

    public function testMethodGetsessionHasResultHordekolabsessionANewSessionIfAnOldSessionWasStoredAndInvalid()
    {
        $session = $this->getMock('Horde_Kolab_Session_Interface');
        $session->expects($this->once())
            ->method('getMail')
            ->will($this->returnValue('mail@example.org'));
        $this->session_storage->expects($this->once())
            ->method('load')
            ->will($this->returnValue($session));
        $this->session_auth->expects($this->once())
            ->method('getCurrentUser')
            ->will($this->returnValue('new@example.org'));
        $this->server->objects->expects($this->once())
            ->method('fetch')
            ->will($this->returnValue($this->user));
        $this->user->expects($this->exactly(1))
            ->method('getSingle')
            ->will($this->returnValue('mail@example.org'));
        $this->user->expects($this->exactly(4))
            ->method('getExternal')
            ->will($this->returnValue(array('mail@example.org')));
        $factory = new Horde_Kolab_Session_Factory_Constructor(
            $this->server, $this->session_auth, array(), $this->session_storage
        );
        $this->assertTrue($session !== $factory->getSession());
    }

    public function testMethodGetsessionHasResultHordekolabsessionANewSessionIfNoOldSessionExisted()
    {
        $this->session_storage->expects($this->once())
            ->method('load')
            ->will($this->returnValue(false));
        $this->server->objects->expects($this->once())
            ->method('fetch')
            ->will($this->returnValue($this->user));
        $this->user->expects($this->exactly(1))
            ->method('getSingle')
            ->will($this->returnValue('mail@example.org'));
        $this->user->expects($this->exactly(4))
            ->method('getExternal')
            ->will($this->returnValue(array('mail@example.org')));
        $factory = new Horde_Kolab_Session_Factory_Constructor(
            $this->server, $this->session_auth, array(), $this->session_storage
        );
        $this->assertType('Horde_Kolab_Session_Interface', $factory->getSession());
    }
}