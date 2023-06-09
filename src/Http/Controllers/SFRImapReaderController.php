<?php

namespace Osfrportal\OsfrportalLaravel\Http\Controllers;

//use Webklex\IMAP\Facades\Client as ImapClient;
use Webklex\PHPIMAP\Client as ImapClient;
use Webklex\PHPIMAP\ClientManager as ImapClientManager;

use Webklex\PHPIMAP\Exceptions\GetMessagesFailedException;
use Webklex\PHPIMAP\Exceptions\ConnectionFailedException;
use Carbon\CarbonImmutable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class SFRImapReaderController extends Controller
{
    private $oClient;
    public function __construct()
    {
        $imapClientManager = new ImapClientManager($options = []);
        $imapHost = config('osfrportal.imap_host');
        $imapPort = config('osfrportal.imap_port');
        $imapProtocol = config('osfrportal.imap_protocol');
        $imapEncryption = config('osfrportal.imap_encryption');
        $imapValidateCert = config('osfrportal.imap_validatecert');
        $imapUsername = config('osfrportal.imap_username');
        $imapPassword = config('osfrportal.imap_password');

        $this->oClient = $imapClientManager->make([
            'host'          => $imapHost,
            'port'          => $imapPort,
            'encryption'    => $imapEncryption,
            'validate_cert' => $imapValidateCert,
            'username'      => $imapUsername,
            'password'      => $imapPassword,
            'protocol'      => $imapProtocol
        ]);
        try {
            $this->oClient->connect();
        } catch (ConnectionFailedException $exception) {
            dd($exception->getMessage());
        }
    }
    public function put1CFilesToFTP()
    {
        try {
            $oFolder = $this->oClient->getFolder('INBOX');
        } catch (ConnectionFailedException $exception) {
            dd($exception->getMessage());
        }
        try {
            $aMessage = $oFolder->query()->since(now()->subDays(2))->unseen()->get();

            foreach ($aMessage as $oMessage) {
                //echo $oMessage->getFrom()[0]->mail . '<br />';
                $att_date = CarbonImmutable::parse($oMessage->getDate())->format('Y-m-d');
                //echo $att_date . '<br />';
                $flags = $oMessage->getFlags();
                //dump($flags);
                if ($oMessage->hasAttachments()) {
                    foreach ($oMessage->getAttachments() as $oAttachment) {
                        $oAttachmentName = imap_utf8($oAttachment->getName());
                        $filename_out = Str::replaceLast('.txt', ' ' . $att_date . '.txt', $oAttachmentName);
                        $file_content = $oAttachment->getAttributes()['content'];
                        //echo $filename_out . '  (' . $oAttachment->get("size") . ')<br />';
                        if (Storage::disk('ftp1c')->missing($filename_out)) {
                            Storage::disk('ftp1c')->put($filename_out, $file_content);
                        }
                        //echo '!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!<br>';
                    }
                }
                $oMessage->setFlag('Seen');
                //echo '-----------------------<br>';
            }


            //echo '<hr>';
        } catch (GetMessagesFailedException $exception) {
            dd($exception->getMessage());
        }
    }
}
