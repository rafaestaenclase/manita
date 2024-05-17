<?php

class User {
    private $id;
    private $name;
    private $subname;
    private $dob;
    private $telephone;
    private $email;
    private $password;
    private $login_hash;
    private $address;
    private $avatar;
    private $desc;
    private $created_at;
    private $updated_at;
    private $role;
    private $is_verified;
    private $prestige;
    private $language;

    // Constructor
    public function __construct($id, $name, $subname, $dob, $telephone, $email, $password, $address, $avatar, $desc, $role, $prestige, $language) {
        $this->id = $id;
        $this->name = $name;
        $this->subname = $subname;
        $this->dob = $dob;
        $this->telephone = $telephone;
        $this->email = $email;
        $this->password = $password;
        $this->login_hash = '';
        $this->address = $address;
        $this->avatar = $avatar;
        $this->desc = $desc;
        $this->created_at = date('Y-m-d H:i:s');
        $this->updated_at = date('Y-m-d H:i:s');
        $this->role = $role;
        $this->is_verified = false;
        $this->prestige = $prestige;
        $this->language = $language;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getSubname() {
        return $this->subname;
    }

    public function getDob() {
        return $this->dob;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getLoginHash() {
        return $this->login_hash;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getAvatar() {
        return $this->avatar;
    }

    public function getDesc() {
        return $this->desc;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function getUpdatedAt() {
        return $this->updated_at;
    }

    public function getRole() {
        return $this->role;
    }

    public function getIsVerified() {
        return $this->is_verified;
    }

    public function getPrestige() {
        return $this->prestige;
    }

    public function getLanguage() {
        return $this->language;
    }

    // Setters
    public function setName($name) {
        $this->name = $name;
    }

    public function setSubname($subname) {
        $this->subname = $subname;
    }

    public function setDob($dob) {
        $this->dob = $dob;
    }

    public function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setLoginHash($login_hash) {
        $this->login_hash = $login_hash;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function setAvatar($avatar) {
        $this->avatar = $avatar;
    }

    public function setDesc($desc) {
        $this->desc = $desc;
    }

    public function setUpdatedAt($updated_at) {
        $this->updated_at = $updated_at;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function setIsVerified($is_verified) {
        $this->is_verified = $is_verified;
    }

    public function setPrestige($prestige) {
        $this->prestige = $prestige;
    }

    public function setLanguage($language) {
        $this->language = $language;
    }
}
?>
