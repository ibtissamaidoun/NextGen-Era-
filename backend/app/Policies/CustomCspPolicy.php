<?php

namespace App\Policies;

use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Policy;

class CustomCspPolicy extends Policy
{
    public function configure()
    {
        $nonce = base64_encode(random_bytes(16)); // Générer un nonce unique pour chaque requête

        $this
            ->addDirective(Directive::BASE, 'self')
            ->addDirective(Directive::SCRIPT, "'nonce-{$nonce}' 'strict-dynamic' https: 'unsafe-inline'") // Assurez-vous d'ajouter 'unsafe-inline' si nécessaire pour le support de certains scripts
            ->addDirective(Directive::STYLE, "'nonce-{$nonce}' 'unsafe-inline'")
            ->addDirective(Directive::IMG, 'self')
            ->addDirective(Directive::FONT, 'self data:')
            ->addDirective(Directive::FORM_ACTION, 'self')
            ->addDirective(Directive::OBJECT, 'none')
            ->addDirective(Directive::FRAME_ANCESTORS, 'none');
    }
}
