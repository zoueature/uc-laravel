<?php

namespace Package\Uc\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Package\Uc\Common\Constant;
use Package\Uc\DataStruct\UserInfo;
use Package\Uc\Exception\UserNotFoundException;

// CREATE TABLE `user` (
//    `id` int NOT NULL AUTO_INCREMENT COMMENT '用户id',
//    `username` varchar(32) NOT NULL DEFAULT '' COMMENT '用户名',
//    `login_type` varchar(16) NOT NULL DEFAULT '' COMMENT '登录类型',
//    `identify` varchar(64) NOT NULL DEFAULT '' COMMENT '标志性账号, 登录类型是email则为邮箱， mobile则为手机号',
//    `password` char(40) NOT NULL DEFAULT '' COMMENT '密码',
//    `nickname` varchar(32) NOT NULL DEFAULT '' COMMENT '昵称',
//    `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
//    `gender` tinyint NOT NULL DEFAULT 0 COMMENT '性别， 0未知， 1男， 2女',
//    `active` tinyint NOT NULL DEFAULT 1 COMMENT '1争产， 0删除',
//    `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
//    `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
//    `last_login_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '最后登录时间',
//    PRIMARY KEY (`id`) USING BTREE,
//    UNIQUE `uk_username` (`username`),
//    UNIQUE `uk_identify` (`identify`)
//) ENGINE=InnoDB AUTO_INCREMENT=100000 DEFAULT CHARSET=utf8mb4 COMMENT='用户表';

/**
 * @property mixed $password
 * @property mixed $id
 * @property mixed $login_type
 * @property mixed $identify
 * @property mixed $nickname
 * @property mixed $avatar
 * @property mixed $gender
 */
class User extends Model
{
    protected $table      = 'user';
    protected $connection = 'user_center';
    public    $timestamps = false;

    public function toUserInfo(): UserInfo
    {
        $userInfo            = new UserInfo();
        $userInfo->id        = $this->id;
        $userInfo->loginType = $this->login_type;
        $userInfo->name      = $this->nickname;
        $userInfo->avatar    = $this->avatar;
        $userInfo->gender    = $this->gender;
        return $userInfo;
    }

    /**
     * getUserByIdentify 根据标识获取用户信息
     * @throws UserNotFoundException
     */
    public function getUserByIdentify(string $loginType, string $identify): User
    {
        try {
            return $this->newQuery()
                ->where('login_type', '=', $loginType)
                ->where('identify', '=', $identify)
                ->where('active', '=', Constant::DATA_STATUS_NORMAL)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException();
        }
    }

    /**
     * getUserByUsername 根据用户名获取用户信息
     * @param string $username
     * @return User
     * @throws UserNotFoundException
     */
    public function getUserByUsername(string $username): User
    {
        try {
            return $this->newQuery()
                ->where('username', '=', $username)
                ->where('active', '=', Constant::DATA_STATUS_NORMAL)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException();
        }

    }

    /**
     * getUserById 根据主键id获取用户信息
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function getUserById(int $id): User
    {
        try {
            return $this->newQuery()
                ->where('id', '=', $id)
                ->where('active', '=', Constant::DATA_STATUS_NORMAL)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException();
        }
    }

    /**
     * getUserWithNoScope 根据主键id获取用户信息
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function getUserWithNoScope(int $id): User
    {
        try {
            return $this->newQuery()
                ->where('id', '=', $id)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new UserNotFoundException();
        }
    }
}