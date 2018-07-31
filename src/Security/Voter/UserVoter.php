<?php

namespace App\Security\Voter;

use App\Entity\Products;
use App\Entity\Users;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter extends Voter
{
    const VIEW = 'view';
    const EDIT = 'edit';
    const DELETE = 'delete';

    protected function supports($attribute, $subject)
    {
        //si l'attribut n'est pas supporté, on renvoie false
        if (!in_array($attribute, array(self::VIEW, self::EDIT, self::DELETE))){
            return false;
        }
        //si $subject n'est pas un objet de classe Users
        if (!$subject instanceof Products){
            return false;
        }
        return true;

    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        //je récupère l'utilisateur connecté
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        $article = $subject;
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($article, $user);
                break;
            case self::VIEW:
                return $this->canView($article, $user);
                break;
            case self::DELETE:
                return $this->canDelete($article, $user);
                break;
        }

        return false;
    }

    //je crée une methode qui va déterminer si l'utilisateur peut modifier l'annonce
    private function canEdit(Products $products, Users $users){
        //l'utilisateur peut modifier l'annonce s'il en est l'auteur
        if ($users == $products->getUser()){
            return true;
        }
        else{
            return false;
        }
    }
    //methode qui va determiner si l'utilisateur peut voir l'article
    private function canView(Products $products, Users $users){

        return true;
    }

    //methode qui permet de supprimer
    private function canDelete(Products $products, Users $users){
        //l'utilisateur peut modifier l'article s'il en est l'auteur
        if ($users == $products->getUser()){
            return true;
        }
        else{
            return false;
        }
    }
}
