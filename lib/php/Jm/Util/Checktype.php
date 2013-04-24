<?php
/**
 * Jm_Util
 *
 * Copyright (c) 2013, Thorsten Heymann <thorsten@metashock.de>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name Thorsten Heymann nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * PHP Version >= 5.3.0
 *
 * @category  Util
 * @package   Jm_Util
 * @author    Thorsten Heymann <thorsten@metashock.de>
 * @copyright 2013 Thorsten Heymann <thorsten@metashock.de>
 * @license   BSD-3 http://www.opensource.org/licenses/BSD-3-Clause
 * @version   GIT: $$GITVERSION$$
 * @link      http://www.metashock.de/
 * @since     0.1.0
 */
/**
 * Provides a solid typecheck that should be used in functions 
 * to ensure that the arguments have the right data type.
 *
 * @category  Util
 * @package   Jm_Util
 * @author    Thorsten Heymann <thorsten@metashock.de>
 * @copyright 2013 Thorsten Heymann <thorsten@metashock.de>
 * @license   BSD-3 http://www.opensource.org/licenses/BSD-3-Clause
 * @version   GIT: $$GITVERSION$$
 * @link      http://www.metashock.de/
 * @since     0.1.0
 */
class Jm_Util_Checktype
{

    /**
     * Helper method for checking data types
     * 
     * @param mixed   $type      A string or an array that contains the types
     *                           which are valid for $value
     * @param mixed   $value     The value which's type should be checked
     * @param boolean $null      .... 
     * @param boolean $throw     If set to TRUE an exception will be thrown
     *                           $value's type does not match
     * @param string  $msgprefix A prefix string that will be prepended i
     *                           in front of the error message
     *
     * @return boolean
     *
     * @throws InvalidArgumentException if $throw is set and and the type 
     * of $value doesn't match the expected type(s)
     */
    public static function check (
        $type,
        $value,
        $throw = TRUE,
        $msgprefix = ''
    ) {

        // wrap $type in an array if it is a scalar value
        if(!is_array($type)) {
            $type = array($type);
        }


        // type checks
        foreach($type as $t) {
            if(is_object($value)) {
                if(is_a($value, $t)) {
                    return TRUE;
                }
            } else if(gettype($value) === $t) {
                return TRUE;
            }
        }

        // typecheck has failed

        if($throw === FALSE) {
            return FALSE;
        }

        $possibleTypes = implode(' or ', $type);
        if(empty($msgprefix)) {
            $msgprefix = 'param ';
        }
        throw new InvalidArgumentException (
            $msgprefix . sprintf(' expected to be %s. %s found',
                $possibleTypes, is_object($value) ? get_class($value)
                    : gettype($value)
            )
        );
    }
}
