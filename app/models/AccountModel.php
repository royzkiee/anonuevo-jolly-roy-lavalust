<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AccountModel extends Model
{
    protected $table = 'accounts';
    protected $primary_key = 'id';
    protected $fillable = [
        'username',
        'password'
    ];

    public function find_by_username($username)
    {
        return $this->db->table($this->table)->where('username', $username)->get();
    }
}
?>
