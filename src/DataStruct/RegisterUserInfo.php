<?php
// Package\Uc\DataStruct/ResgiterUserInfo


namespace Package\Uc\DataStruct;


class RegisterUserInfo
{
    /** @var string 用户名 */
    public string $username;

    /** @var string 昵称 */
    public string $nickname;

    /** @var string 头像 */
    public string $avtar;

    /** @var int 性别 */
    public int $gender;
}