<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';

    protected $primaryKey = 'id';

    public $timestamps = false;

    public function save(array $options = [])
    {
        if( empty($this->created_at) ){
            $this->created_at = date('Y-m-d H:i:s');
        }

        $this->last_updated_time = date('Y-m-d H:i:s');

        if( $this->getOriginal('password') !== $this->password ){
            $this->password = md5($this->password);
        }

        parent::save($options);
    }

    public function IsValidate()
    {
        if( empty($this->first_name) || empty($this->last_name) || empty($this->username) ){
            return false;
        }
        
        if( ! filter_var($this->email, FILTER_VALIDATE_EMAIL) ){
            return false;
        }

        if( empty($this->password) ){
            return false;
        }elseif( $this->getOriginal('password') === $this->password ){
            // nothing, password not changed.
        }elseif( strlen($this->password) <= 8 ){
            return false;
        }elseif( ! preg_match('/[a-z]/', $this->password) ){
            return false;
        }elseif( ! preg_match('/[A-Z]/', $this->password) ){
            return false;
        }elseif( ! preg_match('/[0-9]/', $this->password) ){
            return false;
        }elseif( ! preg_match('/[^(A-Z)|(a-z)|(0-9)]/', $this->password) ){
            return false;
        }

        return true;
    }
}
 