<?php
/**
 * Created by PhpStorm.
 * User: huzairuje
 * Date: 08/05/2019
 * Time: 17:26
 */

namespace App\Library;


class UserResponse extends ApiBaseResponse
{
    public function unauthorizedEmailAndPassword()
    {
        $return = [];
        $return['meta']['status'] = 401;
        $return['meta']['message'] = trans('message.api.unauthorizedEmailAndPassword');
        return $return;
    }

}
