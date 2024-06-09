<?php

namespace App\Policies;
use App\Models\user;
use Spatie\Csp\Directive;
use Spatie\Csp\Policies\Policy;

class CustomCspPolicy extends Policy
{
    public function configure()
    {
        $nonce = base64_encode(random_bytes(16)); // Cette fonction génère une chaîne de 16 octets aléatoires

        $this
            ->addDirective(Directive::BASE, 'self')
            ->addDirective(Directive::SCRIPT, ["'nonce-{$nonce}'", "'strict-dynamic'", "'unsafe-inline'", "https: 'unsafe-eval'"])
            ->addDirective(Directive::STYLE, ["'nonce-{$nonce}'", "'unsafe-inline'"])
            ->addDirective(Directive::IMG, 'self')
            ->addDirective(Directive::FONT, 'self data:')
            ->addDirective(Directive::FORM_ACTION, 'self');
    }
}

