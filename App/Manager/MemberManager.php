<?php
namespace Manager;

use Model\Member;
use PDO;

/**
 * Class MemberManager manage queries datas in member table from db
 */
class MemberManager extends Manager
{
    /**
     * Adding a member in bd
     * @param  \Model\Member $Member
     */
    public function createMember(Member $Member)
    {
        $sql = self::$connection->prepare('
			INSERT INTO member (login, password, reset_password, email, validated, id_type, date_create)
			VALUES (?, ?, ?, ?, ?, ?, NOW())');
        
        $sql->execute([$Member->login(), $Member->password(), '', $Member->email(), 0, 2]);
    }

    /**
     * Get a single member with its id
     * @param  \Model\Member $Member
     * @return array of the member
     */
    public function getMember(Member $Member)
    {
        $sql = self::$connection->prepare('
			SELECT * FROM member
			WHERE BINARY login=:login');

        $sql->bindvalue(':login', (string) $Member->login(), PDO::PARAM_STR);
        $sql->execute();
        return $sql->fetch();
    }

    /**
     * Get list of all members
     * @return array of members list
     */
    public function getMemberList()
    {
        $sql = self::$connection->query('SELECT id, login FROM member');
        return $sql->fetchAll();
    }

    /**
     * Get a member with its reset-password
     * @param  Model\Member $Member
     * @return array of the member
     */
    public function getMemberbyResetPassword(Member $Member)
    {
        $sql = self::$connection->prepare('
			SELECT * FROM member
			WHERE BINARY reset_password=:reset_password');
        $sql->bindvalue(':reset_password', (string) $Member->reset_password(), PDO::PARAM_STR);
        $sql->execute();
        return $sql->fetch();
    }

    /**
     * Get a member with its id
     * @param  Model\Member $Member
     * @return array of the member
     */
    public function getMemberbyId(Member $Member)
    {
        $sql = self::$connection->prepare('
            SELECT * FROM member
            WHERE BINARY id=:id');
        $sql->bindvalue(':id', (int) $Member->id(), PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetch();
    }

    /**
     * Get all member filtered whith the params
     *
     * @param  string $date_begin Date which start the filter
     * @param  string $date_ending Date which end the filter
     * @param  int $validated Value of validated
     * @return array of members
     */
    public function getFilteredMember($date_begin, $date_ending, $validated)
    {
        if ($validated === 2) {
            $query = 'SELECT * FROM member 
			WHERE date_create 
			BETWEEN :date_begin AND :date_ending
			ORDER BY date_create DESC';
        } else {
            $query = 'SELECT * FROM member 
			WHERE date_create 
			BETWEEN :date_begin AND :date_ending
			AND validated=:validated 
			ORDER BY date_create DESC';
        }

        $sql = self::$connection->prepare($query);
        
        $sql->bindvalue(':date_begin', (string) $date_begin, PDO::PARAM_STR);
        $sql->bindvalue(':date_ending', (string) $date_ending, PDO::PARAM_STR);
        if ($validated !== 2) {
            $sql->bindvalue(':validated', (string) $validated, PDO::PARAM_STR);
        }

        $sql->execute();
        return $sql->fetchAll();
    }

    /**
     * Set the validation status of a member
     * @param  \Model\Member $Member
     */
    public function setValidatedMember(Member $Member)
    {
        $sql = self::$connection->prepare('UPDATE member SET validated= :validated WHERE id = :id');

        $sql->bindvalue(':id', (int) $Member->id(), PDO::PARAM_INT);
        $sql->bindvalue(':validated', (int) $Member->validated(), PDO::PARAM_INT);
        $sql->execute();
    }

    /**
     * Update the reset_password of a member
     * @param  \Model\Member $Member
     */
    public function updateResetPassword(Member $Member)
    {
        $sql = self::$connection->prepare(
            '
			UPDATE member
			SET reset_password = :reset_password
			WHERE login = :login'
        );

        $sql->bindvalue(':reset_password', $Member->reset_password(), PDO::PARAM_INT);
        $sql->bindvalue(':login', $Member->login(), PDO::PARAM_INT);
        $sql->execute();
    }

    /**
     * Update the password of a member
     * @param  \Model\Member $Member
     */
    public function changePassword(Member $Member)
    {
        $sql = self::$connection->prepare(
            '
			UPDATE member
			SET password=:password
			WHERE login=:login'
        );

        $sql->bindvalue(':password', $Member->password(), PDO::PARAM_INT);
        $sql->bindvalue(':login', $Member->login(), PDO::PARAM_INT);
        $sql->execute();
    }
}
