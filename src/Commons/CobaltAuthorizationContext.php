<?php

namespace Eidosmedia\Cobalt\Commons;

use Eidosmedia\Cobalt\Directory\Entities\SessionData;

class CobaltAuthorizationContext {

    private $authContext = [];

    /**
     * Add user session to the authentication context
     * 
     * @param session user data as object
     */
    public function pushAuth($sessionUserData) {
        array_push($this->authContext, $sessionUserData);
    }

    /**
     * Get authentication context
     */
    public function getCurrAuth() {
        $i = count($this->authContext) -1;
        if (isset($this->authContext[$i])) {
            return $this->authContext[$i];
        }
        return null;
    }

    /**
     * Clean all authentication contexts
     */
    public function cleanAllAuths() {
        $this->authContext = [];
    }

    /**
     * Delete authentication context
     */
    public function removeAuth($sessionData) {
        $sessionsToDelete = [];
        if ($sessionData instanceof SessionData) {
            $sessionsToDelete[] = $sessionData->getId();

        } else if (is_array($sessionData)) {
            foreach ($sessionData as $sessionToDelete) {
                $sessionsToDelete[] = $sessionToDelete->getId();
            }
        }

        foreach ($this->authContext as $i => $currAuthContext) {
            if (in_array($currAuthContext->getSession()->getId(), $sessionsToDelete)) {
                unset($this->authContext[$i]);
            }
        }
    }

}