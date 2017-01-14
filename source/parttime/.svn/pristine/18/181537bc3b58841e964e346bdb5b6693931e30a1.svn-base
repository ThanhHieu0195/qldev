<?php
require('lib/aweber_api/aweber_api.php');

class MyApp{

    function __construct() {
        # replace XXX with your real keys and secrets
        $this->consumerKey = 'Ak7earo480K5alNFbD4LhRIY';
        $this->consumerSecret = '5Ie4rtKyfjXDCTZArq4sBnvS5idGaZyXfZcCtmkO';
        $this->accessToken = 'Ag9OGz32cbWgY2gR1J1XyOwE';
        $this->accessSecret = 'taWZFmoDmmKM7DsHsDaKQeJgcPhlfyB0rgZbuyqS';
        $this->application = new AWeberAPI($this->consumerKey, $this->consumerSecret);
    }

    function connectToAWeberAccount() {
        list($requestToken, $tokenSecret) = $this->application->getRequestToken('oob');

        echo "Go to this url in your browser: {$this->application->getAuthorizeUrl()}\n";
        echo 'Type code here: ';
        $code = trim(fgets(STDIN));
        $this->application->adapter->debug = true;


        $this->application->user->requestToken = $requestToken;
        $this->application->user->tokenSecret = $tokenSecret;
        $this->application->user->verifier = $code;

        list($accessToken, $accessSecret) = $this->application->getAccessToken();

        print "\n\n$accessToken \n $accessSecret\n";
        return array($accessToken, $accessSecret);

    }

    function findSubscriber($email) {
        $account = $this->application->getAccount($this->accessToken, $this->accessSecret);
        $foundSubscribers = $account->findSubscribers(array('email' => $email));
        return $foundSubscribers[0];
    }

    function findList($listName) {
        $account = $this->application->getAccount($this->accessToken, $this->accessSecret);
        $this->accountid = $account->id;
        $foundLists = $account->lists->find(array('name' => $listName));
        //must pass an associative array to the find method
        return $foundLists;
    }

    function findAllList() {
        $list = $this->findList('');
        return $list;
    }

    function addSubscriber($subscriber, $listid) {
        $account = $this->application->getAccount($this->accessToken, $this->accessSecret);

        $listUrl = "/accounts/$account->id/lists/$listid";
        $list = $account->loadFromUrl($listUrl);

        try {
            $m=$list->subscribers->create($subscriber);
        }

        catch(Exception $exc) {
            return $exc->message;
        }
        return 1;
    }
}
?>
