<?php
namespace App\Manager;

use App\Model\User;

/**
 * UserManager
 * Gestion de la table User
 */
class UserManager extends DatabaseManager{

    public function selectByUsername(string $username): User|false
    {
        $requete = self::getConnexion()->prepare("SELECT * FROM user WHERE username = :username;");
        $requete->execute([
            ":username" => $username
        ]);

        $arrayUser = $requete->fetch();
        //Si pas de résultat fetch()
        if(!$arrayUser) {

            return false;
        }
        //Renvoyer l'instance d'un objet Car avec les données du tableau associatif
        return new User($arrayUser["id"], $arrayUser["username"], $arrayUser["password"],json_decode($arrayUser["role"], true));
    
    }

   public function insert(User $user): bool
   {
       $requete = self::getConnexion()->prepare("INSERT INTO user (username,password, roles) VALUES (:username,:password, :roles);");

       $requete->execute([
           "username" => $user->getUsername(),
           "password" => $user->getPassWord(),
            "roles" => json_encode($user->getRoles())
       ]);
       return $requete->rowCount() > 0;
   }
}