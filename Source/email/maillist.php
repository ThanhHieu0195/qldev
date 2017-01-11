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

    function addSubscriber($subscriber, $list) {
        $account = $this->application->getAccount($this->accessToken, $this->accessSecret);

        $listUrl = "/accounts/$account->id/lists/$list->id";
        $list = $account->loadFromUrl($listUrl);

        try {
            $list->subscribers->create($subscriber);
        }

        catch(Exception $exc) {
            print $exc;
        }
    }
}

$app = new MyApp();
$list = $list = $app->findList($name='');
$Femail = $app->findSubscriber($email='hoai@acong.vn');
if ($Femail) {
    print_r("Found " . $Femail->name . " " . $Femail->email);
}

$servername = "localhost";
$username = "hethong";
$password = "hethong";
$dbname = "hethongtmp";

$link = mysqli_connect($servername, $username, $password, $dbname);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

foreach ($list as $l) {
    $url = "$l->id";    
    $name = utf8_decode($l->name);
    $sqls = "SELECT * FROM aweber WHERE maillist='" . $name . "'";
    $sql = "UPDATE aweber SET apppath='" . $url . "' WHERE maillist='" . $name . "'";
    $result = mysqli_query($link, $sqls);
    if (mysqli_num_rows($result) > 0) {
        $result2 = mysqli_query($link, $sql);
        if ($result2) {
            print_r("Update query successfully " . $sql . "\n");
        }
    } else {
        $sql = "INSERT INTO aweber (maillist, apppath) VALUES ('" . $name . "','" .$url . "')";
        $result = mysqli_query($link, $sql);
        if ($result) {
            print_r("Insert query successfully " . $sql . "\n");
        }
    }
}


$subscriber = array(
    'email' => 'johndoe@example.com',
    'name'  => 'John Doe'
);

#$app->addSubscriber($subscriber, $list);
?>
