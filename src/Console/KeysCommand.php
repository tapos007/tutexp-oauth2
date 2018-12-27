<?php

namespace Tutexpsoft\Oauth2redis\Console;

use phpseclib\Crypt\RSA;
use Illuminate\Console\Command;
use Tutexpsoft\Oauth2redis\TutexpOauth;

class KeysCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tutexpoauth:keys
                                      {--force : Overwrite keys they already exist}
                                      {--length=4096 : The length of the private key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the encryption keys for API authentication';

    /**
     * Execute the console command.
     *
     * @param  \phpseclib\Crypt\RSA  $rsa
     * @return void
     */
    public function handle(RSA $rsa)
    {
        $keys = $rsa->createKey($this->input ? (int) $this->option('length') : 4096);

        list($publicKey, $privateKey) = [
            TutexpOauth::keyPath('tutexpoauth-public.key'),
            TutexpOauth::keyPath('tutexpoauth-private.key'),
        ];

        if ((file_exists($publicKey) || file_exists($privateKey)) && ! $this->option('force')) {
            $this->error('Encryption keys already exist. Use the --force option to overwrite them.');
        } else {
            file_put_contents($publicKey, array_get($keys, 'publickey'));
            file_put_contents($privateKey, array_get($keys, 'privatekey'));

            $this->info('Encryption keys generated successfully.');
        }
    }
}
