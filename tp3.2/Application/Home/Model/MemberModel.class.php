<?php

namespace Home\Model;
use Think\Model;
class MemberModel extends Model {
    protected $tableName = 'member';

    public function sel()
    {
        phpinfo();exit;
        $data=$this->limit(20)->select();
        return $data;
    }
}