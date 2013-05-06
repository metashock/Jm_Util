<?php
/**
 *
 *
 */
/**
 *
 *
 */
class Jm_Util_ChecktypeTest extends PHPUnit_Framework_TestCase
{

    /**
     */
    public function testCheck() {
        // basic type checks
        $this->assertTrue(Jm_Util_Checktype::check('string', 'hello'));
        $this->assertTrue(Jm_Util_Checktype::check('integer', 1));
        $this->assertTrue(Jm_Util_Checktype::check('boolean', FALSE));
        $this->assertTrue(Jm_Util_Checktype::check('DateTime', new DateTime()));
        $this->assertTrue(Jm_Util_Checktype::check('NULL', NULL));

        // mixed types
        $this->assertTrue(Jm_Util_Checktype::check(
            array('string', 'NULL'), 
            NULL
        ));

        $this->assertTrue(Jm_Util_Checktype::check(
            array('string', 'NULL'), 
            'foo'
        ));
        
        // check for interface type
        $this->assertTrue(Jm_Util_Checktype::check('Traversable',
            new DirectoryIterator(__DIR__)));

        $this->assertFalse(Jm_Util_Checktype::check('string', 1, FALSE));
        $this->assertFalse(Jm_Util_Checktype::check('boolean', 1, FALSE));
        $this->assertFalse(Jm_Util_Checktype::check('DateTime', 1, FALSE));
    }


    /** 
     * @expectedException InvalidArgumentException
     * @dataProvider testExceptionDataProvider
     */
    public function testException($types, $value) {
        Jm_Util_Checktype::check($types, $value);
    }


    /**
     * Data provider for the method above
     */
    public function testExceptionDataProvider() {
        return array(
            array('string', 1),
            array('boolean', new DateTime()),
            array('integer', 'foo')
        );
    } 
}
